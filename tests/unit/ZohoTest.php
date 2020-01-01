<?php

use Zoho\CRM\Entities\Lead;
use Zoho\CRM\ZohoClient;

class ZohoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * To avoid having to update code from client using old version of the lib
     * we still use deserilized and serialized even if they are no longer neede.
     *
     * @return void
     */
    public function testBackwardsCompatibilityInsert()
    {
        $ZohoClient = new ZohoClient();

        $ZohoClient->setAuthRefreshToken(getenv('ZOHO_AUTH_REFRESH_TOKEN'));
        $ZohoClient->setZohoClientId(getenv('ZOHO_CLIENT_ID'));
        $ZohoClient->setZohoClientSecret(getenv('ZOHO_CLIENT_SECRET'));
        $refresh = $ZohoClient->generateAccessTokenByRefreshToken();

        $ZohoClient->setModule('Leads');

        $lead = new Lead();

        $request = [
            // 'Owner' => 'mark@financefactory.com',
            'Owner' => '2896936000004024001',
            'First_Name' => 'disposabile111',
            'Last_Name' => 'leadtest111',
            'Lead_Source' => 'Christian Guthermann',
            'Phone' => '22223425363447',
            'Email' => 'c00000exa29@sharklasers.com',
            'Member' => '33',
            'Sponsor' => '0000',
            'Code' => '110100001570806179',
            'URL_1' => 'https://lp.thefinancefactory.com/lp/r/23',
            'Affiliate_RecordE5FID' => 95641000006185231,
            'Sales_Rep' => 'Mark Ledford',
            'Available Collateral' => json_decode(json_encode(['real estate,stock portfolio']), true)
        ];

        $data = $lead->deserializeXml($lead->serializeXml($request));

        $response = $ZohoClient->insertRecords(
            $data,
            ['wfTrigger' => 'true']
        );

        $this->assertTrue($response->isSuccess());
        $this->assertTrue(!empty($response->getRecordId()));
    }

    /**
     * Create a new record.
     *
     * @return void
     */
    public function testCreateRecord()
    {
        $ZohoClient = new ZohoClient();

        $ZohoClient->setAuthRefreshToken(getenv('ZOHO_AUTH_REFRESH_TOKEN'));
        $ZohoClient->setZohoClientId(getenv('ZOHO_CLIENT_ID'));
        $ZohoClient->setZohoClientSecret(getenv('ZOHO_CLIENT_SECRET'));
        $refresh = $ZohoClient->generateAccessTokenByRefreshToken();

        $ZohoClient->setModule('Leads');

        $lead = new Lead();

        $request = [
            // 'Owner' => 'mark@financefactory.com',
            'Owner' => '2896936000004024001',
            'First_Name' => 'disposabile111',
            'Last_Name' => 'leadtest111',
            'Lead_Source' => 'Christian Guthermann',
            'Phone' => '22223425363447',
            'Email' => 'c00000exa29@sharklasers.com',
            'Member' => '33',
            'Sponsor' => '0000',
            'Code' => '110100001570806179',
            'URL_1' => 'https://lp.thefinancefactory.com/lp/r/23',
            'Affiliate_RecordE5FID' => 95641000006185231,
            'Sales_Rep' => 'Mark Ledford',
            'Available Collateral' => json_decode(json_encode(['real estate,stock portfolio']), true)
        ];

        //$data = $lead->deserializeXml($lead->serializeXml($request));

        $response = $ZohoClient->insertRecords(
            $lead->cleanParams($request),
            ['wfTrigger' => 'true']
        );

        $this->assertTrue($response->isSuccess());
        $this->assertTrue(!empty($response->getRecordId()));
    }

    /**
     * Setup the Test.
     *
     * @return void
     */
    protected function setUp()
    {
    }

    /**
     * Destroy the test.
     *
     * @return void
     */
    protected function tearDown()
    {
    }
}
