<?php
/**
 * Copyright © MageMe. All rights reserved.
 * See LICENSE for license terms, or https://mageme.com/license.
 */

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