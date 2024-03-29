<?php
/* Database connectie openen */ 
$database = new database();
/* Variabelen definiëren */ 
$email = $firstName = $lastName = $orderNmr = $reasonOfContact = $phoneNumber = "";

/* Check tegen injections */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["emailaddress"]);
    $firstName = test_input($_POST["firstname"]);
    $lastName = test_input($_POST["lastname"]);
    $orderNmr = test_input($_POST["ordernumber"]);
    $reasonOfContact = test_input($_POST["reasonofcontact"]);
    $phoneNumber = test_input($_POST['phonenumber']);
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
/* Einde check */

/*Check om te kijken of het formulier dat gesubmit wordt door de bezoeker/klant al bestaat in de database
Als het formulier al bestaat wordt er een foutmelding gegeven anders wordt er een melding gegeven dat het gesubmit is */ 
if (isset($_POST['submitform'])) {
    $checkContactForm= $database->DBQuery("SELECT first_name, last_name, email, reason_contact, order_nmr, phone_nmr FROM customerservice WHERE first_name = ? AND last_name = ? AND email = ? AND reason_contact = ? AND order_nmr = ? AND phone_nmr = ?", [$firstName, $lastName, $email, $reasonOfContact, $orderNmr, $phoneNumber]);
    if ($checkContactForm == "0 results found!") {
        $contactForm= $database->DBQuery("INSERT INTO customerservice (first_name, last_name, email, reason_contact, order_nmr, phone_nmr) values (?, ?, ?, ?, ?, ?)", [$firstName, $lastName, $email, $reasonOfContact, $orderNmr, $phoneNumber]);
        echo showSwall('Form submitted', "You will hear from us as soon as possible!", "success", "");
    } else {
        echo showSwall('Form not submitted', "You can't submit the same form twice", "error", "");
    }
}
/* Database connectie sluiten */ 
$database->closeConnection();
?>


<!-- Oude code om het fomulier te testen nog geen opmaak
    <form method="POST" action="/customersupport">
* = required
</br>
*E-mail address: <input type="email" name="emailaddress" placeholder="example@example.com" maxlength="320" required>
</br>
*First name: <input type="text" name="firstname" maxlength="45" required>
*Last name: <input type="text" name="lastname" maxlength="45" required>
Mobile/Phonenumber: <input type='tel' name='phonenumber' placeholder='06-12345678'maxlength="11">
</br>
 Order number: <input type="number" name="ordernumber" min="1" max="99999999" rows="20" maxlength="8">
</br>
*Reason of contact: <textarea style="resize:none" name="reasonofcontact" cols="50" rows="20" maxlength='1000' placeholder='Type your reason here....'required></textarea>
</br>
<input type="submit" name="submitform" value='Submit Form'>
</form> 
Einde oude code-->

<!-- Input formulier voor het contacteren van customer support--> 
<section id="customerSupport" class="wwi_50minheight wwi_50width wwi_center wwi_margin_top_normal wwi_mat_3">
    <form method="POST" action="/customersupport" class="wwi_padding_normal">
    <h1>Contact form</h1>
        <?php
            echo '*Required';
            echo showInput(1, ['emailaddress'], ['csupportEmail'], ['*Email address'], ['email'], [''], ['Example@example.com'], ['wwi_mat_3'], [true]);
            echo '<div class="form-row">';
            echo showInput(2, ['firstname', 'lastname'], ['csupportFirstname', 'csupportLastname'], ['*First name', '*Last name'], ['text', 'text'], ['col-md-6', 'col-md-6'], ['', ''], ['wwi_mat_3', 'wwi_mat_3'], [true, true]);
            echo '</div>';
            echo '<div class="form-row">';
            echo showInput(2, ['phonenumber', 'ordernumber'], ['csupportPhonenumber', 'csupportOrdernumber'], ['Phone number', 'Order Number'], ['tel', 'number'], ['col-md-6', 'col-md-6'], ['06-12345678', ''], ['wwi_mat_3', 'wwi_mat_3'], ['', '']);
            echo '</div>';
        ?>
        <div class="form-group">
            <textarea class="wwi_mat_3 wwi_100procwidth" style="resize: none" name="reasonofcontact" cols="94" rows="12" maxlength='1000' placeholder='*Type your questions or concerns here....'required></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submitform" value="Submit contact form">
        </div>
    </form>
</section>
<!--Einde input formulier-->