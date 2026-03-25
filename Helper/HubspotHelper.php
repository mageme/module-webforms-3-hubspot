<?php
/**
 * MageMe
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageMe.com license that is
 * available through the world-wide-web at this URL:
 * https://mageme.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to a newer
 * version in the future.
 *
 * Copyright (c) MageMe (https://mageme.com)
 **/

namespace MageMe\WebFormsHubspot\Helper;

use MageMe\WebFormsHubspot\Helper\Hubspot\Api;
use Magento\Framework\App\Config\ScopeConfigInterface;
use InvalidArgumentException;

class HubspotHelper
{
    const CONFIG_TOKEN = 'webforms/hubspot/token';
    const CONFIG_ALL_PROPERTIES = 'webforms/hubspot/all_properties';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var Api
     */
    private $api;

    /**
     * @param Api $api
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Api                  $api,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->api         = $api;
    }

    /**
     * @return string|null
     */
    protected function getConfigToken(): ?string
    {
        return $this->scopeConfig->getValue(self::CONFIG_TOKEN);
    }

    /**
     * @return bool
     */
    public function getConfigAllProperties(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::CONFIG_ALL_PROPERTIES);
    }


    /**
     * @return Api
     */
    public function getApi(): Api
    {
        $this->validateConfig();
        $this->api->setToken($this->getConfigToken());
        return $this->api;
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function validateConfig()
    {
        if (empty($this->getConfigToken())) {
            throw new InvalidArgumentException(__('HubSpot token not configured.'));
        }
    }
}