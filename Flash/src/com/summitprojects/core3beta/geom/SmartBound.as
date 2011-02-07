
package com.summitprojects.core3beta.geom { 

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
 * @class 			SmartBound
 * @author  		amoslanka @ summitprojects
 * @date			22.10.2009
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class SmartBound extends Rectangle /*implements IDisposable*/ {
	
	public static const CLASS_NAME:String = "SmartBound";
	public function get className():String { return CLASS_NAME; }
	
	public static const BOTTOM : String = "B";
	public static const BOTTOM_LEFT : String = "BL";
	public static const BOTTOM_RIGHT : String = "BR";
	public static const LEFT : String = "L";
	public static const RIGHT : String = "R";
	public static const TOP : String = "T";
	public static const TOP_LEFT : String = "TL";
	public static const TOP_RIGHT : String = "TR";
	public static const CENTER : String = "C";
	public static const DEFAULT_ALIGNMENT : String = TOP_LEFT;
	
	protected var _alignment:String;
	/*protected var vt:VerboseTrace;
	protected var em:EventManager;*/
	
	
	/**
	 * Constructor.
	 * @param		target		The target Sprite.
	 * @param		verbosity	The verbosity level.
	**/
	public function SmartBound(x:Number=0, y:Number=0, w:Number=0, h:Number=0, align:String=DEFAULT_ALIGNMENT, verbosity:int=0) {
		_alignment = align;
		super(x,y,w,h);
	}
	
	public override function toString():String {
		return className + ": " + super.toString() + " alignment: " + alignment;
	}

	// INITIALIZATION ===============================================================================================================
	
	public override function clone() : Rectangle {
		return new SmartBound(x,y,width,height,alignment);
	}
	
	public static function convertRectangle(rect:Rectangle, align:String=DEFAULT_ALIGNMENT) : SmartBound {
		
		return new SmartBound(rect.x,rect.y,rect.width,rect.height,align);
	}

	// DECONSTRUCTION =====================================================================================================================
	
	// ACTIONS =====================================================================================================================

	public function autoAlign(objectToAlign:Object) : void {
		SmartBoundHelper.autoAlign(objectToAlign,this);
	}
	
	//--------------------------------------
	//  EVENT HANDLERS
	//--------------------------------------

	//--------------------------------------
	//  GETTER / SETTERS
	//--------------------------------------
	
	public function get alignment() : String { return _alignment; }
	public function set alignment( arg:String ) : void { _alignment = arg; }
	
	// UTILITY =====================================================================================================================
	
	
}

}
