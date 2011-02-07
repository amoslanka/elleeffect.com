﻿package com.summitprojects.core3beta.ui.talktalktalk {// Import Adobe classes.import flash.display.*;import flash.events.*;import flash.geom.*;import flash.net.*;import flash.text.*;import flash.utils.*;// Import third-party classes./*import caurina.transitions.*;import caurina.transitions.properties.*;*/import com.greensock.*;import com.greensock.plugins.*;// Import custom classes.import com.summitprojects.core3.animation.IAnimatable;import com.summitprojects.core3.events.EventManager;import com.summitprojects.core3.interfaces.IDisposable;import com.summitprojects.core3.util.Callback;import com.summitprojects.core3.util.Delay;import com.summitprojects.core3.util.MCUtils;import com.summitprojects.core3.util.VerboseTrace;import com.summitprojects.core3.display.StageRef;import com.summitprojects.core3.display.Rect;import com.summitprojects.core3.display.DisplayUtils;import com.summitprojects.core3.ui.keyboard.KeySequence;// Import project classes.import com.summitprojects.core3beta.ui.talktalktalk.TalkBar;import com.summitprojects.core3beta.ui.talktalktalk.TalkBarEvent;/** * Description goes here. * @class 			TalkTalkTalk * @author  		amoslanka @ summitprojects * @date			13.10.2009 * @version			0.1 * @langVersion		3 * @playerVersion	9**/public class TalkTalkTalk extends EventDispatcher implements /*IAnimatable,*/ IDisposable {		public static const CLASS_NAME:String = "TalkTalkTalk";		protected static var _instance:TalkTalkTalk;	protected var _target:Sprite;	protected var vt:VerboseTrace;	protected var em:EventManager;		protected var _bubbleContainer:DisplayObjectContainer;	protected var _talkbar:TalkBar;	protected var _hooks:Object;		/**	 * Constructor.	 * @param		target		The target Sprite.	 * @param		verbosity	The verbosity level.	**/	public function TalkTalkTalk(s:SingletonKey, parent:DisplayObjectContainer=null, verbosity:int=0) {		_target = targetFactory();		parent = parent ? parent : StageRef.stage;		parent.addChild(_target);		init(verbosity);	}	public static function getInstance(parent:DisplayObjectContainer=null, verbosity:int=0) : TalkTalkTalk {		if (!_instance) {			_instance = new TalkTalkTalk(new SingletonKey(), parent, verbosity);		}		return _instance;	}		public override function toString():String {		return CLASS_NAME;	}	protected function targetFactory() : Sprite {		return new Sprite();	}	// INITIALIZATION ===============================================================================================================	private function init(verbosity:int=0):void {		initVars(verbosity);		initObjects();		initEvents();				internalHooks();	}	protected function initVars(verbosity:int=0):void {		vt = new VerboseTrace(verbosity, "  [ " + CLASS_NAME + " ]  ");		em = new EventManager();		_hooks = {};		if (!(StageRef.stage.align == StageAlign.TOP_LEFT)) {			vt.warn(CLASS_NAME + " expects Stage.align property to be " + StageAlign.TOP_LEFT + " in order to display properly.");		}					}	protected function initObjects():void {		_bubbleContainer = new Sprite();		_target.addChild(_bubbleContainer);				buildTalkBar();			}	protected function initEvents():void {		/*em.addEvent(_target, Event.REMOVED_FROM_STAGE, onRemovedFromStage);*/				em.addEvent(_talkbar, TalkBarEvent.TALK, onTalkBarTalk);	}	/**	 * Disposes and removes references to any complex objects in order to properly be collected by the garbage collector.	**/	public function dispose():void {		em.unload();		_hooks = null;	}		protected function internalHooks() : void {		addHook("hooks", onHooksHook);	}		// ACTIONS =====================================================================================================================		protected function buildTalkBar() : void {		_talkbar = new TalkBar(null, TalkBar.ALIGN_DEFAULT, vt.verbosity);		_target.addChild(_talkbar.target);	}	public function printTalk( s:String ) : void {				var bubble:Sprite = buildTalkBubble(s);				_bubbleContainer.addChild(bubble);		DisplayUtils.center(bubble, StageRef.stage.getBounds(StageRef.stage));		/*Tweener.addTween(bubble, {_autoAlpha:0});*/		TweenLite.to(bubble, 0, {autoAlpha:0});		/*Tweener.addTween(bubble, {_autoAlpha:1, time:.2, delay:.01});*/		TweenLite.to(bubble, .2, {autoAlpha:1, delay:.01});		/*Tweener.addTween(bubble, {_autoAlpha:0, time:1, delay:4, onComplete:Callback.create(_bubbleContainer.removeChild, bubble) });*/		TweenLite.to(bubble, 1, {autoAlpha:0, delay:4, onComplete:Callback.create(_bubbleContainer.removeChild, bubble) });			}	protected function buildTalkBubble(s:String) : Sprite {				var sp:Sprite = new Sprite();		var bg:Shape = new Rect(0,0,10,10,0x333333,.8);		sp.addChild(bg);		var tf:TextField = new TextField()		tf.type = TextFieldType.DYNAMIC;		tf.textColor = 0xffffff;		tf.backgroundColor = 0x000000;		tf.text = s;		//tf.autoSize = TextFieldAutoSize.CENTER;		tf.width = Math.min(tf.textWidth + 10, 100);		tf.height = tf.textHeight + 4;		/*tf.embedFonts = true;*/				sp.addChild(tf);				bg.width = tf.width;		bg.height = tf.height;				return sp;			}			public function addHook(key:String, callback:Function) : Boolean {		if (!key || callback == null) return false;		key = cleanseKey(key);		if (key == "") return false;		if (_hooks[key]) return false;		_hooks[key] = callback;		return true;	}	public function removeHook(key:String) : Boolean {		delete _hooks[key];		return true;	}	public function removeAllHooks() : void {		/*			TODO 		*/		throw new Error("todo.");	}		protected function cleanseKey(s:String):String {		return s./*split(" ").join("").*/toLowerCase();	}		//--------------------------------------	//  ANIMATIONS	//--------------------------------------	public function intro(dly:Number=0, callback:Function=null, callbackParams:Array=null):void {		/*Tweener.addTween(_target, {_autoAlpha:1, time:.5, transition:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});*/		TweenLite.to(_target, .5, {autoAlpha:1, ease:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});	}	public function exit(dly:Number=0, callback:Function=null, callbackParams:Array=null):void {		/*Tweener.addTween(_target, {_autoAlpha:0, time:.5, transition:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});*/		TweenLite.to(_target, .5, {autoAlpha:0, ease:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});		}	//--------------------------------------	//  EVENT HANDLERS	//--------------------------------------	/*private function onRemovedFromStage(e:Event):void {		dispose();	}	*/		protected function onTalkBarTalk(e:TalkBarEvent) : void {				vt.trace(0, "Talk :: " + e.text);				var key:String = cleanseKey(e.text);		var hook:Function = _hooks[key];		if (hook != null) {			vt.trace(2, "hook found. " );			hook();		} else if (e.text != "") {			printTalk(e.text);		}			}		protected function onHooksHook() : void {		var h:Array = [];		for (var prop:String in _hooks){			h.push(prop);					}		printTalk(h.join(", "));	}		//--------------------------------------	//  GETTER / SETTERS	//--------------------------------------		/*public function get target():Sprite { return _target; }*/		// UTILITY =====================================================================================================================	/*	protected function $SP(clip:String, scope:DisplayObjectContainer=null):Sprite    { return MCUtils.getSP(scope?scope:_target, clip); }	protected function $MC(clip:String, scope:DisplayObjectContainer=null):MovieClip { return MCUtils.getMC(scope?scope:_target, clip); }	protected function $TF(clip:String, scope:DisplayObjectContainer=null):TextField { return MCUtils.getTF(scope?scope:_target, clip); }*/	}}class SingletonKey {};