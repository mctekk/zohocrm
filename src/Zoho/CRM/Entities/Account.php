<?php

namespace Zoho\CRM\Entities;

use Zoho\CRM\Wrapper\Element;

/**
 * Entity for accounts inside Zoho
 * This class only have default parameters
 *
 * @package Zoho\CRM\Entities
 * @version 1.0.0
 */
class Account extends Element
{
    /**
     * Specify the company name. This field is mandatory.
     *
     * @var string
     */
    protected $Account_Name;

    /**
     * Name of the user to whom the account is assigned.
     *
     * @var string
     */
    protected $Account_Owner;

    /**
     * The URL of the company's Web site.
     *
     * @var string
     */
    protected $Website;

    /**
     * The ticker symbol of the Company.
     *
     * @var string
     */
    protected $Ticker_Symbol;

    /**
     * The parent company name.
     *
     * @var string
     */
    protected $Parent_Account;

    /**
     * The number of employees in account's company.
     *
     * @var int
     */
    protected $Employees;

    /**
     * The type of ownership of the company.
     *
     * @var string
     */
    protected $Ownership;

    /**
     * The type of industry of the company.
     *
     * @var string
     */
    protected $Industry;

    /**
     * The type of account of the company.
     *
     * @var string
     */
    protected $Account_Type;

    /**
     * The reference number for the account. Up to 40 characters are allowed in this field.
     *
     * @var int
     */
    protected $Account_Number;

    /**
     * The name of the account’s location, for example, Headquarters or London. Up to 80 characters are allowed in this field.
     *
     * @var string
     */
    protected $Account_Site;

    /**
     * The phone number of the account.
     *
     * @var string
     */
    protected $Phone;

    /**
     * The fax number of the account.
     *
     * @var string
     */
    protected $Fax;

    /**
     * The official E-mail address of the account.
     *
     * @var string
     */
    protected $Email;

    /**
     * The rating of the account.
     *
     * @var string
     */
    protected $Rating;

    /**
     * The Standard Industrial Classification code of the account.
     *
     * @var int
     */
    protected $SIC_Code;

    /**
     * The annual revenue of the account.
     *
     * @var int
     */
    protected $Annual_Revenue;

    /**
     * The billing address of the account to send the quotes, invoices, and other agreements.
     *
     * Divided into 5 parts:
     *     @var string
     *     @var string
     *     @var string
     *     @var string
     *     @var string
     */
    protected $Billing_Street;
    protected $Billing_City;
    protected $Billing_State;
    protected $Billing_Code;
    protected $Billing_Country;

    /**
     * The shipping address of the account to deliver the shipment.
     *
     * Divided into 5 parts:
     *     @var string
     *     @var string
     *     @var string
     *     @var string
     *     @var string
     */
    protected $Shipping_Street;
    protected $Shipping_City;
    protected $Shipping_State;
    protected $Shipping_Code;
    protected $Shipping_Country;

    /**
     * Specify any other details about the account.
     *
     * @var string
     */
    protected $Description;

}
