<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file parses the correct page and displayes this for the user. If not it redirects to a 404 page
 */



$database = new database();

//Laad StockCategories in 
$getstockgroups = $database->DBQuery("SELECT stockgroupname, stockgroupID FROM stockgroups WHERE stockgroupID != ?",[2]);

for($i=0; $i<count($getstockgroups); $i++){
    print($getstockgroups[$i]['stockgroupname']);
    }


// Laad Discounted product zien op home pagina (unfinished) 
// Dit is de werkende versie die filtered op de datum van nu DESCRIPTION toevogen

$discountedItems = $database->DBQuery("SELECT StartDate, EndDate, DiscountAmount, DiscountPercentage, StockItemName, SD.StockItemID, SI.RecommendedRetailPrice	
FROM specialdeals AS SD 
LEFT JOIN stockitems AS SI 
ON SD.StockItemID = SI.StockItemID 
WHERE UTC_DATE BETWEEN StartDate AND EndDate AND StartDate != ?",[1]);

    
// BEREKENT PRIJS CORRECT
/*
for($b=0; $b < 6; $b++){
    $discountPrice= ($discountedItems[$b]['RecommendedRetailPrice'] - $discountedItems[$b]['DiscountAmount']);
    print($discountPrice);
    }
*/


//TEST QUERYS
/*

//deze laad bestaande deals in  
$discountedItems = $database->DBQuery("SELECT StartDate, EndDate, DiscountAmount, DiscountPercentage, SI.StockItemName, SI.StockItemID, SI.RecommendedRetailPrice
FROM specialdeals AS SD 
LEFT JOIN stockitems AS SI 
ON SD.StockItemID = SI.StockItemID
WHERE  StartDate != ?",[0]);

print($discountedItems[1]['StockItemName']); // Deze is niet bestaand en laat niets zien
//print($discountedItems[1]['StartDate']);     // deze bestsaat wel

// Test Query    voor korting berekenen

$TestQuery= $database->DBQuery("SELECT RecommendedRetailPrice, UnitPrice FROM stockitems WHERE UnitPrice != ?;",[0]);
if(isset($TestQuery[1]['RecommendedRetailPrice'])){
$TestQuerySom = ($TestQuery[1]['RecommendedRetailPrice'] - $TestQuery[1]['UnitPrice']);
print($TestQuerySom);
  }


//berekent de prijs met korting maar niet correcte versie {
    for($b=0; $b < 6; $b++){
$discountPrice= ($TestQuery[$b]['RecommendedRetailPrice'] - $TestQuery[$b]['UnitPrice']);
print($discountPrice);
    }
*/


// (unfinished laad korting producten nog niet in) 

if($discountedItems !== 0  && $discountedItems[0]['StockItemID'] !== 0){
    for($b=0; $b < 6; $b++){
        $discountPrice = ($discountedItems[$b]['RecommendedRetailPrice'] - $discountedItems[$b]['DiscountAmount']);
        print($discountPrice);
    }
}else{  
    print("<ul>");
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');           
    print("</ul>");
}



// populaire producten
$PopularProducts = $database->DBQuery("SELECT stockitemname, recommendedretailprice, searchdetails,  ol.stockitemid, count(ol.stockitemid) AS aantal FROM orderlines AS ol JOIN stockitems AS si ON ol.stockitemid = si.stockitemid GROUP BY ol.stockitemid ORDER BY aantal DESC LIMIT ?" ,[6]);


if($PopularProducts == !0){
for($a=0; $a < 6; $a++){

$getimg = $database->DBQuery('SELECT * FROM picture WHERE stockitemid = ? AND isPrimary IS NOT NULL', [$PopularProducts[$a]['stockitemid']]);
if ($getimg == '0 results found!') {
    $img = '/public/img/products/no-image.png';
}
else {
    $img = $getimg[0]['ImagePath'];
}

showItem($PopularProducts[$a]['stockitemid'], $img, $PopularProducts[$a]['stockitemname'], '', $PopularProducts[$a]['searchdetails'], $PopularProducts[$a]['recommendedretailprice']);    
}
}else{
    print("Popular products are temporarily unavailable ");
} 


