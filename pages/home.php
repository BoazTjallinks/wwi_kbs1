<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file parses the correct page and displayes this for the user. If not it redirects to a 404 page
 */



$database = new database();

// Laad Discounted product zien op home pagina (unfinished) 


/*
$discountedItems = $database->DBQuery("SELECT StartDate, EndDate, DiscountAmount, DiscountPercentage, StockItemName, SI.StockItemID, SI.RecommendedRetailPrice	
FROM specialdeals AS SD 
JOIN stockitems AS SI 
ON SD.StockItemID = SI.StockItemID 
WHERE UTC_DATE BETWEEN StartDate AND EndDate AND StartDate != ?",[1]);
*/

/*
$discountedItems = $database->DBQuery("SELECT StartDate, EndDate, DiscountAmount, DiscountPercentage, DealDiscription,  SI.StockItemName, SI.StockItemID, SI.RecommendedRetailPrice
FROM specialdeals AS SD 
LEFT JOIN stockitems AS SI 
ON SD.StockItemID = SI.StockItemID
WHERE  StartDate != ?",[8]);
*/
/*
$InTheNameOfPHPTestQuery= $database-->DBQuery("SELECT RecommendedRetailPrice, UnitPrice FROM StockItems" ,[]);
//var_dump($discountedItems);

if(isset($InTheNameOfPHPTestQuery[8]['RecommendedRetailPrice'])){
$InTheNameOfPHPTestQuery = ($InTheNameOfPHPTestQuery[8]['RecommendedRetailPrice'] - $InTheNameOfPHPTestQuery[8]['UnitPrice']);
print($InTheNameOfPHPTestQuery);
}
//$discountPrice = ($discountedItems[]['RecommendedRetailPrice'] - $discountedItems[]['DiscountAmount']);

*/


//print($discountedItems[1]['StockItemName']);
//print($discountedItems[1]['StartDate']);    
/*

//berekent de prijs met korting
$discountPrice= $row['SI.UnitPrice'] - $row['DiscountAmount'];

// Calculates the remaining time of the deal duration //

$dealDayRemaining=round((($dealTime/24)/60)/60);
$dealTime =($row['EndDate'] - date('Y-m-d'));
print($dealTime);

*/

// (unfinished laad korting producten nog niet in) 
/*
if($discountedItems == 0){
    print("<ul>");
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');    
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');
    print('<li> new items soon </li>');        
    print("</ul>");
}else{ 
    for ($z=0; $z < 6; $z++){

        $getimg = $database->DBQuery('SELECT * FROM picture WHERE stockitemid = ? AND isPrimary IS NOT NULL', [$discountedItems[$z]['stockitemid']]);
        if ($getimg == '0 results found!') {
            $img = '/public/img/products/no-image.png';
        }
        else {
            $img = $getimg[0]['ImagePath'];
        }
        
        showItem($discountedItems[$z]['stockitemid'], $img, $discountedItems[$z]['stockitemname'], '', $discountedItems[$z]['searchdetails'], $discountedItems[$z]['recommendedretailprice']);    

}
}

*/


// populaire producten (geen description)
$PopularProducts = $database->DBQuery("SELECT stockitemname, recommendedretailprice, searchdetails,  ol.stockitemid, count(ol.stockitemid) AS aantal FROM orderlines AS ol JOIN stockitems AS si ON ol.stockitemid = si.stockitemid GROUP BY ol.stockitemid ORDER BY aantal DESC LIMIT ?" ,[6]);

//$PopulairProducts = 0;

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





