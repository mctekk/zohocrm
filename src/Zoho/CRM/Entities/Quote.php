<?php namespace Zoho\CRM\Entities;


use Zoho\CRM\Wrapper\Element;

class Quote extends Element {

	/**
	 * Specify the name of the quote. This field is mandatory.
	 * @var string
	 */
	private $Subject;

	private $Product_Details;

	private $Total;

	/**
	 * Specify the account name to which the quote has to be created. This field is mandatory
	 *
	 * @var string
	 */
	private $Account_Name;

	/**
	 * Specify the quantity for which the sales order has to be generated. This field is mandatory
	 * @var int
	 */
	private $Quantity;

	/*
	 * Displays the unit price of the product.
	 * @var
	 */
	private $Unit_Price;

	/**
	 * Select the product list price from Price Book or specify the product price. This field is mandatory
	 * @var string
	 */
	private $List_Price;



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
