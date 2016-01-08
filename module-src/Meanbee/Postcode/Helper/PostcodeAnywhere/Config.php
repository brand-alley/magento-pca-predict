<?php

namespace Meanbee\Postcode\Helper\PostcodeAnywhere;

use Meanbee\Postcode\Api\PostcodeAnywhere\ServiceConfigurationInterface;
use Meanbee\Postcode\Helper\Config as AbstractConfig;

class Config extends AbstractConfig implements ServiceConfigurationInterface
{

    const CONFIG_XML_IS_ENABLED = 'postcode/general/enabled';
    const CONFIG_XML_IS_ACCOUNT_CODE = 'postcode/auth/account';
    const CONFIG_XML_IS_API_KEY = 'postcode/auth/api_key';
    const CONFIG_XML_IS_LICENCE_KEY = 'postcode/auth/license';
    const CONFIG_XML_IS_LOGGING = 'postcode/general/logging';

    const DEFAULT_LANGUAGE = 'english';
    const DEFAULT_STYLE = 'simple';
    const DEFAULT_MACHINE_ID = '';
    const DEFAULT_OPTIONS = '';

    /**
     * Check if the extension is enabled in Magento
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getConfigFlag(static::CONFIG_XML_IS_ENABLED);
    }

    /**
     * Check if logging is enabled.
     *
     * @return bool
     */
    public function isLoggingEnabled()
    {
        return $this->getConfigFlag(static::CONFIG_XML_IS_LOGGING);
    }

    /**
     * Get the API Key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->getConfig(static::CONFIG_XML_IS_API_KEY);
    }

    /**
     * Get the licence key
     *
     * @return string
     */
    public function getLicenceKey()
    {
        return $this->getConfig(static::CONFIG_XML_IS_LICENCE_KEY);
    }

    /**
     * Get the account code.
     *
     * @return string
     */
    public function getAccountCode()
    {
        return $this->getConfig(static::CONFIG_XML_IS_ACCOUNT_CODE);
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
}
