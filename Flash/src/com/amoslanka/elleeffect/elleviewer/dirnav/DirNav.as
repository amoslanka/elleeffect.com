
package com.amoslanka.elleeffect.elleviewer.dirnav {

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
import com.summitprojects.core3.display.bounds.IBoundable;
import com.summitprojects.core3.display.Rect;
import com.summitprojects.core3.util.Callback;
import com.summitprojects.core3.util.Delay;
import com.summitprojects.core3.util.MCUtils;
import com.summitprojects.core3.util.VerboseTrace;
import com.summitprojects.core3.ui.buttons.IButtonComponent;
import com.summitprojects.core3.ui.buttons.AbstractButton;

// Import project classes.
import com.amoslanka.elleeffect.elleviewer.events.DirectionEvent;


/**
 * @class 			DirNav
 * @author  		Amos Lanka
 * @date			2010.04.07
 * @version			0.1
 * @langVersion		3
 * @playerVersion	9
**/

public class DirNav extends EventDispatcher implements IDisposable, IBoundable {
	
	public static const CLASS_NAME:String = "DirNav";
	public function get className():String { return CLASS_NAME; }
	
	private var _target:Sprite;
	private var vt:VerboseTrace;
	private var em:EventManager;
	
	private var _left:IButtonComponent;
	private var _right:IButtonComponent;
	
	private var _bounds:Rectangle;
	
	/**
	 * Constructor.
	 * @param		target		The target Sprite.
	 * @param		verbosity	The verbosity level.
	**/
	public function DirNav(target:Sprite=null, verbosity:int=0) {
		_target = target ? target : new Sprite();
		init(verbosity);
	}
	
	public override function toString():String {
		return className + " >> target: " + _target;
	}

	// INITIALIZATION ===============================================================================================================

	private function init(verbosity:int=0):void {
		initVars(verbosity);
		initObjects();
		initEvents();
	}
	
	private function initVars(verbosity:int=0):void {
		vt = new VerboseTrace(verbosity, "  [ " + className + " ]  ");
		em = new EventManager();
	}
	
	private function initObjects():void {
		var clip:Sprite;
		
		clip = new Sprite();
		clip.addChild(new Rect(0,0,10,10));
		clip.alpha = 0;
		_left = new AbstractButton(clip);
		clip = new Sprite();
		clip.addChild(new Rect(0,0,10,10));
		clip.alpha = 0;
		_right = new AbstractButton(clip);

		target.addChild(_left.target);
		target.addChild(_right.target);
		
		em.addEvent(_left, MouseEvent.CLICK, onButtonClick);
		em.addEvent(_right, MouseEvent.CLICK, onButtonClick);
		
		disable();
	}
	
	private function initEvents():void {
	}
	
	// DECONSTRUCTION =====================================================================================================================

	public function dispose():void {
		em.unload();
	}
	
	// ACTIONS =====================================================================================================================;
	
	public function enable() : void {
		_left.enable();
		_right.enable();
	}
	
	public function disable() : void {
		_left.disable();
		_right.disable();
	}
	
	public function setBounds(rect:Rectangle) : void {
		_bounds = rect;
		var clip:Sprite;
		
		clip = _left.target;
		clip.width = _bounds.width/2;
		clip.height = _bounds.height;
		clip.x = 0;
		clip.y = 0;
		
		clip = _right.target;
		clip.width = _bounds.width/2;
		clip.height = _bounds.height;
		clip.x = _bounds.width/2;
		clip.y = 0;
	}
	
	
	// EVENTS ======================================================================================================================
	
	private function onButtonClick(me:MouseEvent) : void {
		vt.trace(0, "onButtonClick: " + me.target);
		switch (me.target){
			case _left.target :
			case _left :
				vt.trace(0, "left. " );
				dispatchEvent(new DirectionEvent(DirectionEvent.LEFT));
			break;
			case _right.target :
			case _right :
				vt.trace(0, "right. " );
				dispatchEvent(new DirectionEvent(DirectionEvent.RIGHT));
			break;
		}
	}
	
	// SETTERS AND GETTERS =========================================================================================================
	
	public function get target():Sprite { return _target; }
	
	// UTILITY =====================================================================================================================
	
}

}
