Zoho CRM library for PHP 5.5+
=============================

The Zoho CRM library is a specialized xml, json wrapper for make request to zoho API, base on another vendor from [vaish](https://github.com/vaish/zohocrm-php), but this have some overpower :p.

I often found myself repeating the same pattern for xml | json manipulation with this API over and over. This library implements that pattern.

At it's heart, the library maps xml string to entity classes elements for interact like PHP value objects.

The following assumptions are made:

* XML namespaces are used everywhere using psr-0 for autoload class, same with composer.
* All XML elements map to entities PHP classes.
* Elements are represented by classes entities. A class(entity) extends of `Zoho\CRM\Wrapper\Element`, this gives you the ability to access the inherited method "deserializeXml()" for conver the values of xml into the object.

This is not your average XML library. The intention is not to make this super
simple, but rather very powerful for complex XML applications.

Installation
------------

Using by composer, just add this parameters to your `composer.json` 

    "mctekk/zohocrm": "dev-master"

Then, run `$ composer update` and you should be good.

Let's start
-----------
The first thing that you have to do is use the namespaces for access to all the classes of the package, then, there are two fases for begin with the interaction:

1. Wrap values from array to entity, this have restrictions for the names of the fields, continue reading
2. If you already have your entity with values, just jump to [Mapping XML to entities elements](#mapping-xml-to-entities-elements)

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

// From array values to xml valid entity string
$lead = new Lead();
$xmlstr = $lead->serializeXml($request);
```
At this part you have an **xvseL** (xml valid string entity Lead), this is nothing more than and entity Lead prepared for be parse to object, something like this:

```xml
<Lead>
  <First_Name>Test_fname</First_Name>
  <Last_Name>Test_lname</Last_Name>
  <Phone>809789654</Phone>
  <Email>test@test.com</Email>
  <Programs>Unspecified</Programs>
</Lead>
```

The above values of the **$request** array can be taken from POST if you are using forms in landing page :D, just be sure that all the keys(name of the field on html) in the array have to be valid properties in the entity Lead of zoho, default properties can be found on documentation [here](https://www.zoho.com/crm/help/api/modules-fields.html#Leads) or make sure that those properties exist in your account if you custom your Lead on Zoho; the following convention are made:

- Name of fields are not CamelCase.
- Name with space between words, space is substituted by an "_".
- Need to clean(unset) from the array all the values that are not part of the entity, if you dont wanna make this, create another clean array.


Mapping XML to entities elements
--------------------------------

Normally when writing an entity class parser using this tool, there will be a number of elements that make sense to create using classes for.

A great example would be the `Lead` entity, is part by default of the package, can be found inside `Zoho\CRM\Entities\Lead` element:

```php
class Lead
{
	/**
	 * Zoho CRM user to whom the Lead is assigned.
	 * 
	 * @var string
	 */
	private $Lead_Owner;

	/**
	 * Salutation for the lead
	 * 
	 * @var string
	 */	
	private $Salutation;
	
	/**
	 * First name of the lead
	 * 
	 * @var string
	 */	
	private $First_Name;
	
	/**
	 * The job position of the lead
	 * 
	 * @var string
	 */	
	private $Title;

	/* etc, others fields... */
}	
```

You can use this entity like a been, and make your own implementation of XML assings, but if you wanna use this for mapping xml, it recommended extends the entity of `Zoho\CRM\Wrapper\Element`, something like this:

```php
use Zoho\CRM\Wrapper\Element;

class Lead extends Element
{
	/* ...fields... */
}	
```

Now for load the **xvseL** into the object Lead just call the method of the parent `deserializeXml(string $xvsel)`:

```php
use Zoho\CRM\Entities\Lead;

$xvsel = '
<Lead>
  <First_Name>Test_fname</First_Name>
  <Last_Name>Test_lname</Last_Name>
  <Phone>809789654</Phone>
  <Email>test@test.com</Email>
  <Programs>Unspecified</Programs>
</Lead>';

$lead = new Lead();
if($lead->deserializeXml($xvsel))
{
	// Nice, now you have the entity with the values loaded from a string, F**k yeah..!
	/* Remember that you can set more parameters to the entity
	$lead->Lead_Owner = 'Test Owner Martinez';
	$lead->Lead_Source = 'http://someweirdsite.xxx';
	$lead->Member = '0001'; // This can be setted too :D
	*/
	echo 'Success, continue using your entity, the xvsel was parsed great...!';
}else
	echo 'The xml could not be parsed, please check the syntax';
}
```
Now the next part is interact with zoho api using the client, first thing, create a `ZohoClient` with your authtoken valid: **Set the module**, for now just Leads, on future or contributing the [missing modules](https://www.zoho.com/crm/help/api/modules-fields.html)

```php
use Zoho\CRM\ZohoClient;

$ZohoClient = new ZohoClient('YOUR_TOKEN'); // Make the connection to zoho api
$ZohoClient->setModule('Leads'); // Set the module

$validXML = $ZohoClient->mapEntity($lead); // Entity lead created with $xvsel
```

The last part if make the call, `$validXML` content returned by `mapEntity(Lead $lead)` is gonna be the xml that will be send to zoho, this is the final string created before the call to ws

Now make the call to ws and get the response object:
```php
$response = $ZohoClient->insertRecords($validXML);
```

The object Response returned in located in `Zoho\CRM\Request`, contain the code, message, method, module, records, record id, uri and xml returned by zoho, this can be accessed by getters.

Hope that can be useful :)