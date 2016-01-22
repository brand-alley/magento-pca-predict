<?php

namespace Meanbee\Postcode\Helper\PostcodeAnywhere;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Meanbee\Postcode\Helper\Config;
use Meanbee\Postcode\Service\PostcodeAnywhere\ServiceConfiguration as DefaultServiceConfiguration;

class ServiceConfiguration extends DefaultServiceConfiguration
{

    const CONFIG_XML_IS_ENABLED = 'meanbee_postcode/postcode_anywhere/enabled';
    const CONFIG_XML_IS_ACCOUNT_CODE = 'meanbee_postcode/postcode_anywhere/account_code';
    const CONFIG_XML_IS_LICENCE_KEY = 'meanbee_postcode/postcode_anywhere/license';
    const CONFIG_XML_IS_LOGGING = 'meanbee_postcode/postcode_anywhere/enable_logging';

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
     * Get the licence key
     *
     * @return string
     */
    public function getLicenceKey()
    {
        return $this->config->getConfig(static::CONFIG_XML_IS_LICENCE_KEY);
    }

    /**
     * Get the account code.
     *
     * @return string
     */
    public function getAccountCode()
    {
        return $this->config->getConfig(static::CONFIG_XML_IS_ACCOUNT_CODE);
    }

}
