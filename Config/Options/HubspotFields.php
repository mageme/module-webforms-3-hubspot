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
use Magento\Framework\Data\OptionSourceInterface;

class HubspotFields implements OptionSourceInterface
{
    /**
     * @var array
     */
    private $options;
    /**
     * @var ContactFields
     */
    private $contactFields;
    /**
     * @var CompanyFields
     */
    private $companyFields;
    /**
     * @var TicketFields
     */
    private $ticketFields;

    /**
     * @param TicketFields $ticketFields
     * @param CompanyFields $companyFields
     * @param ContactFields $contactFields
     */
    public function __construct(TicketFields $ticketFields, CompanyFields $companyFields, ContactFields $contactFields)
    {
        $this->contactFields = $contactFields;
        $this->companyFields = $companyFields;
        $this->ticketFields  = $ticketFields;
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
            $this->options = [];
            if ($this->contactFields->toOptionArray()) {
                $this->options[] = [
                    'label' => 'Contact',
                    'value' => $this->contactFields->toOptionArray()
                ];
            }
            if ($this->companyFields->toOptionArray()) {
                $this->options[] = [
                    'label' => 'Company',
                    'value' => $this->companyFields->toOptionArray()
                ];
            }
            if ($this->ticketFields->toOptionArray()) {
                $this->options[] = [
                    'label' => 'Ticket',
                    'value' => $this->ticketFields->toOptionArray()
                ];
            }
        } catch (Exception $exception) {
            $this->options = [];
        }
        return $this->options;
    }
}