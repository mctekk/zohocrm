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
 * Entity for Affiliates inside Zoho
 * This class only have default parameters.
 *
 * @version 1.0.0
 */
class Vendor extends Element
{
    /**
     * Name of the Affiliates.
     *
     * @var string
     */
    public $Vendor_Name;

    /**
     * Phone of the Affiliates.
     *
     * @var string
     */
    public $Phone;

    /**
     * Email of the Affiliates.
     *
     * @var string
     */
    public $Email;

    /**
     * Company of the Affiliates.
     *
     * @var string
     */
    public $Company;

    /**
     * Identifies if coming from finance agents.
     *
     * @var bool
     */
    public $BFA;

    /**
     *Status of the Affiliates.
     *
     * @var string
     */
    public $Status;

    /**
     * Member number of the Affiliates.
     *
     * @var string
     */
    public $Member_Number;

    /**
     * Sponsor of the Affiliates.
     *
     * @var string
     */
    public $Sponsor;

    /**
     * City of the Affiliates.
     *
     * @var string
     */
    public $City;

    /**
     * State of the Affiliates.
     *
     * @var string
     */
    public $State;

    /**
     * Zip_Code of the Affiliates.
     *
     * @var string
     */
    public $Zip_Code;

    /**
     * Street of the Affiliates.
     *
     * @var string
     */
    public $Street;

    /**
     * Website of the Affiliates.
     *
     * @var string
     */
    public $Website;
}
