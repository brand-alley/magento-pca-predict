<?php
/**
 * Meanbee_Postcode
 *
 * @category   Meanbee
 * @package    Meanbee_Postcode
 * @author     Meanbee Limited <hello@meanbee.com>
 * @copyright  Copyright (c) 2012 Meanbee Limited (http://www.meanbee.com)
 * @license    Single Site License, requiring consent from Meanbee
 */
namespace Meanbee\Postcode\Controller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Meanbee\Postcode\Model\Call;

abstract class Finder extends Action
{

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var Call
     */
    protected $call;

    /**
     * Finder constructor.
     *
     * @param Context     $context
     * @param JsonFactory $resultJsonFactory
     * @param Call        $call
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        Call $call
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->call = $call;
    }

}
