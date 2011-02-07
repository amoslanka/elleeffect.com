/**
 * SWFAddress 2.2: Deep linking for Flash and Ajax <http://www.asual.com/swfaddress/>
 *
 * SWFAddress is (c) 2006-2008 Rostislav Hristov and contributors
 * This software is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 *
 */

/**
 * @class Base class for browser deep linking.
 * @static 
 * @author Rostislav Hristov <http://www.asual.com>
 * @author Matthew J Tretter <http://www.exanimo.com>
 * @author Max Tafelmayer <http://www.tafelmayer.de>
 * @author Piotr Zema <http://felixz.mark-naegeli.com>
 */
asual.swfaddress.WEBAddress = new function() {

    var ID = '',
        FUNCTION = 'function',
        UNDEFINED = 'undefined',
        _swfaddress = asual.swfaddress,
        _util = asual.util,
        _browser = _util.Browser, 
        _events = _util.Events,
        _functions = _util.Functions,
        _version = _browser.getVersion(),
        _supported = false,
        _t = top,
        _d = _t.document,
        _h = _t.history, 
        _l = _t.location,
        _si = setInterval,
        _st = setTimeout, 
        _dc = decodeURIComponent,
        _ec = encodeURIComponent,
        _iframe,
        _form,
        _url,
        _interval,
        _title = _d.title, 
        _length = _h.length, 
        _silent = false,
        _loaded = false,
        _justset = true,
        _juststart = true,
        _stack = [], 
        _listeners = {}, 
        _opts = {history: true, html: false, strict: true, tracker: '_trackDefault'};            
        
    if (_browser.isOpera())
        _supported = _version >= 9.02;

    if (_browser.isIE()) 
        _supported = _version >= 6;
        
    if (_browser.isSafari())
        _supported = _version >= 312;
        
    if (_browser.isChrome())
        _supported = _version >= 0.2;
        
    if (_browser.isCamino()) 
        _supported = _version >= 1;
        
    if (_browser.isFirefox())
        _supported = _version >= 1;

    if ((!_supported && _l.href.indexOf('#') != -1) || 
        (_browser.isSafari() && _version < 418 && _l.href.indexOf('#') != -1 && _l.search != '')){
        _d.open();
        _d.write('<html><head><meta http-equiv="refresh" content="0;url=' + 
            _l.href.substr(0, _l.href.indexOf('#')) + '" /></head></html>');
        _d.close();
    }

    var _getHash = function() {
        var index = _l.href.indexOf('#');
        return index != -1 ? _l.href.substr(index + 1) : '';
    }

    var _value = _getHash();

    var _strictCheck = function(value, force) {
        if (_opts.strict)
            value = force ? (value.substr(0, 1) != '/' ? '/' + value : value) : (value == '' ? '/' : value);
        return value;
    }

    var _ieLocal = function(value) {
        return (_browser.isIE() && _l.protocol == 'file:') ? _value.replace(/\?/, '%3F') : value;    
    }

    var _searchScript = function(el) {
        for (var i = 0, l = el.childNodes.length, s; i < l; i++) {
            if (el.childNodes[i].src)
                _url = String(el.childNodes[i].src);
            if (s = _searchScript(el.childNodes[i]))
                return s;
        }
    }
    
    var _titleCheck = function() {
        if (_browser.isIE() && _d.title != _title && _d.title.indexOf('#') != -1) {
            _d.title = _title;
            if (_opts.html && _iframe && _iframe.contentWindow && _iframe.contentWindow.document)
                _iframe.contentWindow.document.title = _title;
        }
    }

    var _listen = function() {
        if (!_silent) {
            var hash = _getHash();
            var diff = !(_value == hash || _value == _dc(hash) || _dc(_value) == hash);
            if (_browser.isSafari() && _version < 523) {
                if (_length != _h.length) {
                    _length = _h.length;
                    if (typeof _stack[_length - 1] != UNDEFINED)
                        _value = _stack[_length - 1];
                    _update.call(this);
                }
            } else if (_browser.isIE() && diff) {
                if (_version < 7)
                    _l.reload();
                else
                    this.setValue(hash);
            } else if (diff) {
                _value = hash;
                _update.call(this);
            }
            _titleCheck.call(this);
        }
    }

    var _jsDispatch = function(type) {
        this.dispatchEvent(new _swfaddress.WEBAddressEvent(type));
        type = type.substr(0, 1).toUpperCase() + type.substr(1);
        if(typeof this['on' + type] == FUNCTION)
            this['on' + type]();
    }

    var _jsInit = function() {
        _jsDispatch.call(this, 'init');
    }

    var _jsChange = function() {
        _jsDispatch.call(this, 'change');
    }

    var _update = function() {
        _jsChange.call(this);
        _st(_functions.bind(_track, this), 10);
    }

    var _trackDefault = function(value) {
        if (typeof urchinTracker == FUNCTION) 
            urchinTracker(value);
        if (typeof pageTracker != UNDEFINED && typeof pageTracker._trackPageview == FUNCTION)
            pageTracker._trackPageview(value);
    }
    
    eval('var _trackDefault = ' + _trackDefault + ';');
    
    var _track = function() {
        if (typeof _opts.tracker != UNDEFINED && eval('typeof ' + _opts.tracker + ' != "' + UNDEFINED + '"')) {
            var fn = eval(_opts.tracker);
            if (typeof fn == FUNCTION)
                fn(_dc((_l.pathname + (/\/$/.test(_l.pathname) ? '' : '/') + this.getValue()).replace(/\/\//, '/').replace(/^\/$/, '')));
        }
    }
    
    var _htmlWrite = function() {
        var doc = _iframe.contentWindow.document;
        doc.open();
        doc.write('<html><head><title>' + _d.title + '</title><script>var ' + ID + ' = "' + _ec(_getHash()) + '";</script></head></html>');
        doc.close();
    }

    var _htmlLoad = function() {
        var win = _iframe.contentWindow;
        var src = win.location.href;
        _value = (_opts.html) ? (src.indexOf('?') > -1 ? _dc(src.substr(src.indexOf('?') + 1)) : '') : 
            (typeof win[ID] != UNDEFINED ? _dc(win[ID]) : '');
        if (_opts.html)
            win.document.title = _title;
        if (_value != _getHash()) {
            _update.call(_swfaddress.WEBAddress);
            _l.hash = _ieLocal(_value);
        }
    }

    var _load = function() {
        if (!_loaded) {
            _loaded = true;
            var attr = 'id="' + ID + '" style="position:absolute;top:-9999px;"';
            if (_browser.isIE() && _version < 8) {
                _d.body.appendChild(_d.createElement('div')).innerHTML = '<iframe ' + attr + ' src="' + 
                    (_opts.html ? _url.replace(/\.js(\?.*)?$/, '.html') + '?' + _ec(_getHash()) : 'javascript:false;') + 
                    '" width="0" height="0"></iframe>';
                _iframe = _d.getElementById(ID);
                _st(function() {
                    _events.addListener(_iframe, 'load', _htmlLoad);            
                    if (!_opts.html && typeof _iframe.contentWindow[ID] == UNDEFINED) 
                        _htmlWrite();
                }, 50);
            } else if (_browser.isSafari()) {
                if (_version < 418) {
                    _d.body.innerHTML += '<form ' + attr + ' method="get"></form>';
                    _form = _d.getElementById(ID);
                }
                if (typeof _l[ID] == UNDEFINED) _l[ID] = {};
                if (typeof _l[ID][_l.pathname] != UNDEFINED) _stack = _l[ID][_l.pathname].split(',');
            }
            _st(_functions.bind(_jsInit, this), 1);
            _st(_functions.bind(_jsChange, this), 2);
            _st(_functions.bind(_track, this), 10);
            
            if (_browser.isIE() && _version >= 8) {
                _d.body.onhashchange = _functions.bind(_listen, this);
                _interval = _si(_functions.bind(_titleCheck, this), 50);
            } else {
                _interval = _si(_functions.bind(_listen, this), 50);
            }
        }
    }

    var _unload = function() {
        clearInterval(_interval);
    }
    
    /**
     * Init event.
     * @type Function
     * @event
     * @static
     */
    this.onInit = null;
    
    /**
     * Change event.
     * @type Function
     * @event
     * @static
     */
    this.onChange = null;
    
    /**
     * The string representation of this class.
     * @return {String}     
     * @static     
     * @ignore
     */
    this.toString = function() {
        return '[class WEBAddress]';
    }

    /**
     * Loads the previous URL in the history list.
     * @return {void}
     * @static
     */
    this.back = function() {
        _h.back();
    }

    /**
     * Loads the next URL in the history list.
     * @return {void}
     * @static
     */
    this.forward = function() {
        _h.forward();
    }
    
    /**
     * Navigates one level up in the deep linking path.
     * @return {void}
     * @static
     */
    this.up = function() {
        var path = this.getPath();
        this.setValue(path.substr(0, path.lastIndexOf('/', path.length - 2) + (path.substr(path.length - 1) == '/' ? 1 : 0)));
    }
    
    /**
     * Loads a URL from the history list.
     * @param {Number} delta An integer representing a relative position in the history list.
     * @return {void}
     * @static
     */
    this.go = function(delta) {
        _h.go(delta);
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
        if (this.hasEventListener(event.type)) {
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
     * Provides the base address of the document. 
     * @return {String}
     * @static
     */
    this.getBaseURL = function() {
        var url = _l.href;
        if (url.indexOf('#') != -1)
            url = url.substr(0, url.indexOf('#'));
        if (url.substr(url.length - 1) == '/')
            url = url.substr(0, url.length - 1);
        return url;
    }

    /**
     * Provides the state of the strict mode setting. 
     * @return {Boolean}
     * @static
     */
    this.getStrict = function() {
        return _opts.strict;
    }

    /**
     * Enables or disables the strict mode.
     * @param {Boolean} strict Strict mode state.
     * @return {void}
     * @static
     */
    this.setStrict = function(strict) {
        _opts.strict = strict;
    }

    /**
     * Provides the state of the history setting. 
     * @return {Boolean}
     * @static
     */
    this.getHistory = function() {
        return _opts.history;
    }

    /**
     * Enables or disables the creation of history entries.
     * @param {Boolean} history History state.
     * @return {void}
     * @static
     */
    this.setHistory = function(history) {
        _opts.history = history;
    }

    /**
     * Provides the tracker function.
     * @return {String}
     * @static
     */
    this.getTracker = function() {
        return _opts.tracker;
    }

    /**
     * Sets a function for page view tracking. The default value is 'urchinTracker'.
     * @param {String} tracker Tracker function.
     * @return {void}
     * @static
     */
    this.setTracker = function(tracker) {
        _opts.tracker = tracker;
    }

    /**
     * Provides the title of the HTML document.
     * @return {String}
     * @static
     */
    this.getTitle = function() {
        return _d.title;
    }

    /**
     * Sets the title of the HTML document.
     * @param {String} title Title value.
     * @return {void}
     * @static
     */
    this.setTitle = function(title) {
        if (!_supported) return null;
        if (typeof title == UNDEFINED) return;
        if (title == 'null') title = '';
        _title = _d.title = title;
        _st(function() {
            if ((_juststart || _opts.html) && _iframe && _iframe.contentWindow && _iframe.contentWindow.document) {
                _iframe.contentWindow.document.title = title;
                _juststart = false;
            }
            if (!_justset && (_browser.isCamino() || _browser.isFirefox()))
                _l.replace(_l.href.indexOf('#') != -1 ? _l.href : _l.href + '#');
            _justset = false;
        }, 50);
    }

    /**
     * Provides the status of the browser window.
     * @return {String}
     * @static
     */
    this.getStatus = function() {
        return _t.status;
    }

    /**
     * Sets the status of the browser window.
     * @param {String} status Status value.
     * @return {void}
     * @static
     */
    this.setStatus = function(status) {
        if (typeof status == UNDEFINED) return;
        if (!_browser.isSafari()) {
            status = _strictCheck((status != 'null') ? status : '', true);
            if (status == '/') status = '';
            if (!(/http(s)?:\/\//.test(status))) {
                var index = _l.href.indexOf('#');
                status = (index == -1 ? _l.href : _l.href.substr(0, index)) + '#' + status;
            }
            _t.status = status;
        }
    }

    /**
     * Resets the status of the browser window.
     * @return {void}
     * @static
     */
    this.resetStatus = function() {
        _t.status = '';
    }
    
    /**
     * Provides the current deep linking value.
     * @return {String}
     * @static
     */
    this.getValue = function() {
        if (!_supported) return null;
        return _strictCheck(_value, false);
    }
    
    /**
     * Sets the current deep linking value.
     * @param {String} value A value which will be appended to the base link of the HTML document.
     * @return {void}
     * @static
     */
    this.setValue = function(value) {
        if (!_supported) return null;
        if (typeof value == UNDEFINED) return;
        if (value == 'null') value = ''
        value = _strictCheck(value, true);
        if (value == '/') value = '';
        if (_value == value || _value == _dc(value) || _dc(_value) == value) return;
        _justset = true;
        _value = value;
        _silent = true;
        _update.call(_swfaddress.WEBAddress);
        _stack[_h.length] = _value;
        if (_browser.isSafari()) {
            if (_opts.history) {
                _l[ID][_l.pathname] = _stack.toString();
                _length = _h.length + 1;
                if (_version < 418) {
                    if (_l.search == '') {
                        _form.action = '#' + _value;
                        _form.submit();
                    }
                } else if (_version < 523 || _value == '') {
                    var evt = _d.createEvent('MouseEvents');
                    evt.initEvent('click', true, true);
                    var anchor = _d.createElement('a');
                    anchor.href = '#' + _value;
                    anchor.dispatchEvent(evt);                
                } else {
                    _l.hash = '#' + _value;
                }
            } else {
                _l.replace('#' + _value);
            }
        } else if (_value != _getHash()) {
            if (_opts.history)
                _l.hash = (_browser.isChrome() ? '' : '#') + _ieLocal(_value);
            else
                _l.replace('#' + _value);
        }
        if ((_browser.isIE() && _version < 8) && _opts.history) {
            if (_opts.html) {
                var loc = _iframe.contentWindow.location;
                loc.assign(loc.pathname + '?' + _getHash());
            } else {
                _st(_htmlWrite, 50);
            }
        }
        if (_browser.isSafari())
            _st(function(){ _silent = false; }, 1);
        else
            _silent = false;
    }

    /**
     * Provides the deep linking value without the query string.
     * @return {String}
     * @static
     */
    this.getPath = function() {
        var value = this.getValue();
        return (value.indexOf('?') != -1) ? value.split('?')[0] : value;
    }

    /**
     * Provides a list of all the folders in the deep linking path.
     * @return {Array}
     * @static
     */
    this.getPathNames = function() {
        var path = this.getPath();
        var names = path.split('/');
        if (path.substr(0, 1) == '/' || path.length == 0)
            names.splice(0, 1);
        if (path.substr(path.length - 1, 1) == '/')
            names.splice(names.length - 1, 1);
        return names;
    }

    /**
     * Provides the query string part of the deep linking value.
     * @return {String}
     * @static
     */
    this.getQueryString = function() {
        var value = this.getValue();
        var index = value.indexOf('?');
        return (index != -1 && index < value.length) ? value.substr(index + 1) : '';
    }

    /**
     * Provides the value of a specific query parameter.
     * @param {String} param Parameter name.
     * @return {String}
     * @static
     */
    this.getParameter = function(param) {
        var value = this.getValue();
        var index = value.indexOf('?');
        if (index != -1) {
            value = value.substr(index + 1);
            var params = value.split('&');
            var p, i = params.length;
            while(i--) {
                p = params[i].split('=');
                if (p[0] == param)
                    return p[1];
            }
        }
        return '';
    }

    /**
     * Provides a list of all the query parameter names.
     * @return {Array}
     * @static
     */
    this.getParameterNames = function() {
        var value = this.getValue();
        var index = value.indexOf('?');
        var names = [];
        if (index != -1) {
            value = value.substr(index + 1);
            if (value != '' && value.indexOf('=') != -1) {
                var params = value.split('&');
                var i = 0;
                while(i < params.length) {
                    names.push(params[i].split('=')[0]);
                    i++;
                }
            }
        }
        return names;
    }

    if (_supported) {
    
        for (var i = 1; i < _length; i++)
            _stack.push('');
            
        _stack.push(_getHash());
    
        if (_browser.isIE() && _l.hash != _getHash())
            _l.hash = '#' + _ieLocal(_getHash());
    
        _searchScript(document);
        var _qi = _url.indexOf('?');
        if (_url && _qi > -1) {
            var param, params = _url.substr(_qi + 1).split('&');
            for (var i = 0, p; p = params[i]; i++) {
                param = p.split('=');
                if (/^(history|html|strict)$/.test(param[0]))
                    _opts[param[0]] = (isNaN(param[1]) ? eval(param[1]) : (parseFloat(param[1]) > 0));
                if (/^tracker$/.test(param[0]))
                    _opts[param[0]] = param[1];
            }
        }
        if (/file:\/\//.test(_l.href)) _opts.html = false;
        
        var _ei = _url.indexOf('.js'), l;
        if (_url && _ei > -1) {
            while(_ei--) {
                l = _url.substr(_ei, 1);
                if (/(\/|\\)/.test(l)) break;    
                ID = l + ID;
            }
        }
    
        _titleCheck.call(this);
        
        if (window == _t)
            _events.addListener(document, 'DOMContentLoaded', _functions.bind(_load, this));
        _events.addListener(_t, 'load', _functions.bind(_load, this));
        _events.addListener(_t, 'unload', _functions.bind(_unload, this));
            
    } else {
        _track();
    }
}