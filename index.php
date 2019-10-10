<?php

// Include bootstrap loader instead of files if you want
require 'vendor/autoload.php';

use Zoho\CRM\Entities\Lead;
use Zoho\CRM\ZohoClient;

//ZohoCRM.modules.all,ZohoCRM.users.all --> The scope we need to use now

// $ZohoClient = new ZohoClient(
//     '1000.3dbd409069479714ed29915121793a9e.9d98d15ef2931510780527f232a4aa9f',
//     '1000.NCUTHYFLRLZYRX57IMA205E1UBDUFH',
//     '53d352fd313851fc558de0595039a03950b5d1cba5',
//     'https://www.zoho.com'
// );

$ZohoClient = new ZohoClient();

$ZohoClient->setModule('Leads');

// $ZohoClient->generateAccessTokenByGrantToken();

$ZohoClient->setAuthRefreshToken('1000.5c4728219eb163a276d47132143a9257.de9ff3dfb628ca36c22240a5fbb529d8');
$ZohoClient->setZohoClientId('1000.NCUTHYFLRLZYRX57IMA205E1UBDUFH');
$ZohoClient->setZohoClientSecret('53d352fd313851fc558de0595039a03950b5d1cba5');

$refresh = $ZohoClient->generateAccessTokenByRefreshToken();

$response = $ZohoClient->getRecords();

// $response = $ZohoClient->getRecordById('2896936000050692283');

// $response = $ZohoClient->searchRecords('(Email:testlololololo13@gmail.com)');

// $lead = new Lead();

// Receiving request
// $request = [
//     'first_name' => 'Test32',
//     'last_name' => 'Test2',
//     'email' => 'aisrxysjz49@sharklasers.com',
//     'phone' => '4043122124257'
// ];

// $data = $lead->deserializeXml($lead->serializeXml($request));

// $response = $ZohoClient->insertRecords($data, ['wfTrigger' => 'true']);
// $response = $ZohoClient->updateRecords('2896936000050971263', $data, ['wfTrigger' => 'true']);

// $ZohoClient->setModule('Users');
// $response = $ZohoClient->getUsers('AllUsers', 1)->getRecords();

print_r($response);
die();
