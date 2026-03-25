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

class TicketFields implements OptionSourceInterface
{
    const FIELD_SOURCE = 'ticket';

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
            $options = [];
            $groups = $this->hubspotHelper->getApi()->getTicketPropertyGroups();
            $properties = $this->hubspotHelper->getApi()->getTicketProperties();
            foreach ($groups as $group) {
                $options[$group['name']] = [
                    'label' => $group['label'],
                    'value' => []
                ];
            }
            $isAllProperties = $this->hubspotHelper->getConfigAllProperties();
            foreach ($properties as $property) {
                if ($isAllProperties) {
                    if (empty($property['groupName'])) {
                        $options[$property['name']] = [
                            'label' => __($property['label']),
                            'value' => implode(";", [$property['name'], $property['fieldType'], self::FIELD_SOURCE])
                        ];
                        continue;
                    }
                    $options[$property['groupName']]['value'][] = [
                        'label' => __($property['label']),
                        'value' => implode(";", [$property['name'], $property['fieldType'], self::FIELD_SOURCE])
                    ];
                } else {
                    if ($property['formField']) {
                        $options[$property['groupName']]['value'][] = [
                            'label' => __($property['label']),
                            'value' => implode(";", [$property['name'], $property['fieldType'], self::FIELD_SOURCE])
                        ];
                    }
                }
            }
            foreach ($options as $option) {
                if (empty($option['value'])) {
                    continue;
                }
                $this->options[] = $option;
            }
        } catch (Exception $exception) {
            $this->options = [];
        }
        return $this->options;
    }
}