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
use MageMe\WebFormsHubspot\Config\Options\CompanyFields;

class AddCompany extends AddObject
{
    /**
     * @param array $args
     * @inheritDoc
     */
    public function execute(ResultInterface $result, array $args = []): string
    {
        /** @var FormInterface $form */
        $form    = $result->getForm();
        $email   = $this->getEmail($form, $result);
        $company = [
            'owneremail' => $email
        ];
        if ($form->getHubspotOwner()) {
            $company['hubspot_owner_id'] = $form->getHubspotOwner();
        }
        $mapFields = $this->mapFields($form, $result, CompanyFields::FIELD_SOURCE);
        $company   = array_merge($company, $mapFields['object']);
        $api       = $this->hubspotHelper->getApi();
        $id        = isset($company['domain']) ? $api->getCompanyIdByDomain($company['domain']) : false;
        if ($id) {
            if ($form->getHubspotIsCompanyUpdatedByDomain()) {
                $id = $api->updateCompany($id, $company);
            }
        } else {
            $id = $api->insertCompany($company);
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
                    "company",
                    $id,
                    "note_to_company"
                );
            }
        }

        if (!empty($args['contactId'])) {
            $api->associate(
                $args['contactId'],
                $id,
                'contact',
                'company',
                'contact_to_company'
            );
        }

        return $id;
    }
}