<?php
$database = new database();
if(!isset($_GET['page'])){
    header('location: /orderhistory?page=1');
}


// if(isset($_SESSION['isloggedIn'])){
//     $usertoken = $_SESSION['isloggedIn'];
// }else{
//     echo 'Please login first to check your order history';
// }

$page = $_GET['page'];
$offset = $page * 7 - 7;
$orderDetailsAll= $database->DBQuery("SELECT O.OrderID, O.OrderDate, OL.StockItemID, OL.Quantity, S.StockItemName, S.RecommendedRetailPrice, S.TaxRate
FROM orders O 
JOIN orderlines OL ON O.OrderID = OL.OrderID
JOIN stockitems S ON OL.StockItemID = S.StockItemID
WHERE O.CustomerID = ?
GROUP BY O.OrderID
ORDER BY O.OrderDate DESC", [832]);


$orderDetails= $database->DBQuery("SELECT O.OrderID, O.OrderDate, OL.StockItemID, OL.Quantity, S.StockItemName, S.RecommendedRetailPrice, S.TaxRate
FROM orders O 
JOIN orderlines OL ON O.OrderID = OL.OrderID
JOIN stockitems S ON OL.StockItemID = S.StockItemID
WHERE O.CustomerID = ?
GROUP BY O.OrderID
ORDER BY O.OrderDate DESC
LIMIT ? OFFSET ? ", [832, 10, $offset]); 

$itemsNotSold= $database->DBQuery("SELECT DISTINCT SA.StockItemName, SA.RecommendedRetailPrice, SA.TaxRate FROM orders O JOIN orderlines OL ON O.OrderID = OL.OrderID JOIN stockitems_archive SA ON OL.StockItemID = SA.StockItemID WHERE O.CustomerID = ?", [832]);


if($orderDetails == '0 results found!'){
    echo 'No orders found.';
}else{
    for($i = 0; $i < count($orderDetails); $i++){
        $getimg = $database->DBQuery('SELECT * FROM picture WHERE StockItemID = ? AND isPrimary IS NOT NULL', [$orderDetails[$i]['StockItemID']]);
            if ($getimg == '0 results found!') {
                $img = '/public/img/products/no-image.png';
            }
            else {
                $img = $getimg[0]['ImagePath'];
            }
        echo '<figure class="figure"><img class="img-fluid figure-img wwi-itemimg_nowith" src="'.$img.'"></figure>';
        echo $orderDetails[$i]['OrderID'];
        if(isset($orderDetails[$i]['StockItemID'])){
            echo "<a href='/productview?id=".$orderDetails[$i]['StockItemID']."'>".$orderDetails[$i]['StockItemName']."</a>";
        }else{
            echo $itemsNotSold[$i]['StockItemName'];
        }
        echo $orderDetails[$i]['OrderDate'];
        echo '</br>';
        echo "<a href='/orderdetails?OrderID=".$orderDetails[$i]['OrderID']."'>More details</a>";
    }
}
print(count($orderDetailsAll));
$maxPages = ceil(count($orderDetailsAll) / 7);
print($maxPages);
$minPages = 1;
$pagemin = $page - 1;
$pageminTwo = $page - 2;
$pageplusTwo = $page + 2;
$mpagemin = $maxPages - 1;
$mpageminTwo = $maxPages - 2;
$mpageminThree = $maxPages - 3;
$pageplus = $page + 1;
$mpageplus = $minPages + 1;
$mpageplusTwo = $minPages + 2;
$mpageplusThree = $minPages + 3;

if($maxPages <= $minPages){
    $page = 1;
    echo 'Disabled';
}
elseif($page < 1){
    header('Location: /orderhistory?page=1');
}
elseif($page > $maxPages){
    header('Location: /orderhistory?page=1');
}
elseif($maxPages >= 2 AND $maxPages <= 4){
    for($i = 1; $i <= $maxPages; $i++){
        echo "<a href='http://kbs.local/orderhistory?&page=$i' class='button'>$i</a>";
        echo "</br>";
    }
}
elseif($maxPages > 4){
    if($page <= 3){
    echo "<a href='http://kbs.local/orderhistory?&page=1' class='button'>1</a>";
    echo "</br>";
    echo "<a href='http://kbs.local/orderhistory?&page=$mpageplus' class='button'>$mpageplus</a>";
    echo "</br>";
    echo "<a href='http://kbs.local/orderhistory?&page=$mpageplusTwo' class='button'>$mpageplusTwo</a>";
    echo "</br>";
    echo "<a href='http://kbs.local/orderhistory?&page=$mpageplusThree' class='button'>$mpageplusThree</a>";
    echo "</br>";
    echo "<a href='http://kbs.local/orderhistory?&page=$pageplusTwo' class='button'>...</a>";
    echo "<a href='http://kbs.local/orderhistory?&page=$maxPages' class='button'>$maxPages</a>";
    }
    if ($page >= 4 AND $page <= $maxPages - 3){
        echo "<a href='http://kbs.local/orderhistory?&page=1' class='button'>1</a>";
        echo "<a href='http://kbs.local/orderhistory?&page=$pageminTwo' class='button'>...</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/orderhistory?&page=$pagemin' class='button'>$pagemin</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/orderhistory?&page=$page' class='button'>$page</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/orderhistory?&page=$pageplus' class='button'>$pageplus</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/orderhistory?&page=$pageplusTwo' class='button'>...</a>";
        echo "<a href='http://kbs.local/orderhistory?&page=$maxPages' class='button'>$maxPages</a>";
    }
    if($page >= $maxPages - 2){
        echo "<a href='http://kbs.local/orderhistory?&page=1' class='button'>1</a>";
        echo "<a href='http://kbs.local/orderhistory?&page=$pageminTwo' class='button'>...</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/orderhistory?&page=$mpageminThree' class='button'>$mpageminThree</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/orderhistory?&page=$mpageminTwo' class='button'>$mpageminTwo</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/orderhistory?&page=$mpagemin' class='button'>$mpagemin</a>";
        echo "</br>";
        echo "<a href='http://kbs.local/orderhistory?&page=$maxPages' class='button'>$maxPages</a>";
    }
}
 
$database->closeConnection();
?>