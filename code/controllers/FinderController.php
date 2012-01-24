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
class Meanbee_Postcode_FinderController extends Mage_Core_Controller_Front_Action {
    
    public function multipleAction() {
        header("Content-type: application/json");

        $postcode = strtolower(preg_replace("/[^a-zA-Z0-9]/", "", str_replace(' ', '', $_GET['postcode'])));

        if (!empty($postcode)) {
            $call = Mage::getModel('postcode/call');
            echo $call->findMultipleByPostcode($postcode);
        } else {
            echo Zend_Json::encode(array(
                "error" => true,
                "content" => "No postcode provided"
            ));
        }
        exit;
    }

    public function singleAction() {
        header("Content-type: application/json");

        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];

            $call = Mage::getModel('postcode/call');
            echo $call->findSingleAddressById($id);
            exit;
        } else {
            echo Zend_Json::encode(array(
                "error" => true,
                "content" => "No address ID provided"
            ));
        }
    }
}
