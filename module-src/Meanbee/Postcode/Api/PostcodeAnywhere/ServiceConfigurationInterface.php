<?php

namespace Meanbee\Postcode\Api\PostcodeAnywhere;

interface ServiceConfigurationInterface
{

    /**
     * Get the api key.
     *
     * @return string
     */
    public function getApiKey();

    /**
     * Get the license key.
     *
     * @return string
     */
    public function getLicenceKey();

    /**
     * Get the account code.
     *
     * @return string
     */
    public function getAccountCode();

    /**
     * Get the language.
     *
     * @return string
     */
    public function getLanguage();

    /**
     * Get the style you would like your results
     * to be.
     *
     * @return string
     */
    public function getStyle();

    /**
     * Get the default machine id.
     *
     * @return string
     */
    public function getMachineId();

    /**
     * Get the default options.
     *
     * @return string
     */
    public function getOptions();

}
