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

        return $result->setData($this->call->findMultipleByPostcode(
            $this->getRequest()->getParam('postcode'),
            $this->getRequest()->getParam('area')
        ));
    }

}
