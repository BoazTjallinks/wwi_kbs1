<?php


if(!isset($_SESSION['isloggedIn'])){
    header('Location: /home');
}

$notCompleted = false;

if(empty($_POST['bank'])){
    $_POST['bank'] = '';
}else{
    $_SESSION['bank'] = $_POST['bank'];
}
if(empty($_POST['cardnumber'])){
    $_POST['cardnumber'] = '';
}else{
    $_SESSION['cardnumber'] = $_POST['cardnumber'];
}
if(empty($_POST['cardname'])){
    $_POST['cardname'] = '';
}else{
    $_SESSION['cardname'] = $_POST['cardname'];
}
if(empty($_POST['month'])){
    $_POST['month'] = '';
}else{
    $_SESSION['month'] = $_POST['month'];
}
if(empty($_POST['year'])){
    $_POST['year'] = '';
}else{
    $_SESSION['year'] = $_POST['year'];
}
if(empty($_POST['cvccid'])){
    $_POST['cvccid'] = '';
}else{
    $_SESSION['cvccid'] = $_POST['cvccid'];
}

// $database = new database();
// $itemsToSubtract = $database->DBQuery("SELECT si.stockitemid, si.stockitemname, sih.quantityonhand FROM stockitems AS si JOIN stockitemholdings ON si.stockitemid = sih.stockitemid WHERE si.stockitemid = ?",[$stockID]);

// // var_dump($_SESSION['shoppingCart']);
// if (isset($_SESSION['shoppingCart'])) {
//     if (!empty($_SESSION['shoppingCart'])) {
//         $amount = 0;
//         for ($i=0; $i < count($_SESSION['shoppingCart']); $i++) {
//             if ($_SESSION['shoppingCart'][$i] !== 'nAn') {
//                 $stockID = $_SESSION['shoppingCart'][$i]['ItemID'];
//                 $ItemAmount = $_SESSION['shoppingCart'][$i]['ItemAmount'];


//                 // for ($i2=0; $i2 < count($itemsToSubtract); $i2++) {
//                 //     if ($itemsToSubtract[$i2]['StockItemID'] == $stockID) {
//                 //         $amount = $amount + ($itemsToSubtract[$i2]['RecommendedRetailPrice'] * $ItemAmount);
//                 //         var_dump($amount);
//                 //     }
//                 // }
//                 // echo ('id: '.$stockID.' - amount: '.$ItemAmount);
                
//                 $stockitemid = $itemsToSubtract[$i]['stockitemid'];
//                 $stockitemname = $itemsToSubtract[$i]['stockitemname'];
//                 $quantityonhand = $itemsToSubtract[$i]['quantityonhand'];

//                 echo ('id: '.$stockitemid.' - name: '.$stockitemname.' - amount: '.$quantityonhand);
//             }
//         }
//     }
// }

$database = new database();



// echo($itemsToSubtract[0]['quantityonhand'].'<br>');
// print_r($_SESSION['shoppingCart'][$i]['ItemID'].' - '.$_SESSION['shoppingCart'][$i]['ItemAmount'].'<br>');
// echo($itemsToSubtract[$i]['stockitemid'].' - '.$itemsToSubtract[$i]['stockitemname'].' - '.$itemsToSubtract['quantityonhand']);



