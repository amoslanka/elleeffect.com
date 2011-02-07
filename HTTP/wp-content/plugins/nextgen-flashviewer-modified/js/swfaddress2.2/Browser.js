/**
 * SWFAddress 2.2: Deep linking for Flash and Ajax <http://www.asual.com/swfaddress/>
 *
 * SWFAddress is (c) 2006-2008 Rostislav Hristov and contributors
 * This software is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 *
 */

/**
 * @class Utility class that provides detailed browser information.
 * @static
 * @ignore
 * @author Rostislav Hristov <http://www.asual.com>
 */
asual.util.Browser = new function() {

    var _version = -1,
        _agent = navigator.userAgent,
        _ie = false, 
        _camino = false, 
        _safari = false, 
        _opera = false,
        _firefox = false,
        _chrome = false;

    var _getVersion = function(s, i) {
        return parseFloat(_agent.substr(_agent.indexOf(s) + i));
    }
    
    if (_opera = /Opera/.test(_agent))
        _version = parseFloat(navigator.appVersion);
    
    if (_ie = /MSIE/.test(_agent))
        _version = _getVersion('MSIE', 4);
    
    if (_chrome = /Chrome/.test(_agent))
        _version = _getVersion('Chrome', 7);
        
    if (_camino = /Camino/.test(_agent))
        _version = _getVersion('Camino', 7);
    
    if (_safari = (/AppleWebKit/.test(_agent) && !_chrome))
        _version = _getVersion('Safari', 7);        

    if (_firefox = (/Firefox/.test(_agent) && !_camino))
        _version = _getVersion('Firefox', 8);

    /**
     * The string representation of this class.
     * @return {String}
     * @static
     */
    this.toString = function() {
        return '[class Browser]';
    }
    
    /**
     * Detects the version of the browser.
     * @return {Number}
     * @static
     */
    this.getVersion = function() {
        return _version;
    }

    /**
     * Detects if the browser is Internet Explorer.
     * @return {Boolean}
     * @static
     */
    this.isIE = function() {
        return _ie;
    }

    /**
     * Detects if the browser is Safari.
     * @return {Boolean}
     * @static
     */
    this.isSafari = function() {
        return _safari;
    }

    /**
     * Detects if the browser is Opera.
     * @return {Boolean}
     * @static
     */
    this.isOpera = function() {
        return _opera;
    }

    /**
     * Detects if the browser is Camino.
     * @return {Boolean}
     * @static
     */
    this.isCamino = function() {
        return _camino;
    }

    /**
     * Detects if the browser is Firefox.
     * @return {Boolean}
     * @static
     */
    this.isFirefox = function() {
        return _firefox;
    }

    /**
     * Detects if the browser is Chrome.
     * @return {Boolean}
     * @static
     */
    this.isChrome = function() {
        return _chrome;
    }    
}