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

namespace MageMe\WebFormsHubspot\Plugin\Helper\Result\PostHelper;

use MageMe\WebForms\Api\Data\FormInterface;
use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Helper\Result\PostHelper;
use MageMe\WebFormsHubspot\Helper\Hubspot\AddCompany;
use MageMe\WebFormsHubspot\Helper\Hubspot\AddContact;
use MageMe\WebFormsHubspot\Helper\Hubspot\AddTicket;
use Magento\Framework\Exception\NoSuchEntityException;

class PostResult
{
    /**
     * @var AddContact
     */
    private $addContact;
    /**
     * @var AddCompany
     */
    private $addCompany;
    /**
     * @var AddTicket
     */
    private $addTicket;

    /**
     * @param AddTicket $addTicket
     * @param AddCompany $addCompany
     * @param AddContact $addContact
     */
    public function __construct(AddTicket $addTicket, AddCompany $addCompany, AddContact $addContact)
    {
        $this->addContact = $addContact;
        $this->addCompany = $addCompany;
        $this->addTicket  = $addTicket;
    }

    /**
     * @param PostHelper $postHelper
     * @param array $data
     * @param FormInterface|\MageMe\WebFormsHubspot\Api\Data\FormInterface $form
     * @param array $config
     * @return array
     * @noinspection PhpUnusedParameterInspection
     * @throws NoSuchEntityException
     */
    public function afterPostResult(PostHelper $postHelper, array $data, FormInterface $form, array $config = []): array
    {
        if (!$data['success'] || !($data['model'] instanceof ResultInterface)) {
            return $data;
        }
        if (!$form->getIsHubspotEnabled()) {
            return $data;
        }
        $result    = $data['model'];
        $contactId = '';
        $companyId = '';
        if ($form->getHubspotIsContactEnabled()) {
            $contactId = $this->addContact->execute($result);
        }
        if ($form->getHubspotIsCompanyEnabled()) {
            $companyId = $this->addCompany->execute($result, [
                'contactId' => $contactId
            ]);
        }
        if ($form->getHubspotIsTicketEnabled()) {
            $this->addTicket->execute($result, [
                'contactId' => $contactId,
                'companyId' => $companyId
            ]);
        }
        return $data;
    }

}