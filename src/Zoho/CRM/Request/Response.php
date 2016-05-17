<?php

namespace Zoho\CRM\Request;

use Zoho\CRM\Exception\ZohoCRMException;

/**
 * Zoho CRM API Response.
 *
 * Parses the ZohoCRM response into an object and
 * normalizes different response formats.
 *
 * @package Zoho\CRM\Request
 * @version 1.0.0
 */
class Response
{
    /**
     * Code error
     *
     * @var string
     */
    protected $code;

    /**
     * Message of the error
     *
     * @var string
     */
    protected $message;

    /**
     * Method used
     *
     * @var string
     */
    protected $method;

    /**
     * Module used
     *
     * @var string
     */
    protected $module;

    /**
     * Records details affecteds
     *
     * @var array
     */
    protected $records = array();

    /**
     * Specific redord affected
     *
     * @var string
     */
    protected $recordId;

    /**
     * URL used for the request
     *
     * @var string
     */
    protected $uri;

    /**
     * XML on request
     * @var string
     */
    protected $xmlstr;

    public function __construct($xmlstr, $module, $method)
    {
        $this->xmlstr = $xmlstr;
        $this->module = $module;
        $this->method = $method;
        $this->parseResponse();
    }

    /**
     * Setters & Getters
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
        return array(
            'module' => $this->module,
            'method' => $this->method,
            'message' => $this->message,
            'code' => $this->code,
            'uri' => $this->uri,
            'recordId' => $this->recordId,
            'records' => $this->records,
            'xmlstr' => $this->xmlstr,
        );
    }

    protected function parseResponse()
    {
        $xml = simplexml_load_string($this->xmlstr, 'SimpleXMLElement', LIBXML_NOERROR | LIBXML_NOWARNING);
        if ($xml === false) {
            throw new ZohoCRMException("Zoho CRM response could not be parsed as XML.", 0000);
        }

        if (isset($xml->error)) {
            $message = (string) $xml->error->message;
            $code = (string) $xml->error->code;
            throw new ZohoCRMException((string) $xml['uri'] . ' ' . $message, $code);
        }

        $this->uri = (string) $xml['uri'];

        // No records returned
        if (isset($xml->nodata)) {
            $this->message = (string) $xml->nodata->message;
            $this->code = (string) $xml->nodata->code;
        }

        // getFields
        elseif ($this->method == 'getFields') {
            $this->parseResponseGetFields($xml);
        }

        // getUsers
        elseif ($this->method == 'getUsers') {
            $this->parseResponseGetUsers($xml);
        }

        // getRecords, getRelatedRecords, getSearchRecords, getRecordById, getCVRecords
        elseif (isset($xml->result->{$this->module})) {
            $this->parseResponseGetRecords($xml);
        }

        // insertRecords, updateRecords (version = 1 or 2)
        elseif (isset($xml->result->message) && isset($xml->result->recorddetail)) {
            $this->parseResponsePostRecords($xml);
        }

        // insertRecords, updateRecords (version = 4)
        elseif (isset($xml->result->row->success) || isset($xml->result->row->error)) {
            $this->parseResponsePostRecordsMultiple($xml);
        }

        // convertLead
        elseif ((string) $xml->getName() == 'success') {
            $records = array();
            foreach ($xml->children() as $child) {
                $records[(string) $child->getName()] = (string) $child;
            }
            $this->records = $records;
        }

        // deleteRecords
        elseif (isset($xml->result->message) && isset($xml->result->code)) {
            $this->message = (string) $xml->result->message;
            $this->code = (string) $xml->result->code;
            preg_match('/[0-9]{18}/', $this->message, $matches);
            $this->recordId = $matches[0];
        } else {
            throw new ZohoCRMException("Unknown Zoho CRM response format.");
        }
    }

    protected function parseResponseGetFields($xml)
    {
        $records = array();
        foreach ($xml->section as $section) {
            foreach ($section->children() as $field) {
                $label = (string) $field['label'];
                $records[(string) $section['name']][$label] = array(
                    'req' => (string) $field['req'] === 'true' ? true : false,
                    'type' => (string) $field['type'],
                    'isreadonly' => (string) $field['isreadonly'] === 'true' ? true : false,
                    'maxlength' => (int) $field['maxlength'],
                    'label' => $label,
                    'dv' => (string) $field['dv'],
                    'customfield' => (string) $field['customfield'] === 'true' ? true : false,
                );
                if ($field->children()->count() > 0) {
                    $records[(string) $section['name']][$label]['values'] = array();
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
        $records = array();
        foreach ($xml as $user) {
            foreach ($user->attributes() as $key => $value) {
                $records[(string) $user['id']][$key] = (string) $value;
            }
            $records[(string) $user['id']]['name'] = (string) $user;
        }
        $this->records = $records;
    }

    protected function parseResponseGetRecords($xml)
    {
        $records = array();
        foreach ($xml->result->children()->children() as $row) {
            $no = (string) $row['no'];
            foreach ($row->children() as $field) {
                if ($field->count() > 0) {
                    foreach ($field->children() as $item) {
                        foreach ($item->children() as $subitem) {
                            $records[$no][(string) $field['val']][(string) $item['no']][(string) $subitem['val']] = (string) $subitem;
                        }
                    }
                } else {
                    $records[$no][(string) $field['val']] = (string) $field;
                }
            }
        }
        $this->records = $records;

        if ($this->method == 'getRecordById') {
            $id = strtoupper(substr($this->module, 0, -1)) . 'ID';
            $this->recordId = $this->records[1][$id];
        }
    }

    protected function parseResponsePostRecords($xml)
    {
        $record = array();
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
        $records = array();
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

    public function ifSuccess()
    {
        if (strpos($this->message, 'success') !== false) {
            return true;
        }

        return false;
    }
}
