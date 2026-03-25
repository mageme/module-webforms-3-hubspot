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

namespace MageMe\WebFormsHubspot\Api\Data;

interface FormInterface extends \MageMe\WebForms\Api\Data\FormInterface
{
    /** Hubspot settings */
    const IS_HUBSPOT_ENABLED = 'is_hubspot_enabled';
    const HUBSPOT_IS_CONTACT_ENABLED = 'hubspot_is_contact_enabled';
    const HUBSPOT_IS_COMPANY_ENABLED = 'hubspot_is_company_enabled';
    const HUBSPOT_IS_TICKET_ENABLED = 'hubspot_is_ticket_enabled';
    const HUBSPOT_EMAIL_FIELD_ID = 'hubspot_email_field_id';
    const HUBSPOT_OWNER = 'hubspot_owner';
    const HUBSPOT_MAP_FIELDS_SERIALIZED = 'hubspot_map_fields_serialized';

    /**
     * Additional constants for keys of data array.
     */
    const HUBSPOT_MAP_FIELDS = 'hubspot_map_fields';

    /**
     * Contact
     */
    const HUBSPOT_IS_CONTACT_UPDATED_BY_EMAIL = 'hubspot_is_contact_updated_by_email';
    const HUBSPOT_CONTACT_LIFECYCLE_STAGE = 'hubspot_contact_lifecycle_stage';
    const HUBSPOT_CONTACT_LEAD_STATUS = 'hubspot_contact_lead_status';

    /**
     * Company
     */
    const HUBSPOT_IS_COMPANY_UPDATED_BY_DOMAIN = 'hubspot_is_company_updated_by_domain';

    /**
     * Ticket
     */
    const HUBSPOT_TICKET_PIPELINE = 'hubspot_ticket_pipeline';
    const HUBSPOT_TICKET_STATUS = 'hubspot_ticket_status';
    const HUBSPOT_TICKET_PRIORITY = 'hubspot_ticket_priority';
    const HUBSPOT_TICKET_SOURCE = 'hubspot_ticket_source';



    #region HUBSPOT
    /**
     * Get isHubspotEnabled
     *
     * @return bool
     */
    public function getIsHubspotEnabled(): bool;

    /**
     * Set isHubspotEnabled
     *
     * @param bool $isHubspotEnabled
     * @return $this
     */
    public function setIsHubspotEnabled(bool $isHubspotEnabled): FormInterface;

    /**
     * Get hubspotIsContactEnabled
     *
     * @return bool
     */
    public function getHubspotIsContactEnabled(): bool;

    /**
     * Set hubspotIsContactEnabled
     *
     * @param bool $hubspotIsContactEnabled
     * @return $this
     */
    public function setHubspotIsContactEnabled(bool $hubspotIsContactEnabled): FormInterface;

    /**
     * Get hubspotIsCompanyEnabled
     *
     * @return bool
     */
    public function getHubspotIsCompanyEnabled(): bool;

    /**
     * Set hubspotIsCompanyEnabled
     *
     * @param bool $hubspotIsCompanyEnabled
     * @return $this
     */
    public function setHubspotIsCompanyEnabled(bool $hubspotIsCompanyEnabled): FormInterface;

    /**
     * Get hubspotIsTicketEnabled
     *
     * @return bool
     */
    public function getHubspotIsTicketEnabled(): bool;

    /**
     * Set hubspotIsTicketEnabled
     *
     * @param bool $hubspotIsTicketEnabled
     * @return $this
     */
    public function setHubspotIsTicketEnabled(bool $hubspotIsTicketEnabled): FormInterface;

    /**
     * Get hubspotEmailFieldId
     *
     * @return int|null
     */
    public function getHubspotEmailFieldId(): ?int;

    /**
     * Set hubspotEmailFieldId
     *
     * @param int|null $hubspotEmailFieldId
     * @return $this
     */
    public function setHubspotEmailFieldId(?int $hubspotEmailFieldId): FormInterface;

    /**
     * Get hubspotOwner
     *
     * @return string|null
     */
    public function getHubspotOwner(): ?string;

