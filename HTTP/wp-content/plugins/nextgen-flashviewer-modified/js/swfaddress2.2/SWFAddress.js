/**
 * SWFAddress 2.2: Deep linking for Flash and Ajax <http://www.asual.com/swfaddress/>
 *
 * SWFAddress is (c) 2006-2008 Rostislav Hristov and contributors
 * This software is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 *
 */

/**
 * @class The SWFAddress class can be configured with query parameters using the following format:
 * swfaddress.js?html=false&history=1&tracker=pageTracker._trackPageview&strict=1.<br /> 
 * The list of supported options include:<br /><br />
 * <code>history:Boolean</code> - Enables or disables the creation of history entries.<br />
 * <code>html:Boolean</code> - Enables or disables the usage of swfaddress.html.<br />
 * <code>strict:Boolean</code> - Enables or disables the strict mode.<br />
 * <code>tracker:String</code> - Sets a function for page view tracking.<br />
 * @static 
 * @author Rostislav Hristov <http://www.asual.com>
 */ 
SWFAddress = asual.swfaddress.SWFAddress = new function() {

    var UNDEFINED = 'undefined', 
        _t = top, 
        _l = _t.location, 
        _ref = this, 
        _ids = [],
        _popup = [],        
        _listeners = {},
        _util = asual.util,
        _functions = asual.util.Functions,
        _webaddress = asual.swfaddress.WEBAddress;
    
    for (var p in _webaddress)
        this[p] = _webaddress[p];
    
    var _jsDispatch = function(type) {
        this.dispatchEvent(new SWFAddressEvent(type));
        type = type.substr(0, 1).toUpperCase() + type.substr(1);
        if(typeof this['on' + type] == 'function')
            this['on' + type]();
    }
    
    var _bodyClick = function(e) {
        if (_popup.length > 0) {
            var popup = window.open(_popup[0], _popup[1], eval(_popup[2]));
            if (typeof _popup[3] != UNDEFINED)
                eval(_popup[3]);
        }
        _popup = [];
    }
            
    var _init = function() {
        if (_util.Browser.isSafari())
            document.body.addEventListener('click', _bodyClick)
        _jsDispatch.call(this, 'init');
    }
    
    var _change = function() {
        _swfChange();
        _jsDispatch.call(this, 'change');        
    }

    var _swfChange = function() {
        for (var i = 0, id, obj, value = SWFAddress.getValue(), setter = 'setSWFAddressValue'; id = _ids[i]; i++) {
            obj = document.getElementById(id);
            if (obj) {
                if (obj.parentNode && typeof obj.parentNode.so != UNDEFINED) {
                    obj.parentNode.so.call(setter, value);
                } else {
                    if (!(obj && typeof obj[setter] != UNDEFINED)) {
                        var objects = obj.getElementsByTagName('object');
                        var embeds = obj.getElementsByTagName('embed');
                        obj = ((objects[0] && typeof objects[0][setter] != UNDEFINED) ? 
                            objects[0] : ((embeds[0] && typeof embeds[0][setter] != UNDEFINED) ? 
                                embeds[0] : null));
                    }
                    if (obj)
                        obj[setter](decodeURIComponent(value));
                } 
            } else if (obj = document[id]) {
                if (typeof obj[setter] != UNDEFINED)
                    obj[setter](value);
            }
        }
    }
    
    /**
     * The string representation of this class.
     * @return {String}     
     * @static
     * @ignore
     */
    this.toString = function() {
        return '[class SWFAddress]';
    }

    /**
     * Registers an event listener.
     * @param {String} type Event type.
     * @param {Function} listener Event listener.
     * @return {void}
     * @static
     */
    this.addEventListener = function(type, listener) {
        if (typeof _listeners[type] == UNDEFINED)
            _listeners[type] = [];
        _listeners[type].push(listener);
    }

    /**
     * Removes an event listener.
     * @param {String} type Event type.
     * @param {Function} listener Event listener.
     * @return {void}
     * @static     
     */
    this.removeEventListener = function(type, listener) {
        if (typeof _listeners[type] != UNDEFINED) {
            for (var i = 0, l; l = _listeners[type][i]; i++)
                if (l == listener) break;
            _listeners[type].splice(i, 1);
        }
    }

    /**
     * Dispatches an event to all the registered listeners. 
     * @param {Object} event Event object.
     * @return {Boolean}
     * @static
     */
    this.dispatchEvent = function(event) {
        if (typeof _listeners[event.type] != UNDEFINED && _listeners[event.type].length) {
            event.target = this;
            for (var i = 0, l; l = _listeners[event.type][i]; i++)
                l(event);
            return true;           
        }
        return false;
    }

    /**
     * Checks the existance of any listeners registered for a specific type of event. 
     * @param {String} event Event type.
     * @return {Boolean}
     * @static
     */
    this.hasEventListener = function(type) {
        return (typeof _listeners[type] != UNDEFINED && _listeners[type].length > 0);
    }
    
    /**
     * Opens a new URL in the browser. 
     * @param {String} url The resource to be opened.
     * @param {String} target Target window.
     * @return {void}
     * @static
     */
    this.href = function(url, target) {
        target = typeof target != UNDEFINED ? target : '_self';     
        if (target == '_self')
            self.location.href = url; 
        else if (target == '_top')
            _l.href = url; 
        else if (target == '_blank')
            window.open(url); 
        else
            _t.frames[target].location.href = url; 
    }

    /**
     * Opens a browser popup window. 
     * @param {String} url Resource location.
     * @param {String} name Name of the popup window.
     * @param {String} options Options which get evaluted and passed to the window.open() method.
     * @param {String} handler Optional JavaScript code for popup handling.    
     * @return {void}
     * @static
     */
    this.popup = function(url, name, options, handler) {
        try {
            var popup = window.open(url, name, eval(options));
            if (typeof handler != UNDEFINED)
                eval(handler);
        } catch (ex) {}
        _popup = arguments;
    }

    /**
     * Provides a list of all the Flash objects registered. 
     * @return {Array}
     * @static
     */
    this.getIds = function() {
        return _ids;
    }

    /**
     * Provides the id the first and probably the only Flash object registered. 
     * @return {String}
     * @static
     */
    this.getId = function(index) {
        return _ids[0];
    }

    /**
     * Sets the id of a single Flash object which will be registered for deep linking.
     * @param {String} id ID of the object.
     * @return {void}
     * @static
     */
    this.setId = function(id) {
        _ids[0] = id;
    }
    
    /**
     * Adds an id to the list of Flash object registered for deep linking.
     * @param {String} id ID of the object.
     * @return {void}
     * @static
     */
    this.addId = function(id) {
        this.removeId(id);
        _ids.push(id);
    }

    /**
     * Removes an id from the list of Flash object registered for deep linking.
     * @param {String} id ID of the object.
     * @return {void}
     * @static
     */
    this.removeId = function(id) {
        for (var i = 0; i < _ids.length; i++) {
            if (id == _ids[i]) {
                _ids.splice(i, 1);
                break;
            }
        }
    }

    /**
     * Sets the current deep linking value.
     * @param {String} value A value which will be appended to the base link of the HTML document.
     * @return {void}
     * @static
     */
    this.setValue = function(value) {
        if (_ids.length > 0 != 0 && 
            _util.Browser.isFirefox() && 
            navigator.userAgent.indexOf('Mac') != -1)
            setTimeout(function() {
                _webaddress.setValue.call(SWFAddress, value);
            }, 500);
        else
            _webaddress.setValue.call(this, value);
    }

    _webaddress.addEventListener('init', _functions.bind(_init, this));
    _webaddress.addEventListener('change', _functions.bind(_change, this));

    /**
     * SWFAddress embed hooks.
     * @ignore
     */
    (function() {
    
        var _args;
    
        if (typeof FlashObject != UNDEFINED) SWFObject = FlashObject;
        if (typeof SWFObject != UNDEFINED && SWFObject.prototype && SWFObject.prototype.write) {
            var _s1 = SWFObject.prototype.write;
            SWFObject.prototype.write = function() {
                _args = arguments;
                if (this.getAttribute('version').major < 8) {
                    this.addVariable('$swfaddress', SWFAddress.getValue());
                    ((typeof _args[0] == 'string') ? 
                        document.getElementById(_args[0]) : _args[0]).so = this;
                }
                var success;
                if (success = _s1.apply(this, _args))
                    _ref.addId(this.getAttribute('id'));
                return success;
            }
        } 
        
        if (typeof swfobject != UNDEFINED) {
            var _s2r = swfobject.registerObject;
            swfobject.registerObject = function() {
                _args = arguments;
                _s2r.apply(this, _args);
                _ref.addId(_args[0]);
            }
            var _s2c = swfobject.createSWF;
            swfobject.createSWF = function() {
                _args = arguments;
                _s2c.apply(this, _args);
                _ref.addId(_args[0].id);
            }
            var _s2e = swfobject.embedSWF;
            swfobject.embedSWF = function() {
                _args = arguments;
                _s2e.apply(this, _args);
                _ref.addId(_args[8].id);
            }
        }
        
        if (typeof UFO != UNDEFINED) {
            var _u = UFO.create;
            UFO.create = function() {
                _args = arguments;
                _u.apply(this, _args);
                _ref.addId(_args[0].id);
            }
        }
        
        if (typeof AC_FL_RunContent != UNDEFINED) {
            var _a = AC_FL_RunContent;
            AC_FL_RunContent = function() {
                _args = arguments;        
                _a.apply(this, _args);
                for (var i = 0, l = _args.length; i < l; i++)
                    if (_args[i]== 'id') _ref.addId(_args[i+1]);
            }
        }
        
    })();
}