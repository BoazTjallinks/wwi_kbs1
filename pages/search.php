<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file searches through the file
 */

// Checks query $_GET variable and redirects if not
if (!isset($_GET['Searchquery'])) {
    header('location: /search?Searchquery=');
}

$productName = $_GET['Searchquery'];

$database = new database();
$result = $database->DBQuery("SELECT * FROM stockitems WHERE StockItemName LIKE CONCAT('%',?,'%') OR StockItemID LIKE CONCAT('%',?,'%') OR SearchDetails LIKE CONCAT('%',?,'%');", [$productName, $productName, $productName]);

for ($i=0; $i < count($result); $i++) { 
    print_r("<a href='/productview?id=".$result[$i]['StockItemID']."'>" . $result[$i]['StockItemName'] . "</a> -- ");
    print_r($result[$i]['SearchDetails']. '<br>');
}

