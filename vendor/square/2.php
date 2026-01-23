<?php
require('autoload.php');

$access_token = "";
SquareConnect\Configuration::getDefaultConfiguration()->setAccessToken($access_token);
/*
echo'<pre>';
var_dump($_POST);
echo '</pre>';
*/

$location_api = new \SquareConnect\Api\LocationsApi();
$country_id = $location_api->listLocations($access_token)->getLocations()[0]->getaddress()->getcountry();
$location_id = $location_api->listLocations($access_token)->getLocations()[0]->getid();
//print_r($location_id); die;

# Helps ensure this code has been reached via form submission
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  error_log("Received a non-POST request");
  echo "Request not allowed";
  http_response_code(405);
  return;
}
# Fail if the card form didn't send a value for `nonce` to the server
$nonce = $_POST['nonce'];
if (is_null($nonce)) {
  echo "Invalid card data";
  http_response_code(422);
  return;
}

// Creating Customers
$customerapi = new \SquareConnect\Api\CustomersApi();
$customer = $customerapi->createCustomer(array(
  'given_name' => $_POST['given_name'],
  'family_name' => $_POST['family_name'],
  'email_address' => $_POST['email'],
  'address' => array(
    'address_line_1' => $_POST['billing_address'],
    'address_line_2' => '',
    'locality' => $_POST['city'],
    'administrative_district_level_1' => '',
    'postal_code' => $_POST['zip_code'],
    'country' => $country_id
  ),
  'phone_number' => $_POST['phone'],
  'reference_id' => '',
  'note' => 'a customer'
));

$customer_id = $customer->getcustomer()->getid(); 
//echo  $nonce; die;
// Creating Customer card
$api = new \SquareConnect\Api\CustomersApi();
$customer_card = $api->createCustomerCard($customer_id, array(
  'card_nonce' => $nonce,
  'billing_address' => array(
    'address_line_1' => $_POST['billing_address'],
    'address_line_2' => '',
    'locality' => $_POST['city'],
    'administrative_district_level_1' => 'CA',
    'postal_code' => $_POST['zip_code'],
    'country' => $country_id
  ),
  'cardholder_name' => 'Amelia Earhart'
));

//print_r($customer_card);
$customer_card_id = $customer_card->getcard()->getid();


// static data
//$customer_id = 'CBASELsrOEQYcSrirUi7zPPrdsAgAQ';
//$customer_card_id = 'f93403b1-21f2-554b-54fe-6dfbcc222e8b';
//$location_id = '';



$idempotencyKey = uniqid();
$transaction_api = new \SquareConnect\Api\TransactionsApi();

$request_body = array (
  "customer_id" => $customer_id,
  "customer_card_id" => $customer_card_id,
  "amount_money" => array (
    "amount" => (int)$_POST['amount'],
    "currency" => "USD"
  ),
  "idempotency_key" => uniqid()
);

//print_r($request_body); 

$result = $transaction_api->charge($location_id, $request_body);
echo "<pre>";
print_r($result);




die;

