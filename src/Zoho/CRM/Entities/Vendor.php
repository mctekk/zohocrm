<?php

namespace Zoho\CRM\Entities;

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
    protected $Vendor_Name;

    /**
     * Phone of the Affiliates
     *
     * @var string
     */
    protected $Phone;

    /**
     * Email of the Affiliates
     *
     * @var string
     */
    protected $Email;

    /**
     * Company of the Affiliates
     *
     * @var string
     */
    protected $Company;

    /**
     * Identifies if coming from finance agents
     *
     * @var boolean
     */
    protected $BFA;

    /**
     *Status of the Affiliates
     *
     * @var string
     */
    protected $Status;

    /**
     * Member number of the Affiliates
     *
     * @var string
     */
    protected $Member_Number;

    /**
     * Sponsor of the Affiliates
     *
     * @var string
     */
    protected $Sponsor;

    /**
     * City of the Affiliates
     *
     * @var string
     */
    protected $City;

    /**
     * State of the Affiliates
     *
     * @var string
     */
    protected $State;

    /**
     * Zip_Code of the Affiliates
     *
     * @var string
     */
    protected $Zip_Code;

    /**
     * Street of the Affiliates
     *
     * @var string
     */
    protected $Street;

    /**
     * Website of the Affiliates
     *
     * @var string
     */
    protected $Website;

}
