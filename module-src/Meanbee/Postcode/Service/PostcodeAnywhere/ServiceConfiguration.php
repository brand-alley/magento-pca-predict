<?php

namespace Meanbee\Postcode\Service\PostcodeAnywhere;

use Meanbee\Postcode\Api\PostcodeAnywhere\ServiceConfigurationInterface;

class ServiceConfiguration implements ServiceConfigurationInterface
{

    const DEFAULT_LANGUAGE = 'english';
    const DEFAULT_STYLE = 'simple';
    const DEFAULT_MACHINE_ID = '';
    const DEFAULT_OPTIONS = '';

    /**
     * @var
     */
    protected $apiKey;

    /**
     * @var
     */
    protected $licenceKey;

    /**
     * @var
     */
    protected $accountCode;

    /**
     * ServiceConfiguration constructor.
     *
     * @param $apiKey
     * @param $licenceKey
     * @param $accountCode
     */
    public function __construct($apiKey = null, $licenceKey = null, $accountCode = null)
    {

        $this->apiKey = $apiKey;
        $this->licenceKey = $licenceKey;
        $this->accountCode = $accountCode;
    }


    /**
     * Get the default language.
     *
     * @return string
     */
    public function getLanguage()
    {
        return static::DEFAULT_LANGUAGE;
    }

    /**
     * Get the default style.
     *
     * @return string
     */
    public function getStyle()
    {
        return static::DEFAULT_LANGUAGE;
    }

    /**
     * @todo: this is a migration thing, workout if we need this.
     *
     * Get the default machine id.
     *
     * @return string
     */
    public function getMachineId()
    {
        return static::DEFAULT_MACHINE_ID;
    }

    /**
     * @todo: this is a migration thing, workout if we need this.
     *
     * Get the default options.
     *
     * @return string
     */
    public function getOptions()
    {
        return static::DEFAULT_OPTIONS;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return mixed
     */
    public function getLicenceKey()
    {
        return $this->licenceKey;
    }

    /**
     * @return mixed
     */
    public function getAccountCode()
    {
        return $this->accountCode;
    }

}
