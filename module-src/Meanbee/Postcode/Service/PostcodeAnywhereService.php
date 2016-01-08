<?php

namespace Meanbee\Postcode\Service;

use Exception;

use Meanbee\Postcode\Api\PostcodeAnywhere\ServiceConfigurationInterface;
use Meanbee\Postcode\Api\ServiceInterface;
use Meanbee\Postcode\Service\PostcodeAnywhere\Url;

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
     * PostcodeAnywhereService constructor.
     *
     * @param ServiceConfigurationInterface $serviceConfiguration
     * @param Url                           $url
     *
     * @throws Exception
     */
    public function __construct(
        ServiceConfigurationInterface $serviceConfiguration,
        Url $url
    )
    {
        $this->serviceConfiguration = $serviceConfiguration;

        if (!$this->isAccountValid()) {
            throw new Exception("The configuration credentials are incorrect for Postcode Anywhere.");
        }

        $this->url = $url;
    }

    /**
     * Check if the account is valid.
     *
     * @return bool
     */
    public function isAccountValid()
    {
        return ($this->serviceConfiguration->getApiKey() && $this->serviceConfiguration->getLicenceKey());
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

        return $this->makeRequest();
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

        return $this->makeRequest();
    }

    /**
     * @todo: move curl into Guzzle type thing.
     *
     * @return mixed|string
     */
    protected function makeRequest()
    {
        if (function_exists("curl_setopt")) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_URL, $this->url->getUrl());
            $data = curl_exec($curl);
            curl_close($curl);

            return $data;
        } else {
            return file_get_contents($this->url->getUrl());
        }
    }

}
