<?php

require('autoload.php');

$access_token = "";

SquareConnect\Configuration::getDefaultConfiguration()->setAccessToken($access_token);

// Getting Location
$locations_api = new \SquareConnect\Api\LocationsApi();
$locations =  $locations_api->listLocations();
$location_list = json_decode($locations);
$location_id = $location_list->locations[0]->id;

// Creating Customers
$api = new \SquareConnect\Api\CustomersApi();
$customer = $api->createCustomer(array(
  'given_name' => 'Ravi',
  'family_name' => 'rss',
  'email_address' => 'ravi@doomshell.com',
  'address' => array(
    'address_line_1' => 'VDN',
    'address_line_2' => '',
    'locality' => 'Jaipur',
    'administrative_district_level_1' => 'NY',
    'postal_code' => '94103',
    'country' => 'IN'
  ),
  'phone_number' => '9887164001',
  'reference_id' => '123',
  'note' => 'a customer'
));



$body = '';
$customer_id = 'F820BHHN1S65JW835X1N9F0W9G';
$api = new \SquareConnect\Api\CustomersApi();
$customer_cards = $api->createCustomerCardWithHttpInfo($customer_id, $body);


// Show list of customers
//$api = new \SquareConnect\Api\CustomersApi();
//$customer_list = $api->listCustomers();
//print_r($customer_list); die;
// Show list of customers


echo "<pre>";
print_r($customer_cards); die;


//$cardNonce = 
/*
$cardNonce = 'CBASEDyuQuokxhmryxFBjT1DAzo';


$api = new \SquareConnect\Api\CustomersApi();
$customer_card = $api->createCustomerCard('F820BHHN1S65JW835X1N9F0W9G', array(
  'card_nonce' => $cardNonce,
  'billing_address' => array(
    'address_line_1' => '1455 Market St',
    'address_line_2' => 'Suite 600',
    'locality' => 'San Francisco',
    'administrative_district_level_1' => 'CA',
    'postal_code' => '94103',
    'country' => 'US'
  ),
  'cardholder_name' => 'Amelia Earhart'
));


echo "<pre>";
print_r(customer_card); 

*/











?>