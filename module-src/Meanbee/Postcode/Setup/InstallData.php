<?php

namespace Meanbee\Postcode\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Model\Order\Shipment;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{

    /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
    protected $_resourceConfig;

    /**
     * Construct
     *
     * @param \Magento\Config\Model\ResourceModel\Config $resourceConfig
     */
    public function __construct(
        \Magento\Config\Model\ResourceModel\Config $resourceConfig
    ) {
        $this->_resourceConfig = $resourceConfig;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     *
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->saveConfig(Shipment::XML_PATH_STORE_COUNTRY_ID, 'GB');

        $setup->endSetup();
    }

    /**
     * Wrapper around the saveConfig function.
     *
     * @param string $path
     * @param string $value
     * @param string $scope
     * @param int $scopeId
     *
     * @return $this
     */
    public function saveConfig($path, $value, $scope = 'default', $scopeId = 0)
    {
        $this->_resourceConfig->saveConfig($path, $value, $scope, $scopeId);

        return $this;
    }
}
