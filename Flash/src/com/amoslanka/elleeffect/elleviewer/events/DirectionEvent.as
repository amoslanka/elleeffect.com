package com.amoslanka.elleeffect.elleviewer.events {

// Import Adobe classes.
import flash.events.Event;

// Import third-party classes.

// Import custom classes.
import com.summitprojects.core3.util.VerboseTrace;

// Import project classes.



/**
 * Description goes here.
 * @class			DirectionEvent
 * @author			Amos Lanka
 * @date			2010.04.07
 * @version			0.1
**/
public class DirectionEvent extends Event {
	
	public static const CLASS_NAME:String = "DirectionEvent";
	public static const GO:String = "DirectionEvent-GO";
	
	public static const LEFT:String = "left";
	public static const RIGHT:String = "right";

	private var _direction:String;
	
	/**
	 * Constructor.
	 * @param		verbosity	int. Optional, defaults to 0. The verbosity level.
	**/
	public function DirectionEvent(dir:String, type:String=GO, bubbles:Boolean=true, cancelable:Boolean=false, verbosity:int=0) {
		_direction = dir;
		super(type, bubbles, cancelable);
		trace(type);
	}
	
	override public function clone():Event {
		return new DirectionEvent(direction, type, bubbles, cancelable);
	}
	
	public override function toString():String { 
		return formatToString("DirectionEvent", "type", "direction"); 
	}

	public function get direction() : String { return _direction; }
	public function set direction( arg:String ) : void { _direction = arg; }
	
}

}
