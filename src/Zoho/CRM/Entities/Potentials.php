<?php namespace Zoho\CRM\Entities;


use Zoho\CRM\Wrapper\Element;

class Potentials extends Element {

	private $Potential_Name;
	private $Account_Name;
	private $Closing_Date;
	private $Stage;
	private $Quote_Order_Type;
	private $WWW_ID;

	private $NV_Year;
	private $NV_Make;
	private $NV_Model;
	private $NV_Style;
	private $NV_Packages_And_Options;
	private $NV_Color_Ext;
	private $NV_Color_Int;
	private $NV_MSRP;
	private $NV_Invoice;

	private $NV_Special_Requests;
	private $NV_Lease_Term;
	private $NV_Mileage;
	private $NV_Regis_State;
	protected $NV_Regis_City;

	private $TV_VIN;
	private $TV_Finance_Status;
	private $TV_Finance_Co;
	private $TV_Finance_Exp_Date;
	private $TV_Odometer;
	private $TV_Internal_Notes;
	private $Confirm_Complete;

	private $Deliver_Confirmed_By_Cust;
	private $Deliver_Address1_Request_Change;
	private $Deliver_Zipcode_Request_Change;
	private $Deliver_Notes_Request_Change;


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
