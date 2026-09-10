<?php
/**
 * Copyright © MageMe. All rights reserved.
 * See LICENSE for license terms, or https://mageme.com/license.
 */

namespace MageMe\WebFormsHubspot\Plugin\Model\ResourceModel\Form;

use MageMe\WebForms\Model\ResourceModel\Form;
use MageMe\WebFormsHubspot\Api\Data\FormInterface;

class GetSerializableFields
{
    /**
     * @param Form $form
     * @param array $serializableFields
     * @return array
     */
    public function afterGetSerializableFields(Form $form, array $serializableFields): array
    {
        $serializableFields[FormInterface::HUBSPOT_MAP_FIELDS] = [
            $form::SERIALIZE_OPTION_SERIALIZED => FormInterface::HUBSPOT_MAP_FIELDS_SERIALIZED,
            $form::SERIALIZE_OPTION_DEFAULT_DESERIALIZED => []
        ];
        return $serializableFields;
    }
}
