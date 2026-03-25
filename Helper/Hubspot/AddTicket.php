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

namespace MageMe\WebFormsHubspot\Helper\Hubspot;

use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebFormsHubspot\Api\Data\FormInterface;
use MageMe\WebFormsHubspot\Config\Options\TicketFields;

class AddTicket extends AddObject
{
    /**
     * @param array $args
     * @inheritDoc
     */
    public function execute(ResultInterface $result, array $args = []): string
    {
        /** @var FormInterface $form */
        $form      = $result->getForm();
        $ticket = [
            'hs_pipeline' => $form->getHubspotTicketPipeline(),
            'hs_pipeline_stage' => $form->getHubspotTicketStatus(),
            'hs_ticket_priority' => $form->getHubspotTicketPriority(),
            'subject' => $result->getSubject(),
            'source_type' => $form->getHubspotTicketSource(),
        ];
        if ($form->getHubspotOwner()) {
            $ticket['hubspot_owner_id'] = $form->getHubspotOwner();
        }
        $mapFields = $this->mapFields($form, $result, TicketFields::FIELD_SOURCE);
        $ticket      = array_merge($ticket, $mapFields['object']);
        $api       = $this->hubspotHelper->getApi();
        $id        = $api->insertTicket($ticket);

        // Attachments
        if ($mapFields['files']) {
            $timestamp = time();
            foreach ($mapFields['files'] as $file) {
                $this->uploadFiles(
                    $timestamp,
                    $file['field'],
                    $form->getHubspotOwner(),
                    $file['value'],
                    "ticket",
                    $id,
                    "note_to_ticket"
                );
            }
        }

        if (!empty($args['contactId'])) {
            $api->associate(
                $args['contactId'],
                $id,
                'contact',
                'ticket',
                'contact_to_ticket'
            );
        }

        if (!empty($args['companyId'])) {
            $api->associate(
                $args['companyId'],
                $id,
                'company',
                'ticket',
                'company_to_ticket'
            );
        }

        return $id;
    }
}