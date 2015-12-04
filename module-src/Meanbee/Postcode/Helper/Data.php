<?php
/**
 * Meanbee_Postcode
 *
 * @category   Meanbee
 * @package    Meanbee_Postcode
 * @author     Meanbee Limited <hello@meanbee.com>
 * @copyright  Copyright (c) 2012 Meanbee Limited (http://www.meanbee.com)
 * @license    Single Site License, requiring consent from Meanbee
 */
namespace Meanbee\Postcode\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct(
            $context
        );
    }

    /**
    * Get a simplified string which represents the version of magento which is running.
    *
    * @return string|boolean    returns a simple string representing the version number or
    *                           false if this version of magento is not supported. Newer 
    *                           versions of magento will log a warning message.
    */
    public function getVersion() {
        $version = Mage::getVersion();
        $edition = Mage::getEdition();

        if ($edition == Mage::EDITION_ENTERPRISE) {
            if (version_compare($version, '1.12.0.0') >= 0) {
                if (version_compare($version, '1.12.0.2') > 0) {
                    $this->log('Untested version detected: ' . $version . '. Defaulting to 1.12 templates.', Zend_Log::WARN, true);
                }
                $this->log('Magento version 1.12 detected.', Zend_Log::INFO);
                return 'enterprise/1.12';
            } else {
                $this->log('Unsupported version detected: ' . $version . '. Defaulting to 1.12 templates.', Zend_Log::ERR, true);
                return 'enterprise/1.12';
            }
        } elseif ($edition == Mage::EDITION_COMMUNITY) {

            if (version_compare($version, '1.8.0.0') >= 0) {
                if (version_compare($version, '1.8.1.0') > 0) {
                    $this->log('Untested version detected: ' . $version . '. Defaulting to 1.8 templates.', Zend_Log::WARN, true);
                }
                $this->log('Magento version 1.8 detected.', Zend_Log::INFO);
                return '1.8';
            } elseif (version_compare($version, '1.7.0.0') >= 0) {
                $this->log('Magento version 1.7 detected.', Zend_Log::INFO);
                return '1.7';
            } elseif (version_compare($version, '1.6.0.0') >= 0) {
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
    }

    /**
     * Helper function which logs to our module's log file. 
     */
    public function log($message, $severity = Zend_Log::DEBUG, $force = false) {
        if ($this->isLoggingEnabled()) {
            Mage::log($message, $severity, 'meanbee_postcode.log', $force);
        }
    }

    /**
     * @return bool
     */
    public function isEnabled() {
        return Mage::getStoreConfigFlag('postcode/general/enabled');
    }

    public function isLoggingEnabled() {
        return Mage::getStoreConfigFlag('postcode/general/logging');
    }

    /**
     * @return string
     */
    public function getAccountCode() {
        return trim($this->scopeConfig->getValue('postcode/auth/account', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }


    /**
     * @return string
     */
    public function getPublicKey() {
        return trim($this->scopeConfig->getValue('postcode/auth/license', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

    /**
     * @return string
     */
    public function getAdminKey() {
        return trim($this->scopeConfig->getValue('postcode/auth/adminkey', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }

}
