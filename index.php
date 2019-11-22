<?php

// Include bootstrap loader instead of files if you want
require 'vendor/autoload.php';

use Zoho\CRM\Entities\Lead;
use Zoho\CRM\ZohoClient;

//ZohoCRM.modules.all,ZohoCRM.users.all --> The scope we need to use now

$ZohoClient = new ZohoClient();

$ZohoClient->setAuthRefreshToken('1000.5c4728219eb163a276d47132143a9257.de9ff3dfb628ca36c22240a5fbb529d8');
$ZohoClient->setZohoClientId('1000.NCUTHYFLRLZYRX57IMA205E1UBDUFH');
$ZohoClient->setZohoClientSecret('53d352fd313851fc558de0595039a03950b5d1cba5');
$refresh = $ZohoClient->generateAccessTokenByRefreshToken();

// print_r($refresh);
// die();

$ZohoClient->setModule('Leads');

// $ZohoClient->generateAccessTokenByGrantToken();

// $refresh = $ZohoClient->generateAccessTokenByRefreshToken();

// $response = $ZohoClient->getRecords();

// $response = $ZohoClient->getRecordById('2896936000050692283');

// $response = $ZohoClient->searchRecords('(Email:c00000exa27@sharklasers.com)')->getRecords();

// for ($i = 0; $i < 5; $i++) {
//     for ($j = 0; $j < 7; $j++) {
//         // $response = $ZohoClient->searchRecords('(Email:c00000exa5@sharklasers.com)')->getRecords();
//         $refresh = $ZohoClient->generateAccessTokenByRefreshToken();
//         var_dump($refresh);
//         sleep(1);
//     }
//     sleep(5);
// }

// die();

$lead = new Lead();

// Receiving request
// $request = [
//     'first_name' => 'Test32',
//     'last_name' => 'Test2',
//     'email' => 'aisrxysjz49@sharklasers.com',
//     'phone' => '4043122124257'
// ];

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

// print_r($request);
// die();

$data = $lead->deserializeXml($lead->serializeXml($request));

// print_r($data);
// die();

$response = $ZohoClient->insertRecords($data, ['wfTrigger' => 'true']);
// $response = $ZohoClient->updateRecords('2896936000050971263', $data, ['wfTrigger' => 'true']);

// $ZohoClient->setModule('Users');
// $response = $ZohoClient->getUsers('AllUsers', 1)->getRecords();

// print_r($refresh);
print_r($response);
die();
