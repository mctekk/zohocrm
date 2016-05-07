<?php

namespace Zoho\CRM\Common;

/**
 * Common interface for create response
 *
 * @package Zoho\CRM\Common
 * @version 1.0.0
 */
interface FactoryInterface
{

    /**
     * Creates Response object
     *
     */
    function createResponse($xml, $module, $method);

}
