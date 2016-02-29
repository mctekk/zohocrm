<?php namespace Zoho\CRM\Request;

use Zoho\CRM\Common\FactoryInterface;
use Zoho\CRM\Request\Response;

/**
 * Interface for create response objects
 *
 * @package Zoho\CRM\Request
 * @implements FactoryInterface
 * @version 1.0.0
 */
class Factory implements FactoryInterface
{
  /**
   * @param $xml
   * @param $module
   * @param $method
   * @return \Zoho\CRM\Request\Response
   */
  public function createResponse($xml, $module, $method)
  {
    return new Response($xml, $module, $method);
  }
}