    /**
     * Set hubspotOwner
     *
     * @param string $hubspotOwner
     * @return $this
     */
    public function setHubspotOwner(string $hubspotOwner): FormInterface;

    /**
     * Get hubspotMapFieldsSerialized
     *
     * @return string|null
     */
    public function getHubspotMapFieldsSerialized(): ?string;

    /**
     * Set hubspotMapFieldsSerialized
     *
     * @param string $hubspotMapFieldsSerialized
     * @return $this
     */
    public function setHubspotMapFieldsSerialized(string $hubspotMapFieldsSerialized): FormInterface;

    /**
     * Get hubspotMapFields
     *
     * @return array
     */
    public function getHubspotMapFields(): array;

    /**
     * Set hubspotMapFields
     *
     * @param array $hubspotMapFields
     * @return $this
     */
    public function setHubspotMapFields(array $hubspotMapFields): FormInterface;

    /**
     * Get hubspotIsContactUpdatedByEmail
     *
     * @return bool
     */
    public function getHubspotIsContactUpdatedByEmail(): bool;

    /**
     * Set hubspotIsContactUpdatedByEmail
     *
     * @param bool $hubspotIsContactUpdatedByEmail
     * @return $this
     */
    public function setHubspotIsContactUpdatedByEmail(bool $hubspotIsContactUpdatedByEmail): FormInterface;

    /**
     * Get hubspotContactLifecycleStage
     *
     * @return string|null
     */
    public function getHubspotContactLifecycleStage(): ?string;

    /**
     * Set hubspotContactLifecycleStage
     *
     * @param string $hubspotContactLifecycleStage
     * @return $this
     */
    public function setHubspotContactLifecycleStage(string $hubspotContactLifecycleStage): FormInterface;

    /**
     * Get hubspotContactLeadStatus
     *
     * @return string|null
     */
    public function getHubspotContactLeadStatus(): ?string;

    /**
     * Set hubspotContactLeadStatus
     *
     * @param string $hubspotContactLeadStatus
     * @return $this
     */
    public function setHubspotContactLeadStatus(string $hubspotContactLeadStatus): FormInterface;

    /**
     * Get hubspotIsCompanyUpdatedByDomain
     *
     * @return bool
     */
    public function getHubspotIsCompanyUpdatedByDomain(): bool;

    /**
     * Set hubspotIsCompanyUpdatedByDomain
     *
     * @param bool $hubspotIsCompanyUpdatedByDomain
     * @return $this
     */
    public function setHubspotIsCompanyUpdatedByDomain(bool $hubspotIsCompanyUpdatedByDomain): FormInterface;

    /**
     * Get hubspotTicketPipeline
     *
     * @return string|null
     */
    public function getHubspotTicketPipeline(): ?string;

    /**
     * Set hubspotTicketPipeline
     *
     * @param string $hubspotTicketPipeline
     * @return $this
     */
    public function setHubspotTicketPipeline(string $hubspotTicketPipeline): FormInterface;

    /**
     * Get hubspotTicketStatus
     *
     * @return string|null
     */
    public function getHubspotTicketStatus(): ?string;

    /**
     * Set hubspotTicketStatus
     *
     * @param string $hubspotTicketStatus
     * @return $this
     */
    public function setHubspotTicketStatus(string $hubspotTicketStatus): FormInterface;

    /**
     * Get hubspotTicketPriority
     *
     * @return string|null
     */
    public function getHubspotTicketPriority(): ?string;

    /**
     * Set hubspotTicketPriority
     *
     * @param string $hubspotTicketPriority
     * @return $this
     */
    public function setHubspotTicketPriority(string $hubspotTicketPriority): FormInterface;

    /**
     * Get hubspotTicketSource
     *
     * @return string|null
     */
    public function getHubspotTicketSource(): ?string;

    /**
     * Set hubspotTicketSource
     *
     * @param string $hubspotTicketSource
     * @return $this
     */
    public function setHubspotTicketSource(string $hubspotTicketSource): FormInterface;
    #endregion
}
