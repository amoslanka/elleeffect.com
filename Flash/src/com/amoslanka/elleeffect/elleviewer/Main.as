﻿package com.amoslanka.elleeffect.elleviewer {// Import Adobe classes.import flash.display.*;import flash.events.*;import flash.geom.*;import flash.net.*;import flash.text.*;import flash.system.*;import flash.utils.*;// Import third-party classes./*import caurina.transitions.*;import caurina.transitions.properties.*;*/import com.greensock.*;import com.greensock.plugins.*;import com.asual.swfaddress.*;// Import custom classes.import com.summitprojects.core3.animation.IAnimatable;import com.summitprojects.core3.data.xml.XMLLoader;import com.summitprojects.core3.display.StageRef;import com.summitprojects.core3.environment.FlashVars;import com.summitprojects.core3.environment.StageSizeController;import com.summitprojects.core3.events.EventManager;import com.summitprojects.core3.interfaces.IDisposable;import com.summitprojects.core3.util.Callback;import com.summitprojects.core3.util.Delay;import com.summitprojects.core3.util.MCUtils;import com.summitprojects.core3.util.VerboseTrace;import com.summitprojects.core3beta.navigation.NavPath;import com.summitprojects.core3beta.ui.talktalktalk.TalkTalkTalk;import com.summitprojects.core3.display.bounds.IBoundable;import com.summitprojects.core3beta.geom.SmartBound;import com.summitprojects.core3beta.geom.SmartBoundHelper;// Import project classes.import com.amoslanka.elleeffect.elleviewer.thumbnav.ThumbNav;import com.amoslanka.elleeffect.elleviewer.mainviewer.MainViewer;import com.amoslanka.elleeffect.elleviewer.events.DirectionEvent;import com.amoslanka.elleeffect.elleviewer.dirnav.DirNav;/** * Description goes here. * @class 			Main * @author  		amoslanka * @date			2010.02.06 * @version			0.1 * @langVersion		3 * @playerVersion	9**/public class Main extends Sprite implements IAnimatable, IDisposable, IBoundable {		public static const CLASS_NAME:String = "Main";	public function get className():String { return CLASS_NAME; }		private var _target:Sprite;	private var _bounds:Rectangle;	private var vt:VerboseTrace;	private var em:EventManager;		private var _dataLoader:XMLLoader;	private var _images:Array;		private var _thumbNav:ThumbNav;	private var _dirNav:DirNav;	private var _mainViewer:MainViewer;		private var _navPath:NavPath;	/**	 * _stageSizeController	 * Responsible for incoming and outgoing stage resize events.	 * Also handles params requested by ContentObjectModel's params (or flashvars, if needed)	 *   for setting min/max stagewidth/stageheight or simply locking it down altogether.	**/	protected var _stageSizeController:StageSizeController;		private var _talk:TalkTalkTalk;		/**	 * Constructor.	 * @param		target		The target Sprite.	 * @param		verbosity	The verbosity level.	**/	public function Main(target:Sprite=null, verbosity:int=0) {		_target = target ? target : this;		init(verbosity);	}		public override function toString():String {		return className + " >> target: " + _target.name;	}	// INITIALIZATION ===============================================================================================================	private function init(verbosity:int=0):void {		initVars(verbosity);		initObjects();		initEvents();			}		private function initVars(verbosity:int=0):void {		StageRef.init(target.stage);		StageRef.stage.align = StageAlign.TOP_LEFT;		StageRef.stage.scaleMode = StageScaleMode.NO_SCALE;		StageRef.stage.frameRate = 24;		StageRef.stage.stageFocusRect = false;				vt = new VerboseTrace(verbosity, "  [ " + className + " ]  ");		/*vt.traceBox = true;*/		em = new EventManager();				_stageSizeController = StageSizeController.getInstance();		_stageSizeController.addBoundedObject(this);				_stageSizeController.minWidth  = 1000;		_stageSizeController.minHeight = 650;		/*_stageSizeController.maxWidth  = 1000;		_stageSizeController.maxHeight = 1000;*/				TweenPlugin.activate([AutoAlphaPlugin]);				_talk = TalkTalkTalk.getInstance(StageRef.stage);		_talk.addHook("s", onTalkHook);				if (dataUrl != null) {			_dataLoader = new XMLLoader(dataUrl, onDataLoad, onDataError);		}	}		private function initObjects():void {		_navPath = new NavPath();	}		private function initEvents():void {		/*em.addEvent(_target, Event.REMOVED_FROM_STAGE, onRemovedFromStage);*/	}		// DECONSTRUCTION =====================================================================================================================	public function dispose():void {		em.unload();	}		// ACTIONS =====================================================================================================================		public function buildThumbNav() : void {				_thumbNav = new ThumbNav();		target.addChild(_thumbNav.target);		em.addEvent(_thumbNav, Event.CHANGE, onThumbNavChange);				_thumbNav.populate(_images);				if (_images.length > 0) {			_dirNav = new DirNav();			target.addChild(_dirNav.target);			em.addEvent(_dirNav, DirectionEvent.GO, onDirNavGo);			_dirNav.enable();		}			}	public function buildMainViewer() : void {		_mainViewer = new MainViewer();		target.addChild(_mainViewer.target);			}	private function doInitialNavigation() : void {		/*subnavigate("" + _thumbNav.lastIndex);*/		SWFAddress.onChange = onSWFAddressChange;		SWFAddress.onInit =   onSWFAddressInit  ;	}		public function navigate(path:String) : void {		vt.trace(0, "navigate: " + path);		SWFAddress.setValue(path);	}		public function subnavigate(path:String) : void {		vt.trace(0, "subnavigate: " + path);		_navPath.setPath(path);				var index:int = _navPath.getSegmentAsNumber(0);		if (index < 0) {			// navigate to previous portfolio page.									return;		}		if (index >= _images.lenth) {			// navigate to next portfolio page.;									return;		}		var image:ImageModel = _images[index];				if (image) {			_mainViewer.loadImageUrl(image.imageUrl);			_thumbNav.subnavigate(index);			_thumbNav.monitorPreload(index, _mainViewer.loader);		} else {			vt.warn("Image not found for nav path: " + path);		}			}		public function refreshStage() : void {		_stageSizeController.refresh();		/*setStageSize(b.width, b.height);*/	}	protected function setStageSize(w:Number,h:Number) : void {		vt.trace(0, "attempting to set stage size. " + w + "," + h);		_stageSizeController.setStageSize(w, h);	}		public function setBounds(rect:Rectangle) : void {		_bounds = rect;		vt.trace(0, "setBounds:  " + rect);				var thumbBounds:SmartBound = SmartBound.convertRectangle(_bounds, SmartBound.BOTTOM);		_thumbNav.setBounds(thumbBounds);		var actualThumbBounds:Rectangle = _thumbNav.getBounds(target);				var viewerBounds:SmartBound = new SmartBound();		viewerBounds.y = 32;		viewerBounds.width = _bounds.width;		viewerBounds.height = actualThumbBounds.top - viewerBounds.y;		viewerBounds.alignment = SmartBound.TOP;				vt.trace(0, "viewerBounds:  " + viewerBounds);		vt.trace(0, "thumbBounds:  " + thumbBounds);				_mainViewer.setBounds(viewerBounds);		_dirNav.setBounds(viewerBounds);	}		// ANIMATIONS ==================================================================================================================	public function intro(dly:Number=0, callback:Function=null, callbackParams:Array=null):void {		/*Tweener.addTween(_target, {_autoAlpha:1, time:.5, transition:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});*/		TweenLite.to(_target, .5, {autoAlpha:1, ease:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});	}	public function exit(dly:Number=0, callback:Function=null, callbackParams:Array=null):void {		/*Tweener.addTween(_target, {_autoAlpha:0, time:.5, transition:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});*/		TweenLite.to(_target, .5, {autoAlpha:0, ease:"easeOutQuad", delay:dly, onComplete:callback, onCompleteParams:callbackParams});				}	// EVENTS ======================================================================================================================	private function onDataError(e:Event) : void {		vt.warn("Error loading data.");	}	private function onDataLoad(xml:XML) : void {		_images = DataParser.parse(xml);		buildMainViewer();		buildThumbNav();		refreshStage();		doInitialNavigation();	}	private function onTalkHook(key:String) : void {		switch (key){			case "s" :				navigateToURL(new URLRequest(dataUrl), "_blank");			break;		}	}		private function onThumbNavChange(e:Event) : void {		navigate("" + _thumbNav.lastIndex);	}	private function onDirNavGo(e:DirectionEvent) : void {		vt.trace(0, "onDirNavGo " + e.direction);		switch (e.direction){			case DirectionEvent.LEFT :				navigate("" + (_thumbNav.lastIndex - 1));			break;			case DirectionEvent.RIGHT :				navigate("" + (_thumbNav.lastIndex + 1));			break;		}	}		private function onSWFAddressInit(e:Event=null) : void {		vt.trace(0, "onSWFAddressInit");		onSWFAddressChange(e);	}	private function onSWFAddressChange(e:Event=null) : void {		vt.trace(0, "onSWFAddressChange " + SWFAddress.getValue());		subnavigate(SWFAddress.getValue());	}		// SETTERS AND GETTERS =========================================================================================================		public function get target():Sprite { return _target; }	public function get dataUrl() : String { 		if (!inBrowser) return "http://localhost/elleeffect.com/wp-content/plugins/nextgen-flashviewer/xml/elleviewer.php?gid=4";		return FlashVars.getString("xmlDataPath"); 	}		// UTILITY =====================================================================================================================		protected function $SP(clip:String, scope:DisplayObjectContainer=null):Sprite    { return MCUtils.getSP(scope?scope:_target, clip); }	protected function $MC(clip:String, scope:DisplayObjectContainer=null):MovieClip { return MCUtils.getMC(scope?scope:_target, clip); }	protected function $TF(clip:String, scope:DisplayObjectContainer=null):TextField { return MCUtils.getTF(scope?scope:_target, clip); }	public static function get inBrowser():Boolean {		var value:Boolean;		switch (Capabilities.playerType) {			case "StandAlone":			case "External":				value = false;				break;			case "PlugIn":			case "ActiveX":				value = true;				break;		}		return value;		}	}}