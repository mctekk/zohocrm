<?php

// Include bootstrap loader instead of files if you want
require 'vendor/autoload.php';

use Zoho\CRM\Entities\Lead;
use Zoho\CRM\ZohoClient;

$ZohoClient = new ZohoClient(
    '1000.f5cada9783878bbafb5cd10706deded7.f2f85eec81d9c3cd98066a201578417e',
    '1000.NCUTHYFLRLZYRX57IMA205E1UBDUFH',
    '53d352fd313851fc558de0595039a03950b5d1cba5',
    'https://www.zoho.com'
);

$ZohoClient->setModule('Leads');

$ZohoClient->generateAccessTokenByGrantToken();

$refresh = $ZohoClient->generateAccessTokenByRefreshToken();

// $response = $ZohoClient->getRecords();

$response = $ZohoClient->getRecordById('2896936000050692283');

print_r($response);
die();

// $lead = new Lead();
// // $lead->deserializeXml($xmlstr);

// // Receiving request
// $request = [
//     'first_name' => 'Test',
//     'last_name' => 'Test',
//     'email' => 'aisrxybja2@sharklasers.com',
//     'phone' => '404-855-2695',
//     'affiliate_record%5FID' => '95641000016912544',
// ];

// $xmlstr2 = $lead->serializeXml($request); // Mapping the request for create xmlstr
// $lead->deserializeXml($xmlstr2);

// $ZohoClient = new ZohoClient('YOU_TOKEN'); // Make the connection to zoho api
// $ZohoClient->setModule('Leads'); // Selecting the module
// $validXML = $ZohoClient->mapEntity($lead); // Create valid XML (zoho format)

// // Insert the new record
// $response = $ZohoClient->insertRecords($validXML, ['wfTrigger' => 'true']);

// print_r($response);
// print "\n";
