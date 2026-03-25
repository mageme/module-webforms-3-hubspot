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

namespace MageMe\WebFormsHubspot\Config\Options;

use Exception;
use MageMe\WebFormsHubspot\Helper\HubspotHelper;
use Magento\Framework\Data\OptionSourceInterface;

class ContactLeadStatus implements OptionSourceInterface
{
    /**
     * @var array
     */
    private $options;
    /**
     * @var HubspotHelper
     */
    private $hubspotHelper;

    /**
     * @param HubspotHelper $hubspotHelper
     */
    public function __construct(HubspotHelper $hubspotHelper)
    {
        $this->hubspotHelper = $hubspotHelper;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        if ($this->options) {
            return $this->options;
        }
        try {
            $property = $this->hubspotHelper->getApi()->getProperty('contact', 'hs_lead_status');
            $options = $property['options'] ?? [];
            $this->options[] = [
                'label' => __('Not set'),
                'value' => ''
            ];
            foreach ($options as $option) {
                $this->options[] = [
                    'label' => __($option['label']),
                    'value' => $option['value']
                ];
            }
        } catch (Exception $exception) {
            $this->options = [];
        }
        return $this->options;
    }
}