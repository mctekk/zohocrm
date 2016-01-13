<?php namespace Zoho\CRM\Entities;


use Zoho\CRM\Wrapper\Element;

class Contacts extends Element {

	private $First_Name;
	private $Last_Name;
	private $Account_Name;
	private $Email;
	private $Phone;

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
