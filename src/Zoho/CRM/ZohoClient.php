<?php

/*
 * This file is part of mctekk/zohocrm library.
 *
 * (c) MCTekK S.R.L. https://mctekk.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zoho\CRM;

use Zoho\CRM\Common\FactoryInterface;
use Zoho\CRM\Common\HttpClientInterface;
use Zoho\CRM\Request\Factory;
use Zoho\CRM\Request\HttpClient;
use Zoho\CRM\Wrapper\Element;
use GuzzleHttp\Client;
use Exception;
use SimpleXMLElement;

/**
 * Client for provide interface with Zoho CRM.
 */
class ZohoClient
{
    /**
     * Defined the module names.
     *
     * @var string
     */
    const MODULE_LEADS = 'Leads';
    const MODULE_CONTACTS = 'Contacts';
    const MODULE_ACCOUNTS = 'Accounts';

    /**
     * URL for call request.
     *
     * @var string
     */
    const BASE_URI = 'https://crm.zoho.com/crm/private';

    /**
     * URL for call request in zoho.eu.
     *
     * @var string
     */
    const BASE_URI_EU = 'https://crm.zoho.eu/crm/private';

    /**
     * Base Token URI.
     *
     * @var string
     */
    const TOKEN_URI = 'https://accounts.zoho.com/oauth/v2/token';

    /**
     * Grant Type.
     *
     * @var string
     */
    const GRANT_TYPE = 'authorization_code';

    /**
     * Grant Type Refresh.
     *
     * @var string
     */
    const GRANT_TYPE_REFRESH = 'refresh_token';

    /**
     * Grant Type Refresh.
     *
     * @var string
     */
    const API_VERSION = 'v2';

    /**
     * Token used for session of request.
     *
     * @var string
     */
    protected $grantToken;

    /**
     * Client Id from Zoho.
     *
     * @var string
     */
    protected $zohoClientId;

    /**
     * Redirect URI from Zoho.
     *
     * @var string
     */
    protected $zohoRedirectUri;

    /**
     * Client Secret from Zoho.
     *
     * @var string
     */
    protected $zohoClientSecret;

    /**
     * Grant Type from Zoho.
     *
     * @var string
     */
    protected $zohoGrantType;

    /**
     * Refresh Token for Zoho Auth.
     *
     * @var string
     */
    protected $authRefreshToken;

    /**
     * Access Token for Zoho Auth.
     *
     * @var string
     */
    protected $authAccessToken;

    /**
     * Authentication Array.
     *
     * @var string
     */
    protected $authArray;

    /**
     * Instance of the client.
     *
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * Instance of the factory.
     *
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * Format selected for get request.
     *
     * @var string
     */
    protected $format;

    /**
     * Module selected for get request.
     *
     * @var string
     */
    protected $module;

    /**
     * Base URI for selected domain.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * Construct.
     *
     * @param string $grantToken Grant Token of Registered App from Zoho
     * @param string $zohoClientId Client Id of Registered App from Zoho
     * @param string $zohoClientSecret Client Secret of Registered App from Zoho
     * @param string $zohoRedirectUri Redirect URI of Registered App from Zoho
     * @param HttpClientInterface $client HttpClient for connection [optional]
     * @param FactotoryInterface $factory [optional]
     */
    public function __construct($grantToken, $zohoClientId = null, $zohoClientSecret = null, $zohoRedirectUri = null, HttpClientInterface $client = null, FactoryInterface $factory = null)
    {
        $this->format = 'xml';
        $this->client = $client ?: new Client();
        $this->factory = $factory ?: new Factory();

        $this->grantToken = $grantToken;
        $this->zohoClientId = $zohoClientId;
        $this->zohoClientSecret = $zohoClientSecret;
        $this->zohoRedirectUri = $zohoRedirectUri;
        $this->zohoGrantType = self::GRANT_TYPE;

        $this->authArray = [
            'code' => $this->grantToken,
            'redirect_uri' => $this->zohoRedirectUri,
            'client_id' => $this->zohoClientId,
            'client_secret' => $this->zohoClientSecret,
            'grant_type' => $this->zohoGrantType
        ];

        return $this;
    }

    /**
     * Generate Access Token by Grant Token.
     *
     * @return void
     */
    public function generateAccessTokenByGrantToken(): void
    {
        //Use Guzzle client to make call
        $res = $this->client->post(self::TOKEN_URI, ['query' => $this->authArray, 'verify' => false]);
        $auth = json_decode($res->getBody(), true);

        if (!array_key_exists('access_token', $auth)) {
            throw new Exception('Error on Zoho Authentication,please validate that the grant token given to you by Zoho is active');
        }
        $this->authAccessToken = $auth['access_token'];
        $this->authRefreshToken = $auth['refresh_token'];
        $this->baseUri = $auth['api_domain'];
    }

