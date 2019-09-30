<?php

// Include bootstrap loader instead of files if you want
require 'vendor/autoload.php';

use Zoho\CRM\Entities\Lead;
use Zoho\CRM\ZohoClient;

$ZohoClient = new ZohoClient(
    '1000.d78edac4fb4a56e64338b884a91a9a58.0ba8f8f69a139ddbb6cf386bd0035ff9',
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
    'last_name' => 'Test2'
    // 'email' => 'aisrxybja22@sharklasers.com',
    // 'phone' => '4043123124225'
];

$data = $lead->deserializeXml($lead->serializeXml($request));

// $response = $ZohoClient->insertRecords($data, ['wfTrigger' => 'true']);
$response = $ZohoClient->updateRecords('2896936000050971263', $data, ['wfTrigger' => 'true']);

print_r($response);
die();
