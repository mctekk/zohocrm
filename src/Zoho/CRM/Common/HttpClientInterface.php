<?php

namespace Zoho\CRM\Common;

/**
 * Common interface for Http clients
 *
 * @package Zoho\CRM\Common
 * @version 1.0.0
 */
interface HttpClientInterface
{
    /**
     * Performs POST request.
     *
     * @param string $uri Direction to make the post
     * @param string $postBody Post data
     */
    public function post($uri, $postBody);
}
