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

namespace MageMe\WebFormsHubspot\Controller\Adminhtml\Result;

use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Api\ResultRepositoryInterface;
use MageMe\WebForms\Controller\Adminhtml\Result\AbstractAjaxResultMassAction;
use MageMe\WebForms\Model\ResourceModel\Result\CollectionFactory;
use MageMe\WebFormsHubspot\Api\Data\FormInterface;
use MageMe\WebFormsHubspot\Helper\Hubspot\AddCompany;
use MageMe\WebFormsHubspot\Helper\Hubspot\AddContact;
use MageMe\WebFormsHubspot\Helper\Hubspot\AddTicket;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Magento\Ui\Component\MassAction\Filter;

class AjaxSendData extends AbstractAjaxResultMassAction
{
    /**
     * @inheritdoc
     */
    const ACTION = 'send';
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
     * @param ResultRepositoryInterface $repository
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     * @param JsonFactory $jsonFactory
     * @param Context $context
     */
    public function __construct(
        AddTicket                 $addTicket,
        AddCompany                $addCompany,
        AddContact                $addContact,
        ResultRepositoryInterface $repository,
        CollectionFactory         $collectionFactory,
        Filter                    $filter,
        JsonFactory               $jsonFactory,
        Context                   $context
    ) {
        parent::__construct($repository, $collectionFactory, $filter, $jsonFactory, $context);
        $this->addContact = $addContact;
        $this->addCompany = $addCompany;
        $this->addTicket  = $addTicket;
    }

    /**
     * @inheritdoc
     * @throws NoSuchEntityException
     * @noinspection DuplicatedCode
     */
    protected function action(AbstractDb $collection): Phrase
    {
        foreach ($collection as $item) {

            /** @var ResultInterface $result */
            $result = $this->repository->getById($item->getId());

            /** @var FormInterface $form */
            $form = $result->getForm();
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
        }
        return __('A total of %1 contact(s) have been sent.', $collection->getSize());
    }
}