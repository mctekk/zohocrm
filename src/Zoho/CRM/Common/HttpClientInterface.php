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
 * Common interface for Http clients.
 *
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
