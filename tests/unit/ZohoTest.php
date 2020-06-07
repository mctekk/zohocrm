<?php

use Zoho\CRM\Entities\Lead;
use Zoho\CRM\ZohoClient;

class ZohoTest extends PHPUnit_Framework_TestCase
{
    protected $zohoClient;
    protected $redis;
    protected $faker;

    /**
     * Init the test
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->zohoClient = new ZohoClient();

        $this->zohoClient->setAuthRefreshToken(getenv('ZOHO_AUTH_REFRESH_TOKEN'));
        $this->zohoClient->setZohoClientId(getenv('ZOHO_CLIENT_ID'));
        $this->zohoClient->setZohoClientSecret(getenv('ZOHO_CLIENT_SECRET'));

        $this->redis = new Redis();
        $this->redis->connect(getenv('REDIS_HOST'), getenv('REDIS_PORT'));

    }

    /**
     * To avoid having to update code from client using old version of the lib
     * we still use deserialized and serialized even if they are no longer needed.
     *
     * @return void
     */
    public function testBackwardCompatibility()
    {
        $this->faker = Faker\Factory::create();

        $refresh = $this->zohoClient->generateAccessTokenByRefreshToken();
        $this->zohoClient->setModule('Leads');

        $lead = new Lead();

        $request = [
            'First_Name' => $this->faker->firstName,
            'Last_Name' => $this->faker->lastName,
            'Lead_Source' => $this->faker->name,
            'Phone' => $this->faker->phoneNumber,
            'Email' => $this->faker->email,
            'Member' => '33',
            'Sponsor' => '0000',
            'URL_1' => $this->faker->url,
            'Affiliate_RecordE5FID' => 95641000006185231,
            'Sales_Rep' => $this->faker->name,
            'Available Collateral' => json_decode(json_encode(['real estate,stock portfolio']), true)
        ];

        $data = $lead->deserializeXml($lead->serializeXml($request));

        $response = $this->zohoClient->insertRecords(
            $data,
            ['wfTrigger' => 'true']
        );

        $this->assertTrue($response->isSuccess());
        $this->assertTrue(!empty($response->getRecordId()));
        $this->assertTrue(is_array($response->getResponseData()));
    }

    /**
     * Create a new record.
     *
     * @return void
     */
    public function testCreateRecord()
    {
        $this->faker = Faker\Factory::create();

        $refresh = $this->zohoClient->generateAccessTokenByRefreshToken();
        $this->zohoClient->setModule('Leads');

        $lead = new Lead();

        $request = [
            'First_Name' => $this->faker->firstName,
            'Last_Name' => $this->faker->lastName,
            'Lead_Source' => $this->faker->name,
            'Phone' => $this->faker->phoneNumber,
            'Email' => $this->faker->email,
            'Member' => '33',
            'Sponsor' => '0000',
            'URL_1' => $this->faker->url,
            'Affiliate_RecordE5FID' => 95641000006185231,
            'Sales_Rep' => $this->faker->name,
            'Available Collateral' => json_decode(json_encode(['real estate,stock portfolio']), true)
        ];

        $response = $this->zohoClient->insertRecords(
            $request,
            ['wfTrigger' => 'true']
        );

        $this->assertTrue($response->isSuccess());
        $this->assertTrue(!empty($response->getRecordId()));
        $this->assertTrue(is_array($response->getResponseData()));
    }

    /**
     * Create a new record.
     *
     * @return void
     */
    public function testCreateRecordWithRedis()
    {
        $this->faker = Faker\Factory::create();

        $refresh = $this->zohoClient->manageAccessTokenRedis($this->redis, 'test_zoho');
        $this->zohoClient->setModule('Leads');

        $lead = new Lead();

        $request = [
            'First_Name' => $this->faker->firstName,
            'Last_Name' => $this->faker->lastName,
            'Lead_Source' => $this->faker->name,
            'Phone' => $this->faker->phoneNumber,
            'Email' => $this->faker->email,
            'Member' => '33',
            'Sponsor' => '0000',
            'URL_1' => $this->faker->url,
            'Affiliate_RecordE5FID' => 95641000006185231,
            'Sales_Rep' => $this->faker->name,
            'Available Collateral' => json_decode(json_encode(['real estate,stock portfolio']), true)
        ];

        $response = $this->zohoClient->insertRecords(
           $request,
            ['wfTrigger' => 'true']
        );

        $this->assertTrue($response->isSuccess());
        $this->assertTrue(!empty($response->getRecordId()));
        $this->assertTrue(is_array($response->getResponseData()));
    }

}
