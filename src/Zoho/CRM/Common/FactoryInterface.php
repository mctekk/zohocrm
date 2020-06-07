<?php

/*
 * This file is part of mctekk/zohocrm library.
 *
 * (c) MCTekK S.R.L. https://mctekk.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zoho\CRM\Common;

/**
 * Common interface for create response.
 *
 * @version 1.0.0
 */
interface FactoryInterface
{
    /**
     * Creates Response object.
     *
     * @param mixed $responseData
     * @param mixed $module
     * @param mixed $method
     */
    public function createResponse(array $responseData, string $module, string $method);
}
