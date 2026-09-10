<?php
/**
 * Copyright © MageMe. All rights reserved.
 * See LICENSE for license terms, or https://mageme.com/license.
 */

namespace MageMe\WebFormsHubspot\Config\Options;

use Exception;
use MageMe\WebFormsHubspot\Helper\HubspotHelper;
use Magento\Framework\Data\OptionSourceInterface;

class Owners implements OptionSourceInterface
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
            $this->options[] = [
                'label' => __('No owner'),
                'value' => '',
            ];
            $owners = $this->hubspotHelper->getApi()->getOwners();
            foreach ($owners as $owner) {
                $this->options[] = [
                    'label' => __($owner['firstName'] . ' ' . $owner['lastName']),
                    'value' => $owner['id']
                ];
            }
        } catch (Exception $exception) {
            $this->options = [];
        }
        return $this->options;

    }
}