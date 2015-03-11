<?php

/*
* Hello-Paisa Merchant API: PHP-sample code.
*/

// import the nusoap library.
require_once('/lib/nusoap.php');
$transactionID = "";

//crete a client object for the Web-Service (i.e Hello Paisa Payment API)
$client = new nusoap_client('http://110.44.114.210:8080/PaymentHandler/coreApi?wsdl',TRUE);

// defining the request parameters
$requestParameters = array('id' => 'merchant-id-provided',
'mobile' => 'mobile-no-of-the-customer',
'pin' => 'secret code of the merchant',
'serviceCode' => '23′, // payment service code
'value' => 10.0 // Transaction Amount
);

// Initiate the transaction request,
$resultRequest = $client->call("initiatePayment", array('arg0′ => $requestParameters));
// Check for a fault
if ($client->fault) {
echo '<h2>Fault</h2><pre>';
print_r($resultRequest);
echo '</pre>';
} else {
// Check for errors
$err = $client->getError();
if ($err) {
// Display the error
echo '<h2>Error</h2><pre>' . $err . '</pre>';
} else {
// Display the result
//result of the transaction request
echo '<h2>Result</h2><pre>';
print_r($resultRequest);

$requestResponse[] = 'HelloPaisa';
foreach($resultRequest['return'] as $requestReturn)
{
// print_r($r);
array_push($requestResponse, $requestReturn);
echo '</br>';
}
var_dump($requestResponse);
$transactionID = $requestResponse[2];
echo $transactionID;

}
}

// Verify the transaction ,

//Note: It's recommended to check the verification after about 30 seconds, and continue to check //verification until you get a concrete response code  or some timeout.

//eg. response code of: 9004,9005,9006 and validity = true, indicates that the call is in progress.
$transactionID = 'id-returned-from-the-transaction-request';
// call verify method with the parameter of the transaction-id returned from the transaction-request.
$resultVerifyTransaction = $client->call("verifyTransaction",array('arg0′ => $transactionID));

//array to hold the response from the verification
$responseVerify[] = 'CheckVerification';

foreach($resultVerifyTransaction['return'] as $verifyReturn)
{
array_push($responseVerify, $verifyReturn);
}
// here is the outputs from the verifications.
$validity = $responseVerify[3];
$error_description = $responseVerify[1];
if($error_description == '0′ && $validity == 'true')
{
echo 'Transaction Success';
}
else
{
echo 'Transaction Failed';
}
var_dump($responseVerify);
?>