<?php namespace Zoho\CRM\Entities;


use Zoho\CRM\Common\ZohoRecord;

/**
 * Class Potentials
 *
 * @property $Potential_Name
 * @property $Account_Name
 * @property $Closing_Date
 * @property $Stage
 * @property $Quote_Order_Type
 * @property $WWW_ID
 * @property $NV_Year
 * @property $NV_Make
 * @property $NV_Model
 * @property $NV_Style
 * @property $NV_Packages_And_Options
 * @property $NV_Color_Ext
 * @property $NV_Color_Int
 * @property $NV_MSRP
 * @property $NV_Invoice
 * @property $NV_Special_Requests
 * @property $NV_Lease_Term
 * @property $NV_Mileage
 * @property $NV_Regis_State
 * @property $NV_Regis_City
 * @property $TV_VIN
 * @property $TV_Finance_Status
 * @property $TV_Finance_Co
 * @property $TV_Finance_Exp_Date
 * @property $TV_Odometer
 * @property $TV_Internal_Notes
 * @property $Confirm_Complete
 * @property $Deliver_Confirmed_By_Cust
 * @property $Deliver_Address1_Request_Change
 * @property $Deliver_Zipcode_Request_Change
 * @property $Deliver_Notes_Request_Change
 *
 * @package Zoho\CRM\Entities
 */
class Potential extends ZohoRecord {

	protected $Potential_Name;
	protected $Account_Name;
	protected $Closing_Date;
	protected $Stage;
	protected $Quote_Order_Type;
	protected $WWW_ID;

	protected $NV_Year;
	protected $NV_Make;
	protected $NV_Model;
	protected $NV_Style;
	protected $NV_Packages_And_Options;
	protected $NV_Color_Ext;
	protected $NV_Color_Int;
	protected $NV_MSRP;
	protected $NV_Invoice;

	protected $NV_Special_Requests;
	protected $NV_Lease_Term;
	protected $NV_Mileage;
	protected $NV_Regis_State;
	protected $NV_Regis_City;

	protected $TV_VIN;
	protected $TV_Finance_Status;
	protected $TV_Finance_Co;
	protected $TV_Finance_Exp_Date;
	protected $TV_Odometer;
	protected $TV_Internal_Notes;
	protected $Confirm_Complete;

	protected $Deliver_Confirmed_By_Cust;
	protected $Deliver_Address1_Request_Change;
	protected $Deliver_Zipcode_Request_Change;
	protected $Deliver_Notes_Request_Change;
}
