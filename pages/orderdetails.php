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
WHERE O.OrderID = ? AND O.CustomerID = ?", [$orderID, 832]); 
if($orderDetails == '0 results found!'){
    header('location: /orderhistory?page=1');
}


$itemsNotSold= $database->DBQuery("SELECT DISTINCT SA.StockItemName, SA.RecommendedRetailPrice, SA.TaxRate
FROM orders O 
JOIN orderlines OL ON O.OrderID = OL.OrderID
JOIN stockitems_archive SA ON OL.StockItemID = SA.StockItemID
WHERE O.OrderID = ? AND O.CustomerID = ?", [$orderID, 832]);

echo $orderDetails[0]['OrderDate'];
echo '</br>';
echo $orderID;
$maxtotal = 0;
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
    
        echo '</br>';
        echo '</br>';
        echo '<figure class="figure"><img class="img-fluid figure-img wwi-itemimg_nowith" src="'.$img.'"></figure>';
        echo '</br>';
        if(isset($orderDetails[$i]['StockItemID'])){
            echo "<a href='/productview?id=".$orderDetails[$i]['StockItemID']."'>".$orderDetails[$i]['StockItemName']."</a>";
            echo '</br>';
            echo $orderDetails[$i]['RecommendedRetailPrice'];
            echo '</br>';
            echo $orderDetails[$i]['Quantity'];
            echo '</br>';
            echo round($orderDetails[$i]['TaxRate']);
            echo '</br>';
            $total = ($orderDetails[$i]['RecommendedRetailPrice'] * $orderDetails[$i]['Quantity'] /100 * (100 + $orderDetails[$i]['TaxRate']));
            echo round($total, 2);
        }else{
            echo $itemsNotSold[$i]['StockItemName'];
            echo '</br>';
            echo $itemNotSold[$i]['RecommendedRetailPrice'];
            echo '</br>';
            echo $orderDetails[$i]['Quantity'];
            echo '</br>';
            echo round($itemsNotSold[$i]['TaxRate']);
            echo '</br>';
            $total = ($itemsNotSold[$i]['RecommendedRetailPrice'] * $orderDetails[$i]['Quantity'] /100 * (100 + $itemsNotSold[$i]['TaxRate']));
            echo round($total, 2);
        }
        $maxtotal = $maxtotal+$total;
    }
    echo '</br>';
    echo $maxtotal;
}
$database->closeConnection();
?>