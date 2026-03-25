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

use Exception;
use MageMe\WebForms\Api\Data\FieldInterface;
use MageMe\WebForms\Api\Data\FileDropzoneInterface;
use MageMe\WebForms\Api\Data\FormInterface;
use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Api\FieldRepositoryInterface;
use MageMe\WebForms\Api\FileGalleryRepositoryInterface;
use MageMe\WebForms\Model\Field\Type\File;
use MageMe\WebForms\Model\Field\Type\Gallery;
use MageMe\WebFormsHubspot\Helper\HubspotHelper;
use MageMe\WebFormsHubspot\Ui\Component\Form\Form\Modifier\HubspotIntegrationSettings;
use Magento\Framework\Exception\NoSuchEntityException;

abstract class AddObject
{
    /**
     * @var HubspotHelper
     */
    protected $hubspotHelper;
    /**
     * @var FieldRepositoryInterface
     */
    protected $fieldRepository;
    /**
     * @var FileGalleryRepositoryInterface
     */
    protected $fileGalleryRepository;

    /**
     * @param FileGalleryRepositoryInterface $fileGalleryRepository
     * @param FieldRepositoryInterface $fieldRepository
     * @param HubspotHelper $hubspotHelper
     */
    public function __construct(
        FileGalleryRepositoryInterface $fileGalleryRepository,
        FieldRepositoryInterface       $fieldRepository,
        HubspotHelper                  $hubspotHelper
    ) {
        $this->hubspotHelper         = $hubspotHelper;
        $this->fieldRepository       = $fieldRepository;
        $this->fileGalleryRepository = $fileGalleryRepository;
    }

    /**
     * @param ResultInterface $result
     * @param array $args
     * @return void
     * @throws NoSuchEntityException
     * @throws Exception
     */
    abstract public function execute(ResultInterface $result, array $args = []): string;

    /**
     * @param FormInterface|\MageMe\WebFormsHubspot\Api\Data\FormInterface $form
     * @param ResultInterface $result
     * @return string
     */
    protected function getEmail(FormInterface $form, ResultInterface $result): string
    {
        $values  = $result->getFieldArray();
        $emailId = $form->getHubspotEmailFieldId();
        $email   = $values[$emailId] ?? '';
        if ($email) {
            return $email;
        }
        $emailList = $result->getCustomerEmail();
        return $emailList[0] ?? '';
    }

    /**
     * @param FormInterface|\MageMe\WebFormsHubspot\Api\Data\FormInterface $form
     * @param ResultInterface $result
     * @param string $source
     * @return array
     * @throws NoSuchEntityException
     * @throws Exception
     */
    protected function mapFields(FormInterface $form, ResultInterface $result, string $source): array
    {
        $data      = [
            'object' => [],
            'files' => []
        ];
        $values    = $result->getFieldArray();
        $mapFields = $form->getHubspotMapFields();
        foreach ($mapFields as $mapField) {
            if (empty($values[$mapField[FieldInterface::ID]])) {
                continue;
            }
            [$propName, $propType, $propSource] = explode(";", (string)$mapField[HubspotIntegrationSettings::HUBSPOT_FIELD_ID]);
            if ($propSource != $source) {
                continue;
            }
            $field = $this->fieldRepository->getById((int)$mapField[FieldInterface::ID]);
            if ($propType == 'file') {
                $hsFiles = [];
                $value   = [];
                if ($field instanceof File) {
                    $field->setData('result', $result);

                    /** @var FileDropzoneInterface[] $files */
                    $files = $field->getFilteredFieldValue();
                    foreach ($files as $file) {
                        $hsFile    = $this->hubspotHelper->getApi()->uploadFile(
                            $file->getFullPath(),
                            $file->getMimeType(),
                            $file->getName()
                        );
                        $hsFiles[] = $hsFile;
                        $value[]   = $hsFile['url'];
                    }
                } elseif ($field instanceof Gallery) {
                    $images = $field->parseValue($values[$mapField[FieldInterface::ID]]);
                    foreach ($images as $imageId) {
                        $file = $this->fileGalleryRepository->getById((int)$imageId);
                        try {
                            $hsFile    = $this->hubspotHelper->getApi()->uploadFile(
                                $file->getFullPath(),
                                $file->getMimeType(),
                                $file->getName()
                            );
                            $hsFiles[] = $hsFile;
                            $value[]   = $hsFile['url'];
                        } catch (Exception $e) {
                            continue;
                        }
                    }

                } else {
                    continue;
                }
                if ($value) {
                    $data['files'][]           = [
                        'field' => $propName,
                        'value' => $hsFiles
                    ];
                    $data['object'][$propName] = implode(" ", $value);
                }
            } else {
                $value                     = $field
                    ->getValueForResultTemplate($values[$mapField[FieldInterface::ID]], $result->getId(),
                        ['date_format' => 'yyyy-MM-dd']);
                $data['object'][$propName] = $value;
            }
        }
        return $data;
    }

    /**
     * @param $timestamp
     * @param $body
     * @param $owner
     * @param $files
     * @param $objectType
     * @param $objectId
     * @param $associationType
     * @return void
     * @throws Exception
     */
    protected function uploadFiles($timestamp, $body, $owner, $files, $objectType, $objectId, $associationType)
    {
        $api         = $this->hubspotHelper->getApi();
        $attachments = [];
        foreach ($files as $file) {
            $attachments[] = $file['id'];
        }
        $note   = [
            'hs_timestamp' => $timestamp,
            'hs_note_body' => $body,
            'hubspot_owner_id' => $owner,
            'hs_attachment_ids' => implode(";", $attachments),
        ];
        $noteId = $api->createNote($note);
        if ($noteId) {
            $api->associateNote($noteId, $objectType, $objectId, $associationType);
        }
    }
}