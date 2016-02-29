<?php
/**
 * Created by PhpStorm.
 * User: wl-it
 * Date: 25.02.16
 * Time: 12:47
 */

namespace Zoho\CRM\Common;

use Yii;
use yii\base\Exception;
use Zoho\CRM\Entities\Account;
use Zoho\CRM\Exception\UnknownEntityException;
use Zoho\CRM\Exception\ZohoCRMException;
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

    protected $errors = [];

    /**
     * ZohoRecord constructor.
     */
    public function __construct($zohoClient = null, $zohoApiKey = null)
    {
        if (!$zohoClient && !$zohoApiKey) {
            throw new Exception('ZohoClient or ZohoAPIKey are required.');
        }
        $this->zohoClient = ($zohoClient && $zohoClient instanceof ZohoClient) ? $zohoClient : new ZohoClient($zohoApiKey);
    }

    public function save()
    {
        $this->zohoClient->setModule(get_called_class() . 's');
        $validXML = $this->zohoClient->mapEntity($this);
        try {
            $result = $this->zohoClient->insertRecords($validXML);
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
            return true;
        }
        // Request failed
        $this->errors[] = $result->getMessage();
        return false;
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
        }
    }

    public static function createEntity($entity, $params = null)
    {
        $fullClassName = '\Zoho\CRM\Entities\\' . $entity;
        if (!class_exists($fullClassName)) {
            throw new UnknownEntityException('No such entity found');
        }
        return new $fullClassName($params);
    }

}