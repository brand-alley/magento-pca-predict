<?php

namespace Meanbee\Postcode\Helper\PostcodeAnywhere;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Meanbee\Postcode\Helper\Config;
use Meanbee\Postcode\Service\PostcodeAnywhere\ServiceConfiguration as DefaultServiceConfiguration;

class ServiceConfiguration extends DefaultServiceConfiguration
{

    const CONFIG_XML_IS_ENABLED = 'postcode/general/enabled';
    const CONFIG_XML_IS_ACCOUNT_CODE = 'postcode/auth/account';
    const CONFIG_XML_IS_API_KEY = 'postcode/auth/api_key';
    const CONFIG_XML_IS_LICENCE_KEY = 'postcode/auth/license';
    const CONFIG_XML_IS_LOGGING = 'postcode/general/logging';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Config
     */
    protected $config;

    /**
     * ServiceConfiguration constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;

        parent::__construct(
            $this->getApiKey(),
            $this->getLicenceKey(),
            $this->getAccountCode()
        );
    }

    /**
     * Check if the extension is enabled in Magento
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->config->getConfigFlag(static::CONFIG_XML_IS_ENABLED);
    }

    /**
     * Check if logging is enabled.
     *
     * @return bool
     */
    public function isLoggingEnabled()
    {
        return $this->config->getConfigFlag(static::CONFIG_XML_IS_LOGGING);
    }

    /**
     * Get the API Key
     *
     * @return string
     */
    public function getApiKey()
    {
        return 'XX31-TP26-KP59-NC16';//$this->config->getConfig(static::CONFIG_XML_IS_API_KEY);
    }

    /**
     * Get the licence key
     *
     * @return string
     */
    public function getLicenceKey()
    {
        return 'XX31-TP26-KP59-NC16';//$this->config->getConfig(static::CONFIG_XML_IS_LICENCE_KEY);
    }

    /**
     * Get the account code.
     *
     * @return string
     */
    public function getAccountCode()
    {
        return 'INDIV52356';//$this->config->getConfig(static::CONFIG_XML_IS_ACCOUNT_CODE);
    }

}
