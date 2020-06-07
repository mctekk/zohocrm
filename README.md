**Zoho** CRM library for PHP
=============================

The Zoho CRM library is a simple wrapper around Zoho API

At MC we work a lot with Zoho and we found ourself repeting the same patter over and over that's why we build this library.

Installation
------------

Using composer, execute the following command to add the requirement to your `composer.json`

    $ composer require mctekk/zohocrm:^0.1

Let's start
-----------
The first thing that you have to do is use the namespaces for access to all the classes of the package, then, there are two fases for begin with the interaction:

1. Wrap values from array to entity, this have restrictions for the names of the fields, continue reading

```php
<?php

// Include your autoloader for php files of composer

use Zoho\CRM\ZohoClient,
	Zoho\CRM\Entities\Lead,
	Zoho\CRM\Exception\ZohoCRMException
	;

$request = array(
	'first_name' => 'Test_fname',
	'last_name' => 'Test_lname',
	'email' => 'test@test.com',
	'phone' => '809789654'
);

// From array we need to clean its keys
$lead = new Lead();
$data = $lead->cleanParams($request);

```

The above values of the **$request** array can be taken from POST if you are using forms in landing page :D, just be sure that all the keys(name of the field on html) in the array have to be valid properties in the entity Lead of zoho, default properties can be found on documentation [here](https://www.zoho.com/crm/help/api/modules-fields.html#Leads) or make sure that those properties exist in your account if you custom your Lead on Zoho; the following convention are made:

- Name of fields are not CamelCase.
- Name with space between words, space is substituted by an "_".
- Need to clean(unset) from the array all the values that are not part of the entity, if you dont wanna make this, create another clean array.

Now the next part is interact with zoho api using the client, first thing, create a `ZohoClient` with your authtoken valid: **Set the module**, for now just Leads, on future or contributing the [missing modules](https://www.zoho.com/crm/help/api/modules-fields.html)

```php
use Zoho\CRM\ZohoClient;


$ZohoClient = new ZohoClient(); // Make the connection to zoho api
$ZohoClient->setAuthRefreshToken(getenv('ZOHO_AUTH_REFRESH_TOKEN'));
$ZohoClient->setZohoClientId(getenv('ZOHO_CLIENT_ID'));
$ZohoClient->setZohoClientSecret(getenv('ZOHO_CLIENT_SECRET'));
$refresh = $ZohoClient->generateAccessTokenByRefreshToken();

$ZohoClient->setModule('Leads'); // Set the module

```

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

The last part if make the call, `$data` content returned by `cleanParams(Lead $lead)` is gonna be the array that will be send to zoho, this is the final json string created before the call to ws

Now make the call to ws and get the response object:
```php
$response = $ZohoClient->insertRecords($data);
```

The object Response returned in located in `Zoho\CRM\Request`, contain the code, message, method, module, records, record id, uri and xml returned by zoho, this can be accessed by getters.

Hope that can be useful :)

---

Added support for embedded entities/objects

Example [source https://www.zoho.com/crm/help/api/insertrecords.html#SalesOrders](source https://www.zoho.com/crm/help/api/insertrecords.html#SalesOrders):
```php
$product = new Product;
$product->Product_Id = 2000000017001;
$productDetail->Unit_Price = 10.0;
$productDetail->Quantity   = 1.0;
$productDetail->Total      = 123.0;
$productDetail->Discount   = 1.23;
$productDetail->List_Price = 123.0;
$productDetail->Net_Total  = 121.77;


$salesOrder->Product_Details = ['product' => [$product]];
```