if((isset($_POST['submit_ideal']) || isset($_POST['submit_credit'])) && !(isset($_POST['submit_ideal']) && isset($_POST['submit_credit']))){

/*----------------------------------------Submit iDeal begin----------------------------------------*/
    if(isset($_POST['submit_ideal'])){
        $_SESSION['bank'] = $_POST['bank'];
        $notCompleted = false;

        print('<!--<div class="container"><div class="row"><div class="col"><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
                        <div class="modal fade show" role="dialog" tabindex="-1" style="display: block;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Payment completed</h4><a href="/home"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></a></div>
                                    <div class="modal-body">
                                        <h5>Your order will be processed</h5>
                                        <p>Thank you for paying through '.$_SESSION['bank'].' using iDeal.<br>Until next time!</p>
                                    </div>
                                    <div class="modal-footer"><a href="/home"><button class="btn btn-primary" id="go-homepage-button" type="button">Go to homepage</button></a></div>
                                </div>
                            </div>
                        </div>
                    <!--</div></div></div>-->
            ');

            for($i = 0; $i < count($_SESSION['shoppingCart']); $i++){
                if ($_SESSION['shoppingCart'][$i] !== 'nAn') {
            
                    $shoppedID = $_SESSION['shoppingCart'][$i]['ItemID'];
                    $shoppedAmount = $_SESSION['shoppingCart'][$i]['ItemAmount'];
            
                    $itemsToSubtract = $database->DBQuery("SELECT StockItemID, QuantityOnHand FROM quantity_test WHERE stockitemid = ?",[$shoppedID]);
                    $instock = $itemsToSubtract[0]['QuantityOnHand'];
                    
                    $newinstock = $instock - $shoppedAmount;
                    // echo ('itemid: '.$shoppedID.' amount to buy: '.$shoppedAmount.' amount in stock: '.$instock.' nieuw in stock: '.$newinstock.'<br>');
            
                    $updateDatabaseStock = $database->DBQuery("UPDATE quantity_test SET QuantityOnHand = ? WHERE StockItemID = ?",[$newinstock,$shoppedID]);
                    
                }
            }

            unset($_SESSION['shoppingCart']);
            $database->closeConnection();

    }
/*----------------------------------------Submit iDeal eind----------------------------------------*/

/*----------------------------------------Submit credit begin----------------------------------------*/
    if(isset($_POST['submit_credit'])){
        $_SESSION['bank'] = 'credit';
        $_SESSION['cardnumber'] = $_POST['cardnumber'];
        $_SESSION['cardname'] = $_POST['cardname'];
        $_SESSION['month'] = $_POST['month'];
        $_SESSION['year'] = $_POST['year'];
        $_SESSION['cvccid'] = $_POST['cvccid'];

        if(!empty($_SESSION['cardnumber']) AND !empty($_SESSION['cardname']) AND !empty($_SESSION['month']) AND !empty($_SESSION['year']) AND !empty($_SESSION['cvccid'])){
            
            if(is_numeric($_SESSION['cardnumber']) && is_numeric($_SESSION['cvccid'])){
                $notCompleted = false;
                print('<!--<div class="container"><div class="row"><div class="col"><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
                        <div class="modal fade show" role="dialog" tabindex="-1" style="display: block;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Payment completed</h4><a href="/home"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></a></div>
                                    <div class="modal-body">
                                        <h5>Your order will be processed</h5>
                                        <p>Thank you for paying with '.$_SESSION['bank'].'.<br>Until next time!</p>
                                    </div>
                                    <div class="modal-footer"><a href="/home"><button class="btn btn-primary" id="go-homepage-button" type="button">Go to homepage</button></a></div>
                                </div>
                            </div>
                        </div>
                        <!--</div></div></div>-->');

                        for($i = 0; $i < count($_SESSION['shoppingCart']); $i++){
                            if ($_SESSION['shoppingCart'][$i] !== 'nAn') {
                        
                                $shoppedID = $_SESSION['shoppingCart'][$i]['ItemID'];
                                $shoppedAmount = $_SESSION['shoppingCart'][$i]['ItemAmount'];
                        
                                $itemsToSubtract = $database->DBQuery("SELECT StockItemID, QuantityOnHand FROM quantity_test WHERE stockitemid = ?",[$shoppedID]);
                                $instock = $itemsToSubtract[0]['QuantityOnHand'];
                                
                                $newinstock = $instock - $shoppedAmount;
                                // echo ('itemid: '.$shoppedID.' amount to buy: '.$shoppedAmount.' amount in stock: '.$instock.' nieuw in stock: '.$newinstock.'<br>');
                        
                                $updateDatabaseStock = $database->DBQuery("UPDATE quantity_test SET QuantityOnHand = ? WHERE StockItemID = ?",[$newinstock,$shoppedID]);
                                
                            }
                        }

                        unset($_SESSION['shoppingCart']);
                        $database->closeConnection();

            }else{
                $notCompleted = true;
            }
        }else{
            echo('You didn\'t correctly fill in the form. Please fill all fields!');
        }
    }
    /*----------------------------------------Submit credit eind----------------------------------------*/

}


?>

<div class="container">
        <div>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link <?php if(isset($_POST['submit_ideal'])){print('active');}elseif(!isset($_POST['submit_ideal']) && !isset($_POST['submit_credit'])){print('active');} ?>" role="tab" data-toggle="tab" href="#tab-1">iDeal</a></li>
                <li class="nav-item"><a class="nav-link <?php if(isset($_POST['submit_credit'])){echo'active';} ?>" role="tab" data-toggle="tab" href="#tab-2">Creditcard</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane <?php if(isset($_POST['submit_ideal'])){print('active');}elseif(!isset($_POST['submit_ideal']) && !isset($_POST['submit_credit'])){print('active');} ?>" role="tabpanel" id="tab-1">
                    <div class="form-group">

                        <form action="/checkout" method="post" name="form_ideal">
                            <div class="row">
                                <div class="col">
                                    <p>Choose your bank</p>
                                    <select name="bank">
                                        <optgroup label="Available Banks">
                                            <option value="ABN AMRO">ABN AMRO</option>
                                            <option value="ASN Bank">ASN Bank</option>
                                            <option value="Handelsbanken">Handelsbanken</option>
                                            <option value="ING">ING</option>
                                            <option value="Knab">Knab</option>
                                            <option value="Moneyou">Moneyou</option>
                                            <option value="Rabobank">Rabobank</option>
                                            <option value="RegioBank">RegioBank</option>
                                            <option value="SNS">SNS</option>
                                            <option value="Triodos Bank">Triodos Bank</option>
                                            <option value="Van Lanschot">Van Lanschot</option>
                                            <option value="bunq">bunq</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <input name="submit_ideal" class="btn btn-primary" id="paymentbutton-ideal" type="submit" value="Proceed with iDeal payment"></input>
                        </form>
                    </div>
                </div>


                <div class="tab-pane <?php if(isset($_POST['submit_credit'])){echo'active';} ?>" role="tabpanel" id="tab-2">
                    <div class="form-group">
                        <form action="/checkout" method="post" name="form_credit">
                            <div class="row">
                                <div class="col">
                                    <?php
                                    if(isset($_POST['submit_credit'])){
                                        if($notCompleted == true){
                                            print('<strong style="color:red;">Please fill in the form correctly!</strong>');
                                        }
                                    }
                                    ?>
                                    <span>
                                        <br>Card number*<br>
                                        <input name="cardnumber" type="tel" onkeyup="this.value=this.value.replace(/[^\d++]/,'')" maxlength="19" value="<?php if(isset($_POST['submit_credit']) && ($notCompleted = true)){print($_SESSION['cardnumber']);} ?>" required>
                                    </span>
                                </div>
                                <div class="col">
                                    <span>
                                        <br>Name on the card*<br>
                                        <input name="cardname" type="text" maxlength="60" value="<?php if(isset($_POST['submit_credit']) && ($notCompleted = true)){print($_SESSION['cardname']);} ?>" required><br>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span>CVC/CID*<br>
                                        <input name="cvccid" onkeyup="this.value=this.value.replace(/[^\d++]/,'')" maxlength="4" type="tel" value="<?php if(isset($_POST['submit_credit']) && ($notCompleted = true)){print($_SESSION['cvccid']);} ?>" required>
                                    </span>
                                </div>
                                <div class="col">
                                    <span>Expiration date*<br>
                                        <select name="month" required>
                                            <optgroup label="Month" required>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </optgroup>
                                        </select>
                                        <select name="year" required>
                                            <optgroup label="Year" required>
                                                <option value="2019">2019</option>
                                                <option value="2019">2020</option>
                                                <option value="2019">2021</option>
                                                <option value="2019">2022</option>
                                                <option value="2019">2023</option>
                                                <option value="2019">2024</option>
                                                <option value="2019">2025</option>
                                                <option value="2019">2026</option>
                                                <option value="2019">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                            </optgroup>
                                        </select>
                                    </span>
                                </div>
                                
                            </div>
                        <input name="submit_credit" class="btn btn-primary" id="paymentbutton-credit" type="submit" value="Proceed with credit payment"></input>
                    </form> 
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br>
</div>