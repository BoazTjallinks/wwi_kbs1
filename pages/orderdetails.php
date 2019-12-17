<?php 
$database = new database();
if(!isset($_GET['OrderID'])){
    header('location: /orderhistory?page=1');
}
    

// if(isset($_SESSION['isloggedIn'])){
//     $usertoken = $_SESSION['isloggedIn'];
// }else{
//     echo 'Please login first to check your order details';
// }

$orderID = $_GET['OrderID'];

$orderDetails= $database->DBQuery("SELECT O.OrderID, O.OrderDate, OL.StockItemID, OL.Quantity, S.StockItemName, S.RecommendedRetailPrice, S.TaxRate
FROM orders O 
JOIN orderlines OL ON O.OrderID = OL.OrderID
JOIN stockitems S ON OL.StockItemID = S.StockItemID
WHERE O.OrderID = ? ", [$orderID]); 

print_r($orderDetails);
$database->closeConnection();
?>