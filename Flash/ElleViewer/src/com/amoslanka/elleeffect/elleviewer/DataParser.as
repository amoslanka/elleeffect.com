
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
	
	public static var allImages:Array = [];
	public static var galleries:Array;
	
	public static function parse(xml:XML) : void {

		// trace("xml " + xml)

		if (!xml) return;
		allImages = [];
		galleries = [];

		var gallery:GalleryModel;
		var galleryList:XMLList = xml..gallery;
		var galleryXML:XML;
		
		var images:Array;
        var image:ImageModel;
        var imageXML:XML;
		var imageList:XMLList;
		
		for (var i:int = 0; i<galleryList.length(); i++){
			galleryXML = galleryList[i];
			imageList =  galleryXML..image;
			images = [];
			
			if (imageList.length() <= 0) continue;
			
			for (var j:int = 0; j < imageList.length(); j++)
			{
			    imageXML = imageList[j];
                image = new ImageModel(imageXML.permalink, imageXML.description, imageXML.thumbUrl, imageXML.imageUrl, galleryXML.permalink);
                images.push(image);
                allImages.push(image);
			}
			
			
			gallery = new GalleryModel(galleryXML.title, galleryXML.permalink, images);
			galleries.push(gallery);
		}
        
        
	}


    public static function getGallery(permalink:String):GalleryModel
    {
        for (var i:int = 0; i < galleries.length; i++)
        {
            if (galleries[i].permalink == permalink)
            {
                return galleries[i];
            }
        }
        return null;
    }
    public static function getImageFromGallery(id:String, galleryPermalink:String):ImageModel
    {
        var gallery:GalleryModel = getGallery(galleryPermalink);
        
        if (!gallery) return null;
        
        for (var i:int = 0; i < gallery.images.length; i++)
        {
            if (gallery.images[i].id == id)
            {
                return gallery.images[i];
            }
        }
        return null;
    }
    public static function getImage(id:String):ImageModel
    {
        
        trace(" >> allImages: " + allImages.length);

        for (var i:int = 0; i < allImages.length; i++)
        {
            if (allImages[i].id == id)
            {
                return allImages[i];
            }
        }
        return null;
    }
	
	
}

}
