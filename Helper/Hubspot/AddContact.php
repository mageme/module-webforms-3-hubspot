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
use MageMe\WebFormsHubspot\Config\Options\ContactFields;
use MageMe\WebFormsHubspot\Helper\Hubspot\Exception\DuplicateException;

class AddContact extends AddObject
{
    /**
     * @param array $args
     * @inheritDoc
     */
    public function execute(ResultInterface $result, array $args = []): string
    {
        /** @var FormInterface $form */
        $form      = $result->getForm();
        $email     = $this->getEmail($form, $result);
        $firstName = '';
        $lastName  = $result->getCustomerName();
        $customer  = $result->getCustomer();
        if ($customer) {
            $firstName = $customer->getFirstname();
            $lastName  = $customer->getLastname();
        }
        $contact = [
            'lastname' => $lastName,
            'firstname' => $firstName,
            'email' => $email,
            'lifecyclestage' => $form->getHubspotContactLifecycleStage(),
            'hs_lead_status' => $form->getHubspotContactLeadStatus(),
        ];
        if ($form->getHubspotOwner()) {
            $contact['hubspot_owner_id'] = $form->getHubspotOwner();
        }
        $mapFields = $this->mapFields($form, $result, ContactFields::FIELD_SOURCE);
        $contact   = array_merge($contact, $mapFields['object']);
        $api       = $this->hubspotHelper->getApi();
        try {
            $id = $api->insertContact($contact);
        } catch (DuplicateException $exception) {
            $id = $exception->getObjectId();
            if ($form->getHubspotIsContactUpdatedByEmail()) {
                $id = $api->updateContact($exception->getObjectId(), $contact);
            }
        }

        // Attachments
        if ($mapFields['files']) {
            $timestamp = time();
            foreach ($mapFields['files'] as $file) {
                $this->uploadFiles(
                    $timestamp,
                    $file['field'],
                    $form->getHubspotOwner(),
                    $file['value'],
                    "contact",
                    $id,
                    "note_to_contact"
                );
            }
        }

        return $id;
    }
}