<?php
// unset($_SESSION['shoppingCart']);
if (isset($_POST['stockItemID'])) {
    if (is_numeric($_POST['stockItemID'])) {
        $item = ['ItemID' => $_POST['stockItemID'], 'ItemAmount' => 1, 'newItem' => true];
        if (isset($_SESSION['shoppingCart'])) {
            if (empty($_SESSION['shoppingCart'])) {
                $_SESSION['shoppingCart'] = [$item];
            } else {
                for ($i=0; $i < count($_SESSION['shoppingCart']); $i++) {
                    if ($_SESSION['shoppingCart'][$i]['ItemID'] == $_POST['stockItemID']) {
                        if ($_SESSION['shoppingCart'][$i]['newItem'] == true) {
                            $_SESSION['shoppingCart'][$i]['ItemAmount'] = $_SESSION['shoppingCart'][$i]['ItemAmount'];
                            $_SESSION['shoppingCart'][$i]['newItem'] = false;
                        } else {
                            $_SESSION['shoppingCart'][$i]['ItemAmount'] = ($_SESSION['shoppingCart'][$i]['ItemAmount'] + 1);
                        }
                    } else {
                        array_push($_SESSION['shoppingCart'], $item);
                    }
                }
            }
        } else {
            $_SESSION['shoppingCart'] = [$item];
        }
    }
    // print_r($_SESSION['shoppingCart']);
}

$database = new database();
$StockItems = $database->DBquery('SELECT * FROM stockitems JOIN stockitemholdings ON stockitems.StockItemID = stockitemholdings.StockItemID', []);


