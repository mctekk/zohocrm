<?php
/**
 * Created by PhpStorm.
 * User: wl-it
 * Date: 25.02.16
 * Time: 12:47
 */

namespace Zoho\CRM\Common;

use Yii;
use Zoho\CRM\Entities\Account;
use Zoho\CRM\Exception\UnknownEntityException;
use Zoho\CRM\Exception\ZohoCRMException;
use Zoho\CRM\Request\Response;
use Zoho\CRM\ZohoClient;
use Zoho\CRM\Wrapper\Element;

abstract class ZohoRecord extends Element
{
    // TODO: Add Entities classes for the next entities
    const MODULE_CAMPAIGNS = 'Campaigns';
    const MODULE_CASES = 'Cases';
    const MODULE_SOLUTIONS = 'Solutions';
    const MODULE_PRODUCTS = 'Products';
    const MODULE_PRICE_BOOKS = 'PriceBooks';
    const MODULE_INVOICES = 'Invoices';
    const MODULE_SALES_ORDERS = 'SalesOrders';
    const MODULE_PURCHASE_ORDERS = 'PurchaseOrders';
    const MODULE_EVENTS = 'Events';
    const MODULE_TASKS = 'Tasks';
    const MODULE_CALLS = 'Calls';

    private $zohoClient;

    /**
     * @var array Zoho API call additional params
     */
    protected $zohoParams = [];
    /**
     * @var array properties to exclude from Zoho API call XML data
     */
    protected $excludes = ['excludes', 'zohoParams'];

    protected $errors = [];

    protected $id = null;

    protected $customFields = [];

    /**
     * ZohoRecord constructor.
     */
    public function __construct($params = [])
    {
        if (!isset($params['zohoClient']) && !isset($params['zohoApiKey'])) {
            throw new \Exception('ZohoClient or ZohoAPIKey are required.');
        }

        if (isset($params['zohoClient']) && !($params['zohoClient'] instanceof ZohoClient)) {
            throw new \Exception('ZohoClient should be an instance of Zoho\CRM\ZohoClient.');
        }

        $this->zohoClient = (isset($params['zohoClient'])) ? $params['zohoClient'] : new ZohoClient($params['zohoApiKey']);
        if (isset($params['zohoClient'])) {
            unset($params['zohoClient']);
        }
        if (isset($params['zohoApiKey'])) {
            unset($params['zohoApiKey']);
        }
        $this->load($params);
    }

    protected function load($properties)
    {
        foreach ($properties as $key => $property) {
            if (property_exists($this, $key)) {
                $this->$key = $property;
            }
        }
    }

    abstract protected function getEntityName();

    public function save()
    {
        $this->errors = [];
        $this->zohoClient->setModule($this->getEntityName());
        $validXML = $this->zohoClient->mapEntity($this, $this->excludes);
        try {
            $result = $this->internalSave($validXML);
        } catch (ZohoCRMException $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
        if ($result->getCode() === null) {
            // Hack for duplicated record. TODO: Find out how to handle it more appropriate
            if ($result->getMessage() == 'Record(s) already exists') {
                $this->errors[] = $result->getMessage();
                return false;
            }
            // No error occurred but some issues may still happen. TODO: Add all possible error handlings
            $this->id = $result->getRecordId();
            return true;
        }
        // Request failed
        $this->errors[] = $result->getMessage();
        return false;
    }

    protected function internalSave($validXML)
    {
        if ($this->id === null) {
            return $this->zohoClient->insertRecords($validXML, $this->zohoParams);
        } else {
            return $this->zohoClient->updateRecords($this->id, $validXML, $this->zohoParams);
        }
    }

    /**
     * Errors list
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Getter
     *
     * @return mixed
     */
    public function __get($property)
    {
        return isset($this->$property) ? $this->$property :null;
    }

    /**
     * Setter
     *
     * @param string $property Name of the property to set the value
     * @param mixed $value Value for the property
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            $this->customFields[$property] = $value;
        }
    }

    public static function createEntity($entity, $params = [])
    {
        $fullClassName = static::getFullEntityClass($entity, true);
        return new $fullClassName($params);
    }

    public static function getEntity($entity, $params = [])
    {

        $entityItem = static::createEntity($entity, $params);
        $entityItem->errors = [];
        if (!$entityItem->loadEntity()) {
            // TODO: consider what to do. Throw an exception with errors probably
        }
        return $entityItem;
    }

    public static function getFullEntityClass($entity, $throwException = false)
    {
        $fullClassName = '\Zoho\CRM\Entities\\' . $entity;
        if (!class_exists($fullClassName)) {
            if ($throwException) {
                throw new UnknownEntityException('No such entity found');
            } else {
                return null;
            }
        }
        return $fullClassName;
    }

    protected function loadEntity()
    {
        if (empty($this->id)) {
            throw new \Exception('An ID must be provided to load data from Zoho');
        }
        // TODO: Consider adding params
        $this->zohoClient->setModule($this->getEntityName());
        try {
            $response = $this->zohoClient->getRecordById($this->id);
        } catch (ZohoCRMException $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }

        if ($response->getCode() !== null) {
            // Request failed
            $this->errors[] = $response->getMessage();
            return false;
        }
        // No error occurred but some issues may still happen. TODO: Add all possible error handlings
        $mappedRecords = $this->mapEntityNames($response);
        $properties = $mappedRecords[1];
        $this->load($properties);
        return true;
    }

    protected function generatePropertyName($XmlName)
    {
        // TODO: Check why $, _, etc. are needed in the replace list. @see ZohoClient->generateXmlElementName
//        return  str_replace([' ', '$', '_', 'and', '?'], ['_', 'N36', 'E5F', '&', '98T'], $XmlName);
        return  str_replace(' ', '_', $XmlName);
    }

    /**
     * Convert entity property names from XML to PHP format
     *
     * @param Response $response
     * @return array mapped records
     * @throws \Exception
     */
    protected function mapEntityNames(Response $response)
    {
        $records = [];
        foreach ($response->getRecords() as $index => $record) {
            $records[$index] = [];
            foreach ($record as $entityXmlProperty => $value) {
                $propName = $this->generatePropertyName($entityXmlProperty);
                $records[$index][$propName] = $value;
            }
        }

        return $records;
    }
}