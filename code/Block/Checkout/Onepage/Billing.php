<?php 
class Meanbee_Postcode_Block_Checkout_Onepage_Billing extends Mage_Checkout_Block_Onepage_Billing {
    /**
     * Override of the getTemplate method to change it to one based on our magento version
     */
    public function getTemplate() {
        if (/*TODO add enabled switch Mage::helper('worldaddresses/config')->isEnabled()*/ true) {
            $version = Mage::helper('postcode')->getVersion();
            if ($version != false) {
                return 'meanbee/postcode/' . $version . '/billing.phtml';
            }
        } else {
            return parent::getTemplate();
        }
    }
}
