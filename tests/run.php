<?php

// Include bootstrap loader instead of files if you want
require_once '../src/Zoho/CRM/Common/HttpClientInterface.php';
require_once '../src/Zoho/CRM/Common/FactoryInterface.php';
require_once '../src/Zoho/CRM/Request/HttpClient.php';
require_once '../src/Zoho/CRM/Request/Factory.php';
require_once '../src/Zoho/CRM/Request/Response.php';
require_once '../src/Zoho/CRM/ZohoClient.php';
require_once '../src/Zoho/CRM/Wrapper/Element.php';
require_once '../src/Zoho/CRM/Entities/Lead.php';

use Zoho\CRM\Entities\Lead;
use Zoho\CRM\ZohoClient;

/*

$xmlstr = '
<Lead>
<LendioRepresentative>Doug Goodwin</LendioRepresentative>
<LendioFileID>209595408</LendioFileID>
<AmountOfFinancing>25000</AmountOfFinancing>
<FirstName>Test</FirstName>
<LastName>Test</LastName>
<Phone>555 555-5555</Phone>
<Email>testDaniel03@sharklasers.com</Email>
<BusinessName>Test</BusinessName>
<Address>
<Street>4111nc561hwy </Street>
<City>louisburg </City>
<State>NC</State>
<ZipCode>27549</ZipCode>
</Address>
<Industry>Commercial and Industrial Machinery and Equipment (except Automotive and Electronic) Repair and Maintenance</Industry>
<MonthlyCreditCardSales>None, I don\'t accept credit cards</MonthlyCreditCardSales>
<PrimaryCustomer>Business to Consumer</PrimaryCustomer>
<Comments>Time In Business: Not yet in business, still in planning stages
Annual Revenue: $0, No Revenues
Loan Purpose: Working Capital
Accounts Receivable Amount: Do not have accounts receivable
Total Profits: Not Profitable
Collateral Available: Land / Real Estate,Equity in a home/personal residence
Product Name: Business Credit Lines
Inquiry Date:
Time To Funding: 1 month
Comments: want to purchase a hydraulic band sawmill
</Comments>
<CreditScore>Excellent</CreditScore>
<Bankruptcy>No</Bankruptcy>
</Lead>';

 */

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
print "\n";
