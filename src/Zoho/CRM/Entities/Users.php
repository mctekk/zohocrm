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
 * Entity for users inside Zoho
 * This class only have default parameters.
 *
 * @version 1.0.0
 */
class Users extends Element
{
    /**
     * Specify the user id.
     *
     * @var int
     */
    protected $id;

    /**
     * Email of the user.
     *
     * @var string
     */
    protected $email;

    /**
     * User's role.
     *
     * @var string
     */
    protected $role;

    /**
     * User's profile.
     *
     * @var string
     */
    protected $profile;

    /**
     * Status of user.
     *
     * @var string
     */
    protected $status;

    /**
     * Specify if is confirmed.
     *
     * @var string
     */
    protected $confirm;
}
