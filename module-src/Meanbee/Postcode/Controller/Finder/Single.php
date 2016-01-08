<?php
namespace Meanbee\Postcode\Controller\Finder;

use Meanbee\Postcode\Controller\Finder;

class Single extends Finder
{

    /**
     * Set the json response from the Postcode Anywhere
     * api call response.
     *
     * @return $this
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $data = $this->postcodeFinder->getSingleAddress($this->getRequest()->getParam('id'));

        return $result->setData($data);
    }

}
