<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file parses the correct page and displayes this for the user. If not it redirects to a 404 page
 */



$database = new database();

//ff

// Laad Discounted product zien op home pagina (untested) 

$DiscountedItems = $database->DBQuery("SELECT StartDate, EndDate, DiscountAmount, DiscountPercentage, StockItemName, SI.StockItemID, SI.UnitPrice FROM specialdeals AS SD JOIN stockitems AS SI ON SD.StockItemID = SI.StockItemID WHERE UTC_DATE BETWEEN StartDate AND EndDate AND StockItemName != ?",[0]);

if($DiscountedItems == 0){
    print("<ul>");
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');    
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');    
    print("</ul>");
}else{ 
    for ($z=0; $z < count($DiscountedItems); $z++){
    print($DiscountedItems[$z]['StockItemName']);
    }
}


// EyeCatchers (Loop is hard coded want PARAM probleem  )

$EyeCatchersRand = $database->DBQuery("SELECT S.StockItemID, S.StockItemName, S.RecommendedRetailPrice, P.Description, S.Photo, SH.QuantityOnHand FROM stockitems AS S JOIN purchaseorderlines AS P ON S.StockItemID = P.StockItemID JOIN stockitemholdings AS SH ON S.StockItemID = SH.StockItemID ORDER BY RAND() LIMIT ?" ,[5]);

for ($x=0; $x < count($EyeCatchersRand); $x++){
    print($EyeCatchersRand[$x]['StockItemName']);
    }


$PopulairProducts = $database->DBQuery("SELECT stockitemid, count(stockitemid) AS aantal FROM orderlines GROUP BY stockitemid ORDER BY aantal DESC LIMIT ?" ,[5]);

for($a=0; $a < $PopulairProducts; $a++){
   // print($PopulairProducts[$a]['StockItemName']);
}

//var_dump($EyeCatchers);
//  print($$EyeCatchers['StockItemName']);

/*
for ($a= 0; $a < 100; $a++) {
    for ($x=0; $x < $EyeCatchers[$a]['StockItemName']; $x++){
    print($EyeCatchers[$x]['StockItemName']);
    }
}
*/