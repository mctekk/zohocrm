<?php namespace Zoho\CRM\Entities;

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
	private $Account_Name;

	/**
	 * Name of the user to whom the account is assigned.
	 * 
	 * @var string
	 */
	private $Account_Owner;
    
    /**
	 * The URL of the company's Web site.
	 * 
	 * @var string
	 */
	private $Website;
    
    /**
	 * The ticker symbol of the Company.
	 * 
	 * @var string
	 */
	private $Ticker_Symbol;
    
    /**
	 * The parent company name.
	 * 
	 * @var string
	 */
	private $Parent_Account;
    
    /**
	 * The number of employees in account's company.
	 * 
	 * @var int
	 */
	private $Employees;
    
    /**
	 * The type of ownership of the company.
	 * 
	 * @var string
	 */
	private $Ownership;
    
    /**
	 * The type of industry of the company.
	 * 
	 * @var string
	 */
	private $Industry;
    
    /**
	 * The type of account of the company.
	 * 
	 * @var string
	 */
	private $Account_Type;
    
    /**
	 * The reference number for the account. Up to 40 characters are allowed in this field.
	 * 
	 * @var int
	 */
	private $Account_Number;
    
    /**
	 * The name of the account’s location, for example, Headquarters or London. Up to 80 characters are allowed in this field.
	 * 
	 * @var string
	 */
	private $Account_Site;
    
    /**
	 * The phone number of the account.
	 * 
	 * @var string
	 */
	private $Phone;
    
    /**
	 * The fax number of the account.
	 * 
	 * @var string
	 */
	private $Fax;
    
    /**
	 * The official E-mail address of the account.
	 * 
	 * @var string
	 */
	private $Email;
    
    /**
	 * The rating of the account.
	 * 
	 * @var string
	 */
	private $Rating;
    
    /**
	 * The Standard Industrial Classification code of the account.
	 * 
	 * @var int
	 */
	private $SIC_Code;
    
    /**
	 * The annual revenue of the account.
	 * 
	 * @var int
	 */
	private $Annual_Revenue;
    
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
	private $Billing_Street;
	private $Billing_City;
	private $Billing_State;
	private $Billing_Code;
	private $Billing_Country;
    
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
	private $Shipping_Street;
	private $Shipping_City;
	private $Shipping_State;
	private $Shipping_Code;
	private $Shipping_Country;
    
    /**
	 * Specify any other details about the account.
	 * 
	 * @var string
	 */
	private $Description;

	/**
	 * Getter
	 * 
	 * @return mixed
	 */
	public function __get($property)
	{
		return isset($this->$property)?$this->$property :null;
	}

	/**
	 * Setter
	 *
	 * @param string $property Name of the property to set the value
	 * @param mixed $value Value for the property
	 * @return mixed
	 */
	public function __set($property, $value)
	{
		$this->$property = $value;
		return $this->$property;
	}	
}