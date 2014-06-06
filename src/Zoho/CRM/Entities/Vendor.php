<?php namespace Zoho\CRM\Entities;

use Zoho\CRM\Wrapper\Element;

/**
 * Entity for Affiliates inside Zoho
 * This class only have default parameters
 *
 * @version 1.0.0
 */
class Vendor extends Element 
{
	/**
	 * Name of the Affiliates
	 * 
	 * @var string
	 */
	private $Vendor_Name;
	
	/**
	 * Phone of the Affiliates
	 * 
	 * @var string
	 */
	private $Phone;
	
	/**
	 * Email of the Affiliates
	 * 
	 * @var string
	 */
	private $Email;
	
	/**
	 * Company of the Affiliates
	 * 
	 * @var string
	 */
	private $Company;
	
	/**
	 * Identifies if coming from finance agents
	 * 
	 * @var boolean
	 */
	private $BFA;
	
	/**
	 *Status of the Affiliates
	 * 
	 * @var string
	 */
	private $Status;
	
	/**
	 * Member number of the Affiliates
	 * 
	 * @var string
	 */
	private $Member_Number;
	
	/**
	 * Sponsor of the Affiliates
	 * 
	 * @var string
	 */
	private $Sponsor;
	
	/**
	 * City of the Affiliates
	 * 
	 * @var string
	 */
	private $City;
	
	/**
	 * State of the Affiliates
	 * 
	 * @var string
	 */
	private $State;
	
	/**
	 * Zip_Code of the Affiliates
	 * 
	 * @var string
	 */
	private $Zip_Code;
	
	/**
	 * Street of the Affiliates
	 * 
	 * @var string
	 */
	private $Street;
	
	/**
	 * Website of the Affiliates
	 * 
	 * @var string
	 */
	private $Website;

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