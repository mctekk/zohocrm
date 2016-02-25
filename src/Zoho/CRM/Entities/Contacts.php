<?php namespace Zoho\CRM\Entities;


use Zoho\CRM\Common\ZohoRecord;

class Contacts extends ZohoRecord {

	private $First_Name;
	private $Last_Name;
	private $Account_Name;
	private $Email;
	private $Phone;

	/**
	 * Contacts constructor.
	 */
	public function __construct()
	{
		parent::__construct(ZohoRecord::MODULE_CONTACTS);
	}

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
