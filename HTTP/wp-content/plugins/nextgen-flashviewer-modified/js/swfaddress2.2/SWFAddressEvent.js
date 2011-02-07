/**
 * SWFAddress 2.2: Deep linking for Flash and Ajax <http://www.asual.com/swfaddress/>
 *
 * SWFAddress is (c) 2006-2008 Rostislav Hristov and contributors
 * This software is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 *
 */

/**
 * Creates a new SWFAddressEvent event.
 * @class Event class for SWFAddressEvent.
 * @param {String} type Type of the event.
 * @author Rostislav Hristov <http://www.asual.com>
 */
SWFAddressEvent = asual.swfaddress.SWFAddressEvent = function(type) {

    SWFAddressEvent.superConstructor.apply(this, arguments);

    /**
     * The target of this event.
     * @type Function
     */
    this.target = [SWFAddress][0];
    
    /**
     * The string representation of this object.
     * @return {String}     
     * @ignore
     */
    this.toString = function() {
        return '[object SWFAddressEvent]';
    }
}
asual.util.Functions.extend(asual.swfaddress.WEBAddressEvent, SWFAddressEvent);

/**
 * Init event.
 * @type String
 * @memberOf SWFAddressEvent
 * @static
 */
asual.swfaddress.SWFAddressEvent.INIT = 'init';

/**
 * Change event.
 * @type String
 * @memberOf SWFAddressEvent
 * @static 
 */
asual.swfaddress.SWFAddressEvent.CHANGE = 'change';