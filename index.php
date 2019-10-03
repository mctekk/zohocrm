<?php

// Include bootstrap loader instead of files if you want
require 'vendor/autoload.php';

use Zoho\CRM\Entities\Lead;
use Zoho\CRM\ZohoClient;

$ZohoClient = new ZohoClient(
    '1000.a5315b8c8d18617295c80d9b3bb5cd39.0ad13caa977b4913e6e8b5945c8a64e6',
    '1000.NCUTHYFLRLZYRX57IMA205E1UBDUFH',
    '53d352fd313851fc558de0595039a03950b5d1cba5',
    'https://www.zoho.com'
);

$ZohoClient->setModule('Leads');

$ZohoClient->generateAccessTokenByGrantToken();

$refresh = $ZohoClient->generateAccessTokenByRefreshToken();

// $response = $ZohoClient->getRecords();

// $response = $ZohoClient->getRecordById('2896936000050692283');

// $response = $ZohoClient->searchRecords('(Email:testlololololo13@gmail.com)');

$lead = new Lead();

// Receiving request
$request = [
    'first_name' => 'Test32',
    'last_name' => 'Test2',
    'email' => 'aisrxysjz49@sharklasers.com',
    'phone' => '4043122124257'
];

$data = $lead->deserializeXml($lead->serializeXml($request));

$response = $ZohoClient->insertRecords($data, ['wfTrigger' => 'true']);
// $response = $ZohoClient->updateRecords('2896936000050971263', $data, ['wfTrigger' => 'true']);

print_r($response);
die();
