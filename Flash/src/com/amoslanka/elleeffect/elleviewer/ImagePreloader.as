
package com.amoslanka.elleeffect.elleviewer {

// Import Adobe classes.
import flash.display.*;
import flash.events.*;
import flash.geom.*;
import flash.net.*;
import flash.text.*;
import flash.utils.*;

// Import third-party classes.
/*import caurina.transitions.*;
import caurina.transitions.properties.*;*/

// Import custom classes.
import com.summitprojects.core3.animation.IAnimatable;
import com.summitprojects.core3.events.EventManager;
import com.summitprojects.core3.interfaces.IDisposable;
import com.summitprojects.core3.util.Callback;
import com.summitprojects.core3.util.Delay;
import com.summitprojects.core3.util.MCUtils;
import com.summitprojects.core3.util.VerboseTrace;
import com.summitprojects.core3.display.preloader.Preloader;
import com.summitprojects.core3.display.preloader.IPreloaderComponent;

// Import project classes.


/**
 * Description goes here.
 * @class 			ImagePreloader
 * @author  		Amos Lanka
 * @date			2010.04.12
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class ImagePreloader extends Preloader {
	
	public static const CLASS_NAME:String = "ImagePreloader";
	override public function get className():String { return CLASS_NAME; }
	
	private var _label:TextField;
	
	/**
	 * Constructor.
	 * @param		target		The target Sprite.
	 * @param		verbosity	The verbosity level.
	**/
	public function ImagePreloader(monitorObject:IEventDispatcher=null, verbosity:int=0) {
		super(new Preloader_Graphic(), monitorObject, verbosity);
		_target.mouseEnabled = false;
		_target.mouseChildren = false;
	}
	
	// INITIALIZATION ===============================================================================================================
	
	override protected function createChildren():void {
		super.createChildren();
		_label = $TF("label_tf");
	}
	
	// ACTIONS =====================================================================================================================
	
	override public function progress(loaded:uint=0, total:uint=0) : void {
		super.progress(loaded, total);
		
		_label.text = "" + quantize(Math.ceil(percentLoaded*100)+1, 5);// + "%";
		vt.trace(0, "progress: " + _label.text);
	}
	
	public static function quantize(num:Number, precision:Number=0, method:String="normal"):Number {
		var val:Number;
		switch (method){
			case "ceil" :
			val = (Math.ceil(num / precision) * precision);
			break;
			case "floor" :
			val = (Math.floor(num / precision) * precision);
			break;
			default:
			val = (Math.round(num / precision) * precision);
		}
		return val;
	}
	
}

}
