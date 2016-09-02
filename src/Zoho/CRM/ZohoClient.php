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

/**
 * Client for provide interface with Zoho CRM
 */
class ZohoClient
{
    /**
     * Defined the module names
     *
     * @var string
     */
    const MODULE_LEADS = 'Leads';
    const MODULE_CONTACTS = 'Contacts';
    const MODULE_ACCOUNTS = 'Accounts';

    /**
     * URL for call request
     *
     * @var string
     */
    const BASE_URI = 'https://crm.zoho.com/crm/private';

    /**
     * URL for call request in zoho.eu
     *
     * @var string
     */
    const BASE_URI_EU = 'https://crm.zoho.eu/crm/private';

    /**
     * Token used for session of request
     *
     * @var string
     */
    protected $authtoken;

    /**
     * Instance of the client
     *
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * Instance of the factory
     *
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * Format selected for get request
     *
     * @var string
     */
    protected $format;

    /**
     * Module selected for get request
     *
     * @var string
     */
    protected $module;

    /**
     * Base URI for selected domain
     *
     * @var string
     */
    protected $baseUri;

    /**
     * Construct
     *
     * @param string $authtoken Token for connection
     * @param HttpClientInterface $client HttpClient for connection [optional]
     * @param FactotoryInterface $factory [optional]
     */
    public function __construct($authtoken, HttpClientInterface $client = null, FactoryInterface $factory = null)
    {
        $this->authtoken = $authtoken;
        // Only XML format is supported for the time being
        $this->format = 'xml';
        $this->client = $client ?: new HttpClient();
        $this->factory = $factory ?: new Factory();
        $this->baseUri = self::BASE_URI;

        return $this;
    }

    /**
     * Select EU Domain
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

        return $this->call('getRecordById', $params);
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
        return $this->call('getRecords', $params);
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
    public function getRelatedRecords($params = [], $options = [])
    {
        return $this->call('getRelatedRecords', $params);
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

        return $this->call('searchRecords', $params);
    }

    /**
     * Implements getUsers API method.
     *
     *  @param string  $type       type of the user to return. Possible values:
     *                              AllUsers - all users (both active and inactive)
     *                              ActiveUsers - only active users
     *                              DeactiveUsers - only deactivated users
     *                              AdminUsers - all users with admin privileges
     *                              ActiveConfirmedAdmins - users with admin privileges that are confirmed
     * @param int $newFormat  1 (default) - exclude fields with null values in the response
     *                            2 - include fields with null values in the response
     *
     * @return Response The Response object
     */
    public function getUsers($type = 'AllUsers', $newFormat = 1)
    {
        $params['type'] = $type;
        $params['newFormat'] = $newFormat;

        return $this->call('getUsers', $params);
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
        // if (!isset($params['duplicateCheck'])) {
        //     $params['duplicateCheck'] = 1;
        // }
        if (!isset($params['version']) && isset($data['records']) && count($data['records']) > 1) {
            $params['version'] = 4;
        }

        return $this->call('insertRecords', $params, $data, $options);
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
        if (is_array($data) && count($data['records']) > 1) {
            // Version 4 is mandatory for updating multiple records.
            $params['version'] = 4;
        } else {
            if (empty($id)) {
                throw new \InvalidArgumentException('Record Id is required and cannot be empty.');
            }

            $params['id'] = $id;
        }

        return $this->call('updateRecords', $params, $data, $options);
    }

    /**
     * Implements uploadFile API method.
     *
     * @param string             $id            unique ID of the record to be updated
     * @param file path             $content     Pass the File Input Stream of the file
     * @param array  $params   request parameters
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
        $params['content'] = $content;
        if (function_exists('curl_file_create')) { // php 5.6+
            $params['content'] = curl_file_create($content);
        }

        return $this->call('uploadFile', $params);
    }

    /**
     * Get the module
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set the model
     *
     * @param string $module Module to use
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * Convert from array to XML
     *
     * @param array $data Data to convert
     *
     * @return XML
     */
    public function toXML($data)
    {
        $root = isset($data['root']) ? $data['root'] : $this->module;
        $no = 1;
        $xml = '<'.$root.'>';
        if (isset($data['options'])) {
            $xml .= '<row no="'.$no.'">';
            foreach ($data['options'] as $key => $value) {
                $xml .= '<option val="'.$key.'">'.$value.'</option>';
            }
            $xml .= '</row>';
            ++$no;
        }
        foreach ($data['records'] as $row) {
            $xml .= '<row no="'.$no.'">';
            foreach ($row as $key => $value) {
                if (is_array($value)) {
                    $xml .= '<FL val="'.str_replace('&', 'and', $key).'">';
                    foreach ($value as $k => $v) {
                        list($tag, $attribute) = explode(' ', $k);
                        $xml .= '<'.$tag.' no="'.$attribute.'">';
                        foreach ($v as $kk => $vv) {
                            $xml .= '<FL val="'.str_replace('&', 'and', $kk).'"><![CDATA['.$vv.']]></FL>';
                        }
                        $xml .= '</'.$tag.'>';
                    }
                    $xml .= '</FL>';
                } else {
                    $xml .= '<FL val="'.str_replace('&', 'and', $key).'"><![CDATA['.$value.']]></FL>';
                }
            }
            $xml .= '</row>';
            ++$no;
        }
        $xml .= '</'.$root.'>';

        return $xml;
    }

