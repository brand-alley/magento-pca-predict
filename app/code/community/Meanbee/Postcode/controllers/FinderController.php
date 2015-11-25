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
class Meanbee_Postcode_FinderController extends Mage_Core_Controller_Front_Action {
    
    public function multipleAction() {
        header("Content-type: application/json");

        $postcode = strtolower(preg_replace("/[^a-zA-Z0-9]/", "", str_replace(' ', '', $_GET['postcode'])));
        $area = $_GET['area'];

        if (!empty($postcode)) {
            /** @var Meanbee_Postcode_Model_Call $call */
            $call = Mage::getModel('postcode/call');
            echo $call->findMultipleByPostcode($postcode, $area);
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
            $area = $_GET['area'];
            /** @var Meanbee_Postcode_Model_Call $call */
            $call = Mage::getModel('postcode/call');
            echo $call->findSingleAddressById($id, $area);
            exit;
        } else {
            echo Zend_Json::encode(array(
                "error" => true,
                "content" => "No address ID provided"
            ));
        }
    }
}
