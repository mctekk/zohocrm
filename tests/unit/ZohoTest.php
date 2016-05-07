<?php

use Zoho\CRM\Entities\Lead;
use Zoho\CRM\ZohoClient;

class ZohoTest extends \PHPUnit_Framework_TestCase
{

    /**
     * test crunchyroll login
     *
     * @return [type] [description]
     */
    public function testInsertRecord()
    {
        $lead = new Lead();
        // $lead->deserializeXml($xmlstr);

        // Receiving request
        $request = [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'aisrxybja2@sharklasers.com',
            'phone' => '404-855-2695',
            'affiliate_record%5FID' => '95641000016912544',
        ];

        $xmlstr2 = $lead->serializeXml($request); // Mapping the request for create xmlstr
        $lead->deserializeXml($xmlstr2);

        $ZohoClient = new ZohoClient('YOU_TOKEN'); // Make the connection to zoho api
        $ZohoClient->setModule('Leads'); // Selecting the module
        $validXML = $ZohoClient->mapEntity($lead); // Create valid XML (zoho format)

        // Insert the new record
        $response = $ZohoClient->insertRecords($validXML, ['wfTrigger' => 'true']);

        print_r($response);
    }

    protected function setUp()
    {

    }

    protected function tearDown()
    {
    }
}
