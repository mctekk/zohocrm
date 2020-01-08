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

    /**
     * Response Status.
     *
     * @var string
     */
    protected $status;

    public function __construct($responseData, $module, $method)
    {
        $this->responseData = $responseData;
        $this->module = $module;
        $this->method = $method;
        $this->parseResponse();
    }

    /**
     * Is successfull.
     *
     * @deprecated 1.0
     * @return void
     */
    public function ifSuccess()
    {
        return $this->isSuccess();
    }

    /**
     * Is successfull.
     *
     * @return bool
     */
    public function isSuccess()
    {
        if (mb_strpos($this->status, 'success') !== false) {
            return true;
        }

        return false;
    }

    /**
     * Parse response.
     *
     * @return void
     * @todo Need to convert json data from Zoho API v2 to the same array given in our Zoho CRM SDK
     */
    protected function parseResponse()
    {
        if ($this->method == 'get' && ($this->module == 'Contacts' || $this->module == 'Accounts' || $this->module == 'Potentials')) {
            $this->parseResponseGetRecords();
        } elseif ($this->method == 'get' && $this->module == 'Users') {
            $this->parseResponseGetUsers();
        } else {
            $this->parseResponsePostRecords();
        }
    }

    /**
     * Parse response for function using module Users and GET method.
     *
     * @return void
     */
    protected function parseResponseGetUsers()
    {
        $data = $this->responseData['users'];
        $records = [];
        foreach ($data as $dataElement) {
            foreach ($dataElement as $key => $value) {
                if (gettype($value) == 'array' && array_key_exists('id', $value)) {
                    $value = $value['name'];
                }
                if (gettype($value) == 'array' && empty($value)) {
                    $value = null;
                }

                $record[$key] = $value;
            }
            $records[$record['id']] = $record;
        }

        $this->records = $records;
    }

    /**
     * Parse response for functions using GET method.
     *
     * @param [type] $xml
     * @return void
     */
    protected function parseResponseGetRecords()
    {
        if (is_array($this->responseData)) {
            $data = $this->responseData['data'];
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
        } else {
            $this->records = null;
        }
    }

    /**
     * Parse response for functions using POST or PUT method.
     * @return void
     */
    protected function parseResponsePostRecords()
    {
        $data = current($this->responseData['data']);
        $this->status = $data['status'];
        $this->recordId = array_key_exists('id', $data['details']) ? $data['details']['id'] : null;
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

    public function getResponseData()
    {
        return $this->responseData;
    }

    public function getRelatedRecords()
    {
        return $this->records;
    }

    public function getRecordId()
    {
        return $this->recordId;
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
            'records' => $this->records
        ];
    }
}
