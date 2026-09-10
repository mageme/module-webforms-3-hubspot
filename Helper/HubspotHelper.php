<?php
/**
 * Copyright © MageMe. All rights reserved.
 * See LICENSE for license terms, or https://mageme.com/license.
 */

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