<?php
class Meanbee_Postcode_Block_Customer_Address_Edit extends Mage_Customer_Block_Address_Edit {
    /**
     * Override of the getTemplate method to change it to one based on our magento version
     */
    public function getTemplate() {
        if (/*TODO add enabled switch Mage::helper('worldaddresses/config')->isEnabled()*/ true) {
            $version = Mage::helper('postcode')->getVersion();
            if ($version != false) {
                return 'meanbee/postcode/' . $version . '/customer_address_edit.phtml';
            }
        } else {
            return parent::getTemplate();
        }
    }
}
