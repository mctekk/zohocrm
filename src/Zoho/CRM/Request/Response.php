<?php

/*
 * This file is part of mctekk/zohocrm library.
 *
 * (c) MCTekK S.R.L. https://mctekk.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zoho\CRM\Request;

use Zoho\CRM\Exception\ZohoCRMException;

/**
 * Zoho CRM API Response.
 *
 * Parses the ZohoCRM response into an object and
 * normalizes different response formats.
 *
 * @version 1.0.0
 */
class Response
{
    /**
     * Code error.
     *
     * @var string
     */
    protected $code;

    /**
     * Message of the error.
     *
     * @var string
     */
    protected $message;

    /**
     * Method used.
     *
     * @var string
     */
    protected $method;

    /**
     * Module used.
     *
     * @var string
     */
    protected $module;

    /**
     * Records details affecteds.
     *
     * @var array
     */
    protected $records = [];

    /**
     * Specific redord affected.
     *
     * @var string
     */
    protected $recordId;

    /**
     * URL used for the request.
     *
     * @var string
     */
    protected $uri;

    /**
     * Response Data from request.
     *
     * @var string
     */
    protected $responseData;

    public function __construct($responseData, $module, $method)
    {
        $this->responseData = $responseData['data'];
        $this->module = $module;
        $this->method = $method;
        $this->parseResponse();
    }

    /**
     * Setters & Getters.
     */
    public function getModule()
    {
        return $this->module;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getRequestURI()
    {
        return $this->uri;
    }

    public function getRecords()
    {
        return $this->records;
    }

    public function getRelatedRecords()
    {
        return $this->records;
    }

    public function getRecordId()
    {
        return $this->recordId;
    }

    public function getXML()
    {
        return $this->xmlstr;
    }

    public function getResponse()
    {
        return [
            'module' => $this->module,
            'method' => $this->method,
            'message' => $this->message,
            'code' => $this->code,
            'uri' => $this->uri,
            'recordId' => $this->recordId,
            'records' => $this->records,
            'xmlstr' => $this->xmlstr,
        ];
    }

    public function ifSuccess()
    {
        if (mb_strpos($this->message, 'success') !== false) {
            return true;
        }

        return false;
    }

    /**
     * Parse response
     *
     * @return void
     * @todo Need to convert json data from Zoho API v2 to the same array given in our Zoho CRM SDK
     */
    protected function parseResponse()
    {
        /**
         * For getRecords, getRelatedRecords, getSearchRecords, getRecordById, getCVRecords functions
         */
        if($this->method == 'get') {
            $this->parseResponseGetRecords();
        }

        /**
         * For insertRecords, updateRecords functions
         */
        if ($this->method == 'post' || $this->method == 'put') {
            $this->parseResponsePostRecords($xml);
        }

    }

    /**
     * Parse GET method responses
     *
     * @param [type] $xml
     * @return void
     */
    protected function parseResponseGetRecords()
    {
        $data = $this->responseData;
        $records = [];
        foreach ($data as $dataElement) {
            foreach ($dataElement as $key => $value) {

                $key = strpos($key, '_') ? str_replace('_', ' ', $key) : $key;

                if (gettype($value) == 'array' && array_key_exists('id', $value)) {

                    if ($key == 'Owner') {
                        $key = 'Lead ' . $key;
                        $record['SMOWNERID'] = $value['id'];
                        $value = $value['name'];
                        
                    } elseif ($key == 'Created By') {
                        $record['SMCREATORID'] = $value['id'];
                        $value = $value['name'];

                    } else {
                        $record[strtoupper(str_replace(' ', '', $key))] = $value['id'];
                        $value = $value['name'];
                    }
                }

                if (gettype($value) == 'array' && empty($value)) {
                    $value = '';
                }

                if ($key == 'id') {
                    $key = 'LEADID';
                }

                $record[$key] = $value;
            }
            $records[] = $record; 
        }

        $this->records = $records;

        // if ($this->method == 'getRecordById') {
        //     $id = mb_strtoupper(mb_substr($this->module, 0, -1)) . 'ID';
        //     $this->recordId = $this->records[1][$id];
        // }
    }

    protected function parseResponseGetFields($xml)
    {
        $records = [];
        foreach ($xml->section as $section) {
            foreach ($section->children() as $field) {
                $label = (string) $field['label'];
                $records[(string) $section['name']][$label] = [
                    'req' => (string) $field['req'] === 'true' ? true : false,
                    'type' => (string) $field['type'],
                    'isreadonly' => (string) $field['isreadonly'] === 'true' ? true : false,
                    'maxlength' => (int) $field['maxlength'],
                    'label' => $label,
                    'dv' => (string) $field['dv'],
                    'customfield' => (string) $field['customfield'] === 'true' ? true : false,
                ];
                if ($field->children()->count() > 0) {
                    $records[(string) $section['name']][$label]['values'] = [];
                    foreach ($field->children() as $value) {
                        $records[(string) $section['name']][$label]['values'][] = (string) $value;
                    }
                }
            }
        }
        $this->records = $records;
    }

    protected function parseResponseGetUsers($xml)
    {
        $records = [];
        foreach ($xml as $user) {
            foreach ($user->attributes() as $key => $value) {
                $records[(string) $user['id']][$key] = (string) $value;
            }
            $records[(string) $user['id']]['name'] = (string) $user;
        }
        $this->records = $records;
    }

    protected function parseResponsePostRecords($xml)
    {
        $record = [];
        foreach ($xml->result->recorddetail as $detail) {
            foreach ($detail->children() as $field) {
                $record[(string) $field['val']] = (string) $field;
            }
            $this->records[] = $record;
        }

        $this->message = (string) $xml->result->message;
        if (count($this->records) == 1) {
            $this->recordId = isset($record['Id']) ? $record['Id'] : null;
        }
    }

    protected function parseResponsePostRecordsMultiple($xml)
    {
        $records = [];
        foreach ($xml->result->row as $row) {
            $no = (string) $row['no'];
            if (isset($row->success)) {
                $records[$no]['code'] = (string) $row->success->code;
                foreach ($row->success->details->children() as $field) {
                    $records[$no][(string) $field['val']] = (string) $field;
                }
            } else {
                $records[$no]['code'] = (string) $row->error->code;
                $records[$no]['message'] = (string) $row->error->details;
            }
        }
        ksort($records);
        $this->records = $records;
    }
}