    /**
     * Generate Access Token by Grant Token.
     *
     * @return void
     */
    public function generateAccessTokenByRefreshToken()
    {
        $authRefreshArray = [
            'refresh_token' => $this->authRefreshToken,
            'client_id' => $this->zohoClientId,
            'client_secret' => $this->zohoClientSecret,
            'grant_type' => self::GRANT_TYPE_REFRESH
        ];

        return $authRefreshArray;

        //Use Guzzle client to make call
        $res = $this->client->post(self::TOKEN_URI, ['query' => $authRefreshArray, 'verify' => false]);
        $auth = json_decode($res->getBody(), true);

        $this->authAccessToken = $auth['access_token'];
    }

    /**
     * Sets the http client's default headers.
     *
     * @return void
     * @todo Give more options on default header by passing an array.
     */
    public function getDefaultHeaders()
    {
        $this->generateAccessTokenByRefreshToken();
        return [
            'Authorization' => 'Zoho-oauthtoken ' . $this->authAccessToken
        ];
    }

    /**
     * Select EU Domain.
     *
     * @param bool isEU
     * @param mixed $eu
     */
    public function setEuDomain($eu = true)
    {
        $this->baseUri = $eu ? self::BASE_URI_EU : self::BASE_URI;
    }

    /**
     * Implements convertLead API method.
     *
     * @param string $leadId  Id of the lead
     * @param array $data     xmlData represented as an array
     *                        array will be converted into XML before sending the request
     * @param array $params   request parameters
     *                        newFormat 1 (default) - exclude fields with null values in the response
     *                                  2 - include fields with null values in the response
     *                        version   1 (default) - use earlier API implementation
     *                                  2 - use latest API implementation
     * @param array $options Options to add for configurations [optional]
     *
     * @return Response The Response object
     */
    public function convertLead($leadId, $data, $params = [], $options = [])
    {
        $params['leadId'] = $leadId;

        return $this->call('convertLead', $params, $data, $options);
    }

    /**
     * Implements getCVRecords API method.
     *
     * @param string $name    name of the Custom View
     * @param array  $params  request parameters
     *                        selectColumns     String  Module(optional columns) i.e, leads(Last Name,Website,Email) OR All
     *                        fromIndex         Integer Default value 1
     *                        toIndex           Integer Default value 20
     *                                                  Maximum value 200
     *                        lastModifiedTime  DateTime  Default value: null
     *                                                    If you specify the time, modified data will be fetched after the configured time.
     *                        newFormat         Integer 1 (default) - exclude fields with null values in the response
     *                                                  2 - include fields with null values in the response
     *                        version           Integer 1 (default) - use earlier API implementation
     *                                                   2 - use latest API implementation
     * @param array $options Options to add for configurations [optional]
     *
     * @return Response The Response object
     */
    public function getCVRecords($name, $params = [], $options = [])
    {
        $params['cvName'] = $name;

        return $this->call('getCVRecords', $params);
    }

    /**
     * Implements getFields API method.
     *
     * @return Response The Response object
     */
    public function getFields()
    {
        return $this->call('getFields', []);
    }

    /**
     * Implements deleteRecords API method.
     *
     * @param mixed $id  Id of the record if string or list of ids if an array
     *                     a list will be passed as the parameter idlist
     *
     * @return Response The Response object
     */
    public function deleteRecords($id)
    {
        if (is_array($id)) {
            $params['idlist'] = implode(';', $id);
        } else {
            $params['id'] = $id;
        }

        return $this->call('deleteRecords', $params);
    }

    /**
     * Implements getRecordById API method.
     *
     * @param mixed $id       Id of the record if string or list of ids if an array
     *                          a list will be passed as the parameter idlist
     * @param array $params   request parameters
     *                        newFormat 1 (default) - exclude fields with null values in the response
     *                                  2 - include fields with null values in the response
     *                        version   1 (default) - use earlier API implementation
     *                                  2 - use latest API implementation
     * @param array $options Options to add for configurations [optional]
     *
     * @return Response The Response object
     */
    public function getRecordById($id, $params = [], $options = [])
    {
        if (is_array($id)) {
            $params['idlist'] = implode(';', $id);
        } else {
            $params['id'] = $id;
        }

        return $this->call('get', $params);
    }

