package com.summitprojects.core3beta.ui.talktalktalk {

// Import Adobe classes.
import flash.events.Event;

// Import third-party classes.

// Import custom classes.
import com.summitprojects.core3.util.VerboseTrace;
import com.summitprojects.core3.interfaces.IDisposable;

// Import project classes.



/**
 * Description goes here.
 * @class			TalkBarEvent
 * @author			
 * @date			13.10.2009
 * @version			0.1
**/
public class TalkBarEvent extends Event implements IDisposable {
	
	public static const CLASS_NAME:String = "TalkBarEvent";
	public static const TALK:String = "onTalk";
	
	/*private var vt:VerboseTrace;*/
	private var _text:String;
	
	
	/**
	 * Constructor.
	 * @param		verbosity	int. Optional, defaults to 0. The verbosity level.
	**/
	public function TalkBarEvent(type:String, text:String, bubbles:Boolean=true, cancelable:Boolean=false, verbosity:int=0) {
		_text = text;
		super(type, bubbles, cancelable);
		init(verbosity);
	}
	
	override public function clone():Event {
		return new TalkBarEvent(type, text, bubbles, cancelable, 0);
	}
	
	public override function toString():String { 
		return formatToString("TalkBarEvent", "type", "text"); 
	}


	// INITIALIZATION ============================================================================================================
	private function init(verbosity:int=0):void {
		initVars(verbosity);
		initObjects();
		initEvents();
	}
	
	private function initVars(verbosity:int=0):void {
		/*vt = new VerboseTrace(verbosity, "  [ " + CLASS_NAME + " ]  ");*/
	}
	
	private function initObjects():void {
	}
	
	private function initEvents():void {
	}

	/**
	 * Disposes and removes references to any complex objects in order to properly be collected by the garbage collector.
	**/
	public function dispose():void {
	}
	
	
	
	
	// ACTIONS ===================================================================================================================
	
	
	
	// SETTERS AND GETTERS =======================================================================================================
	public function get text() : String { return _text; }
	
	
	// EVENTS ====================================================================================================================
	
}

}
