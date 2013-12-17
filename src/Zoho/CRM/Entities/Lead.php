<?php namespace Zoho\CRM\Entities;

use Zoho\CRM\Wrapper\Element;

/**
 * Entity for leads inside Zoho
 * This class only have default parameters
 *
 * @package Zoho\CRM\Entities
 * @version 1.0.0
 */
class Lead extends Element 
{
	/**
	 * Zoho CRM user to whom the Lead is assigned.
	 * 
	 * @var string
	 */
	private $Lead_Owner;

	/**
	 * Salutation for the lead
	 * 
	 * @var string
	 */
	private $Salutation;

	/**
	 * First name of the lead
	 * 
	 * @var string
	 */
	private $First_Name;

	/**
	 * The job position of the lead
	 * 
	 * @var string
	 */
	private $Title;

	/**
	 * Last name of the lead
	 * 
	 * @var string
	 */	
	private $Last_Name;

	/**
	 * Name of the company where the lead is working. 
	 * This field is a mandatory
	 * 
	 * @var string
	 */
	private $Company;

	/**
	 * Source of the lead, that is, from where the lead is generated
	 * 
	 * @var string
	 */
	private $Lead_Souce;

	/**
	 * Industry to which the lead belongs
	 * 
	 * @var string
	 */
	private $Industry;

	/**
	 * Annual revenue of the company where the lead is working
	 * 
	 * @var integer
	 */
	private $Annual_Revenue;

	/**
	 * Phone number of the lead
	 * 
	 * @var string
	 */
	private $Phone;

	/**
	 * Modile number of the lead
	 * 
	 * @var string
	 */	
	private $Mobile;

	/**
	 * Fax number of the lead
	 * 
	 * @var string
	 */	
	private $Fax;

	/**
	 * Email address of the lead
	 * 
	 * @var string
	 */	
	private $Email;

	/**
	 * Secundary email address of the lead
	 * 
	 * @var string
	 */	
	private $Secundary_Email;

	/**
	 * Skype ID of the lead. Currently skype ID 
	 * can be in the range of 6 to 32 characters
	 * 
	 * @var string
	 */
	private $Skype_ID;

	/**
	 * Web site of the lead
	 * 
	 * @var string
	 */
	private $Website;

	/**
	 * Status of the lead
	 * 
	 * @var string
	 */
	private $Lead_Status;

	/**
	 * Rating of the lead
	 * 
	 * @var string
	 */
	private $Rating;

	/**
	 * Number of employees in lead's company
	 * 
	 * @var integer
	 */
	private $No_of_Employees;

	/**
	 * Remove leads from your mailing list so that they will 
	 * not receive any emails from your Zoho CRM account
	 * 
	 * @var string
	 */
	private $Email_Opt_Out;

	/**
	 * Campaign related to the Lead
	 * 
	 * @var string
	 */
	private $Campaing_Source;

	/**
	 * Street address of the lead
	 * 
	 * @var string
	 */
	private $Street;

	/**
	 * Name of the city where the lead lives
	 * 
	 * @var string
	 */
	private $City;

	/**
	 * Name of the state where the lead lives
	 * 
	 * @var string
	 */
	private $State;

	/**
	 * Postal code of the lead's address
	 * 
	 * @var string
	 */
	private $Zip_Code;

	/**
	 * Name of the lead's country
	 * 
	 * @var string
	 */
	private $Country;

	/**
	 * Other details about the lead
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