?>
<!-- The Modal -->
<div class="modal fade wwi_mat_4" role="dialog" tabindex="-1" id="cart">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Modal body -->
            <div class="modal-body wwi_auth_modal">
                <?php
                    if (!isset($_SESSION['shoppingCart'])) {
                        echo '<center><h3 class="wwi_maincolor wwi_padding_normal"><strong>You got nothing in your cart...</strong></h3></center>';
                    } else {
                        if (empty($_SESSION['shoppingCart'])) {
                            echo '<center><h3 class="wwi_maincolor wwi_padding_normal"><strong>You got nothing in your cart...</strong></h3></center>';
                        } else {
                            ?>

                <section id="shopping-cart">
                    <h3 class="wwi_maincolor wwi_padding_normal"><strong><?php echo count($_SESSION['shoppingCart']); ?> Item(s) in shopping cart</strong></h3>
                    <div class="table-responsive table-borderless">
                        <table class="table table-bordered">
                            <thead class="wwi_mainbgcolor wwi_text_light wwi_textalign_center">
                                <tr class="wwi_frontsize_small">
                                    <th>Picture</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                    if (isset($_SESSION['shoppingCart'])) {
                                        if (!empty($_SESSION['shoppingCart'])) {
                                            for ($i = 0; $i < count($_SESSION['shoppingCart']); $i++) {
                                                if ($_SESSION['shoppingCart'][$i] !== 'nAn') {
                                                    $stockID = $_SESSION['shoppingCart'][$i]['ItemID'];
                                                    $ItemAmount = $_SESSION['shoppingCart'][$i]['ItemAmount'];

                                                    $getimg = $database->DBQuery('SELECT * FROM picture WHERE StockItemID = ? AND isPrimary IS NOT NULL', [$stockID]);
                                                    if ($getimg == '0 results found!') {
                                                        $img = '/public/img/products/no-image.png';
                                                    } else {
                                                        $img = $getimg[0]['ImagePath'];
                                                    }

                                                    for ($i2=0; $i2 < count($StockItems); $i2++) {
                                                        if ($StockItems[$i2]['StockItemID'] == $stockID) {
                                                            echo '<tr class="wwi_textalign_center wwi_frontsize_small">';
                                                            echo '<td class="align-middle"><figure class="figure"><img class="img-fluid figure-img wwi-itemimg_nowith" src="'.$img.'"></figure></td>';
                                                            echo '<td class="align-middle">'.$StockItems[$i2]['StockItemName'].'</td>';
                                                            echo '<td class="align-middle"><form method="GET" action="/updatequantitiy"><input type="hidden" value="'.$cat.'" name="catid"><input type="hidden" value="" name="redirect"><input class="form-control-sm" name="newnr" type="number" value="'.$ItemAmount.'" min="1" max="'.$StockItems[$i2]['QuantityOnHand'].'"></form></td>';
                                                            echo '<td class="align-middle">'.($StockItems[$i2]['RecommendedRetailPrice'] * $ItemAmount).'</td>';
                                                            echo '<td class="align-middle"><a class="text-danger" href="/deletecart?itemid='.$StockItems[$i2]['StockItemID'].'&redirect='.$query.'"><i class="fa fa-trash wwi_frontsize_normal"></i></a></td>';
                                                            echo '</tr>';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row no-gutters">
                        <div class="col wwi_padding_normal bg-light">
                            <h1 class="wwi_frontsize_normal wwi_padding_left_normal"><strong>Shipping information</strong></h1>
                            <div class="wwi_padding_left_normal wwi_fontsize_xtrasmall">
                            <?php
                                if (isset($_SESSION['isloggedIn'])) {
                                    $customerInfo = $database->DBQuery('SELECT * FROM webCustomer WHERE wCustomerID = ?', [$_SESSION['isloggedIn']]);
                                    // print_r($_SESSION['isloggedIn']);
                                    echo '<p><strong>Name</strong> '.$customerInfo[0]['wCustomerName'].'</p>';
                                    echo '<p><strong>Address</strong> '.$customerInfo[0]['wCustomerStreetPostal'].'</p>';
                                    echo '<p><strong>Street</strong> '.$customerInfo[0]['wCustomerStreetname'].' '.$customerInfo[0]['wCustomerStreetNumber'].'</p>';
                                    echo '<p><strong>City</strong> '.$customerInfo[0]['wCustomerCity'].'</p>';
                                    echo '<p><strong>Country</strong>&nbsp;'.$customerInfo[0]['wCustomerCountry'].'</p>';
                                } else {
                                    echo '<div class="align-middle wwi_padding_left_normal"><!--<a href="/checkout">--><strong>You\'ll need to log in first!</strong><!--</a>--></div>';
                                } ?>
                            </div>
                        </div>
                        <div class="col wwi_mainbgcolor wwi_padding_normal wwi_text_light">
                            <div class="row no-gutters">
                                <div class="col">
                                    
                            <?php
                            if (isset($_SESSION['shoppingCart'])) {
                                if (!empty($_SESSION['shoppingCart'])) {
                                    $amount = 0;
                                    for ($i=0; $i < count($_SESSION['shoppingCart']); $i++) {
                                        if ($_SESSION['shoppingCart'][$i] !== 'nAn') {
                                            $stockID = $_SESSION['shoppingCart'][$i]['ItemID'];
                                            $ItemAmount = $_SESSION['shoppingCart'][$i]['ItemAmount'];
                                            for ($i2=0; $i2 < count($StockItems); $i2++) {
                                                if ($StockItems[$i2]['StockItemID'] == $stockID) {
                                                    $amount = $amount + ($StockItems[$i2]['RecommendedRetailPrice'] * $ItemAmount);
                                                }
                                            }
                                        }
                                    }
                                    $tax = round(($amount / 100 * 20), 2);
                                    $total = round($amount + $tax, 2);
                                    echo '<h3 class="wwi_padding_left_normal"><strong>SUB TOTAL&nbsp;</strong>€'.$amount.'</h3>';
                                    echo '<h5 class="wwi_padding_left_normal"><strong>TAX&nbsp;</strong>€'.$tax.'</h5>';
                                    echo '<h5 class="wwi_padding_left_normal"><strong>SHIPPING COSTS&nbsp;</strong>€'.$tax.'</h5>';
                                    echo '<h1 class="wwi_padding_left_normal"><strong>TOTAL&nbsp;</strong>€'.$total.'</h1>';
                                    if (isset($_SESSION['isloggedIn'])) {
                                        echo '<div class="align-middle wwi_padding_left_normal"><a href="/checkout"><button class="btn btn-light btn-lg wwi_maincolor" type="button"><strong>Proceed to checkout</strong></button></a></div>';
                                    } else {
                                        echo '<div class="align-middle wwi_padding_left_normal"><!--<a href="/checkout">--><strong>You\'ll need to log in first!</strong><!--</a>--></div>';
                                    }
                                }
                            } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
                        }
                    }
                    $database->closeConnection();
                ?>
            </div>
        </div>
    </div>
</div>

