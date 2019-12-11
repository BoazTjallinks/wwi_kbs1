<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file searches through the file
 */

// Checks query $_GET variable and redirects if not
if (!isset($_GET['query'])) {
    header('location: /search?query=');
}

$productName = $_GET['query'];

$database = new database();
$result = $database->DBQuery("SELECT * FROM stockitems WHERE StockItemName LIKE CONCAT('%',?,'%') OR StockItemID LIKE CONCAT('%',?,'%') OR SearchDetails LIKE CONCAT('%',?,'%')", [$productName]);

while ($row = $result) {
    print_r("<a href='/productpagecode?id=".$row['StockItemID']."'>" . $row['StockItemName'] . "</a> -- ");
    print_r($row['SearchDetails']. '<br>');
}

