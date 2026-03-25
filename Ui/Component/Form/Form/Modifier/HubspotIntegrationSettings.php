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

namespace MageMe\WebFormsHubspot\Ui\Component\Form\Form\Modifier;

use MageMe\WebForms\Api\Data\FieldInterface;
use MageMe\WebForms\Api\Data\FormInterface as FormInterfaceAlias;
use MageMe\WebForms\Api\FormRepositoryInterface;
use MageMe\WebForms\Model\Field\Type\Email;
use MageMe\WebFormsHubspot\Api\Data\FormInterface;
use MageMe\WebFormsHubspot\Config\Options\ContactLeadStatus;
use MageMe\WebFormsHubspot\Config\Options\ContactLifecycleStage;
use MageMe\WebFormsHubspot\Config\Options\Owners;
use MageMe\WebFormsHubspot\Config\Options\HubspotFields;
use MageMe\WebFormsHubspot\Config\Options\TicketPipeline;
use MageMe\WebFormsHubspot\Config\Options\TicketPriority;
use MageMe\WebFormsHubspot\Config\Options\TicketSource;
use MageMe\WebFormsHubspot\Config\Options\TicketStage;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form;
use Magento\Ui\Component\Form\Element\ActionDelete;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class HubspotIntegrationSettings implements ModifierInterface
{
    const HUBSPOT_FIELD_ID = 'hubspot_field_id';
    /**
     * @var FormRepositoryInterface
     */
    private $formRepository;
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var Owners
     */
    private $owners;
    /**
     * @var HubspotFields
     */
    private $hubspotFields;
    /**
     * @var ContactLifecycleStage
     */
    private $contactLifecycleStage;
    /**
     * @var ContactLeadStatus
     */
    private $contactLeadStatus;
    /**
     * @var TicketSource
     */
    private $ticketSource;
    /**
     * @var TicketPriority
     */
    private $ticketPriority;
    /**
     * @var TicketPipeline
     */
    private $ticketPipeline;
    /**
     * @var TicketStage
     */
    private $ticketStage;

    /**
     * @param TicketStage $ticketStage
     * @param TicketPipeline $ticketPipeline
     * @param TicketPriority $ticketPriority
     * @param TicketSource $ticketSource
     * @param ContactLeadStatus $contactLeadStatus
     * @param ContactLifecycleStage $contactLifecycleStage
     * @param HubspotFields $hubspotFields
     * @param Owners $owners
     * @param RequestInterface $request
     * @param FormRepositoryInterface $formRepository
     */
    public function __construct(
        TicketStage             $ticketStage,
        TicketPipeline          $ticketPipeline,
        TicketPriority          $ticketPriority,
        TicketSource            $ticketSource,
        ContactLeadStatus       $contactLeadStatus,
        ContactLifecycleStage   $contactLifecycleStage,
        HubspotFields           $hubspotFields,
        Owners                  $owners,
        RequestInterface        $request,
        FormRepositoryInterface $formRepository
    ) {
        $this->formRepository        = $formRepository;
        $this->request               = $request;
        $this->owners                = $owners;
        $this->hubspotFields         = $hubspotFields;
        $this->contactLifecycleStage = $contactLifecycleStage;
        $this->contactLeadStatus     = $contactLeadStatus;
        $this->ticketSource          = $ticketSource;
        $this->ticketPriority        = $ticketPriority;
        $this->ticketPipeline        = $ticketPipeline;
        $this->ticketStage           = $ticketStage;
    }

    /**
     * @inheritDoc
     */
    public function modifyData(array $data): array
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function modifyMeta(array $meta): array
    {
        $meta['hubspot_integration_settings'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Form\Fieldset::NAME,
                        'label' => __('HubSpot Integration Settings'),
                        'sortOrder' => 170,
                        'collapsible' => true,
                        'opened' => false,
                    ]
                ]
            ],
            'children' => [
                FormInterface::IS_HUBSPOT_ENABLED => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Checkbox::NAME,
                                'dataType' => Form\Element\DataType\Boolean::NAME,
                                'visible' => 1,
                                'sortOrder' => 10,
                                'label' => __('Enable HubSpot Integration'),
                                'default' => '0',
                                'prefer' => 'toggle',
                                'valueMap' => ['false' => '0', 'true' => '1'],
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_IS_CONTACT_ENABLED => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Checkbox::NAME,
                                'dataType' => Form\Element\DataType\Boolean::NAME,
                                'visible' => 1,
                                'sortOrder' => 20,
                                'label' => __('Contact'),
                                'additionalInfo' => __('Create HubSpot contact record. Please map appropriate attributes.'),
                                'default' => '0',
                                'prefer' => 'toggle',
                                'valueMap' => ['false' => '0', 'true' => '1'],
                                'switcherConfig' => [
                                    'component' => 'Magento_Ui/js/form/switcher',
                                    'enabled' => true,
                                    'rules' => [
                                        [
                                            'value' => '0',
                                            'actions' => [
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_IS_CONTACT_UPDATED_BY_EMAIL,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'hide'
                                                ],
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_CONTACT_LIFECYCLE_STAGE,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'hide'
                                                ],
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_CONTACT_LEAD_STATUS,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'hide'
                                                ],
                                            ]
                                        ],
                                        [
                                            'value' => '1',
                                            'actions' => [
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_IS_CONTACT_UPDATED_BY_EMAIL,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'show'
                                                ],
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_CONTACT_LIFECYCLE_STAGE,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'show'
                                                ],
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_CONTACT_LEAD_STATUS,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'show'
                                                ],
                                            ]
                                        ]
                                    ],
                                ],
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_IS_CONTACT_UPDATED_BY_EMAIL => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Checkbox::NAME,
                                'dataType' => Form\Element\DataType\Boolean::NAME,
                                'visible' => 1,
                                'sortOrder' => 30,
                                'label' => __('Update Existing Contacts'),
                                'additionalInfo' => __('Update contact information for already existing email.'),
                                'default' => '0',
                                'prefer' => 'toggle',
                                'valueMap' => ['false' => '0', 'true' => '1'],
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_CONTACT_LIFECYCLE_STAGE => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Text::NAME,
                                'visible' => 1,
                                'sortOrder' => 40,
                                'label' => __('Contact Lifecycle Stage'),
                                'options' => $this->contactLifecycleStage->toOptionArray(),
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_CONTACT_LEAD_STATUS => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Text::NAME,
                                'visible' => 1,
                                'sortOrder' => 50,
                                'label' => __('Contact Lead Status'),
                                'options' => $this->contactLeadStatus->toOptionArray(),
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_IS_COMPANY_ENABLED => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Checkbox::NAME,
                                'dataType' => Form\Element\DataType\Boolean::NAME,
                                'visible' => 1,
                                'sortOrder' => 60,
                                'label' => __('Company'),
                                'additionalInfo' => __('Create HubSpot company record. Please map appropriate attributes.'),
                                'default' => '0',
                                'prefer' => 'toggle',
                                'valueMap' => ['false' => '0', 'true' => '1'],
                                'switcherConfig' => [
                                    'component' => 'Magento_Ui/js/form/switcher',
                                    'enabled' => true,
                                    'rules' => [
                                        [
                                            'value' => '0',
                                            'actions' => [
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_IS_COMPANY_UPDATED_BY_DOMAIN,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'hide'
                                                ],
                                            ]
                                        ],
                                        [
                                            'value' => '1',
                                            'actions' => [
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_IS_COMPANY_UPDATED_BY_DOMAIN,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'show'
                                                ],
                                            ]
                                        ]
                                    ],
                                ],
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_IS_COMPANY_UPDATED_BY_DOMAIN => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Checkbox::NAME,
                                'dataType' => Form\Element\DataType\Boolean::NAME,
                                'visible' => 1,
                                'sortOrder' => 70,
                                'label' => __('Update Existing Companies'),
                                'additionalInfo' => __('Update company information for already existing domain.'),
                                'default' => '0',
                                'prefer' => 'toggle',
                                'valueMap' => ['false' => '0', 'true' => '1'],
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_IS_TICKET_ENABLED => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Checkbox::NAME,
                                'dataType' => Form\Element\DataType\Boolean::NAME,
                                'visible' => 1,
                                'sortOrder' => 80,
                                'label' => __('Ticket'),
                                'additionalInfo' => __('Create HubSpot ticket. Please map appropriate attributes.'),
                                'default' => '0',
                                'prefer' => 'toggle',
                                'valueMap' => ['false' => '0', 'true' => '1'],
                                'switcherConfig' => [
                                    'component' => 'Magento_Ui/js/form/switcher',
                                    'enabled' => true,
                                    'rules' => [
                                        [
                                            'value' => '0',
                                            'actions' => [
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_TICKET_PIPELINE,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'hide'
                                                ],
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_TICKET_STATUS,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'hide'
                                                ],
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_TICKET_PRIORITY,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'hide'
                                                ],
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_TICKET_SOURCE,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'hide'
                                                ]
                                            ]
                                        ],
                                        [
                                            'value' => '1',
                                            'actions' => [
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_TICKET_PIPELINE,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'show'
                                                ],
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_TICKET_STATUS,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'show'
                                                ],
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_TICKET_PRIORITY,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'show'
                                                ],
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::HUBSPOT_TICKET_SOURCE,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'show'
                                                ]
                                            ]
                                        ]
                                    ],
                                ],
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_TICKET_PIPELINE => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Text::NAME,
                                'visible' => 1,
                                'sortOrder' => 90,
                                'label' => __('Ticket Pipeline'),
                                'options' => $this->ticketPipeline->toOptionArray(),
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_TICKET_STATUS => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Text::NAME,
                                'visible' => 1,
                                'sortOrder' => 100,
                                'label' => __('Ticket Status'),
                                'options' => $this->ticketStage->toOptionArray(),
                                'filterBy' => [
                                    'target' => '${ $.provider }:${ $.parentScope }.' . FormInterface::HUBSPOT_TICKET_PIPELINE,
                                    'field' => 'pipeline_id',
                                    '__disableTmpl' => false,
                                ]
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_TICKET_PRIORITY => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Text::NAME,
                                'visible' => 1,
                                'sortOrder' => 110,
                                'label' => __('Ticket Priority'),
                                'options' => $this->ticketPriority->toOptionArray(),
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_TICKET_SOURCE => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Text::NAME,
                                'visible' => 1,
                                'sortOrder' => 120,
                                'label' => __('Ticket Source'),
                                'options' => $this->ticketSource->toOptionArray(),
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_EMAIL_FIELD_ID => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Number::NAME,
                                'visible' => 1,
                                'sortOrder' => 130,
                                'label' => __('Customer Email'),
                                'options' => $this->getFields(Email::class),
                                'caption' => __('Default'),
                            ]
                        ]
                    ]
                ],
                FormInterface::HUBSPOT_OWNER => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Text::NAME,
                                'visible' => 1,
                                'sortOrder' => 140,
                                'label' => __('Owner'),
                                'options' => $this->owners->toOptionArray(),
                            ]
                        ]
                    ]
                ],

                FormInterface::HUBSPOT_MAP_FIELDS => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => DynamicRows::NAME,
                                'visible' => 1,
                                'sortOrder' => 150,
                                'label' => __('Fields Mapping'),
                            ]
                        ]
                    ],
                    'children' => [
                        'record' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'componentType' => Container::NAME,
                                        'isTemplate' => true,
                                        'is_collection' => true,
                                    ]
                                ]
                            ],
                            'children' => [
                                self::HUBSPOT_FIELD_ID => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => Form\Field::NAME,
                                                'formElement' => Form\Element\Select::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'visible' => 1,
                                                'sortOrder' => 10,
                                                'label' => __('HubSpot Attribute'),
                                                'options' => $this->hubspotFields->toOptionArray(),
                                                'validation' => [
                                                    'required-entry' => true,
                                                ],
                                            ]
                                        ]
                                    ]
                                ],
                                FieldInterface::ID => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => Form\Field::NAME,
                                                'formElement' => Form\Element\Select::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'visible' => 1,
                                                'sortOrder' => 20,
                                                'label' => __('Field'),
                                                'options' => $this->getFields(),
                                                'validation' => [
                                                    'required-entry' => true,
                                                ],
                                            ]
                                        ]
                                    ]
                                ],
                                ActionDelete::NAME => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => ActionDelete::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'label' => '',
                                                'sortOrder' => 30,
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        ]
                    ]
                ],
            ]
        ];
        return $meta;
    }

    /**
     * @param mixed $type
     * @return array
     */
    protected function getFields($type = false): array
    {
        $formId = (int)$this->request->getParam(FormInterfaceAlias::ID);
        if (!$formId) {
            return [];
        }
        try {
            return $this->formRepository->getById($formId)->getFieldsAsOptions($type);
        } catch (NoSuchEntityException $e) {
            return [];
        }
    }
}