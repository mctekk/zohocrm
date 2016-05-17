<?php

namespace Zoho\CRM\Entities;

use Zoho\CRM\Wrapper\Element;

/**
 * Entity for leads inside Zoho
 * This class only have default parameters
 *
 * @package Zoho\CRM\Entities
 * @version 1.0.0
 */
class Lead extends Element
{
    /**
     * Zoho CRM user to whom the Lead is assigned.
     *
     * @var string
     */
    public $Lead_Owner;

    /**
     * Salutation for the lead
     *
     * @var string
     */
    public $Salutation;

    /**
     * First name of the lead
     *
     * @var string
     */
    public $First_Name;

    /**
     * The job position of the lead
     *
     * @var string
     */
    public $Title;

    /**
     * Last name of the lead
     *
     * @var string
     */
    public $Last_Name;

    /**
     * Name of the company where the lead is working.
     * This field is a mandatory
     *
     * @var string
     */
    public $Company;

    /**
     * Source of the lead, that is, from where the lead is generated
     *
     * @var string
     */
    public $Lead_Souce;

    /**
     * Industry to which the lead belongs
     *
     * @var string
     */
    public $Industry;

    /**
     * Annual revenue of the company where the lead is working
     *
     * @var integer
     */
    public $Annual_Revenue;

    /**
     * Phone number of the lead
     *
     * @var string
     */
    public $Phone;

    /**
     * Modile number of the lead
     *
     * @var string
     */
    public $Mobile;

    /**
     * Fax number of the lead
     *
     * @var string
     */
    public $Fax;

    /**
     * Email address of the lead
     *
     * @var string
     */
    public $Email;

    /**
     * Secundary email address of the lead
     *
     * @var string
     */
    public $Secundary_Email;

    /**
     * Skype ID of the lead. Currently skype ID
     * can be in the range of 6 to 32 characters
     *
     * @var string
     */
    public $Skype_ID;

    /**
     * Web site of the lead
     *
     * @var string
     */
    public $Website;

    /**
     * Status of the lead
     *
     * @var string
     */
    public $Lead_Status;

    /**
     * Rating of the lead
     *
     * @var string
     */
    public $Rating;

    /**
     * Number of employees in lead's company
     *
     * @var integer
     */
    public $No_of_Employees;

    /**
     * Remove leads from your mailing list so that they will
     * not receive any emails from your Zoho CRM account
     *
     * @var string
     */
    public $Email_Opt_Out;

    /**
     * Campaign related to the Lead
     *
     * @var string
     */
    public $Campaing_Source;

    /**
     * Street address of the lead
     *
     * @var string
     */
    public $Street;

    /**
     * Name of the city where the lead lives
     *
     * @var string
     */
    public $City;

    /**
     * Name of the state where the lead lives
     *
     * @var string
     */
    public $State;

    /**
     * Postal code of the lead's address
     *
     * @var string
     */
    public $Zip_Code;

    /**
     * Name of the lead's country
     *
     * @var string
     */
    public $Country;

    /**
     * Other details about the lead
     *
     * @var string
     */
    public $Description;

}
