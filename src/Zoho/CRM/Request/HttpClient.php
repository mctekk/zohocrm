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

use Zoho\CRM\Common\HttpClientInterface;
use Exception;

/**
 * Simple cURL based HTTP Client.
 * Sends API calls to Zoho server.
 *
 * @version 1.0.0
 * @implements HttpClientInterface
 */
class HttpClient implements HttpClientInterface
{
    protected $curl;
    protected $timeout = 5;
    protected $retry = 2;

    /**
     * Construct
     */
    public function __construct()
    {
        if (!function_exists('curl_init')) {
            throw new Exception('cURL is not supported by server.');
        }
    }

    public function post($uri, $postBody)
    {
        $this->curl = curl_init();
        $this->setOptions($uri, $postBody);

        $count = 0;
        $response = false;
        while ($response === false && $count < $this->retry) {
            $response = curl_exec($this->curl);
            ++$count;
        }

        if ($response === false) {
            throw new \RuntimeException(curl_error($this->curl), curl_errno($this->curl));
        }

        curl_close($this->curl);

        return $response;
    }

    public function setTimeout($timeout)
    {
        if (is_numeric($timeout)) {
            $this->timeout = (int) $timeout;
        }
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function setRetry($retry)
    {
        if (is_numeric($retry)) {
            $this->retry = (int) $retry;
        }
    }

    public function getRetry()
    {
        return $this->retry;
    }

    protected function setOptions($uri, $postBody)
    {
        curl_setopt($this->curl, CURLOPT_URL, $uri);

        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $postBody);

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);

        // curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        // curl_setopt($this->curl, CURLOPT_SSL_CIPHER_LIST, 'rsa_rc4_128_sha');
        // curl_setopt($this->curl, CURLOPT_SSLVERSION, 3);
    }
}
