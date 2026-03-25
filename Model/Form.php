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

namespace MageMe\WebFormsHubspot\Model;

use MageMe\WebFormsHubspot\Api\Data\FormInterface;

class Form extends \MageMe\WebForms\Model\Form implements FormInterface
{
    #region DB getters and setters
    /**
     * @inheritDoc
     */
    public function getIsHubspotEnabled(): bool
    {
        return (bool)$this->getData(self::IS_HUBSPOT_ENABLED);
    }

    /**
     * @inheritDoc
     */
    public function setIsHubspotEnabled(bool $isHubspotEnabled): FormInterface
    {
        return $this->setData(self::IS_HUBSPOT_ENABLED, $isHubspotEnabled);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotIsContactEnabled(): bool
    {
        return (bool)$this->getData(self::HUBSPOT_IS_CONTACT_ENABLED);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotIsContactEnabled(bool $hubspotIsContactEnabled): FormInterface
    {
        return $this->setData(self::HUBSPOT_IS_CONTACT_ENABLED, $hubspotIsContactEnabled);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotIsCompanyEnabled(): bool
    {
        return (bool)$this->getData(self::HUBSPOT_IS_COMPANY_ENABLED);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotIsCompanyEnabled(bool $hubspotIsCompanyEnabled): FormInterface
    {
        return $this->setData(self::HUBSPOT_IS_COMPANY_ENABLED, $hubspotIsCompanyEnabled);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotIsTicketEnabled(): bool
    {
        return (bool)$this->getData(self::HUBSPOT_IS_TICKET_ENABLED);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotIsTicketEnabled(bool $hubspotIsTicketEnabled): FormInterface
    {
        return $this->setData(self::HUBSPOT_IS_TICKET_ENABLED, $hubspotIsTicketEnabled);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotEmailFieldId(): ?int
    {
        return $this->getData(self::HUBSPOT_EMAIL_FIELD_ID);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotEmailFieldId(?int $hubspotEmailFieldId): FormInterface
    {
        return $this->setData(self::HUBSPOT_EMAIL_FIELD_ID, $hubspotEmailFieldId);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotOwner(): ?string
    {
        return $this->getData(self::HUBSPOT_OWNER);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotOwner(string $hubspotOwner): FormInterface
    {
        return $this->setData(self::HUBSPOT_OWNER, $hubspotOwner);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotMapFieldsSerialized(): ?string
    {
        return $this->getData(self::HUBSPOT_MAP_FIELDS_SERIALIZED);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotMapFieldsSerialized(string $hubspotMapFieldsSerialized): FormInterface
    {
        return $this->setData(self::HUBSPOT_MAP_FIELDS_SERIALIZED, $hubspotMapFieldsSerialized);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotMapFields(): array
    {
        $data = $this->getData(self::HUBSPOT_MAP_FIELDS);
        return is_array($data) ? $data : [];
    }

    /**
     * @inheritDoc
     */
    public function setHubspotMapFields(array $hubspotMapFields): FormInterface
    {
        return $this->setData(self::HUBSPOT_MAP_FIELDS, $hubspotMapFields);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotIsContactUpdatedByEmail(): bool
    {
        return (bool)$this->getData(self::HUBSPOT_IS_CONTACT_UPDATED_BY_EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotIsContactUpdatedByEmail(bool $hubspotIsContactUpdatedByEmail): FormInterface
    {
        return $this->setData(self::HUBSPOT_IS_CONTACT_UPDATED_BY_EMAIL, $hubspotIsContactUpdatedByEmail);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotContactLifecycleStage(): ?string
    {
        return $this->getData(self::HUBSPOT_CONTACT_LIFECYCLE_STAGE);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotContactLifecycleStage(string $hubspotContactLifecycleStage): FormInterface
    {
        return $this->setData(self::HUBSPOT_CONTACT_LIFECYCLE_STAGE, $hubspotContactLifecycleStage);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotContactLeadStatus(): ?string
    {
        return $this->getData(self::HUBSPOT_CONTACT_LEAD_STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotContactLeadStatus(string $hubspotContactLeadStatus): FormInterface
    {
        return $this->setData(self::HUBSPOT_CONTACT_LEAD_STATUS, $hubspotContactLeadStatus);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotIsCompanyUpdatedByDomain(): bool
    {
        return (bool)$this->getData(self::HUBSPOT_IS_COMPANY_UPDATED_BY_DOMAIN);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotIsCompanyUpdatedByDomain(bool $hubspotIsCompanyUpdatedByDomain): FormInterface
    {
        return $this->setData(self::HUBSPOT_IS_COMPANY_UPDATED_BY_DOMAIN, $hubspotIsCompanyUpdatedByDomain);
    }


    /**
     * @inheritDoc
     */
    public function getHubspotTicketPipeline(): ?string
    {
        return $this->getData(self::HUBSPOT_TICKET_PIPELINE);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotTicketPipeline(string $hubspotTicketPipeline): FormInterface
    {
        return $this->setData(self::HUBSPOT_TICKET_PIPELINE, $hubspotTicketPipeline);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotTicketStatus(): ?string
    {
        return $this->getData(self::HUBSPOT_TICKET_STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotTicketStatus(string $hubspotTicketStatus): FormInterface
    {
        return $this->setData(self::HUBSPOT_TICKET_STATUS, $hubspotTicketStatus);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotTicketPriority(): ?string
    {
        return $this->getData(self::HUBSPOT_TICKET_PRIORITY);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotTicketPriority(string $hubspotTicketPriority): FormInterface
    {
        return $this->setData(self::HUBSPOT_TICKET_PRIORITY, $hubspotTicketPriority);
    }

    /**
     * @inheritDoc
     */
    public function getHubspotTicketSource(): ?string
    {
        return $this->getData(self::HUBSPOT_TICKET_SOURCE);
    }

    /**
     * @inheritDoc
     */
    public function setHubspotTicketSource(string $hubspotTicketSource): FormInterface
    {
        return $this->setData(self::HUBSPOT_TICKET_SOURCE, $hubspotTicketSource);
    }
    #endregion
}
