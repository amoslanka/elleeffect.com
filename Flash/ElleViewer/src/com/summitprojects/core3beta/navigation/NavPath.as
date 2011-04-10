
package com.summitprojects.core3beta.navigation {

// Import Adobe classes.
import flash.display.*;
import flash.events.*;
import flash.geom.*;
import flash.net.*;
import flash.text.*;
import flash.utils.*;

// Import third-party classes.

// Import custom classes.
import com.summitprojects.core3.events.EventManager;
import com.summitprojects.core3.interfaces.IDisposable;
import com.summitprojects.core3.util.Callback;
import com.summitprojects.core3.util.Delay;
import com.summitprojects.core3.util.VerboseTrace;

// Import project classes.


/**
 * Description goes here.
 * @class 			NavPath
 * @author  		
 * @date			02.11.2009
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class NavPath /*extends String*/  {
	
	public static const CLASS_NAME:String = "NavPath";
	public function get className():String { return CLASS_NAME; }
	
	public static const DEFAULT_DELIMITERS:RegExp = /\//; //"/"
	public static const SINGLE_DELIMITER:String = "/";
	
	private var _instanceDelimiters:RegExp;
	private var vt:VerboseTrace;
	private var em:EventManager;
	
	private var _segments:Array;
	
	private var _removeWhitespace:Boolean = true;
	
	/**
	 * _history
	 * An array of past revisions of this navpath. 
	 * Implementaion STILL TO BE COMPLETED
	**/
	/*private var _history:Array;*/
	
	/**
	 * Constructor.
	 * @param		target		The target Sprite.
	 * @param		verbosity	The verbosity level.
	**/
	public function NavPath(val:String="", delimiters:RegExp=null,verbosity:int=0) {

		vt = new VerboseTrace(verbosity, "  [ " + className + " ]  ");
 		_instanceDelimiters = delimiters ? delimiters : DEFAULT_DELIMITERS;
		/*super(val.toLowerCase());*/
		/*init(verbosity);*/
		setPath(val);
		/*cleanse();*/
	}
	
	public function toString():String {
		return className + " >> value: " + value;
	}
	
	public function clone():NavPath
	{
        return new NavPath(this.value, _instanceDelimiters);
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
	}
	
	private function initObjects():void {
	}
	
	private function initEvents():void {
	}*/
	
	// DECONSTRUCTION =====================================================================================================================

	/**
	 * Disposes and removes references to any complex objects in order to properly be collected by the garbage collector.
	**/
	public function dispose():void {
		/*em.unload();*/
	}
	
	// ACTIONS =====================================================================================================================
	
	public function setPath(s:String) : void {
		
		s = s.toLowerCase();								// case insensetive
		s = s.replace(new RegExp('[ \n\t\r]', 'g'), ''); 	// remove white space
		
		_segments = s.split(_instanceDelimiters);
		cleanse();
	}
	
	public function cleanse() : String {
		var a:Array = _segments;
		var len:uint = a.length;
		for (var i:int = 0; i < len; i++){
			if (a[i] != null) a[i] = a[i];
			if (a[i] == "") {
				a.splice(i, 1);
				i--;
			}
		}
		return value;
	}

	public function getSubnav(startIndex:int=1) : String { 
		return buildString(getArray(startIndex));
	}
	
	public function getArray(startIndex:int=0, endIndex:int=10000) : Array {
		return _segments.slice(startIndex); 
	}
	
	protected function buildString(array:Array=null) : String {
		if (!array) array = _segments;
		return array.join(SINGLE_DELIMITER);
	}
	
	public function getSegment(index:int=0) : String {
		return _segments[index];
	}
	
	public function getSegmentAsNumber(index:int=0) : Number {
		return parseFloat(_segments[index]);
	}
	
	//--------------------------------------
	//  ANIMATIONS
	//--------------------------------------


	//--------------------------------------
	//  EVENT HANDLERS
	//--------------------------------------

	
	//--------------------------------------
	//  GETTER / SETTERS
	//--------------------------------------
	
	public function get value() : String {
		return _segments.join(SINGLE_DELIMITER);
	}
	
	public function get first() : String { return getSegment(0); }
	public function get second() : String { return getSegment(1); }
	public function get third() : String { return getSegment(2); }
	
	// UTILITY =====================================================================================================================
	
	
}

}
