<?php
/**
 * Copyright © MageMe. All rights reserved.
 * See LICENSE for license terms, or https://mageme.com/license.
 */

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