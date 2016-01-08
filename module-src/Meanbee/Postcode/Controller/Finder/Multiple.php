<?php
namespace Meanbee\Postcode\Controller\Finder;

use Meanbee\Postcode\Controller\Finder;

class Multiple extends Finder
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
        $data = $this->postcodeFinder->getMultipleAddresses($this->getRequest()->getParam('postcode'));

        return $result->setData($data);
    }

}
