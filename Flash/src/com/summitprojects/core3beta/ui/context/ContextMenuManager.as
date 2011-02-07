
package com.summitprojects.core3beta.ui.context {

// Import Adobe classes.
import flash.display.*;
import flash.events.*;
import flash.geom.*;
import flash.net.*;
import flash.text.*;
import flash.utils.*;
import flash.ui.*;

// Import third-party classes.

// Import custom classes.
import com.summitprojects.core3.events.EventManager;
import com.summitprojects.core3.util.Callback;
import com.summitprojects.core3.util.VerboseTrace;

// Import project classes.


/**
 * 
 * @class 			ContextMenuManager
 * @author  		amoslanka @ summitprojects
 * @date			10.14.2009
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class ContextMenuManager {
	
	public static const CLASS_NAME:String = "ContextMenuManager";
	
	/*private var _target:Sprite;*/
	private static var _hasInit:Boolean = false;
	private static var vt:VerboseTrace;
	private static var em:EventManager;
	
	private static var _globalItems:Array;
	private static var _globalItemIds:Array;
	private static var _globalItemCallbacks:Array;
	
	private static var _globalMenu:ContextMenu;
	

	//--------------------------------------
	//  INITIALIZATION
	//--------------------------------------

	public function toString():String {
		return CLASS_NAME;
	}

	/**
	 * init
	**/
	public static function init(verbosity:int=0):void {
		if (_hasInit) return;
		_hasInit = true;
		initVars(verbosity);
		/*initObjects();
		initEvents();*/
	}
	
	private static function initVars(verbosity:int=0):void {
		vt = new VerboseTrace(verbosity, "  [ " + CLASS_NAME + " ]  ");
		em = new EventManager();
		
		clear();
	}
	
	/*private function initObjects():void {
	}
	
	private function initEvents():void {
		em.addEvent(_target, Event.REMOVED_FROM_STAGE, onRemovedFromStage);
	}*/
	
	/**
	 * clear
	 * Destoys the menu and global menu items.
	**/
	public static function clear():void {
		if (em) em.unload();
		
		_globalMenu = new ContextMenu();
		_globalItems = [];
		_globalItemIds = [];
		_globalItemCallbacks = [];

	}
	
	
	//--------------------------------------
	//  ACTIONS
	//--------------------------------------
	
	/**
	 * Adds a menu item that will be applied to all global lists of menu items. 
	 * @param	text	The menu text to be displayed.
	 * @param	callback	The function to be called when the item is selected.
	 * @returns	ContextMenuItem. The item created.
	**/
	public static function addGlobalItem(text:String, callback:Function=null) : ContextMenuItem {
		init();
		
		var item:ContextMenuItem = new ContextMenuItem(text);
		
		_globalItemIds.push(text);
		_globalItems.push(item);
		_globalItemCallbacks.push(callback);
		em.addEvent(item, ContextMenuEvent.MENU_ITEM_SELECT, onItemSelect);
		
		_globalMenu.customItems = [];
		for each (var gItem:ContextMenuItem in _globalItems){
			_globalMenu.customItems.push(gItem);
		}
		
		return item;
		
	}
	public static function removeGlobalItem(item:ContextMenuItem) : void {
		init();
		throw new Error("this method not set up yet.");
	}
	
	/**
	 * Creates a context menu on the InteractiveObject passed in. Automatically adds the global items if requested. 
	 * @param	object	The object on which to construct the ContextMenu
	 * @param	localItems	The items specific to the object passed in. These are optional and should be null or empty if only the global items are desired.
	 * @param	includeGlobal	Whether to include the set of global menu items held by this class.
	 * @param	hideBuiltInItems	Whether to hide or show the built in menu items.
	**/
	public static function buildMenu(object:InteractiveObject, localItems:Array=null, includeGlobal:Boolean=true, hideBuiltInItems:Boolean=true) : ContextMenu {
		if (!object) throw new Error("Must provide a valid InteractiveObject");
		if (!localItems) localItems = [];
		var contextMenu:ContextMenu = new ContextMenu(); // _globalMenu.clone(); CLONING ALSO CLONES ITEMS.
		var item:ContextMenuItem;
		var len:int;
		var i:int;
		
		if (hideBuiltInItems) contextMenu.hideBuiltInItems();
		if (includeGlobal) {
			len = _globalItems.length;
			for (i = 0; i<len; i++){
				item = _globalItems[i];
				contextMenu.customItems.push(item);
			}
		}
		
		len = localItems.length;
		for (i = 0; i<len; i++){
			item = localItems[i];
			contextMenu.customItems.push(item);
		}
		
		/*vt.trace(0, "««««« contextMenu »»»»»");
		for each (item in contextMenu.customItems){
			vt.trace(0, " " + item.caption);
		}*/
		
		object.contextMenu = contextMenu;
		return contextMenu;
	}
	
	//--------------------------------------
	//  EVENT HANDLERS
	//--------------------------------------

	/**
	 * onItemSelect
	**/
	private static function onItemSelect(e:ContextMenuEvent) : void {
		vt.trace(2, "onItemSelect :: " + (e.target as ContextMenuItem).caption);

		var item:ContextMenuItem = e.target as ContextMenuItem;
		/*dispatchEvent(e);*/
		var index:int = _globalItems.indexOf(item);
		var callback:Function = _globalItemCallbacks[index];
		if (index >= 0 && callback != null) {
			callback();
		}
	}
	
	//--------------------------------------
	//  GETTER / SETTERS
	//--------------------------------------	

	
}

}
