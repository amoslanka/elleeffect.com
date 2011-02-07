
package com.amoslanka.elleeffect.elleviewer.thumbnav {

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
import com.summitprojects.core3.util.VerboseTrace;
import com.summitprojects.core3.display.Rect;
import com.summitprojects.core3.display.LoaderGT;
import com.summitprojects.core3.ui.buttons.*;

// Import project classes.
import com.amoslanka.elleeffect.elleviewer.Config;


/**
 * Description goes here.
 * @class 			ThumbNavArrowButton
 * @author  		amoslanka
 * @date			2010.02.07
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class ThumbNavArrowButton extends AbstractButtonDecorator {
	
	public static const CLASS_NAME:String = "ThumbNavArrowButton";
	public override function get className():String { return CLASS_NAME; }
	
	
	/**
	 * Constructor.
	 * @param		target		The target Sprite.
	 * @param		verbosity	The verbosity level.
	**/
	public function ThumbNavArrowButton(target:Sprite, verbosity:int=0) {
		var btn:IButtonComponent = new AbstractButton(target);
		btn = new AlphaButton(btn, btn.target, 1, .15, .1);
		super(btn);
	}
	
	public override function toString():String {
		return className + " >> target: " + target;
	}

	// INITIALIZATION ===============================================================================================================

	/*private function init(verbosity:int=0):void {
		initVars(verbosity);
		initObjects();
		initEvents();
	}
	
	private function initVars(verbosity:int=0):void {
		vt = new VerboseTrace(verbosity, "  [ " + className + " ]  ");
		em = new EventManager();
		
		TweenPlugin.activate([AutoAlphaPlugin]);
		
	}
	
	
	private function initEvents():void {
		em.addEvent(target, Event.REMOVED_FROM_STAGE, onRemovedFromStage);
	}*/
	
	override protected function createChildren():void {
		super.createChildren();
		
		/*_mask = new Rect(0,0,Config.THUMB_WIDTH, Config.THUMB_WIDTH);
		target.addChild(_mask);
		_loader = new LoaderGT(_url, onLoaderComplete);
		target.addChild(_loader);
		_loader.mask = _mask;
		em.addEvent(_loader, IOErrorEvent.IO_ERROR, onLoaderError);*/
		
	}
	
	// DECONSTRUCTION =====================================================================================================================

	override public function dispose():void {
		super.dispose();
	}
	
	// ACTIONS =====================================================================================================================


	override public function setSelectedState():void{
		super.setSelectedState();
		
	}
	override public function setUnselectedState():void{
		super.setUnselectedState();
		
	}
	override public function setEnabledState():void{
		super.setEnabledState();
		vt.trace(0, "setEnabledState. " );
		
	}
	override public function setDisabledState():void{
		super.setDisabledState();
		TweenLite.to(target, .2, {autoAlpha:0, ease:"easeOutQuad"});
		vt.trace(0, "setDisabledState. " );
	}
	
	
	// ANIMATIONS ==================================================================================================================

	override public function intro(dly:Number=0, callback:Function=null, callbackParams:Array=null):void {
		/*Tweener.addTween(target, {_autoAlpha:1, time:.5, transition:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});*/
		TweenLite.to(target, .5, {autoAlpha:1, ease:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});
	}
	override public function exit(dly:Number=0, callback:Function=null, callbackParams:Array=null):void {
		/*Tweener.addTween(target, {_autoAlpha:0, time:.5, transition:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});*/
		TweenLite.to(target, .5, {autoAlpha:0, ease:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});
	}

	// EVENTS ======================================================================================================================

	/*private function onLoaderComplete(e:Event) : void {
		vt.trace(1, "onLoaderComplete " );
		
		var bitmap:Bitmap = _loader.content as Bitmap;
		if (bitmap) {
			bitmap.smoothing = true;
			bitmap.width = _mask.width;
			bitmap.scaleY = bitmap.scaleX;
			if (bitmap.height < _mask.height) {
				bitmap.height = _mask.height;
				bitmap.scaleX = bitmap.scaleY;
			}
		}
		
		dispatchEvent(new Event(Event.COMPLETE));
	}
	
	private function onLoaderError(e:Event) : void {
		vt.trace(0, "onLoaderError " );
		dispatchEvent(e);
	}*/
	
	// SETTERS AND GETTERS =========================================================================================================
	
	// UTILITY =====================================================================================================================

	
}

}
