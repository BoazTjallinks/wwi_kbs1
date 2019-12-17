<?php
/* ------------------- OUDE CHECKOUT, NIET GEBRUIKEN, NIET VERWIJDEREN ---------------------*/ 
// print("<!-- <form action='/checkout.php' method='POST'><select name='Kies uw bank'><option>Kies uw bank..</option><option value='ABN AMRO'>ABN AMRO</option><option value='ASN Bank'>ASN Bank</option><option value='Handelsbanken'>Handelsbanken</option><option value='ING'>ING</option><option value='Knab'>Knab</option><option value='Moneyou'>Moneyou</option><option value='Rabobank'>Rabobank</option><option value='RegioBank'>RegioBank</option><option value='SNS'>SNS</option><option value='Triodos Bank'>Triodos Bank</option><option value='Van Lanschot'>Van Lanschot</option><option value='bunq'>bunq</option></select><br><input type='submit' value='Verder'></form> -->"); 
// $abnamro = $_POST['ABN AMRO'];// $asnbank = $_POST['ASN Bank'];// $handelsbanken = $_POST['Handelsbanken'];// $ing = $_POST['ING'];// $knab = $_POST['Knab'];// $moneyou = $_POST['Moneyou'];// $rabobank = $_POST['Rabobank'];// $regiobank = $_POST['RegioBank'];// $sns = $_POST['SNS'];// $triodosbank = $_POST['Triodos Bank'];// $vanlanschot = $_POST['Van Lanschot'];// $bunq = $_POST['bunq'];// $verder = $_POST['Verder']; 
// if(!isset($verder)){//     if(isset($abnamro)){//         echo('Gaat u verder');//         header('Location: /home');//     }else{//         echo('Kies een bank!');//     }// } 
/* ------------------- OUDE CHECKOUT, NIET GEBRUIKEN, NIET VERWIJDEREN ---------------------*/ 
// session_start();

// include('/payment.php');

?>

<div class="container">
        <div>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-1">iDeal</a></li>
                <li class="nav-item"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-2">Creditcard</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="tab-1">
                    <div class="form-group">

                        <form action="/payment" method="post" name="form_ideal">
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
                    <!-- <br><br><br><br><br><br> -->
               </div>


                <div class="tab-pane" role="tabpanel" id="tab-2">
                    <div class="form-group">
                        <form action="/payment" method="post" name="form_credit">
                            <div class="row">
                                <div class="col">
                                    <span>
                                        <br>Card number*<br>
                                        <input name="cardnumber" type="tel" onkeyup="this.value=this.value.replace(/[^\d++]/,'')" maxlength="19" value="<?php $_SESSION['cardnumber'] ?>" required>
                                    </span>
                                </div>
                                <div class="col">
                                    <span>
                                        <br>Name on the card*<br>
                                        <input name="cardname" type="text" maxlength="60" required><br>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span>CVC/CID*<br>
                                        <input name="cvccid" onkeyup="this.value=this.value.replace(/[^\d++]/,'')" maxlength="4" type="tel" required>
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
                <!-- <br><br><br> -->
            </div>
        </div>
        
    </div>
    <br><br><br><br><br><br>

</div>
    