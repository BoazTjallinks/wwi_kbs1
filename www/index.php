<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file parses the correct page and displayes this for the user. If not it redirects to a 404 page
 */

ob_start();
session_start();

// Load Dynamic functions
$functions = scandir('../src/functions/');

// Sanitizes everything
$_GET = filter_var_array($_GET,FILTER_SANITIZE_STRING);
$_POST = filter_var_array($_POST,FILTER_SANITIZE_STRING);
$_SESSION = filter_var_array($_SESSION,FILTER_SANITIZE_STRING);

for ($i=2; $i < count($functions); $i++) {
    require_once('../src/functions/'.$functions[$i]);
}

$query = $_GET['q'];

if ($query == '') {
    header('location: /home');
}

require_once('../src/includes/header.php');

// This checks if file that get's requested exists. If not it redirects the user to a 404 page
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/pages/' . $query . '.php')) {
    require($_SERVER['DOCUMENT_ROOT'] . '/pages/' . $query . '.php');
}
// Redirects user to 404
else {
    require($_SERVER['DOCUMENT_ROOT'] . '/src/error/404.php');
}

require_once('../src/includes/footer.php');

