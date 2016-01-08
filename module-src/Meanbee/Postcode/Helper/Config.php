<?php

namespace Meanbee\Postcode\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

abstract class Config
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {

        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get data from the config.
     *
     * @param string      $path
     * @param string      $scope
     * @param null|string $scopeCode
     *
     * @return mixed
     */
    public function getConfig($path, $scope = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return $this->scopeConfig->getValue($path, $scope, $scopeCode);
    }

    /**
     * Get data from the config.
     *
     * @param      $path
     * @param      $scope
     * @param null $scopeCode
     *
     * @return bool
     */
    public function getConfigFlag($path, $scope = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return $this->scopeConfig->isSetFlag($path, $scope, $scopeCode);
    }

}
