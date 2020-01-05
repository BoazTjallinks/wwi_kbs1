<?php
/* Verbinding maken met de database en pagina nummer naar 1 veranderen */
$database = new database();
if(!isset($_GET['page'])){
    header('location: /orderhistory?page=1');
}

/* Controleren of er is ingelogd, als dat niet het geval is terug naar homepagina */
if(isset($_SESSION['isloggedIn'])){
    $usertoken = $_SESSION['isloggedIn'];
}else{
    header('location: /home');
}

$page = $_GET['page'];
$offset = $page * 6 - 6;

/* Query om alle orders opvragen voor pagination */
$orderDetailsAll= $database->DBQuery("SELECT * FROM orders O  WHERE O.CustomerID = ? GROUP BY O.OrderID", [$usertoken]);

/* Query om alle gegevens van de orders op te vragen */
$orderDetails= $database->DBQuery("SELECT O.OrderID, O.OrderDate, OL.StockItemID, OL.Quantity, S.StockItemName,SUM(OL.Quantity * S.RecommendedRetailPrice / 100 * (100 + S.TaxRate)) AS TotalPriceItem, S.TaxRate
FROM orders O 
JOIN orderlines OL ON O.OrderID = OL.OrderID
JOIN stockitems S ON OL.StockItemID = S.StockItemID
WHERE O.CustomerID = ?
GROUP BY O.OrderID
ORDER BY O.OrderDate DESC, O.OrderID DESC
LIMIT ? OFFSET ? ", [$usertoken, 6, $offset]); 

/* Query om informatie op te halen over producten die niet meer verkocht worden */
$itemsNotSold= $database->DBQuery("SELECT DISTINCT SA.StockItemName, SA.RecommendedRetailPrice, SA.TaxRate FROM orders O JOIN orderlines OL ON O.OrderID = OL.OrderID JOIN stockitems_archive SA ON OL.StockItemID = SA.StockItemID WHERE O.CustomerID = ?", [$usertoken]);

?>
<!-- Begin tonen informatie order history-->
<section id="shopping-cart" class="wwi_padding_normal">
        <h1 class="wwi_maincolor"><strong>Your order history</strong></h1>
        <div class="table-responsive table-borderless">
            <table class="table table-striped table-sm">
                <thead class="wwi_mainbgcolor wwi_text_light wwi_textalign_center">
                    <tr class="wwi_frontsize_small">
                        <th></th>
                        <th>OrderID:</th>
                        <th>First Item Product Name:</th>
                        <th>Order date:</th>
                        <th>Total Price Incl. Tax:</th>
                        <th></th>
                        
                    </tr>
                </thead>
                <tbody>
                        <?php
                        /* Check of er resultaten zijn uit de query anders No orders found tonen als er wel resultaten zijn door de query lopen met for loop
                        met een query foto's uit de database halen*/
                        if($orderDetails == '0 results found!'){
                            echo '<td>No orders found.</td>';
                        }else{
                            $maxt;
                            for($i = 0; $i < count($orderDetails); $i++){
                                echo ' <tr class="wwi_textalign_center wwi_frontsize_small">';
                                $getimg = $database->DBQuery('SELECT * FROM picture WHERE StockItemID = ? AND isPrimary IS NOT NULL', [$orderDetails[$i]['StockItemID']]);
                                    if ($getimg == '0 results found!') {
                                        $img = '/public/img/products/no-image.png';
                                    }
                                    else {
                                        $img = $getimg[0]['ImagePath'];
                                    }
                                $normalDate = date("d-m-Y", strtotime($orderDetails[$i]['OrderDate']));
                                echo '<td class="align-middle"><figure class="figure"><img class="img-fluid figure-img wwi-itemimg_nowith" src="'.$img.'"></figure></td>';
                                echo '<td class="align-middle">'.$orderDetails[$i]['OrderID'].'</td>';
                                /* Check of item een item is dat nog verkocht wordt anders uit archive halen */
                                if(isset($orderDetails[$i]['StockItemID'])){
                                    echo "<td class='align-middle'><a href='/productview?id=".$orderDetails[$i]['StockItemID']."'>".$orderDetails[$i]['StockItemName']."</a></td>";
                                }else{
                                    echo "<td class='align-middle'>$itemsNotSold[$i]['StockItemName']</td>";
                                }
                                echo '<td class="align-middle">'.$normalDate.'</td>';
                                /* Max price met shipping kost berekenen */
                                if($orderDetails[$i]['TotalPriceItem'] < 100){
                                    $maxt = $orderDetails[$i]['TotalPriceItem'] + (10 / 100 * (100 + $orderDetails[0]['TaxRate']));
                                }else{
                                    $maxt = $orderDetails[$i]['TotalPriceItem'];
                                }
                                echo '<td class="align-middle">€ '.round($maxt,2).'</td>';
                                echo "<td class='align-middle'><a href='/orderdetails?OrderID=".$orderDetails[$i]['OrderID']."' class='btn btn-primary'>More details</a></td>";
                                echo '</tr>';
                                }
                            }
                        ?>
                </tbody>
            </table>
        </div>
    </section>
<!-- Einde tonen informatie order history -->
<?php

/* variabelen voor pagination*/
$maxPages = ceil(count($orderDetailsAll) / 6);
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
?>
<nav>
<ul class="pagination container">
<!-- <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
<li class="page-item"><a class="page-link" href="#">1</a></li>
<li class="page-item"><a class="page-link" href="#">2</a></li>
<li class="page-item"><a class="page-link" href="#">3</a></li>
<li class="page-item"><a class="page-link" href="#">4</a></li>
<li class="page-item"><a class="page-link" href="#">5</a></li>
<li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> -->

    <?php
/* begin pagination */
    if ($maxPages <= $minPages) {
        $page = 1;
    } elseif ($page < 1) {
        header('Location: /orderhistory?page=1');
    } elseif ($page > $maxPages) {
        header('Location: /orderhistory?page=1');
    } elseif ($maxPages >= 2 and $maxPages <= 4) {
        for ($i = 1; $i <= $maxPages; $i++) {
            echo " <li class='page-item'><a href='/orderhistory?&page=$i' class='button page-link'>$i</a></li>";
        }
    } elseif ($maxPages > 4) {
        if ($page <= 3) {
            echo " <li class='page-item'><a href='/orderhistory?&page=1' class='button page-link'>1</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$mpageplus' class='button page-link'>$mpageplus</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$mpageplusTwo' class='button page-link'>$mpageplusTwo</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$mpageplusThree' class='button page-link'>$mpageplusThree</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$pageplusTwo' class='button page-link'>...</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$maxPages' class='button page-link'>$maxPages</a></li>";
        }
        if ($page >= 4 and $page <= $maxPages - 3) {
            echo " <li class='page-item'><a href='/orderhistory?&page=1' class='button page-link'>1</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$pageminTwo' class='button page-link'>...</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$pagemin' class='button page-link'>$pagemin</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$page' class='button page-link'>$page</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$pageplus' class='button page-link'>$pageplus</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$pageplusTwo' class='button page-link'>...</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$maxPages' class='button page-link'>$maxPages</a></li>";
        }
        if ($page >= $maxPages - 2) {
            echo " <li class='page-item'><a href='/orderhistory?&page=1' class='button page-link'>1</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$pageminTwo' class='button page-link'>...</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$mpageminThree' class='button page-link'>$mpageminThree</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$mpageminTwo' class='button page-link'>$mpageminTwo</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$mpagemin' class='button page-link'>$mpagemin</a></li>";
            echo " <li class='page-item'><a href='/orderhistory?&page=$maxPages' class='button page-link'>$maxPages</a></li>";
        }
    }
/* Einde pagination */                     
    
    ?>
</ul>
</nav>
<?php
$database->closeConnection();
?>