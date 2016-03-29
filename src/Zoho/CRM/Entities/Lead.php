<?php namespace Zoho\CRM\Entities;

use Zoho\CRM\Common\ZohoRecord;

/**
 * Entity for leads inside Zoho
 * This class only have default parameters
 *
 * @property $Lead_Owner
 * @property $Salutation
 * @property $First_Name
 * @property $Title
 * @property $Last_Name
 * @property $Company
 * @property $Lead_Source
 * @property $Industry
 * @property $Annual_Revenue
 * @property $Phone
 * @property $Mobile
 * @property $Fax
 * @property $Email
 * @property $Secondary_Email
 * @property $Skype_ID
 * @property $Website
 * @property $Lead_Status
 * @property $Rating
 * @property $No_of_Employees
 * @property $Email_Opt_Out
 * @property $Campaign_Source
 * @property $Street
 * @property $City
 * @property $State
 * @property $Zip_Code
 * @property $Country
 * @property $Description
 *
 * @package Zoho\CRM\Entities
 * @version 1.0.0
 */
class Lead extends ZohoRecord
{
	protected function getEntityName()
	{
		return 'Leads';
	}
	/**
	 * Zoho CRM user to whom the Lead is assigned.
	 * 
	 * @var string
	 */
	protected $Lead_Owner;

	/**
	 * Salutation for the lead
	 * 
	 * @var string
	 */
	protected $Salutation;

	/**
	 * First name of the lead
	 * 
	 * @var string
	 */
	protected $First_Name;

	/**
	 * The job position of the lead
	 * 
	 * @var string
	 */
	protected $Title;

	/**
	 * Last name of the lead
	 * 
	 * @var string
	 */
	protected $Last_Name;

	/**
	 * Name of the company where the lead is working. 
	 * This field is a mandatory
	 * 
	 * @var string
	 */
	protected $Company;

	/**
	 * Source of the lead, that is, from where the lead is generated
	 * 
	 * @var string
	 */
	protected $Lead_Source;

	/**
	 * Industry to which the lead belongs
	 * 
	 * @var string
	 */
	protected $Industry;

	/**
	 * Annual revenue of the company where the lead is working
	 * 
	 * @var integer
	 */
	protected $Annual_Revenue;

	/**
	 * Phone number of the lead
	 * 
	 * @var string
	 */
	protected $Phone;

	/**
	 * Modile number of the lead
	 * 
	 * @var string
	 */
	protected $Mobile;

	/**
	 * Fax number of the lead
	 * 
	 * @var string
	 */
	protected $Fax;

	/**
	 * Email address of the lead
	 * 
	 * @var string
	 */
	protected $Email;

	/**
	 * Secundary email address of the lead
	 * 
	 * @var string
	 */
	protected $Secondary_Email;

	/**
	 * Skype ID of the lead. Currently skype ID 
	 * can be in the range of 6 to 32 characters
	 * 
	 * @var string
	 */
	protected $Skype_ID;

	/**
	 * Web site of the lead
	 * 
	 * @var string
	 */
	protected $Website;

	/**
	 * Status of the lead
	 * 
	 * @var string
	 */
	protected $Lead_Status;

	/**
	 * Rating of the lead
	 * 
	 * @var string
	 */
	protected $Rating;

	/**
	 * Number of employees in lead's company
	 * 
	 * @var integer
	 */
	protected $No_of_Employees;

	/**
	 * Remove leads from your mailing list so that they will 
	 * not receive any emails from your Zoho CRM account
	 * 
	 * @var string
	 */
	protected $Email_Opt_Out;

	/**
	 * Campaign related to the Lead
	 * 
	 * @var string
	 */
	protected $Campaign_Source;

	/**
	 * Street address of the lead
	 * 
	 * @var string
	 */
	protected $Street;

	/**
	 * Name of the city where the lead lives
	 * 
	 * @var string
	 */
	protected $City;

	/**
	 * Name of the state where the lead lives
	 * 
	 * @var string
	 */
	protected $State;

	/**
	 * Postal code of the lead's address
	 * 
	 * @var string
	 */
	protected $Zip_Code;

	/**
	 * Name of the lead's country
	 * 
	 * @var string
	 */
	protected $Country;

	/**
	 * Other details about the lead
	 * 
	 * @var string
	 */
	protected $Description;
}