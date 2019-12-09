<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file parses the correct page and displayes this for the user. If not it redirects to a 404 page
 */
$database = new database();

// Insert query
$insertNewCustomer = $database->DBQuery('INSERT INTO webCustomer (wCustomerEmail, wCustomerPassword, wCustomerPerms) values (?, ?, 0)', ['testemail@gmail.com', 'testpassword']);

print_r($insertNewCustomer);

$database->closeConnection();