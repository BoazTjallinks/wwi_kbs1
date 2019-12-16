<?php
// unset($_SESSION['shoppingCart']);
if(isset($_POST['stockItemID'])){
    if (is_numeric($_POST['stockItemID'])) {
        $item = ['ItemID' => $_POST['stockItemID'], 'ItemAmount' => 1];
        if (isset($_SESSION['shoppingCart'])) {
            for ($i=0; $i < count($_SESSION['shoppingCart']); $i++) { 
               if ($_SESSION['shoppingCart'][$i]['ItemID'] == $_POST['stockItemID']) {
                   if ($_SESSION['shoppingCart'][$i]['ItemAmount'] == 0) {                   
                       $_SESSION['shoppingCart'][$i]['ItemAmount'] = $_SESSION['shoppingCart'][$i]['ItemAmount'];
                   }
                   else {
                        $_SESSION['shoppingCart'][$i]['ItemAmount'] = ($_SESSION['shoppingCart'][$i]['ItemAmount'] + 1);
                   }
               }
               else {
                    array_push($_SESSION['shoppingCart'], $item);
               }
            }
        }
        else {
            $_SESSION['shoppingCart'] = [$item];
        }
    }
    print_r($_SESSION['shoppingCart']);
}
?>
<!-- The Modal -->
<div class="modal fade wwi_mat_4" role="dialog" tabindex="-1" id="cart">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Modal body -->
            <div class="modal-body">
                <?php
                $database = new database();
                $selectStockItem= $database->DBquery("SELECT * FROM StockItems WHERE StockItemID = ?",[$id]);
                $database->closeConnection();?>
               
            </div>
        </div>
    </div>
</div>