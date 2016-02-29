<?php namespace Zoho\CRM\Entities;


use Zoho\CRM\Common\ZohoRecord;

/**
 * Class Quote
 *
 * @property $Subject
 * @property $Product_Details
 * @property $Total
 * @property $Account_Name
 * @property $Quantity
 * @property $Unit_Price
 * @property $List_Price
 *
 * @package Zoho\CRM\Entities
 */
class Quote extends ZohoRecord
{
	protected function getEntityName()
	{
		return 'Quotes';
	}
	/**
	 * Specify the name of the quote. This field is mandatory.
	 * @var string
	 */
	protected $Subject;

	/**
	 * Specify the queue product details.
	 * @var string
	 */
	protected $Product_Details;

	/**
	 * Specify the quote total.
	 * @var
	 */
	protected $Total;

	/**
	 * Specify the account name to which the quote has to be created. This field is mandatory
	 *
	 * @var string
	 */
	protected $Account_Name;

	/**
	 * Specify the quantity for which the sales order has to be generated. This field is mandatory
	 * @var int
	 */
	protected $Quantity;

	/**
	 * Displays the unit price of the product.
	 * @var
	 */
	protected $Unit_Price;

	/**
	 * Select the product list price from Price Book or specify the product price. This field is mandatory
	 * @var string
	 */
	protected $List_Price;
}
