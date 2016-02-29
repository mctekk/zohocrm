<?php namespace Zoho\CRM\Entities;


use Zoho\CRM\Common\ZohoRecord;

/**
 * Class Contacts
 *
 * @property $First_Name
 * @property $Last_Name
 * @property $Account_Name
 * @property $Email
 * @property $Phone
 *
 * @package Zoho\CRM\Entities
 */
class Contacts extends ZohoRecord
{
	protected function getEntityName()
	{
		return 'Contacts';
	}

	protected $First_Name;
	protected $Last_Name;
	protected $Account_Name;
	protected $Email;
	protected $Phone;
}
