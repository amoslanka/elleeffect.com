
package com.summitprojects.core3beta.geom {

// Import Adobe classes.
/*import flash.display.*;*/
/*import flash.events.*;*/
import flash.geom.*;
/*import flash.net.*;*/
/*import flash.text.*;*/
import flash.utils.*;

// Import third-party classes.

// Import custom classes.
import com.summitprojects.core3.util.VerboseTrace;
import com.summitprojects.core3beta.geom.SmartBound;

// Import project classes.


/**
 * Description goes here.
 * @class 			SmartBoundHelper
 * @author  		amoslanka @ summitprojects
 * @date			22.10.2009
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class SmartBoundHelper {
	
	public static const CLASS_NAME:String = "SmartBoundHelper";
	public function get className():String { return CLASS_NAME; }
	
	/**
	 * Automatically aligns the object provided to the bounds rectangle. Uses the alignment property
	 * of the SmartBound object, which extends Rectangle. If the provided bounds is not a SmartBound, 
	 * a default alignment of TOP_LEFT will be used.
	 * @param	obj	The object to align.
	 * @param	bounds	A Rectangle object whose properties will be used in the alignment.
	**/
	public static function autoAlign(obj:Object, bounds:Rectangle) : void {
		var sb:SmartBound;
		sb = (bounds && bounds is SmartBound) ? bounds as SmartBound : SmartBound.convertRectangle(bounds);

		/*trace("autoAlign: " + sb.alignment);
		trace("bounds.x : " + bounds.x);
		trace("bounds.y : " + bounds.y);
		trace("bounds.w : " + bounds.width);
		trace("bounds.h : " + bounds.height);
		trace("obj.x : " + obj.x);
		trace("obj.y : " + obj.y);
		trace("obj.w : " + obj.width);
		trace("obj.h : " + obj.height);*/

		switch (sb.alignment){
			// TOP
			case SmartBound.TOP :
			case SmartBound.TOP_LEFT :
			case SmartBound.TOP_RIGHT :
				obj.y = sb.top;
			break;
			// BOTTOM
			case SmartBound.BOTTOM :
			case SmartBound.BOTTOM_LEFT :
			case SmartBound.BOTTOM_RIGHT :
				obj.y = sb.bottom - obj.height;
			break;
			
			case SmartBound.LEFT :
			case SmartBound.RIGHT :
			case SmartBound.CENTER :
				// vertical center
				obj.y = sb.y + (sb.height - obj.height)*.5;
			break;
		}
		switch (sb.alignment){
			// LEFT
			case SmartBound.LEFT :
			case SmartBound.BOTTOM_LEFT :
			case SmartBound.TOP_LEFT :
				obj.x = sb.left;
			break;
			// RIGHT
			case SmartBound.RIGHT :
			case SmartBound.BOTTOM_RIGHT :
			case SmartBound.TOP_RIGHT :
				obj.x = sb.right - obj.width;
			break;
			
			case SmartBound.TOP :
			case SmartBound.BOTTOM :
			case SmartBound.CENTER :
				// horizontal center
				obj.x = sb.x + (sb.width - obj.width)*.5;
			break;
		}
		
	}
	
	/**
	 * Automatically sizes the object provided to the size of the bounds provided.
	 * Ignores the x/y values of the Rectangle.
	 * @param	obj	The object to size.
	 * @param	bounds	A Rectangle object whose width and height properties will be used in the sizing.
	**/
	public static function autoSize(obj:Object, bounds:Rectangle) : void {
		if (!obj || !bounds) {
			throw new Error("You must provide valid object and bounds properties.");
		}
		var sb:SmartBound;
		sb = (bounds && bounds is SmartBound) ? bounds as SmartBound : SmartBound.convertRectangle(bounds);
		obj.height = bounds.height;
		obj.width = bounds.width;
	}
	

	
}

}
