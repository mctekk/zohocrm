<?php

namespace Zoho\CRM;

use Zoho\CRM\Common\FactoryInterface;
use Zoho\CRM\Common\HttpClientInterface;
use Zoho\CRM\Request\Factory;
use Zoho\CRM\Request\HttpClient;
use Zoho\CRM\Wrapper\Element;

/**
 * Client for provide interface with Zoho CRM
 *
 * @package Zoho\CRM
 */
class ZohoClient
{
    /**
     * URL for call request
     *
     * @var string
     */
    const BASE_URI = 'https://crm.zoho.com/crm/private';

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
        return $this;
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
     * @return Response The Response object
     */
    public function convertLead($leadId, $data, $params = array(), $options = array())
    {
        $params['leadId'] = $leadId;
        return $this->call('convertLead', $params, $data);
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
     * @return Response The Response object
     */
    public function getCVRecords($name, $params = array(), $options = array())
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
        return $this->call('getFields', array());
    }

    /**
     * Implements deleteRecords API method.
     *
     * @param string $id      Id of the record
     *
     * @return Response The Response object
     */
    public function deleteRecords($id)
    {
        $params['id'] = $id;
        return $this->call('deleteRecords', $params);
    }

    /**
     * Implements getRecordById API method.
     *
     * @param string $id      Id of the record
     * @param array $params   request parameters
     *                        newFormat 1 (default) - exclude fields with null values in the response
     *                                  2 - include fields with null values in the response
     *                        version   1 (default) - use earlier API implementation
     *                                  2 - use latest API implementation
     * @param array $options Options to add for configurations [optional]
     * @return Response The Response object
     */
    public function getRecordById($id, $params = array(), $options = array())
    {
        $params['id'] = $id;
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
     * @return Response The Response object
     */
    public function getRecords($params = array(), $options = array())
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
     * @return Response The Response object
     */
    public function getRelatedRecords($params = array(), $options = array())
    {
        return $this->call('getRelatedRecords', $params);
    }

    /**
     * Implements getSearchRecords API method.
     *
     * @param string $searchCondition search condition in the format (fieldName|condition|searchString)
     *                                e.g. (Email|contains|*@sample.com*)
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
     *
     * @return Response The Response object
     */
    public function getSearchRecords($searchCondition, $params = array(), $options = array())
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
     *
     * @return Response The Response object
     */
    public function searchRecords($criteria, $params = array(), $options = array())
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
     * @param integer $newFormat  1 (default) - exclude fields with null values in the response
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
     *
     * @param array $options Options to add for configurations [optional]
     * @return Response The Response object
     * @todo
    - Make default value for duplicateCheck configurable
     */
    public function insertRecords($data, $params = array(), $options = array())
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
     *
     * @param array $options Options to add for configurations [optional]
     * @return Response The Response object
     */
    public function updateRecords($id, $data, $params = array(), $options = array())
    {
        if (is_array($data) && count($data['records']) > 1) {
            // Version 4 is mandatory for updating multiple records.
            $params['version'] = 4;
        } else {
            if (empty($id)) {
                throw new \InvalidArgumentException('Record Id is required and cannot be empty.');
            }

            $params['id'] = $id;
        }return $this->call('updateRecords', $params, $data);
    }

    /**
     * Implements uploadFile API method.
     *
     * @param string             $id            unique ID of the record to be updated
     *
     * @param file path             $content     Pass the File Input Stream of the file
     *
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
    public function uploadFile($id, $content, $params = array())
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Record Id is required and cannot be empty.');
        }
        $params['id'] = $id;
        $params['content'] = $content;
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
     * Make the call using the client
     *
     * @param string $command Command to call
     * @param string $params Options
     * @param array $data Data to send [optional]
     * @param array $options Options to add for configurations [optional]
     * @return Response
     */
    protected function call($command, $params, $data = array(), $options = array())
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
     * @return string
     */
    protected function getRequestURI($command)
    {
        if (empty($this->module)) {
            throw new \RuntimeException('Zoho CRM module is not set.');
        }$parts = array(self::BASE_URI, $this->format, $this->module, $command);
        return implode('/', $parts);
    }

    /**
     * Get the body of the request
     *
     * @param array $params Params
     * @param Object $data Data
     * @return string
     */
    protected function getRequestBody($params, $data, $options)
    {
        $params['scope'] = 'crmapi';
        $params['authtoken'] = $this->authtoken;
        $params += array('newFormat' => 1); //'version' => 2,
        if (!empty($data)) {
            $params['xmlData'] = (isset($options['map']) && $options['map']) ? $this->toXML($data) : $data;
        }

        if (!isset($params['content'])) {
            return http_build_query($params, '', '&');
        }

        return $params;
    }

    /**
     * Convert from array to XML
     *
     * @param array $data Data to convert
     * @return XML
     */
    public function toXML($data)
    {
        $root = isset($data['root']) ? $data['root'] : $this->module;
        $no = 1;
        $xml = '<' . $root . '>';
        if (isset($data['options'])) {
            $xml .= '<row no="' . $no . '">';
            foreach ($data['options'] as $key => $value) {
                $xml .= '<option val="' . $key . '">' . $value . '</option>';
            }
            $xml .= '</row>';
            $no++;
        }
        foreach ($data['records'] as $row) {
            $xml .= '<row no="' . $no . '">';
            foreach ($row as $key => $value) {
                if (is_array($value)) {
                    $xml .= '<FL val="' . str_replace('&', 'and', $key) . '">';
                    foreach ($value as $k => $v) {
                        list($tag, $attribute) = explode(' ', $k);
                        $xml .= '<' . $tag . ' no="' . $attribute . '">';
                        foreach ($v as $kk => $vv) {
                            $xml .= '<FL val="' . str_replace('&', 'and', $kk) . '"><![CDATA[' . $vv . ']]></FL>';
                        }
                        $xml .= '</' . $tag . '>';
                    }
                    $xml .= '</FL>';
                } else {
                    $xml .= '<FL val="' . str_replace('&', 'and', $key) . '"><![CDATA[' . $value . ']]></FL>';
                }
            }
            $xml .= '</row>';
            $no++;
        }
        $xml .= '</' . $root . '>';
        return $xml;
    }

    /**
     * Convert an entity into XML
     *
     * @param Element $entity Element with values on fields setted
     * @return string XML created
     * @todo
    - Add iteration for multiples entities and creation of xml with collection
     */
    public function mapEntity(Element $entity)
    {
        if (empty($this->module)) {
            throw new \Exception("Invalid module, it must be setted before map the entity", 1);
        }

        $element = new \ReflectionObject($entity);
        $properties = $element->getProperties();
        $no = 1;
        $xml = '<' . $this->module . '>';
        $xml .= '<row no="' . $no . '">';
        foreach ($properties as $property) {
            $propName = $property->getName();
            $propValue = $entity->$propName;
            if (!empty($propValue)) {
                $xml .= '<FL val="' . str_replace(['_', 'N36', 'E5F', '&', '98T'], [' ', '$', '_', 'and', '?'], $propName) . '"><![CDATA[' . $propValue . ']]></FL>';
            }

        }$xml .= '</row>';
        $xml .= '</' . $this->module . '>';
        return $xml;
    }
}
