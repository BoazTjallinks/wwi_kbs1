<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * Shows al items in categorie
 */

$function = new cat();
$database = new database();

$function->checkGetParams();
$function->checkFilterSession();

$cat = $_GET['catid'];
$page = $_GET['page'];
$limit = $_SESSION['limit'];
$colorId = $_SESSION['colorid'];
$minPrice = $_SESSION['minprice'];
$maxPrice = $_SESSION['maxprice'];
$size = $_SESSION['size'];

$_SESSION['maxprice'] = 1;

$fetchStockCategories = $database->DBQuery('SELECT * FROM stockitems si JOIN stockitemstockgroups sisg ON si.StockItemID = sisg.StockItemID WHERE sisg.StockGroupID in (SELECT StockGroupID FROM stockgroups WHERE StockGroupID = ?) LIMIT ?', [$cat, $limit]);
$sessionOptions = $function->getOptions();

for ($i=0; $i < count($sessionOptions); $i++) { 
    if ( $_SESSION[$sessionOptions[$i]] !== $function->getDefaultnr($sessionOptions[$i]) ) {
        echo $_SESSION[$sessionOptions[$i]]."</br>";
        echo $function->getDefaultnr($sessionOptions[$i])."</br>";
        echo $sessionOptions[$i].'</br></br>';
    }
}

// while ($row = mysqli_fetch_assoc($fetchStockCategories)) {
//     echo $row['StockItemID'].'</br>';
// }