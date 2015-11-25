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
class Meanbee_Postcode_Block_Checkout_Onepage_Billing extends Mage_Checkout_Block_Onepage_Billing {
    /**
     * Override of the getTemplate method to change it to one based on our magento version
     */
    public function getTemplate() {
        if (Mage::helper('postcode')->isEnabled()) {
            $version = Mage::helper('postcode')->getVersion();
            if ($version != false) {
                return 'meanbee/postcode/' . $version . '/billing.phtml';
            }
        } else {
            return parent::getTemplate();
        }
    }
}
