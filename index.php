<?php

// Include bootstrap loader instead of files if you want
require 'vendor/autoload.php';

use Zoho\CRM\Entities\Lead;
use Zoho\CRM\ZohoClient;

//ZohoCRM.modules.all,ZohoCRM.users.all --> The scope we need to use now

$ZohoClient = new ZohoClient();

$ZohoClient->setModule('Leads');

// $ZohoClient->generateAccessTokenByGrantToken();

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