    /**
     * Implements getRecords API method.
     *
     * @param array $params   request parameters
     *                        selectColumns     String  Module(optional columns) i.e, leads(Last Name,Website,Email) OR All
     *                        fromIndex            Integer    Default value 1
     *                        toIndex              Integer    Default value 20
     *                                                  Maximum value 200
     *                        sortColumnString    String    If you use the sortColumnString parameter, by default data is sorted in ascending order.
     *                        sortOrderString      String    Default value - asc
     *                                          if you want to sort in descending order, then you have to pass sortOrderString=desc.
     *                        lastModifiedTime    DateTime    Default value: null
     *                                          If you specify the time, modified data will be fetched after the configured time.
     *                        newFormat         Integer    1 (default) - exclude fields with null values in the response
     *                                                  2 - include fields with null values in the response
     *                        version           Integer    1 (default) - use earlier API implementation
     *                                                  2 - use latest API implementation
     * @param array $options Options to add for configurations [optional]
     *
     * @return Response The Response object
     */
    public function getRecords($params = [], $options = [])
    {
        return $this->call('get', $params);
    }

    /**
     * Implements getSearchRecords API method.
     *
     * @param string $searchCondition search condition in the format (fieldName|condition|searchString)
     *                                e.g. (Email|contains|*@sample.com*)
     *
     * @param array $params           request parameters
     *                                selectColumns String  Module(columns) e.g. Leads(Last Name,Website,Email)
     *                                                      Note: do not use any extra spaces when listing column names
     *                                fromIndex        Integer    Default value 1
     *                                toIndex          Integer    Default value 20
     *                                                      Maximum value 200
     *                                newFormat     Integer 1 (default) - exclude fields with null values in the response
     *                                                      2 - include fields with null values in the response
     *                                version       Integer 1 (default) - use earlier API implementation
     *                                                      2 - use latest API implementation
     * @param mixed $options
     *
     * @return Response The Response object
     */
    public function getSearchRecords($searchCondition, $params = [], $options = [])
    {
        $params['searchCondition'] = $searchCondition;
        if (empty($params['selectColumns'])) {
            $params['selectColumns'] = 'All';
        }

        return $this->call('getSearchRecords', $params);
    }

    /**
     * Implements searchRecords API method.
     *
     * @param string $searchCondition search condition in the format (((Last Name:Steve)AND(Company:Zillum))OR(Lead Status:Contacted))
     * @param array $params           request parameters
     *                                selectColumns String  Module(columns) e.g. Leads(Last Name,Website,Email)
     *                                                      Note: do not use any extra spaces when listing column names
     *                                fromIndex        Integer    Default value 1
     *                                toIndex          Integer    Default value 20
     *                                                      Maximum value 200
     *                                newFormat     Integer 1 (default) - exclude fields with null values in the response
     *                                                      2 - include fields with null values in the response
     *                                version       Integer 1 (default) - use earlier API implementation
     *                                                      2 - use latest API implementation
     * @param mixed $criteria
     * @param mixed $options
     *
     * @return Response The Response object
     */
    public function searchRecords($criteria, $params = [], $options = [])
    {
        $params['criteria'] = $criteria;
        if (empty($params['selectColumns'])) {
            $params['selectColumns'] = 'All';
        }

        return $this->call('get', $params);
    }

    /**
     * Implements insertRecords API method.
     *
     * @param array $data     xmlData represented as an array
     *                        array will be converted into XML before sending the request
     * @param array $params   request parameters
     *                        wfTrigger          Boolean    Set value as true to trigger the workflow rule
     *                                          while inserting record into CRM account. By default, this parameter is false.
     *                        duplicateCheck    Integer    Set value as "1" to check the duplicate records and throw an
     *                                                error response or "2" to check the duplicate records, if exists, update the same.
     *                        isApproval        Boolean    By default, records are inserted directly . To keep the records in approval mode,
     *                                                set value as true. You can use this parameters for Leads, Contacts, and Cases module.
     *                        newFormat       Integer    1 (default) - exclude fields with null values in the response
     *                                                2 - include fields with null values in the response
     *                        version         Integer    1 (default) - use earlier API implementation
     *                                                2 - use latest API implementation
     *                                                4 - enable duplicate check functionality for multiple records.
     *                                                It's recommended to use version 4 for inserting multiple records
     *                                                even when duplicate check is turned off.
     * @param array $options Options to add for configurations [optional]
     *
     * @return Response The Response object
     *
     * @todo
     */
    public function insertRecords($data, $params = [], $options = [])
    {
        return $this->call('post', $params, $data, $options);
    }

