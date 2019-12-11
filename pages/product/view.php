<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * View item page
 */

if (!isset($_GET['id']) && !is_numeric($_GET['id'])) {
    header('location: /home');
}

$database = new database();
$fetchItem = $database->DBQuery("SELECT DISTINCT S.StockItemID, S.StockItemName, S.RecommendedRetailPrice, P.Description, SH.QuantityOnHand FROM stockitems AS S JOIN purchaseorderlines AS P ON S.StockItemID = P.StockItemID JOIN stockitemholdings AS SH ON S.StockItemID = SH.StockItemID WHERE S.StockItemID = ? ORDER BY S.StockItemID;",[$id]);

$soldOut = false;

$stockItemID = $result[0]["StockItemID"];
$stockItemName = $result[0]["StockItemName"];
$recomretprice  = $result[0]["RecommendedRetailPrice"];
$description = $result[0]["Description"];
$video = "<iframe width=\"560\" height=\"315\" src=\"https:'//'www.youtube-nocookie.com/embed/dQw4w9WgXcQ?start=42\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
#$video = $result[0]["[HIER DE ROUTE NAAR DE VIDEO]"];

$GetStockItemHolding = $result[0]["QuantityOnHand"];
//zorgt ervoor dat er verschillende kleuren worden gebruikt bij een X hoeveelheid stockitems
if($GetStockItemHolding > 15){
    $stockItemHolding = "Enough in stock for you to order!";
    $styleColor = "style=\"\"";
}elseif(($GetStockItemHolding <= 15) AND ($GetStockItemHolding > 5)){
    $stockItemHolding = "Only <strong>".$GetStockItemHolding."</strong> left! Order Now!";
    $styleColor = "style=\"background-color: orange;\"";
}elseif(($GetStockItemHolding <= 5) AND ($GetStockItemHolding >0)){
    $stockItemHolding = "Nearly sold out! Only <strong>".$GetStockItemHolding."</strong> left! Order Now!";
    $styleColor = "style=\"background-color: red;\"";
}else{
    $stockItemHolding = "Out of stock!";
    $styleColor = "style=\"background-color: grey;\"";
    $soldOut = true;
}

$photoPath = "../../public/img/products/id".$id.".png";

if(file_exists($photoPath)){                                    
    $photo = $photoPath;
}else{
    $photo = "../../public/img/products/no-image.png";
}

