<?php
/**
 * Created by PhpStorm.
 * User: wl-it
 * Date: 25.02.16
 * Time: 12:47
 */

namespace Zoho\CRM\Common;

use Yii;
use Zoho\CRM\ZohoClient;
use Zoho\CRM\Wrapper\Element;

abstract class ZohoRecord extends Element
{
    const MODULE_LEADS = 'Leads';
    const MODULE_ACCOUNTS = 'Accounts';
    const MODULE_CONTACTS = 'Contacts';
    const MODULE_POTENTIALS = 'Potentials';
    const MODULE_CAMPAIGNS = 'Campaigns';
    const MODULE_CASES = 'Cases';
    const MODULE_SOLUTIONS = 'Solutions';
    const MODULE_PRODUCTS = 'Products';
    const MODULE_PRICE_BOOKS = 'PriceBooks';
    const MODULE_QUOTES = 'Quotes';
    const MODULE_INVOICES = 'Invoices';
    const MODULE_SALES_ORDERS = 'SalesOrders';
    const MODULE_VENDORS = 'Vendors';
    const MODULE_PURCHASE_ORDERS = 'PurchaseOrders';
    const MODULE_EVENTS = 'Events';
    const MODULE_TASKS = 'Tasks';
    const MODULE_CALLS = 'Calls';

    private $zohoClient;


    /**
     * ZohoRecord constructor.
     */
    public function __construct($module)
    {
        $this->zohoClient = new ZohoClient();
        $this->zohoClient->setModule($module);
    }

    public function save()
    {
        $validXML = $this->zohoClient->mapEntity($this);
        return $this->zohoClient->insertRecords($validXML);
    }

}