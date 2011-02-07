
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
import com.summitprojects.core3.util.Callback;

// Import project classes.


/**
 * Description goes here.
 * @class 			AutoArrange
 * @author  		amoslanka @ summitprojects
 * @date			23.10.2009
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class AutoArrange {
	
	public static const CLASS_NAME:String = "AutoArrange";
	public function get className():String { return CLASS_NAME; }
	
	public static const HORIZONTAL:String = "horizontal";
	public static const VERTICAL:String = "vertical";

	public static function arrange(items:Array, arrangeTo:String=HORIZONTAL, margin:Number=0) : void {
		if (!items) throw new Error("Array of items to arrange must be defined.");
		
		var len:int = items.length;
		var item:*;
		var last:*;
		try {
			
			for (var i:int = 0; i<len; i++){
				item = items[i];
				if (item) {
					switch (arrangeTo){
						case HORIZONTAL :
							item.x = last ? last.x + last.width + margin : 0;
						break;
						case VERTICAL :
							item.y = last ? last.y + last.height + margin : 0;
						break;
					}
					last = item;
				}
			}

		} catch (e:Error) {
			throw new Error("All items in the array must have x,y and width,height setters. " + e.message);
		}
	}
	
	
	
	

}

}
