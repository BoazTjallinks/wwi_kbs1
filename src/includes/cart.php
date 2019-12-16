<?php
// unset($_SESSION['shoppingCart']);
if (isset($_POST['stockItemID'])) {
    if (is_numeric($_POST['stockItemID'])) {
        $item = ['ItemID' => $_POST['stockItemID'], 'ItemAmount' => 1];
        if (isset($_SESSION['shoppingCart'])) {
            for ($i=0; $i < count($_SESSION['shoppingCart']); $i++) {
                if ($_SESSION['shoppingCart'][$i]['ItemID'] == $_POST['stockItemID']) {
                    if ($_SESSION['shoppingCart'][$i]['ItemAmount'] == 0) {
                        $_SESSION['shoppingCart'][$i]['ItemAmount'] = $_SESSION['shoppingCart'][$i]['ItemAmount'];
                    } else {
                        $_SESSION['shoppingCart'][$i]['ItemAmount'] = ($_SESSION['shoppingCart'][$i]['ItemAmount'] + 1);
                    }
                } else {
                    array_push($_SESSION['shoppingCart'], $item);
                }
            }
        } else {
            $_SESSION['shoppingCart'] = [$item];
        }
    }
    print_r($_SESSION['shoppingCart']);
}

$database = new database();
if (isset($_SESSION['shoppingCart'])) {
    if (!empty($_SESSION['shoppingCart'])) {
    } else {
        echo '<tr><td>Nothing in the Cart :(</td></tr>';
    }
}

?>
<!-- The Modal -->
<div class="modal fade wwi_mat_4" role="dialog" tabindex="-1" id="cart">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Modal body -->
            <div class="modal-body wwi_auth_modal">
                <section id="shopping-cart">
                    <h1 class="wwi_maincolor wwi_padding_normal"><strong><?php echo count($_SESSION['shoppingCart']); ?> Item(s) in shopping cart</strong></h1>
                    <div class="table-responsive table-borderless">
                        <table class="table table-bordered">
                            <thead class="wwi_mainbgcolor wwi_text_light wwi_textalign_center">
                                <tr class="wwi_frontsize_small">
                                    <th>Picture</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Price</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                    if (isset($_SESSION['shoppingCart'])) {
                                        if (!empty($_SESSION['shoppingCart'])) {
                                            for ($i = 0; $i < count($_SESSION['shoppingCart']); $i++) {
                                                $stockID = $_SESSION['shoppingCart'][$i]['ItemID'];
                                                $selectStockItem= $database->DBquery("SELECT * FROM StockItems WHERE StockItemID = ?", [$stockID]);
                                                print_r($selectStockItem);
                                                echo '<tr class="wwi_textalign_center wwi_frontsize_small">';
                                                echo '<td class="align-middle"><figure class="figure"><img class="img-fluid figure-img wwi-itemimg_nowith" src="assets/img/products/testproduct.png"></figure></td>';
                                                echo '<td class="align-middle">StockItemName</td>';
                                                echo '<td class="align-middle"><input class="form-control-sm" type="number" min="0" max="12"></td>';
                                                echo '<td class="align-middle">€12</td>';
                                                echo '
                                                    <td class="align-middle"><a class="text-danger" href="#"><i class="fa fa-trash wwi_frontsize_normal"></i></a></td>';
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                    $database->closeConnection();
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row no-gutters">
                        <div class="col wwi_padding_normal bg-light">
                            <h1 class="wwi_frontsize_normal wwi_padding_left_normal"><strong>Shipping information</strong></h1>
                            <div class="wwi_padding_left_normal wwi_fontsize_xtrasmall">
                                <p><strong>Name</strong> Ton Scholma</p>
                                <p><strong>Street</strong> Tontonstraat 25b</p>
                                <p><strong>Postal</strong> 7426TT</p>
                                <p><strong>City</strong> Zwolle</p>
                                <p><strong>Country</strong>&nbsp;Netherlands</p>
                            </div>
                        </div>
                        <div class="col wwi_mainbgcolor wwi_padding_normal wwi_text_light">
                            <div class="row no-gutters">
                                <div class="col">
                                    <h3 class="wwi_padding_left_normal"><strong>SUB TOTAL&nbsp;</strong>€49,75</h3>
                                    <h4 class="wwi_padding_left_normal"><strong>TAX&nbsp;</strong>€0,25</h4>
                                    <h1 class="wwi_padding_left_normal"><strong>TOTAL&nbsp;</strong>€50,00</h1>
                                    <div class="align-middle wwi_padding_left_normal"><button class="btn btn-light btn-lg wwi_maincolor" type="button"><strong>Proceed to checkout</strong></button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>