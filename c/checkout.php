<?php
/* ------------------- OUDE CHECKOUT, NIET GEBRUIKEN, NIET VERWIJDEREN ---------------------*/
// print("<!-- <form action='/checkout.php' method='POST'><select name='Kies uw bank'><option>Kies uw bank..</option><option value='ABN AMRO'>ABN AMRO</option><option value='ASN Bank'>ASN Bank</option><option value='Handelsbanken'>Handelsbanken</option><option value='ING'>ING</option><option value='Knab'>Knab</option><option value='Moneyou'>Moneyou</option><option value='Rabobank'>Rabobank</option><option value='RegioBank'>RegioBank</option><option value='SNS'>SNS</option><option value='Triodos Bank'>Triodos Bank</option><option value='Van Lanschot'>Van Lanschot</option><option value='bunq'>bunq</option></select><br><input type='submit' value='Verder'></form> -->");
// $abnamro = $_POST['ABN AMRO'];// $asnbank = $_POST['ASN Bank'];// $handelsbanken = $_POST['Handelsbanken'];// $ing = $_POST['ING'];// $knab = $_POST['Knab'];// $moneyou = $_POST['Moneyou'];// $rabobank = $_POST['Rabobank'];// $regiobank = $_POST['RegioBank'];// $sns = $_POST['SNS'];// $triodosbank = $_POST['Triodos Bank'];// $vanlanschot = $_POST['Van Lanschot'];// $bunq = $_POST['bunq'];// $verder = $_POST['Verder'];
// if(!isset($verder)){//     if(isset($abnamro)){//         echo('Gaat u verder');//         header('Location: /home');//     }else{//         echo('Kies een bank!');//     }// }
/* ------------------- OUDE CHECKOUT, NIET GEBRUIKEN, NIET VERWIJDEREN ---------------------*/





/*
 * Make sure to disable the display of errors in production code!
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/examples/functions.php";
/*
 * Initialize the Mollie API library with your API key.
 *
 * See: https://www.mollie.com/dashboard/developers/api-keys
 */


$mollie = new \Mollie\Api\MollieApiClient();
var_dump($mollie);
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




