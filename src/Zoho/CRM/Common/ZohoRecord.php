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
     * @var string
     */
    abstract public function getModuleName();

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
        $this->zohoClient->setModule($this->getModuleName());
        $validXML = $this->zohoClient->mapEntity($this);
        return $this->zohoClient->insertRecords($validXML);
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

}