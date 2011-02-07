/**
 * SWFAddress 2.2: Deep linking for Flash and Ajax <http://www.asual.com/swfaddress/>
 *
 * SWFAddress is (c) 2006-2008 Rostislav Hristov and contributors
 * This software is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 *
 */

/**
 * Creates a new WEBAddress event.
 * @class Event class for WEBAddress.
 * @param {String} type Type of the event.
 * @author Rostislav Hristov <http://www.asual.com>
 */
asual.swfaddress.WEBAddressEvent = function(type) {

    var _webaddress = asual.swfaddress.WEBAddress;
    
    /**
     * The string representation of this object.
     * @return {String}
     * @ignore
     */
    this.toString = function() {
        return '[object WEBAddressEvent]';
    }

    /**
     * The type of this event.
     * @type String
     */
    this.type = type;

    /**
     * The target of this event.
     * @type Function
     */
    this.target = [_webaddress][0];

    /**
     * The value of this event.
     * @type String
     */
    this.value = _webaddress.getValue();

    /**
     * The path of this event.
     * @type String
     */
    this.path = _webaddress.getPath();
    
    /**
     * The folders in the deep linking path of this event.
     * @type Array
     */
    this.pathNames = _webaddress.getPathNames();

    /**
     * The parameters of this event.
     * @type Object
     */
    this.parameters = {};

    var _parametersNames = _webaddress.getParameterNames();
    for (var i = 0, l = _parametersNames.length; i < l; i++)
        this.parameters[_parametersNames[i]] = _webaddress.getParameter(_parametersNames[i]);
    
    /**
     * The parameters names of this event.
     * @type Array     
     */
    this.parametersNames = _parametersNames;
}

/**
 * Init event.
 * @type String
 * @memberOf WEBAddressEvent
 * @static
 */
asual.swfaddress.WEBAddressEvent.INIT = 'init';

/**
 * Change event.
 * @type String
 * @memberOf WEBAddressEvent
 * @static 
 */
asual.swfaddress.WEBAddressEvent.CHANGE = 'change';