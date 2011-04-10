
package com.amoslanka.elleeffect.elleviewer {

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
import com.summitprojects.core3.util.VerboseTrace;

// Import project classes.


/**
 * Description goes here.
 * @class 			GalleryModel
 * @author  		amoslanka
 * @date			2010.02.06
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class GalleryModel implements IDisposable {
	
	public static const CLASS_NAME:String = "GalleryModel";
	public function get className():String { return CLASS_NAME; }
	
    /*private var vt:VerboseTrace;*/
	
	private var _title:String;
	private var _permalink:String;
	private var _images:Array;
	
	public function GalleryModel(title:String, permalink:String, images:Array) {
        _title = title;
        _permalink = permalink;
        _images = images;
	}
	
	public function toString():String {
		return className;
	}

	// INITIALIZATION ===============================================================================================================

	// DECONSTRUCTION =====================================================================================================================

	public function dispose():void {
	}
	
	// ACTIONS =====================================================================================================================

	// EVENTS ======================================================================================================================
	
	// SETTERS AND GETTERS =========================================================================================================
	
	public function get title():String
	{
	   return _title;
	}
    public function get permalink():String
    {
        return _permalink;
    }
	public function get images():Array
	{
	   return _images;
	}
	
	// UTILITY =====================================================================================================================
	
}

}