    /**
     * Implements updateRecords API method.
     *
     * @param string $id       unique ID of the record to be updated
     * @param array  $data     xmlData represented as an array
     *                         array will be converted into XML before sending the request
     * @param array  $params   request parameters
     *                         wfTrigger    Boolean   Set value as true to trigger the workflow rule
     *                                                while inserting record into CRM account. By default, this parameter is false.
     *                         newFormat    Integer   1 (default) - exclude fields with "null" values while updating data
     *                                                2 - include fields with "null" values while updating data
     *                         version      Integer   1 (default) - use earlier API implementation
     *                                                2 - use latest API implementation
     *                                                4 - update multiple records in a single API method call
     * @param array $options Options to add for configurations [optional]
     *
     * @return Response The Response object
     */
    public function updateRecords($id, $data, $params = [], $options = [])
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Record Id is required and cannot be empty.');
        }
        $params['id'] = $id;
        return $this->call('put', $params, $data, $options);
    }

    /**
     * Implements uploadFile API method.
     *
     * @param string           $id          unique ID of the record to be updated
     * @param file path        $content     Pass the File Input Stream of the file or URL
     * @param array            $params      request parameters
     *                         wfTrigger    Boolean   Set value as true to trigger the workflow rule
     *                                                while inserting record into CRM account. By default, this parameter is false.
     *                         newFormat    Integer   1 (default) - exclude fields with "null" values while updating data
     *                                                2 - include fields with "null" values while updating data
     *                         version      Integer   1 (default) - use earlier API implementation
     *                                                2 - use latest API implementation
     *                                                4 - update multiple records in a single API method call
     *
     * @return Response The Response object
     */
    public function uploadFile($id, $content, $params = [])
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Record Id is required and cannot be empty.');
        }
        $params['id'] = $id;

        if (substr($content, 0, 4) === 'http') {
            $params['attachmentUrl'] = $content;
        } else {
            $params['content'] = $content;
            if (function_exists('curl_file_create')) { // php 5.6+
                $params['content'] = curl_file_create($content);
            }
        }

        return $this->call('uploadFile', $params);
    }

    /**
     * Get the module.
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set the model.
     *
     * @param string $module Module to use
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * Make the call using the client.
     *
     * @param string $method HTTP method
     * @param string $params Options
     * @param array $data Data to send [optional]
     * @param array $options Options to add for configurations [optional]
     *
     * @todo Modify createResponse so that it gives the same response regardless of how the response is structured
     * @return Response
     */
    protected function call($method, $params = [], $data = [], $options = [])
    {
        $defaultHeaders = $this->getDefaultHeaders();
        $uri = array_key_exists('id', $params) ? $this->getRequestURI() . '/' . $params['id'] : $this->getRequestURI();
        if (array_key_exists('criteria', $params)) {
            $uri = $this->appendCriteria($uri, $params['criteria']);
        }
        $body = $this->getRequestBody($params, $data, $options);
        $response = $this->client->request(strtoupper($method), $uri, $this->constructRequestParams($defaultHeaders, $body));
        $responseData = json_decode($response->getBody(), true);
        return $this->factory->createResponse($responseData, $this->module, $method)->getRecords();
    }

    /**
     * Append search criteria to current URI.
     *
     * @param string $uri
     * @param string $criteria
     * @return string
     */
    protected function appendCriteria(string $uri, string $criteria): string
    {
        $equalCriteriaSearch = str_replace(':', ':equals:', $criteria);
        return $uri . '/search?criteria=' . $equalCriteriaSearch;
    }

    /**
     * Construct request's params array.
     *
     * @return array
     */
    protected function constructRequestParams(array $defaultHeaders, array $body = []): array
    {
        return [
            'headers' => $defaultHeaders,
            'json' => [
                'data' => [$body['data']],
                'trigger' => $body['trigger']
            ],
            'verify' => false
        ];
    }

    /**
     * Get the current request uri.
     *
     * @param string $command Command for get uri
     *
     * @return string
     */
    protected function getRequestURI(): string
    {
        if (empty($this->module)) {
            throw new \RuntimeException('Zoho CRM module is not set.');
        }
        $parts = [$this->baseUri, 'crm', self::API_VERSION, $this->module];

        return implode('/', $parts);
    }

    /**
     * Get the body of the request.
     *
     * @param array $params Params
     * @param object $data Data
     * @param mixed $options
     *
     * @return string
     */
    protected function getRequestBody($params, $data, $options)
    {
        return  [
            'data' => $data,
            'trigger' => $options
        ];
    }
}
