**Zoho** CRM library for PHP
=============================

The Zoho CRM library is a simple wrapper around Zoho API

At MC we work a lot with Zoho and we found ourself repeating the same patter over and over that's why we build this library.

Installation
------------

Using composer, execute the following command to add the requirement to your `composer.json`

    $ composer require mctekk/zohocrm:^0.1

Let's start
-----------

Zoho API V2 has change the wey they handle connecto to the API,  it now uses OAuth instead of just simple private and public keys we usted to have in v1. So you will need to do the following to get this library to work

- Register a Zoho Client via its Developer Console [https://api-console.zoho.com/]
- Make sure to elect Web Based App and Follow this tutorial https://www.zoho.com/crm/developer/docs/api/register-client.html
- Once you have the Client ID and Its Secret we will need to generate a refresh_token
- To generate the refresh_token you will need to visit , change {client_id} with the client id and redirect_uri with the value you configure the cliente
  - https://accounts.zoho.com/oauth/v2/auth?scope=ZohoCRM.modules.ALL&client_id={client_id}&response_type=code&access_type=offline&redirect_uri={redirect_uri}
- This URL will redirect to the client URI with a query string code 
- Take the code query string and make a POST https://accounts.zoho.com/oauth/v2/token sending 
  - grant_type : authorization_code
  - client_id : {client_id}
  - client_secret : {client_secret}
  - redirect_uri : {redirect_uri}
  - code : {code}
- This final request will provide you with the refresh_token .
- Set client_id, client_secret and refresh_token on .env and the package will handle the rest

*Todo* In future version we will add the refresh_token generator directly as a php script

```php
<?php

use Zoho\CRM\ZohoClient;


$ZohoClient = new ZohoClient(); // Make the connection to zoho api
$ZohoClient->setAuthRefreshToken(getenv('ZOHO_AUTH_REFRESH_TOKEN'));
$ZohoClient->setZohoClientId(getenv('ZOHO_CLIENT_ID'));
$ZohoClient->setZohoClientSecret(getenv('ZOHO_CLIENT_SECRET'));
$refresh = $ZohoClient->generateAccessTokenByRefreshToken();
//or with redis $ZohoClient->manageAccessTokenRedis($redis);

$this->zohoClient->setModule('Leads');

$lead = new Lead();

$request = [
	'First_Name' => 'Test',
	'Last_Name' => 'Zoho',
	'Phone' => '000000000',
	'Email' => 'testzoho@mctekk.com'
];

$response = $this->zohoClient->insertRecords(
	$request,
	['wfTrigger' => 'true']
);

$response->getResponseData();

```

The above values of the **$request** array can be taken from POST if you are using forms in landing page :D, just be sure that all the keys(name of the field on html) in the array have to be valid properties in the entity Lead of zoho, default properties can be found on documentation [here](https://www.zoho.com/crm/help/api/modules-fields.html#Leads) or make sure that those properties exist in your account if you custom your Lead on Zoho; the following convention are made:

- Name of fields are not CamelCase.
- Name with space between words, space is substituted by an "_".
- Need to clean(unset) from the array all the values that are not part of the entity, if you don't wanna make this, create another clean array.

Users of the .eu domain (i.e. your CRM URL is crm.zoho.eu, rather than crm.zoho.com) should call `setEuDomain()` after instantiating ZohoClient, i.e.

```php
$ZohoClient = new ZohoClient(); // Make the connection to zoho api
$ZohoClient->setAuthRefreshToken(getenv('ZOHO_AUTH_REFRESH_TOKEN'));
$ZohoClient->setZohoClientId(getenv('ZOHO_CLIENT_ID'));
$ZohoClient->setZohoClientSecret(getenv('ZOHO_CLIENT_SECRET'));
$refresh = $ZohoClient->generateAccessTokenByRefreshToken();
$ZohoClient->setEuDomain();
$ZohoClient->setModule('Leads'); // Set the module
```
