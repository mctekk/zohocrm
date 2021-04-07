<?php

/*
 * This file is part of mctekk/zohocrm library.
 *
 * (c) MCTekK S.R.L. https://mctekk.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zoho\CRM\Request;

use Zoho\CRM\Common\FactoryInterface;

/**
 * Interface for create response objects
 *
 * @implements FactoryInterface
 *
 * @version 1.0.0
 */
class Factory implements FactoryInterface
{
    public function createResponse($xml, $module, $method)
    {
        return new Response($xml, $module, $method);
    }
}
