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

// $offset = $page * 10 - 10;

$orderDetails= $database->DBQuery("SELECT O.OrderID, O.OrderDate, OL.StockItemID, OL.Quantity, S.StockItemName, S.RecommendedRetailPrice, S.TaxRate
FROM orders O 
JOIN orderlines OL ON O.OrderID = OL.OrderID
JOIN stockitems S ON OL.StockItemID = S.StockItemID
WHERE O.CustomerID = ?
GROUP BY O.OrderID
LIMIT ? OFFSET ? ", [$usertoken, 10, $offset]); 
if($orderDetails == '0 results found!'){
    echo 'No orders found.';
}else{
    for($i = 0; $i < count($orderDetails); $i++){
        echo $orderDetails[$i]['OrderID']; 
        echo '</br>';
        echo "<a href='/orderdetails?OrderID=".$orderDetails[$i]['OrderID']."'>More details</a>";
    }
}

// $page = $_GET['page'];
// $maxPages = ceil(count($orderDetails) / 10);
// $minPages = 1;
// $pagemin = $page - 1;
// $pageminTwo = $page - 2;
// $pageplusTwo = $page + 2;
// $mpagemin = $maxPages - 1;
// $mpageminTwo = $maxPages - 2;
// $mpageminThree = $maxPages - 3;
// $pageplus = $page + 1;
// $mpageplus = $minPages + 1;
// $mpageplusTwo = $minPages + 2;
// $mpageplusThree = $minPages + 3;

// if($maxPages <= $minPages){
//     $page = 1;
//     echo 'Disabled';
// }
// elseif($page < 1){
//     header('Location: /home');
// }
// elseif($page > $maxPages){
//     header('Location: /home');
// }
// elseif($maxPages >= 2 AND $maxPages <= 4){
//     for($i = 1; $i <= $maxPages; $i++){
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$i' class='button'>$i</a>";
//         echo "</br>";
//     }
    
// }
// elseif($maxPages > 4){
//     if($page <= 3){
//     echo "<a href='http://kbs.local/categories?catid=$cat&page=1' class='button'>1</a>";
//     echo "</br>";
//     echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpageplus' class='button'>$mpageplus</a>";
//     echo "</br>";
//     echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpageplusTwo' class='button'>$mpageplusTwo</a>";
//     echo "</br>";
//     echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpageplusThree' class='button'>$mpageplusThree</a>";
//     echo "</br>";
//     echo "<a href='http://kbs.local/categories?catid=$cat&page=$pageplusTwo' class='button'>...</a>";
//     echo "<a href='http://kbs.local/categories?catid=$cat&page=$maxPages' class='button'>$maxPages</a>";
//     }
//     if ($page >= 4 AND $page <= $maxPages - 3){
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=1' class='button'>1</a>";
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$pageminTwo' class='button'>...</a>";
//         echo "</br>";
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$pagemin' class='button'>$pagemin</a>";
//         echo "</br>";
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$page' class='button'>$page</a>";
//         echo "</br>";
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$pageplus' class='button'>$pageplus</a>";
//         echo "</br>";
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$pageplusTwo' class='button'>...</a>";
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$maxPages' class='button'>$maxPages</a>";
//     }
//     if($page >= $maxPages - 2){
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=1' class='button'>1</a>";
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$pageminTwo' class='button'>...</a>";
//         echo "</br>";
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpageminThree' class='button'>$mpageminThree</a>";
//         echo "</br>";
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpageminTwo' class='button'>$mpageminTwo</a>";
//         echo "</br>";
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$mpagemin' class='button'>$mpagemin</a>";
//         echo "</br>";
//         echo "<a href='http://kbs.local/categories?catid=$cat&page=$maxPages' class='button'>$maxPages</a>";
//     }
// }
 
$database->closeConnection();
?>