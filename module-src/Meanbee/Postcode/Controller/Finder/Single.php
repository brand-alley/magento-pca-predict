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

        return $result->setData($this->call->findSingleAddressById(
            $this->getRequest()->getParam('id'),
            $this->getRequest()->getParam('area')
        ));
    }

}
