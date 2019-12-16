<?php


require('../c/vendor/autoload.php');
require('../c/examples/functions.php');



// require_once __DIR__ . "/vendor/autoload.php";
// require_once __DIR__ . "/examples/functions.php";
/*
 * Initialize the Mollie API library with your API key.
 *
 * See: https://www.mollie.com/dashboard/developers/api-keys
 */


$mollie = new \Mollie\Api\MollieApiClient();
// var_dump($mollie);
$mollie->setApiKey("test_fHfgFwJuQsT42u5kRRsTUA2MgP2usS");

$payment = $mollie->payments->create([
    "amount" => [
        "currency" => "EUR",
        "value" => "10.00"
    ],
    "description" => "My first API payment",
    "redirectUrl" => "https://webshop.example.org/order/12345/",
    "webhookUrl"  => "https://webshop.example.org/mollie-webhook/",
]);

var_dump($payment);


?>