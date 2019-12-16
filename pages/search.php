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
    print('<div class="row container wwi_center">');
    for ($i=0; $i < count($result); $i++) {
        $getimg = $database->DBQuery('SELECT * FROM picture WHERE StockItemID = ? AND isPrimary IS NOT NULL', [$result[$i]['StockItemID']]);
        if ($getimg == '0 results found!') {
            $img = '/public/img/products/no-image.png';
        }
        else {
            $img = $getimg[0]['ImagePath'];
        }

        showItem($result[$i]['StockItemID'], $img, $result[$i]['StockItemName'], '', $result[$i]['SearchDetails'], $result[$i]['RecommendedRetailPrice']);
    }
    print('</div>');
}

