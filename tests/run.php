<?php

// Include bootstrap loader
require_once '/home/composer/public_html/zohocrm-php/vendor/autoload.php';

use Zoho\CRM\Entities\Lead;

// Create the client
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


$lead = new Lead();
$lead->deserializeXml($xmlstr);

echo $lead->LendioRepresentative."\n";
echo $lead->Email."\n";
echo $lead->Address->Street."\n";
