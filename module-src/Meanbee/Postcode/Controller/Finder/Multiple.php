<?php
namespace Meanbee\Postcode\Controller\Finder;

class Multiple extends \Meanbee\Postcode\Controller\Finder
{

    public function execute()
    {
        header("Content-type: application/json");

        $postcode = strtolower(preg_replace("/[^a-zA-Z0-9]/", "", str_replace(' ', '', $_GET['postcode'])));
        $area = $_GET['area'];

        if (!empty($postcode)) {
            /** @var Meanbee_Postcode_Model_Call $call */
            $call = Mage::getModel('postcode/call');
            echo $call->findMultipleByPostcode($postcode, $area);
        } else {
            echo Zend_Json::encode(array(
                "error"   => true,
                "content" => "No postcode provided"
            ));
        }
        exit;
    }

}
