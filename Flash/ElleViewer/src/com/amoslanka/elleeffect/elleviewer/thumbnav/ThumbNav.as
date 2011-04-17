
package com.amoslanka.elleeffect.elleviewer.thumbnav {

// Import Adobe classes.
import flash.display.*;
import flash.events.*;
import flash.geom.*;
import flash.net.*;
import flash.text.*;
import flash.utils.*;

// Import third-party classes.
import com.greensock.plugins.*;
import com.greensock.*;

// Import custom classes.
import com.summitprojects.core3.display.DisplayUtils;
import com.summitprojects.core3.animation.IAnimatable;
import com.summitprojects.core3.events.EventManager;
import com.summitprojects.core3.interfaces.IDisposable;
import com.summitprojects.core3.display.Rect;
import com.summitprojects.core3.util.Callback;
import com.summitprojects.core3.util.Delay;
import com.summitprojects.core3.util.MCUtils;
import com.summitprojects.core3.util.VerboseTrace;
import com.summitprojects.core3.ui.buttons.*;
import com.summitprojects.core3beta.geom.AutoArrange;
import com.summitprojects.core3.display.bounds.IBoundable;
import com.summitprojects.core3beta.geom.SmartBound;
import com.summitprojects.core3beta.geom.SmartBoundHelper;
import com.summitprojects.core3.display.preloader.IPreloaderComponent;

// Import project classes.
import com.amoslanka.elleeffect.elleviewer.ImageModel;
import com.amoslanka.elleeffect.elleviewer.Config;
import com.amoslanka.elleeffect.elleviewer.ImagePreloader;


/**
 * Description goes here.
 * @class 			ThumbNav
 * @author  		amoslanka
 * @date			2010.02.07
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class ThumbNav extends EventDispatcher implements IAnimatable, IDisposable, IBoundable {
	
	public static const CLASS_NAME:String = "ThumbNav";
	public function get className():String { return CLASS_NAME; }
	
	private var _target:Sprite;
	private var vt:VerboseTrace;
	private var em:EventManager;
	
	private var _thumbs:Array;
	private var _dataObjects:Array;
	private var _thumbContainer:DisplayObjectContainer;
	private var _thumbMask:Sprite;
	private var _shadow:Sprite;
	private var _lastIndex:int = -1;
	private var _currentDisplayIndex:int;
	
	private var _leftButton:IButtonComponent;
	private var _rightButton:IButtonComponent;
	
	/**
	 * Constructor.
	 * @param		target		The target Sprite.
	 * @param		verbosity	The verbosity level.
	**/
	public function ThumbNav(target:Sprite=null, verbosity:int=0) {
		_target = target ? target : new ThumbNav_Graphic();
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
		_shadow = $SP("shadow_mc");
		_thumbContainer = $SP("thumbContainer_mc");
		/*target.addChild(_thumbContainer);*/
		_thumbMask = new Sprite();
		_thumbMask.y = _thumbContainer.y;
		_thumbMask.addChild(new Rect(0, 0, Config.THUMBS_PER_ROW*Config.THUMB_WIDTH, Config.THUMB_WIDTH+20, 0x000000, 0));
		target.addChild(_thumbMask);
		_thumbContainer.mask = _thumbMask;
		
		var clip:Sprite;
		
		clip = new ThumbNavLeft_Graphic();
		target.addChild(clip);
		_leftButton  = new ThumbNavArrowButton(clip);
		clip = new ThumbNavRight_Graphic();
		target.addChild(clip);
		_rightButton = new ThumbNavArrowButton(clip);
		
		em.addEvent(_leftButton,  MouseEvent.CLICK, onDirButtonClick);
		em.addEvent(_rightButton, MouseEvent.CLICK, onDirButtonClick);
	}
	
	private function initEvents():void {
		em.addEvent(_target, Event.REMOVED_FROM_STAGE, onRemovedFromStage);
	}
	
	// DECONSTRUCTION =====================================================================================================================

	public function dispose():void {
		clearItems();
		em.unload();
	}
	
	public function clearItems() : void {
		_dataObjects = new Array();
		DisplayUtils.removeAllChildren(_thumbContainer);
		for each (var btn:IButtonComponent in _thumbs){
			em.removeEvent(btn, IOErrorEvent.IO_ERROR, onButtonLoadError);
			/*em.removeEvent(btn, Event.COMPLETE, onButtonLoadComplete);*/
			em.removeEvent(btn, MouseEvent.CLICK, onButtonClick)
			btn.dispose();
		}
		_thumbs = new Array();
		_lastIndex = -1;
	}
	
	// ACTIONS =====================================================================================================================
	
	public function subnavigate(index:int) : void {
		vt.trace(0, "subnavigate: " + index);
		vt.trace(0, "_lastIndex: " + _lastIndex);
		
		if (index == _lastIndex || length == 0) {
			vt.trace(0, "returning from subnavigate. invalid" );
			return;
		}
		
		if (_lastButton) _lastButton.unselect();
		_lastIndex = index;
		if (_lastButton) _lastButton.select();
		if (index < _currentDisplayIndex || index >= _currentDisplayIndex+Config.THUMBS_PER_ROW) setTimeout(Callback.create(displayRange, index), 500);
		dispatchEvent(new Event(Event.CHANGE));
	}
	
	public function populate(items:Array) : void {
		
		clearItems();
		
		var item:ImageModel;
		var thumb:IButtonComponent;
		for (var i:int = 0; i<items.length; i++){
			item = items[i] as ImageModel;
			if (!item) continue;
			
			thumb = thumbFactory(item.thumbUrl);
			_dataObjects.push(item);
			_thumbs.push(thumb);
			
			_thumbContainer.addChild(thumb.target);
		}
		
		//_lastIndex = _thumbs.length >= 1 ? 0 : -1;
		
		arrange();
		subnavigate(0);
	}
	
	public function arrange() : void {
		var clips:Array = [];
		for (var i:int = 0; i<_thumbs.length; i++){
			clips.push(_thumbs[i].target);
		}
		AutoArrange.arrange(clips);
		_shadow.width = _thumbMask.width;
	}
	
	public function displayRange(startIndex:int=0) : void {
		if (startIndex > length-Config.THUMBS_PER_ROW) startIndex = length-Config.THUMBS_PER_ROW;
		if (startIndex < 0) startIndex = 0;
		
		var xTo:int = -startIndex*Config.THUMB_WIDTH;
		
		TweenLite.to(_thumbContainer, .24, {x:xTo, ease:"easeOutQuad"/*, delay:dly, onComplete:callback, onCompleteParams:callbackParams*/});
		
		var hideThumbs:Array = _thumbs.slice();
		var showThumbs:Array = hideThumbs.splice(startIndex, Config.THUMBS_PER_ROW);
		
		var thumb:IButtonComponent
		for each (thumb in hideThumbs){
			TweenLite.to(thumb.target, .25, {autoAlpha:0, ease:"easeOutQuad"});
		}
		for each (thumb in showThumbs){
			TweenLite.to(thumb.target, 1.25, {autoAlpha:1, ease:"easeOutQuad"});
		}
		
		if (startIndex <= 0) {
			_leftButton.unhilight();
			_leftButton.disable();
		} else {
			_leftButton.enable();
		}
		
		if (startIndex+Config.THUMBS_PER_ROW < length) {
			_rightButton.enable();
		} else {
			_rightButton.unhilight();
			_rightButton.disable();
		}
		
		_currentDisplayIndex = startIndex;
		
	}
	
	/*private function isInDisplayRange(indexToCheck:int, startIndex:int) : Boolean {
		if (startIndex > length-Config.THUMBS_PER_ROW) startIndex = length-Config.THUMBS_PER_ROW;
		if (startIndex < 0) startIndex = 0;
		return (indexToCheck >= startIndex && indexToCheck < startIndex+Config.THUMBS_PER_ROW);
	}*/
	
	public function thumbFactory(url:String) : IButtonComponent {
		var btn:IButtonComponent = new ThumbNavButton(url);
		em.addSingle(btn, IOErrorEvent.IO_ERROR, onButtonLoadError);
		em.addEvent(btn, MouseEvent.CLICK, onButtonClick);
		return btn;
	}
	
	public function getBounds(obj:DisplayObject) : Rectangle {
		return _shadow.getBounds(obj);
	}
	
	public function setBounds(rect:Rectangle) : void {
		var sb:SmartBound = rect is SmartBound ? rect as SmartBound : SmartBound.convertRectangle(rect);
		SmartBoundHelper.autoAlign(this, sb);
		
		/*target.y = sb.bottom - target.height;*/
		
		_leftButton.target.y =  _thumbContainer.y + (Config.THUMB_WIDTH - _leftButton.target.height) / 2;
		_rightButton.target.y = _thumbContainer.y + (Config.THUMB_WIDTH - _rightButton.target.height) / 2;
		_leftButton.target.x = 0;
		_rightButton.target.x = Config.THUMB_WIDTH * Config.THUMBS_PER_ROW;
		
	}
	
	public function monitorPreload(index:int, dispatcher:IEventDispatcher) : void {
		
		var thumb:ThumbNavButton = _thumbs[index] as ThumbNavButton;
		if (thumb && dispatcher) {
			var preloader:IPreloaderComponent = new ImagePreloader(dispatcher);
			thumb.addPreloader(preloader);
		}
		
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
	private function onButtonLoadError(e:Event):void {
		vt.trace(0, "onButtonLoadError. " + e);
	}
	private function onButtonClick(e:Event) : void {
		var index:int = _thumbs.indexOf(e.target);
		vt.trace(0, "onButtonClick " + index);
		subnavigate(index);
	}
	private function onDirButtonClick(me:MouseEvent) : void {
		vt.trace(0, "onDirButtonClick " + me.target);
		
		switch (me.target){
			case _leftButton :
				displayRange(_currentDisplayIndex - Config.THUMBS_PER_ROW);
			break;
			case _rightButton :
				displayRange(_currentDisplayIndex + Config.THUMBS_PER_ROW);
			break;
		}
		
	}
	
	// SETTERS AND GETTERS =========================================================================================================
	
	public function get target():Sprite { return _target; }
	public function get lastIndex() : int { return _lastIndex; }
	protected function get _lastButton() : IButtonComponent { return _thumbs[lastIndex]; }
	public function get length() : int { return _thumbs.length; }

	public function get x() : Number { return target.x; }
	public function set x( arg:Number ) : void { target.x = arg; }
	public function get y() : Number { return target.y; }
	public function set y( arg:Number ) : void { target.y = arg; }
	public function get width() : Number { return _shadow.width; }
	public function set width( arg:Number ) : void { _shadow.width = arg; }
	public function get height() : Number { return _shadow.height; }
	public function set height( arg:Number ) : void { _shadow.height = arg; }
	
	// UTILITY =====================================================================================================================
	
	protected function $SP(clip:String, scope:DisplayObjectContainer=null):Sprite    { return MCUtils.getSP(scope?scope:_target, clip); }
	protected function $MC(clip:String, scope:DisplayObjectContainer=null):MovieClip { return MCUtils.getMC(scope?scope:_target, clip); }
	protected function $TF(clip:String, scope:DisplayObjectContainer=null):TextField { return MCUtils.getTF(scope?scope:_target, clip); }

	
}

}
