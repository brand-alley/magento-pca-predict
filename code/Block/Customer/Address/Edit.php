<?php
class Meanbee_Postcode_Block_Customer_Address_Edit extends Mage_Customer_Block_Address_Edit {
    /**
     * Override of the getTemplate method to change it to one based on our magento version
     */
    public function getTemplate() {
        if (Mage::helper('postcode')->isEnabled()) {
            $version = Mage::helper('postcode')->getVersion();
            if ($version != false) {
                return 'meanbee/postcode/' . $version . '/customerAddressEdit.phtml';
            }
        } else {
            return parent::getTemplate();
        }
    }

    public function hasAddress() {
        $hasAddress = true;

        $this->hasAddressField($this->getAddress()->getPostcode(), $hasAddress);
        $this->hasAddressField($this->getAddress()->getStreet(), $hasAddress);
        $this->hasAddressField($this->getAddress()->getCity(), $hasAddress);

        return $hasAddress;
    }

    protected function hasAddressField($field, &$hasAddressFlag) {
        if ($hasAddressFlag == false) {
            return;
        }

        if ($field == NULL) {
            $hasAddressFlag = false;
        }
    }
}
