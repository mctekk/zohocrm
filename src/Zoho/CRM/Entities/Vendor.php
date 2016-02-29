<?php namespace Zoho\CRM\Entities;

use Zoho\CRM\Common\ZohoRecord;

/**
 * Entity for Affiliates inside Zoho
 * This class only have default parameters
 *
 * @property $Vendor_Name
 * @property $Phone
 * @property $Email
 * @property $Company
 * @property $BFA
 * @property $Status
 * @property $Member_Number
 * @property $Sponsor
 * @property $City
 * @property $State
 * @property $Zip_Code
 * @property $Street
 * @property $Website
 *
 */
class Vendor extends ZohoRecord
{
	/**
	 * Name of the Affiliates
	 *
	 * @var string
	 */
	protected $Vendor_Name;

	/**
	 * Phone of the Affiliates
	 *
	 * @var string
	 */
	protected $Phone;

	/**
	 * Email of the Affiliates
	 *
	 * @var string
	 */
	protected $Email;

	/**
	 * Company of the Affiliates
	 *
	 * @var string
	 */
	protected $Company;

	/**
	 * Identifies if coming from finance agents
	 *
	 * @var boolean
	 */
	protected $BFA;

	/**
	 *Status of the Affiliates
	 *
	 * @var string
	 */
	protected $Status;

	/**
	 * Member number of the Affiliates
	 *
	 * @var string
	 */
	protected $Member_Number;

	/**
	 * Sponsor of the Affiliates
	 *
	 * @var string
	 */
	protected $Sponsor;

	/**
	 * City of the Affiliates
	 *
	 * @var string
	 */
	protected $City;

	/**
	 * State of the Affiliates
	 *
	 * @var string
	 */
	protected $State;

	/**
	 * Zip_Code of the Affiliates
	 *
	 * @var string
	 */
	protected $Zip_Code;

	/**
	 * Street of the Affiliates
	 *
	 * @var string
	 */
	protected $Street;

	/**
	 * Website of the Affiliates
	 *
	 * @var string
	 */
	protected $Website;
}