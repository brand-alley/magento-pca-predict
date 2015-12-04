<?php
namespace Meanbee\Postcode\Controller\Finder;

class Single extends \Meanbee\Postcode\Controller\Finder
{

    public function execute()
    {
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
                "error"   => true,
                "content" => "No address ID provided"
            ));
        }
    }
}
