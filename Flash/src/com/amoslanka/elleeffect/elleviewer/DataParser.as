
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
import com.summitprojects.core3.util.VerboseTrace;

// Import project classes.
import com.amoslanka.elleeffect.elleviewer.ImageModel;


/**
 * Description goes here.
 * @class 			DataParser
 * @author  		amoslanka
 * @date			2010.02.06
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class DataParser {
	
	public static const CLASS_NAME:String = "DataParser";
	public function get className():String { return CLASS_NAME; }
	
	private var vt:VerboseTrace;
	
	public static function parse(xml:XML) : Array {

		trace("xml " + xml)

		if (!xml) return [];
		
		/*var thumbPath:String = xml.@thumbPath;
		var imagePath:String = xml.@imagePath;*/
		
		var items:Array = [];
		var item:ImageModel;
		var itemXML:XML;
		var imageList:XMLList = xml..image;
		
		for (var i:int = 0; i<imageList.length(); i++){
			itemXML = imageList[i];
			item = new ImageModel(itemXML.name, itemXML.description, itemXML.thumbUrl, itemXML.imageUrl);
			items.push(item);
		}
		return items;
	}
	
	
}

}
