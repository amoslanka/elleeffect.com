
package com.amoslanka.elleeffect.elleviewer {

// Import Adobe classes.
/*import flash.display.*;
import flash.events.*;
import flash.geom.*;
import flash.net.*;
import flash.text.*;
import flash.utils.*;*/

// Import third-party classes.

// Import custom classes.

// Import project classes.


/**
 * Description goes here.
 * @class 			Config
 * @author  		amoslanka
 * @date			2010.02.07
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class Config  {
	
	public static const CLASS_NAME:String = "Config";



	public static const THUMBS_PER_ROW : int = 10;
	public static const THUMB_WIDTH : int = 85;

	public static function get VIEWER_WIDTH() : int { return THUMB_WIDTH * THUMBS_PER_ROW; }
	public static function get VIEWER_HEIGHT() : int { return VIEWER_WIDTH * .75; }


	
}

}
