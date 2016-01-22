<?php

namespace Meanbee\Postcode\Service;

use Exception;

use Meanbee\Postcode\Api\PostcodeAnywhere\ServiceConfigurationInterface;
use Meanbee\Postcode\Api\ResponseInterface;
use Meanbee\Postcode\Api\ServiceInterface;
use Meanbee\Postcode\Service\PostcodeAnywhere\Url;
use Zend_Http_Client;

class PostcodeAnywhereService implements ServiceInterface {

    const CODE = 'postcode_anywhere';

    const SINGLE_ACTION = 'fetch';

    const MULTIPLE_ACTION = 'lookup';
    const MULTIPLE_TYPE = 'by_postcode';

    /**
     * @var Url
     */
    protected $url;

    /**
     * @var ServiceConfigurationInterface
     */
    protected $serviceConfiguration;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Zend_Http_Client
     */
    protected $client;

    /**
     * PostcodeAnywhereService constructor.
     *
     * @param ServiceConfigurationInterface $serviceConfiguration
     * @param Zend_Http_Client              $client
     * @param ResponseInterface             $response
     * @param Url                           $url
     *
     * @throws Exception
     */
    public function __construct(
        ServiceConfigurationInterface $serviceConfiguration,
        Zend_Http_Client $client,
        ResponseInterface $response,
        Url $url
    )
    {
        $this->serviceConfiguration = $serviceConfiguration;

        if (!$this->isAccountValid()) {
            throw new Exception("The configuration credentials are incorrect for Postcode Anywhere.");
        }

        $this->url = $url;
        $this->response = $response;
        $this->client = $client;
    }

    /**
     * Check if the account is valid.
     *
     * @return bool
     */
    public function isAccountValid()
    {
        return ($this->serviceConfiguration->getAccountCode() && $this->serviceConfiguration->getLicenceKey());
    }

    /**
     * Return a unique code for the service.
     *
     * @return string
     */
    public function getCode()
    {
        return static::CODE;
    }

    /**
     * Get a single address from a postcode.
     *
     * @param mixed $id
     *
     * @return string
     */
    public function getSingleAddress($id)
    {
        $this->url->setParams([
            'action'       => static::SINGLE_ACTION,
            'id'           => $id,
            'language'     => $this->serviceConfiguration->getLanguage(),
            'style'        => $this->serviceConfiguration->getStyle(),
            'account_code' => $this->serviceConfiguration->getAccountCode(),
            'license_code' => $this->serviceConfiguration->getLicenceKey(),
            'machine_id'   => $this->serviceConfiguration->getMachineId(),
            'options'      => $this->serviceConfiguration->getOptions()
        ]);

        $this->client->setUri($this->url->getUrl());
        $this->response->setContent($this->client->request()->getBody());

        return $this->response->toArray();
    }

    /**
     * Get multiple addresses
     *
     * @param $postcode
     *
     * @return mixed
     */
    public function getMultipleAddresses($postcode)
    {
        $this->url->setParams([
            'action'       => static::MULTIPLE_ACTION,
            'type'         => static::MULTIPLE_TYPE,
            'postcode'     => $postcode,
            'account_code' => $this->serviceConfiguration->getAccountCode(),
            'license_code' => $this->serviceConfiguration->getLicenceKey(),
            'machine_id'   => $this->serviceConfiguration->getMachineId()
        ]);

        $this->client->setUri($this->url->getUrl());
        $this->response->setContent($this->client->request()->getBody());

        return $this->response->toArray();
    }


    /**
     * Get the current response from PostcodeAnywhere.
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

}
