<?php

/*
 * This file is part of mctekk/zohocrm library.
 *
 * (c) MCTekK S.R.L. https://mctekk.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zoho\CRM\Entities;

use Zoho\CRM\Wrapper\Element;

/**
 * Entity for accounts inside Zoho
 * This class only have default parameters.
 *
 * @version 1.0.0
 */
class Contact extends Element
{
    /**
     * Zoho CRM user to whom the Lead is assigned.
     *
     * @var string
     */
    public $Contact_Owner;

    /**
     * Salutation for the lead.
     *
     * @var string
     */
    public $Salutation;

    /**
     * First name of the lead.
     *
     * @var string
     */
    public $First_Name;

    /**
     * The job position of the lead.
     *
     * @var string
     */
    public $Title;

    /**
     * Last name of the lead, this field is mandatory.
     *
     * @var string
     */
    public $Last_Name;

    /**
     * Select the account related to the contact.
     *
     * @var string
     */
    public $Account_Name;

    /**
     * Select the vendor relatedd to the contact.
     *
     * @var string
     */
    public $Vendor_Name;

    /**
     * Source of the lead, that is, from where the lead is generated.
     *
     * @var string
     */
    public $Lead_Source;

    /**
     * Specify the department of the contact.
     *
     * @var string
     */
    public $Department;

    /**
     * Specify the birthday of the contact to send greetings for a better relationship.
     *
     * @var Date
     */
    public $Date_Of_Birth;

    /**
     * Select the person to whom the contact reports.
     *
     * @var int
     */
    public $Report_To;

    /**
     * Phone number of the lead.
     *
     * @var string
     */
    public $Phone;

    /**
     * Specify the home phone number of the contact.
     *
     * @var string
     */
    public $Home_Phone;

    /**
     * Specify the other phone number of the contact (if any).
     *
     * @var string
     */
    public $Other_Phone;

    /**
     * Modile number of the lead.
     *
     * @var string
     */
    public $Mobile;

    /**
     * Fax number of the lead.
     *
     * @var string
     */
    public $Fax;

    /**
     * Email address of the lead.
     *
     * @var string
     */
    public $Email;

    /**
     * Secondary email address of the lead.
     *
     * @var string
     */
    public $Secondary_Email;

    /**
     * Skype ID of the lead. Currently skype ID
     * can be in the range of 6 to 32 characters.
     *
     * @var string
     */
    public $Skype_ID;

    /**
     * Specify the name of the contact’s assistant.
     *
     * @var string
     */
    public $Assistant;

    /**
     * Specify the phone number of the contact's assistant.
     *
     * @var string
     */
    public $Asst_Phone;

    /**
     * Remove leads from your mailing list so that they will
     * not receive any emails from your Zoho CRM account.
     *
     * @var string
     */
    public $Email_Opt_Out;

    /**
     * Campaign related to the Lead.
     *
     * @var string
     */
    public $Campaign_Source;

    /**
     * Other details about the lead.
     *
     * @var string
     */
    public $Description;

    /**
     * Specify the primary address of the contact.
     *
     * Divided into 5 parts:
     *
     *     @var string
     *     @var string
     *     @var string
     *     @var string
     *     @var string
     */
    protected $Street;
    protected $City;
    protected $State;
    protected $Zip_Code;
    protected $Country;

    /**
     * Specify the primary address of the contact.
     *
     * Divided into 5 parts:
     *
     *     @var string
     *     @var string
     *     @var string
     *     @var string
     *     @var string
     */
    protected $Other_Street;
    protected $Other_City;
    protected $Other_State;
    protected $Other_Zip_Code;
    protected $Other_Country;
}