    /**
     * Convert an entity into XML
     *
     * @param Element $entity     Element
     * @param string  $entityName Element name
     * @return string XML created
     * @throws \Exception
     */
    public function mapEntity($entity, $entityName = null)
    {
        // It's module entity
        if (is_null($entityName)) {
            if (empty($this->module)) {
                throw new \Exception('Invalid module, it must be set before mapping entity', 1);
            }
            $entityName = $this->module;
            $entity = [$entity];
        }

        $xml = '<' . $entityName . '>';
        $xml .= is_array($entity) ? $this->mapEntityList($entity) : $this->mapSingleEntity($entity);
        $xml .= '</' . $entityName . '>';
        return $xml;
    }

    /**
     * Convert single entity into XML
     *
     * @param Element $entity Element
     * @return string XML created
     */
    protected function mapSingleEntity(Element $entity)
    {
        $element = new \ReflectionObject($entity);
        $properties = $element->getProperties();
        $xml = '';
        foreach ($properties as $property) {
            $propName = $property->getName();
            $propValue = $entity->$propName;
            if ($propValue !== null) {
                $xml .= '<FL val="' . str_replace(['_', 'N36', 'E5F', '&', '98T'], [' ', '$', '_', 'and', '?'], $propName) . '">';
                // It's a list of entities
                if (is_array($propValue)) {
                    $tag = null;
                    list($key, $list) = each($propValue);
                    if (!is_numeric($key)) {
                        $tag = $key;
                        $propValue = $list;
                    }
                    $xml .= $this->mapEntityList($propValue, $tag);
                }
                // It's an entity
                elseif (is_object($propValue)) {
                    $xml .= $this->mapSingleEntity($propValue);
                }
                else {
                    $xml .= '<![CDATA[' . $propValue . ']]>';
                }
                $xml .= '</FL>';
            }
        }
        return $xml;
    }

    /**
     * Convert list of entities into XML
     *
     * @param array  $list           List of Elements
     * @param string $rowElementName Element name
     * @return string XML $list
     */
    protected function mapEntityList(array $list, $rowElementName = null)
    {
        if (is_null($rowElementName)) {
            $rowElementName = 'row';
        }
        $xml = '';
        $no = 1;
        foreach ($list as $element) {
            $xml .= '<' . $rowElementName . ' no="' . $no++ . '">';
            $xml .= $this->mapSingleEntity($element);
            $xml .= "</$rowElementName>";
        }

        return $xml;
    }

    /**
     * Make the call using the client
     *
     * @param string $command Command to call
     * @param string $params Options
     * @param array $data Data to send [optional]
     * @param array $options Options to add for configurations [optional]
     *
     * @return Response
     */
    protected function call($command, $params, $data = [], $options = [])
    {
        $uri = $this->getRequestURI($command);
        $body = $this->getRequestBody($params, $data, $options);
        $xml = $this->client->post($uri, $body); // Make the request to web service
        return $this->factory->createResponse($xml, $this->module, $command);
    }

    /**
     * Get the current request uri
     *
     * @param string $command Command for get uri
     *
     * @return string
     */
    protected function getRequestURI($command)
    {
        if (empty($this->module)) {
            throw new \RuntimeException('Zoho CRM module is not set.');
        }
        $parts = [$this->baseUri, $this->format, $this->module, $command];

        return implode('/', $parts);
    }

    /**
     * Get the body of the request
     *
     * @param array $params Params
     * @param object $data Data
     * @param mixed $options
     *
     * @return string
     */
    protected function getRequestBody($params, $data, $options)
    {
        $params['scope'] = 'crmapi';
        $params['authtoken'] = $this->authtoken;
        $params += ['newFormat' => 1]; //'version' => 2,
        if (!empty($data)) {
            $params['xmlData'] = (isset($options['map']) && $options['map']) ? $this->toXML($data) : $data;
        }

        if (!isset($params['content'])) {
            return http_build_query($params, '', '&');
        }

        return $params;
    }
}
