<?php 
class Meanbee_Postcode_Block_Checkout_Onepage_Shipping extends Mage_Checkout_Block_Onepage_Shipping {
    /**
     * Override of the getTemplate method to change it to one based on our magento version
     */
    public function getTemplate() {
        if (/* TODO add enabled switch Mage::helper('worldaddresses/config')->isEnabled() */ true) {
            $version = Mage::helper('meanbee_postcode')->getVersion();
            if ($version != false) {
                return 'meanbee/postcode/' . $version . '/shipping.phtml';
            } 
        } else {
            return parent::getTemplate();
        }
    }
}
