<?php
/**
 * Meanbee_Postcode
 *
 * This module was developed by Meanbee Internet Solutions.  If you require any
 * support or have any questions please contact us at support@meanbee.com.
 *
 * @category   Meanbee
 * @package    Meanbee_Postcode
 * @author     Meanbee Internet Solutions <support@meanbee.com>
 * @copyright  Copyright (c) 2009 Meanbee Internet Solutions (http://www.meanbee.com)
 * @license    Single Site License, requiring consent from Meanbee Internet Solutions
 */
class Meanbee_Postcode_Helper_Data extends Mage_Core_Helper_Abstract {
    /**
    * Get a simplified string which represents the version of magento which is running.
    *
    * @return string|boolean    returns a simple string representing the version number or
    *                           false if this version of magento is not supported. Newer 
    *                           versions of magento will log a warning message.
    */
    public function getVersion() {
        $version = Mage::getVersion();
        if (version_compare($version, '1.6.0.0') >= 0) {
            if (version_compare($version, '1.6.1.0') > 0) {
                $this->log('Untested version detected: ' . $version . '. Defaulting to 1.6 templates.', Zend_Log::WARN, true);
            }
            $this->log('Magento version 1.6 detected.', Zend_Log::INFO);
            return '1.6'; 
        } elseif (version_compare($version, '1.5.0.0') >= 0) {
            $this->log('Magento version 1.5 detected.', Zend_Log::INFO);
            return '1.5'; 
        } elseif (version_compare($version, '1.4.0.0') >= 0) {
            $this->log('Magento version 1.4 detected.', Zend_Log::INFO);
            return '1.4'; 
        } else {
            $this->log('Unsupported version detected: ' . $version, Zend_Log::ERR, true);
            return false; 
        }
    }

    /**
     * Helper function which logs to our module's log file. 
     */
    public function log($message, $severity = Zend_Log::DEBUG, $force = false) {
        Mage::log($message, $severity, 'meanbee_postcode.log', $force);
    }

    public function isEnabled() {
        return Mage::getStoreConfigFlag('postcode/general/enabled');
    }

}
