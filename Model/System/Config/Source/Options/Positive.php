<?php
/**
 * Copyright 2015 SIGNIFYD Inc. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Signifyd\Connect\Model\System\Config\Source\Options;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Option\ArrayInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Option data for positive order actions
 */
class Positive implements ArrayInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $coreConfig;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * Positive constructor.
     * @param ScopeConfigInterface $coreConfig
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        ScopeConfigInterface $coreConfig,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->coreConfig = $coreConfig;
        $this->request = $request;
    }

    public function toOptionArray()
    {
        $options = array(
            array(
                'value' => 'nothing',
                'label' => 'Do nothing'
            ),
            array(
                'value' => 'unhold',
                'label' => 'Update status to processing'
            ),
            array(
                'value' => 'capture',
                'label' => 'Capture payment and update order status'
            )
        );

        $store = $this->request->getParam('store');
        $website = $this->request->getParam('website');

        if (empty($store)) {
            if (empty($website)) {
                $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
                $scopeCode = null;
            } else {
                $scopeType = ScopeInterface::SCOPE_WEBSITE;
                $scopeCode = $website;
            }
        } else {
            $scopeType = ScopeInterface::SCOPE_STORE;
            $scopeCode = $store;
        }

        if ($this->coreConfig->getValue('signifyd/advanced/guarantee_positive_action', $scopeType, $scopeCode) == 'hold') {
            $options[] = array(
                'value' => 'hold',
                'label' => 'Leave on hold',
            );
        }

        return $options;
    }
}
