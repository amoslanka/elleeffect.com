
package com.summitprojects.core3beta.ui.talktalktalk {

// Import Adobe classes.
import flash.display.*;
import flash.events.*;
import flash.geom.*;
import flash.ui.*;
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
import com.summitprojects.core3.util.Delay;
import com.summitprojects.core3.util.MCUtils;
import com.summitprojects.core3.util.VerboseTrace;
import com.summitprojects.core3.ui.keyboard.KeyBinding;
import com.summitprojects.core3.ui.keyboard.KeyBindingSet;
import com.summitprojects.core3.ui.keyboard.KeyboardGT;
import com.summitprojects.core3.display.StageRef;
import com.summitprojects.core3.display.Rect;
import com.summitprojects.core3.math.MathGT;

// Import project classes.


/**
 * @class 			TalkBar
 * @author  		amoslanka @ summitprojects
 * @date			13.10.2009
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class TalkBar extends EventDispatcher implements /*IAnimatable,*/ IDisposable {
	
	public static const CLASS_NAME:String = "TalkBar";
	public function get className() : Object { return CLASS_NAME; }
	public static const ALIGN_DEFAULT : String = "BOTTOM"; // finish alignment stuff some day..
	
	protected var _target:Sprite;
	protected var _container:Sprite;
	protected var vt:VerboseTrace;
	protected var em:EventManager;
	
	protected var _active:Boolean = false;
	
	protected var _bg:Sprite;
	protected var _textfield:TextField;
	
	protected var _history:Array;
	protected var _inHistory:int = -1;
	protected var _keybindingset:KeyBindingSet;
	protected var _constantKeybindingset:KeyBindingSet;
	
	/**
	 * Constructor.
	 * @param		target		The target Sprite.
	 * @param		alignment
	 * @param		verbosity	The verbosity level.
	**/
	public function TalkBar(target:Sprite=null, alignment:String=null, verbosity:int=0) {

		/*
			TODO alignment.
		*/
		_target = target ? target : targetFactory();
		init(verbosity);
	}
	
	public override function toString():String {
		return className + " >> target: " + _target;
	}
	
	protected function targetFactory() : Sprite {
		return new Sprite();
	}


	// INITIALIZATION ===============================================================================================================

	private function init(verbosity:int=0):void {
		initVars(verbosity);
		initObjects();
		initEvents();
		autoPosition();
	}
	
	protected function initVars(verbosity:int=0):void {
		vt = new VerboseTrace(verbosity, "  [ " + className + " ]  ");
		em = new EventManager();
		TweenPlugin.activate([AutoAlphaPlugin]);
		_history = [];
	}
	
	protected function initObjects():void {
		_container = new Sprite();
		_target.addChild(_container);
		
		_bg = bgFactory();
		_textfield = textfieldFactory();
		_container.addChild(_bg);
		_container.addChild(_textfield);
		
		_keybindingset = new KeyBindingSet();
		_constantKeybindingset = new KeyBindingSet();
		_constantKeybindingset.addBinding(new KeyBinding(Keyboard.PAGE_UP, onActivateKey));
		_constantKeybindingset.addBinding(new KeyBinding(Keyboard.PAGE_DOWN, onDectivateKey));
		/*_constantKeybindingset.addBinding(new KeyBinding(KeyboardGT.CODES["]"], onActivateKey));
		_constantKeybindingset.addBinding(new KeyBinding(KeyboardGT.CODES["["], onDectivateKey));*/
		_constantKeybindingset.addBinding(new KeyBinding(KeyboardGT.CODES["]"], onActivateKey));
		_constantKeybindingset.addBinding(new KeyBinding(KeyboardGT.CODES["["], onDectivateKey));
		
		/*_constantKeybindingset.addBinding(new KeyBinding(KeyboardGT.CODES[KeyboardGT.J], onToggleKey, null, 1));
		_constantKeybindingset.addBinding(new KeyBinding(KeyboardGT.CODES[KeyboardGT.J], onToggleKey, null));*/
		/*_constantKeybindingset.addBinding(new KeyBinding(KeyboardGT.CODES[Keyboard.F1], onToggleKey, null));
		_constantKeybindingset.addBinding(new KeyBinding(KeyboardGT.CODES[KeyboardGT.CODES["\\"]], onToggleKey, null));*/

		_constantKeybindingset.addBinding(new KeyBinding(Keyboard.RIGHT, onActivateKey));
		_constantKeybindingset.addBinding(new KeyBinding(Keyboard.LEFT, onDectivateKey));

		
		_keybindingset.addBinding(new KeyBinding(Keyboard.NUMPAD_ENTER, onEnterKey));
		_keybindingset.addBinding(new KeyBinding(Keyboard.ENTER, onEnterKey));
		_keybindingset.addBinding(new KeyBinding(Keyboard.UP, 		Callback.create(onHistoryKey, Keyboard.UP)));
		_keybindingset.addBinding(new KeyBinding(Keyboard.DOWN, 	Callback.create(onHistoryKey, Keyboard.DOWN)));
		
		/*Tweener.addTween(_target, {_autoAlpha:0});*/
		TweenLite.to(_target, 0, {autoAlpha:0});
		
		/*Tweener.addTween(_container, {y:0});*/
		TweenLite.to(_container, 0, {y:0});
		
		
	}
	
	protected function initEvents():void {
		em.addEvent(_target, Event.REMOVED_FROM_STAGE, onRemovedFromStage);
		em.addEvent(StageRef.stage, Event.RESIZE, onStageResize);
	}
	
	protected function bgFactory() : Sprite {
		var sp:Sprite = new Sprite();
		var s:Shape = new Rect(0,0,10,10,0x333333,.8);
		sp.addChild(s);
		return sp;
	}
	protected function textfieldFactory() : TextField {
		var tf:TextField = new TextField()
		tf.type = TextFieldType.INPUT;
		tf.textColor = 0xffffff;
		tf.backgroundColor = 0x000000;
		tf.autoSize = TextFieldAutoSize.CENTER;
		tf.multiline = true;
		
		tf.text = "Hello";
		tf.height = tf.textHeight + 10;
		tf.text = "";
		
		return tf;
	}
	/**
	 * Disposes and removes references to any complex objects in order to properly be collected by the garbage collector.
	**/
	public function dispose():void {
		em.unload();
		_keybindingset.dispose();
	}
	
	
	// ACTIONS =====================================================================================================================
	
	public function submit() : void {
		vt.trace(2, "submit. text :: " + _textfield.text );
		dispatchEvent(new TalkBarEvent(TalkBarEvent.TALK, text));
		addToHistory(text);
		_inHistory = -1;
		if (_active) toggleActive();
	}
	
	public function toggleActive() : void {
		if (_active) {
			deactivate();
		} else {
			activate();
		}
		
	}
	
	public function autoPosition() : void {
		_target.x = 0;
		_target.y = StageRef.stageHeight;
		_bg.width = StageRef.stageWidth;
		_bg.height = _textfield.height;
		_textfield.width = StageRef.stageWidth;
	}
	
	public function clearText() : void {
		_textfield.text = "";
	}
	
	public function addToHistory(s:String) : void {
		if (s && s != "") {
			_history.unshift(s);
		}
	}
	public function gotoNext() : void {
		vt.trace(1, "gotoNext " );
		_inHistory = MathGT.limit(_inHistory-1, 0, _history.length-1);
		var s:String = _history[_inHistory];
		_textfield.text = s ? s : "";
	}
	public function gotoPrevious() : void {
		vt.trace(1, "gotoPrevious " );
		_inHistory = MathGT.limit(_inHistory+1, 0, _history.length-1);
		var s:String = _history[_inHistory];
		_textfield.text = s ? s : "";
	}
	
	//--------------------------------------
	//  ANIMATIONS
	//--------------------------------------

	public function activate() : void { //intro(dly:Number=0, callback:Function=null, callbackParams:Array=null):void {
		vt.trace(1, "activate " );
		if (_active) return;

		var dly:Number = 0;
		_active = true;
		StageRef.focus = _textfield;
		clearText();
		
		/*Tweener.addTween(_target, {_autoAlpha:1, time:.2, transition:"easeOutQuad", delay:dly});*/
		TweenLite.to(_target, .2, {autoAlpha:1, ease:"easeOutQuad", delay:dly});
		
		/*Tweener.addTween(_container, {y:-_container.height, time:.4, transition:"easeOutQuad", delay:dly});*/
		TweenLite.to(_container, .4, {y:-_container.height, ease:"easeOutQuad", delay:dly});
		
		enableMouseEvents();
	}
	public function deactivate() : void { //exit(dly:Number=0, callback:Function=null, callbackParams:Array=null):void {
		vt.trace(1, "deactivate "  );
		if (!_active) return;
		
		var dly:Number = 0;
		_active = false;
		StageRef.focus = StageRef.stage;
		
		/*Tweener.addTween(_target, {_autoAlpha:0, time:.4, transition:"easeOutQuad", delay:dly});*/
		TweenLite.to(_target, .4, {autoAlpha:0, ease:"easeOutQuad", delay:dly});
		/*Tweener.addTween(_container, {y:0, time:.2, transition:"easeOutQuad", delay:dly});*/
		TweenLite.to(_container, .2, {y:0, ease:"easeOutQuad", delay:dly});
	
		disableMouseEvents();
	}

	
	//--------------------------------------
	//  EVENT HANDLERS
	//--------------------------------------

	protected function enableMouseEvents() : void {
		em.addEvent(StageRef.stage, MouseEvent.MOUSE_UP, onStageClick);
		_keybindingset.enable();
	}
	protected function disableMouseEvents() : void {
		em.removeEvent(StageRef.stage, MouseEvent.MOUSE_UP, onStageClick);
		_keybindingset.disable();
	}
	protected function onStageClick(me:MouseEvent) : void {

		var result:Boolean = target.hitTestPoint(StageRef.stage.mouseX, StageRef.stage.mouseY);
		if (!result){
			vt.trace(1, "clicked away from target, deactivating");
			deactivate();
		}
		
	}

	private function onRemovedFromStage(e:Event):void {
		dispose();
	}
	private function onStageResize(e:Event) : void {
		autoPosition();
	}
	
	protected function onEnterKey(e:Event=null) : void {
		vt.trace(2, "onEnterKey() " );
		if (StageRef.focus == _textfield) {
			submit();
		}
	}
	protected function onActivateKey(e:Event=null) : void {
		vt.trace(2, "onActivateKey() " );
		if (!_hasFocus) {
			toggleActive();
		}
		/*if (!_active) {
		}*/
	}
	protected function onToggleKey(e:Event=null) : void {
		toggleActive();
	}
	
	protected function onDectivateKey(e:Event=null) : void {
		vt.trace(2, "onDectivateKey() " );
		deactivate();
	}
	
	protected function onHistoryKey(key:String) : void {
		vt.trace(0, "onHistoryKey " + key);
		switch (parseInt(key)){
			case Keyboard.UP:
				vt.trace(0, "going to previous..... " );
				gotoPrevious();
			break;
			case Keyboard.DOWN:
				vt.trace(0, "going to next..... " );
				gotoNext();
			break;
		}
	}
	
	//--------------------------------------
	//  GETTER / SETTERS
	//--------------------------------------
	
	public function get target():Sprite { return _target; }
	public function get text() : String { return _textfield.text; }
	
	protected function get _hasFocus() : Boolean {
		return (StageRef.stage.focus == _textfield);
	}
	
	// UTILITY =====================================================================================================================
	
	protected function $SP(clip:String, scope:DisplayObjectContainer=null):Sprite    { return MCUtils.getSP(scope?scope:_target, clip); }
	protected function $MC(clip:String, scope:DisplayObjectContainer=null):MovieClip { return MCUtils.getMC(scope?scope:_target, clip); }
	protected function $TF(clip:String, scope:DisplayObjectContainer=null):TextField { return MCUtils.getTF(scope?scope:_target, clip); }

	
}

}
 