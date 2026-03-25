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

use CURLFile;
use Exception;
use MageMe\WebFormsHubspot\Helper\Hubspot\Exception\DuplicateException;
use Magento\Framework\HTTP\Client\Curl;
use Psr\Log\LoggerInterface;

class Api
{
    const API_URL = 'https://api.hubapi.com';
    const CRM_SCOPE = '/crm/v3';
    const FILE_SCOPE = '/files/v3';
    const UNEXPECTED_ERROR = 'Unexpected error';

    /**
     * @var string|null
     */
    private $token;
    /**
     * @var Curl
     */
    private $curl;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     * @param Curl $curl
     */
    public function __construct(
        LoggerInterface $logger,
        Curl            $curl
    ) {
        $this->curl   = $curl;
        $this->logger = $logger;
    }

    #region Getters\Setters

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     * @return Api
     */
    public function setToken(?string $token): Api
    {
        $this->token = $token;
        return $this;
    }
    #endregion

    /**
     * @return array
     * @throws Exception
     */
    public function getOwners(): array
    {
        $this->curl->setHeaders(['Authorization' => 'Bearer ' . $this->token]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $this->curl->get(self::API_URL . self::CRM_SCOPE . '/owners');
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['results'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['results'] ?? [];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getContactProperties(): array
    {
        $this->curl->setHeaders(['Authorization' => 'Bearer ' . $this->token]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $this->curl->get(self::API_URL . self::CRM_SCOPE . '/properties/contact');
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['results'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['results'] ?? [];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getContactPropertyGroups(): array
    {
        $this->curl->setHeaders(['Authorization' => 'Bearer ' . $this->token]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $this->curl->get(self::API_URL . self::CRM_SCOPE . '/properties/contact/groups');
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['results'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['results'] ?? [];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getCompanyProperties(): array
    {
        $this->curl->setHeaders(['Authorization' => 'Bearer ' . $this->token]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $this->curl->get(self::API_URL . self::CRM_SCOPE . '/properties/company');
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['results'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['results'] ?? [];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getCompanyPropertyGroups(): array
    {
        $this->curl->setHeaders(['Authorization' => 'Bearer ' . $this->token]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $this->curl->get(self::API_URL . self::CRM_SCOPE . '/properties/company/groups');
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['results'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['results'] ?? [];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getTicketProperties(): array
    {
        $this->curl->setHeaders(['Authorization' => 'Bearer ' . $this->token]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $this->curl->get(self::API_URL . self::CRM_SCOPE . '/properties/ticket');
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['results'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['results'] ?? [];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getTicketPropertyGroups(): array
    {
        $this->curl->setHeaders(['Authorization' => 'Bearer ' . $this->token]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $this->curl->get(self::API_URL . self::CRM_SCOPE . '/properties/ticket/groups');
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['results'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['results'] ?? [];
    }

    /**
     * @param array $contact
     * @return string
     * @throws Exception
     */
    public function insertContact(array $contact): string
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $data = [
            'properties' => $contact
        ];
        $this->curl->post(self::API_URL . self::CRM_SCOPE . '/objects/contacts', json_encode($data));
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['id'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            if (preg_match('/(already exists. Existing ID: )(\d+)/', (string)$message, $matches)) {
                throw new DuplicateException($matches[2], $message);
            }
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['id'];
    }

    /**
     * @param string $id
     * @param array $contact
     * @return string
     * @throws Exception
     */
    public function updateContact(string $id, array $contact): string
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PATCH'
        ]);
        $data = [
            'properties' => $contact
        ];
        $this->curl->post(self::API_URL . self::CRM_SCOPE . '/objects/contacts/' . $id, json_encode($data));
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['id'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['id'];
    }

    /**
     * @param array $company
     * @return string
     * @throws Exception
     */
    public function insertCompany(array $company): string
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $data = [
            'properties' => $company
        ];
        $this->curl->post(self::API_URL . self::CRM_SCOPE . '/objects/companies', json_encode($data));
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['id'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
//            if (preg_match('/(already exists. Existing ID: )(\d+)/', (string)$message, $matches)) {
//                throw new DuplicateException($matches[2], $message);
//            }
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['id'];
    }

    /**
     * @param string $id
     * @param array $company
     * @return string
     * @throws Exception
     */
    public function updateCompany(string $id, array $company): string
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PATCH'
        ]);
        $data = [
            'properties' => $company
        ];
        $this->curl->post(self::API_URL . self::CRM_SCOPE . '/objects/companies/' . $id, json_encode($data));
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['id'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['id'];
    }

    /**
     * @param string $domain
     * @return string
     * @throws Exception
     */
    public function getCompanyIdByDomain(string $domain): string
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $data = [
            'filterGroups' => [
                [
                    'filters' => [
                        [
                            'value' => $domain,
                            'propertyName' => 'domain',
                            'operator' => 'EQ'
                        ]
                    ]
                ]
            ]
        ];
        $this->curl->post(self::API_URL . self::CRM_SCOPE . '/objects/companies/search', json_encode($data));
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['total'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        if ((int)$response['total'] > 0) {
            return $response['results'][0]['id'];
        }
        return '';
    }

    /**
     * @param array $ticket
     * @return string
     * @throws Exception
     */
    public function insertTicket(array $ticket): string
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $data = [
            'properties' => $ticket
        ];
        $this->curl->post(self::API_URL . self::CRM_SCOPE . '/objects/tickets', json_encode($data));
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['id'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['id'];
    }

    /**
     * @param string $filePath
     * @param string $mimeType
     * @param string $fileName
     * @return array
     * @throws Exception
     */
    public function uploadFile(string $filePath, string $mimeType = '', string $fileName = ''): array
    {
        $this->createFolder("webforms");
        $file = new CURLFile(realpath($filePath), $mimeType, $fileName);
        $data = [
            'file' => $file,
            'folderPath' => "/webforms",
            'options' => '{ "access": "PUBLIC_NOT_INDEXABLE" }'
        ];

        // Custom curl for files
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS | CURLPROTO_FTP | CURLPROTO_FTPS,
            CURLOPT_URL => self::API_URL . self::FILE_SCOPE . '/files',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: multipart/form-data'
            ]
        ]);
        $body = curl_exec($curl);
        $err  = curl_errno($curl);
        if ($err) {
            $message = curl_error($curl);
            $this->logger->error('Curl error: ' . $message);
            throw new Exception(__($message));
        }
        curl_close($curl);

        $response = json_decode($body, true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['id'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response;
    }

    /**
     * @param string $folderName
     * @return string
     * @throws Exception
     */
    public function createFolder(string $folderName): string
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $data = [
            'name' => $folderName
        ];
        $this->curl->post(self::API_URL . self::FILE_SCOPE . '/folders', json_encode($data));
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['id'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['id'];
    }

    /**
     * @param array $note
     * @return string
     * @throws Exception
     */
    public function createNote(array $note): string
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $data = [
            'properties' => $note
        ];
        $this->curl->post(self::API_URL . self::CRM_SCOPE . '/objects/notes', json_encode($data));
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['id'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['id'];
    }

    /**
     * @param string $noteId
     * @param string $objectType
     * @param string $objectId
     * @param string $associationType
     * @return mixed
     * @throws Exception
     */
    public function associateNote(string $noteId, string $objectType, string $objectId, string $associationType)
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'PUT'
        ]);
        $this->curl->post(self::API_URL . self::CRM_SCOPE .
            '/objects/notes/' . $noteId .
            '/associations/' . $objectType . '/' . $objectId . '/' . $associationType, "");
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['properties'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['properties'];
    }

    /**
     * @param string $fromId
     * @param string $toId
     * @param string $fromObjectType
     * @param string $toObjectType
     * @param string $associationType
     * @return mixed
     * @throws Exception
     */
    public function associate(
        string $fromId,
        string $toId,
        string $fromObjectType,
        string $toObjectType,
        string $associationType
    ) {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $data    = [
            "from" => [
                'id' => $fromId,
            ],
            "to" => [
                'id' => $toId,
            ],
            "type" => $associationType
        ];
        $encoded = '{"inputs":[' . json_encode($data) . ']}';

        $this->curl->post(self::API_URL . self::CRM_SCOPE .
            '/associations/' . $fromObjectType . '/' . $toObjectType . '/batch/create', $encoded);
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (empty($response['results'])) {
            $message = isset($response['errors']) ? $response['errors']['message'] ?? self::UNEXPECTED_ERROR : self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['results'];
    }

    /**
     * @param string $objectType
     * @param string $propertyName
     * @return array
     * @throws Exception
     */
    public function getProperty(string $objectType, string $propertyName): array
    {
        $this->curl->setHeaders(['Authorization' => 'Bearer ' . $this->token]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $this->curl->get(self::API_URL . self::CRM_SCOPE . "/properties/$objectType/$propertyName");
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (isset($response['status'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response;
    }

    /**
     * @param string $objectType
     * @return array
     * @throws Exception
     */
    public function getPipelines(string $objectType): array
    {
        $this->curl->setHeaders(['Authorization' => 'Bearer ' . $this->token]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $this->curl->get(self::API_URL . self::CRM_SCOPE . "/pipelines/$objectType");
        $response = json_decode($this->curl->getBody(), true);
        if (!is_array($response)) {
            $this->logger->error(self::UNEXPECTED_ERROR . ' body: ' . $this->curl->getBody());
            throw new Exception(__(self::UNEXPECTED_ERROR));
        }
        if (!isset($response['results'])) {
            $message = $response['message'] ?? self::UNEXPECTED_ERROR;
            $this->logger->error($message . ' body: ' . $this->curl->getBody());
            throw new Exception(__($message));
        }
        return $response['results'] ?? [];
    }
}