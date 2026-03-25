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