<?php 
/* Verbinding maken met de database en terug verwijzen naar orderhistory */
$database = new database();
if(!isset($_GET['OrderID'])){
    header('location: /orderhistory?page=1');
}
    
/* Controleren of er is ingelogd, als dat niet het geval is terug naar homepagina */
if(isset($_SESSION['isloggedIn'])){
    $usertoken = $_SESSION['isloggedIn'];
}else{
    header('location: /home');
}

$orderID = $_GET['OrderID'];

/* Alle informatie van een order ophalen met deze query */
$orderDetails= $database->DBQuery("SELECT O.OrderID, O.OrderDate, OL.StockItemID, OL.Quantity, S.StockItemName, S.RecommendedRetailPrice, S.TaxRate
FROM orders O 
JOIN orderlines OL ON O.OrderID = OL.OrderID
JOIN stockitems S ON OL.StockItemID = S.StockItemID
WHERE O.OrderID = ? AND O.CustomerID = ?", [$orderID, $usertoken]); 
if($orderDetails == '0 results found!'){
    header('location: /orderhistory?page=1');
}
/* Als een item niet verkocht wordt wordt deze uit archive gehaald */
$itemsNotSold= $database->DBQuery("SELECT DISTINCT SA.StockItemName, SA.RecommendedRetailPrice, SA.TaxRate
FROM orders O 
JOIN orderlines OL ON O.OrderID = OL.OrderID
JOIN stockitems_archive SA ON OL.StockItemID = SA.StockItemID
WHERE O.OrderID = ? AND O.CustomerID = ?", [$orderID, $usertoken]);

$normalDate = date("d-m-Y", strtotime($orderDetails[0]['OrderDate']));
$maxtotal = 0;
$shipping = 10;
?>
<!-- Begin tonen order details-->
<section id="orderDetails" class="wwi_padding_normal">
<div class="row">
    <div class="col">
        <h1 class="wwi_maincolor"><strong>Order details</strong></h1>
    </div>
    <div class="col wwi_text_right">
       <?php echo "<h4 class='wwi_maincolor'><strong>&nbsp; &nbsp; OrderID: ".$orderID."</strong><br><strong>Order Date: ".$normalDate."</strong></h4>"; ?>
    </div>
</div>
<div class="table-responsive table-borderless table-striped">
    <table class="table table-bordered table-sm">
        <thead class="wwi_mainbgcolor wwi_text_light wwi_textalign_center">
            <tr class="wwi_frontsize_small">
                <th></th>
                <th>Product Name:</th>
                <th>Price Each:</th>
                <th>Quantity:</th>
                <th>Total Price Item Incl. Tax:</th>
            </tr>
        </thead>
        <tbody>
            <?php
            /* Check of er resultaten zijn uit de query anders No orders found tonen als er wel resultaten zijn door de query lopen met for loop
            met een query foto's uit de database halen*/
            if($orderDetails == '0 results found!'){
                echo 'No orders found.';
            }else{
                $price1;
                $maxt;
                for($i = 0; $i < count($orderDetails); $i++){
                $getimg = $database->DBQuery('SELECT * FROM picture WHERE StockItemID = ? AND isPrimary IS NOT NULL', [$orderDetails[$i]['StockItemID']]);
                $price1 = round($orderDetails[$i]['TaxRate']);
                if ($getimg == '0 results found!') {
                    $img = '/public/img/products/no-image.png';
                }
                else {
                    $img = $getimg[0]['ImagePath'];
                }
                /* Checken of een stockitem id gevonden kan worden tussen de producten in stock dan tonen met link anders uit archive halen zonder link naar productpage */
                if(isset($orderDetails[$i]['StockItemID'])){
                    echo '<tr class="wwi_textalign_center wwi_frontsize_small">';
                    echo '<td class="align-middle"><figure class="figure"><img class="img-fluid figure-img wwi-itemimg_nowith" src="'.$img.'"></figure></td>';
                    echo "<td class='align-middle'><a href='/productview?id=".$orderDetails[$i]['StockItemID']."'>".$orderDetails[$i]['StockItemName']."</a></td>";
                    echo "<td class='align-middle'>€ ".$orderDetails[$i]['RecommendedRetailPrice']."</td>";
                    echo "<td class='align-middle'>".$orderDetails[$i]['Quantity']."</td>";
                    $total = ($orderDetails[$i]['RecommendedRetailPrice'] * $orderDetails[$i]['Quantity'] /100 * (100 + $orderDetails[$i]['TaxRate']));
                    echo "<td class='align-middle'>€ ".round($total, 2)."</td>";
                    echo '</tr>';
                    $maxtotal = $maxtotal + $total;
                    }else{
                    echo '<tr class="wwi_textalign_center wwi_frontsize_small">';
                    echo '<td class="align-middle"><figure class="figure"><img class="img-fluid figure-img wwi-itemimg_nowith" src="'.$img.'"></figure></td>';
                    echo "<td class='align-middle'>".$itemsNotSold[$i]['StockItemName']."</td>";
                    echo "<td class='align-middle'>€ ".$itemsNotSold[$i]['RecommendedRetailPrice']."</td>";
                    echo "<td class='align-middle'>".$orderDetails[$i]['Quantity']."</td>";
                    $total = ($orderDetails[$i]['RecommendedRetailPrice'] * $orderDetails[$i]['Quantity'] /100 * (100 + $orderDetails[$i]['TaxRate']));
                    echo "<td class='align-middle'>€ ".round($total, 2)."</td>";
                    echo '</tr>';
                    $maxtotal = $maxtotal + $total;
                    }
                    /* Berekenen shipping cost */
                    if($maxtotal < 100){
                        $shipping = $shipping /100 * (100 + $price1);
                        $maxt = $maxtotal + $shipping;
                    }else{
                        $shipping = "Free";
                        $maxt = $maxtotal;
                    
                }
            }
        }
            
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <?php
                /* ifstatment voor shipping cost */
                if($shipping == 'Free'){
                    echo "<td class='wwi_textalign_center wwi_maincolor wwi_fontsize_xtrasmall'><strong>Shipping: &nbsp;</strong>".$shipping."</td>"; 
                }else{
                    echo "<td class='wwi_textalign_center wwi_maincolor wwi_fontsize_xtrasmall'><strong>Shipping: &nbsp;</strong> € ".$shipping."</td>"; 
                }
                echo "<td class='wwi_textalign_center wwi_maincolor wwi_fontsize_xtrasmall'><strong>Tax: &nbsp;</strong>".$price1."%</td>";
                echo "<td class='wwi_textalign_center wwi_maincolor wwi_fontsize_xtrasmall'><strong>Total Price: &nbsp;</strong> € ".round($maxt,2)."</td>";
                ?>
                
            </tr>
        </tfoot>
    </table>
</div>
</section>
<!-- Einde tonen order details-->
<?php
/* Database connection sluiten*/
$database->closeConnection();
?>