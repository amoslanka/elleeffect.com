
package com.amoslanka.elleeffect.elleviewer.mainviewer {

// Import Adobe classes.
import flash.display.*;
import flash.events.*;
import flash.geom.*;
import flash.net.*;
import flash.text.*;
import flash.utils.*;

// Import third-party classes.
/*import caurina.transitions.*;
import caurina.transitions.properties.*;*/
import com.greensock.*;
import com.greensock.plugins.*;

// Import custom classes.
import com.summitprojects.core3.animation.IAnimatable;
import com.summitprojects.core3.events.EventManager;
import com.summitprojects.core3.interfaces.IDisposable;
import com.summitprojects.core3.util.Callback;
import com.summitprojects.core3.display.Rect;
import com.summitprojects.core3.display.LoaderGT;
import com.summitprojects.core3.display.LoaderEaseGT;
import com.summitprojects.core3.util.Delay;
import com.summitprojects.core3.util.MCUtils;
import com.summitprojects.core3.util.VerboseTrace;
import com.summitprojects.core3.display.bounds.IBoundable;

// Import project classes.
import com.amoslanka.elleeffect.elleviewer.Config;
import com.summitprojects.core3beta.geom.SmartBound;
import com.summitprojects.core3beta.geom.SmartBoundHelper;


/**
 * Description goes here.
 * @class 			MainViewer
 * @author  		amoslanka
 * @date			2010.02.07
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class MainViewer extends EventDispatcher implements IAnimatable, IDisposable, IBoundable {
	
	public static const CLASS_NAME:String = "MainViewer";
	public function get className():String { return CLASS_NAME; }
	
	private var _target:Sprite;
	private var vt:VerboseTrace;
	private var em:EventManager;
	
	private var _loader:LoaderGT;
	private var _contentContainer:DisplayObjectContainer;
	private var _contentMask:DisplayObject;
	private var _bg:DisplayObject;
	private var _currentContent:DisplayObject;
	
	private var _bounds:Rectangle;
	
	/**
	 * Constructor.
	 * @param		target		The target Sprite.
	 * @param		verbosity	The verbosity level.
	**/
	public function MainViewer(target:Sprite=null, verbosity:int=0) {
		_target = target ? target : new Sprite();
		init(verbosity);
	}
	
	public override function toString():String {
		return className + " >> target: " + _target;
	}

	// INITIALIZATION ===============================================================================================================

	private function init(verbosity:int=0):void {
		initVars(verbosity);
		initObjects();
		initEvents();
	}
	
	private function initVars(verbosity:int=0):void {
		vt = new VerboseTrace(verbosity, "  [ " + className + " ]  ");
		em = new EventManager();
		
		TweenPlugin.activate([AutoAlphaPlugin]);
		
	}
	
	private function initObjects():void {
		_bg = new Rect(0, 0, Config.VIEWER_WIDTH, Config.VIEWER_HEIGHT, 0x000000, 0);
		target.addChild(_bg);
		_contentContainer = new Sprite();
		target.addChild(_contentContainer);
		_contentMask = new Rect(0, 0, Config.VIEWER_WIDTH, Config.VIEWER_HEIGHT, 0x000000, 0);
		target.addChild(_contentMask);
		/*_contentContainer.mask = _contentMask;*/
		
		target.mouseEnabled = false;
		target.mouseChildren = false;
	}
	
	private function initEvents():void {
		em.addEvent(_target, Event.REMOVED_FROM_STAGE, onRemovedFromStage);
	}
	
	// DECONSTRUCTION =====================================================================================================================

	public function dispose():void {
		em.unload();
		clearLoader();
	}
	
	private function clearLoader() : void {
		if (_loader) {
			_loader.dispose();
		}
	}
	
	// ACTIONS =====================================================================================================================
	
	public function loadImageUrl(url:String) : void {
		
		clearLoader();
		
		vt.trace(0, "loadImageUrl: " + url);
		
		_loader = new LoaderGT(url, onLoaderComplete);
		em.addSingle(_loader, IOErrorEvent.IO_ERROR, onLoaderError);
		
		
	}
	
	public function setCurrentContent(obj:DisplayObject) : void {
		
		vt.trace(0, "setCurrentContent " + obj);
		var dly:Number = 0;
		
		if (_currentContent) {
			/*_contentContainer.removeChild(_currentContent);*/
			TweenLite.to(_currentContent, .25, {autoAlpha:0, ease:"easeOutQuad", delay:dly, onComplete:Callback.create(_contentContainer.removeChild, _currentContent)});
		}
		
		_currentContent = obj;
		dly+=.1;
		
		if (_currentContent) {
			/*_contentContainer.addChild(_currentContent);*/
			_currentContent.alpha = 0;
			TweenLite.to(_currentContent, .25, {autoAlpha:1, ease:"easeOutQuad", delay:dly, onStart:Callback.create(_contentContainer.addChild, _currentContent)});
		}
		
		setBounds(_bounds);
		
	}
	
	public function getBounds(obj:DisplayObject) : Rectangle {
		return _contentMask.getBounds(obj);
	}
	
	public function setBounds(rect:Rectangle) : void {
		_bounds = rect is SmartBound ? rect as SmartBound : SmartBound.convertRectangle(rect, SmartBound.TOP);
		target.x = _bounds.x;
		target.y = _bounds.y;
		setContentBounds();
		/*SmartBoundHelper.autoAlign(target, _bounds as SmartBound);*/

	}
	
	protected function setContentBounds() : void {
		/*target.x = rect.x;
		target.y = rect.y;*/
		
		
		/*_contentContainer.width = _bounds.width;*/
		
		/*SmartBoundHelper.autoSize(_contentContainer, _bounds);*/
		
		/*SmartBoundHelper.autoSize(_contentMask, _bounds);*/
		//_contentMask.alpha = .5;
		//_contentContainer.mask = null;
		/*_bg.height = _bounds.height;
		
		if (_bg.width < _bounds.width) {
		_bg.scaleX = _bg.scaleY;
			_bg.scaleY = _bg.scaleX;
			_bg.width = _bounds.width;

		}*/

		_bg.height = _bounds.height;
		_bg.scaleX = _bg.scaleY;
		/*SmartBoundHelper.autoSize(_bg, _bounds);*/
		
		_contentMask.height = _bounds.height;
		_contentMask.scaleX = _contentMask.scaleY;
		
		SmartBoundHelper.autoAlign(_bg, _bounds);
		if (_loader) {
			_loader.height = _bounds.height;
			_loader.scaleX = _loader.scaleY;
			SmartBoundHelper.autoAlign(_loader, _bounds);
			_loader.y = 0;
		}
		SmartBoundHelper.autoAlign(_contentMask, _bounds);
		
		_bg.y = 0;
		_contentContainer.y = 0;
		_contentMask.y = 0;
		
		_contentContainer.x = 0;
		_contentContainer.y = 0;
		
		vt.trace(0, "setContentBounds: " + _bounds);
		
		/*if (_loader) vt.trace(0, "_loader bounds: " + _loader.getBounds(_loader.target));
		vt.trace(0, "_contentContainer bounds: " + _contentContainer.getBounds(_contentContainer.parent));*/
		

	}
	
	// ANIMATIONS ==================================================================================================================

	public function intro(dly:Number=0, callback:Function=null, callbackParams:Array=null):void {
		/*Tweener.addTween(_target, {_autoAlpha:1, time:.5, transition:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});*/
		TweenLite.to(_target, .5, {autoAlpha:1, ease:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});
	}
	public function exit(dly:Number=0, callback:Function=null, callbackParams:Array=null):void {
		/*Tweener.addTween(_target, {_autoAlpha:0, time:.5, transition:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});*/
		TweenLite.to(_target, .5, {autoAlpha:0, ease:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});
	}

	// EVENTS ======================================================================================================================

	private function onRemovedFromStage(e:Event):void {
		dispose();
	}
	private function onLoaderComplete(e:Event) : void {
		vt.trace(0, "onLoaderComplete " );
		
		if (_loader) {

			var bitmap:Bitmap = _loader.content as Bitmap;
			if (bitmap) {
				bitmap.smoothing = true;
				/*bitmap.height = _bg.height;
				bitmap.scaleX = bitmap.scaleY;
				if (bitmap.width < _bg.width) {
					bitmap.width = _bg.width;
					bitmap.scaleY = bitmap.scaleX;
				}*/
			}
		
			setCurrentContent(_loader);
		}
		
		/*dispatchEvent(new Event(Event.COMPLETE));*/
	}
	private function onLoaderError(e:Event) : void {
		
	}
	
	// SETTERS AND GETTERS =========================================================================================================
	
	public function get target():Sprite { return _target; }
	public function get loader() : Loader { return _loader; }
	
	// UTILITY =====================================================================================================================
	
	protected function $SP(clip:String, scope:DisplayObjectContainer=null):Sprite    { return MCUtils.getSP(scope?scope:_target, clip); }
	protected function $MC(clip:String, scope:DisplayObjectContainer=null):MovieClip { return MCUtils.getMC(scope?scope:_target, clip); }
	protected function $TF(clip:String, scope:DisplayObjectContainer=null):TextField { return MCUtils.getTF(scope?scope:_target, clip); }

	
}

}
