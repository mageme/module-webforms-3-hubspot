<?php
/**
 * Copyright © MageMe. All rights reserved.
 * See LICENSE for license terms, or https://mageme.com/license.
 */

namespace MageMe\WebFormsHubspot\Plugin\Helper\Result\PostHelper;

use MageMe\WebForms\Api\Data\FormInterface;
use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Helper\Result\PostHelper;
use MageMe\WebFormsHubspot\Helper\Hubspot\AddCompany;
use MageMe\WebFormsHubspot\Helper\Hubspot\AddContact;
use MageMe\WebFormsHubspot\Helper\Hubspot\AddTicket;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param AddTicket $addTicket
     * @param AddCompany $addCompany
     * @param AddContact $addContact
     * @param LoggerInterface $logger
     */
    public function __construct(AddTicket $addTicket, AddCompany $addCompany, AddContact $addContact, LoggerInterface $logger)
    {
        $this->addContact = $addContact;
        $this->addCompany = $addCompany;
        $this->addTicket  = $addTicket;
        $this->logger     = $logger;
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
        try {
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
        } catch (\Throwable $e) {
            $this->logger->error('WebForms Hubspot integration failed for result #' . $result->getId() . ': ' . $e->getMessage());
        }
        return $data;
    }

}