<?php
$database = new database();
$email = $firstName = $lastName = $orderNmr = $reasonOfContact = $phoneNumber = "";

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

if (isset($_POST['submitform'])) {
    $checkContactForm= $database->DBQuery("SELECT first_name, last_name, email, reason_contact, order_nmr, phone_nmr FROM customerservice WHERE first_name = ? AND last_name = ? AND email = ? AND reason_contact = ? AND order_nmr = ? AND phone_nmr = ?", [$firstName, $lastName, $email, $reasonOfContact, $orderNmr, $phoneNumber]);
    if ($checkContactForm == "0 results found!") {
        $contactForm= $database->DBQuery("INSERT INTO customerservice (first_name, last_name, email, reason_contact, order_nmr, phone_nmr) values (?, ?, ?, ?, ?, ?)", [$firstName, $lastName, $email, $reasonOfContact, $orderNmr, $phoneNumber]);
        echo "Thank you for your message, you will hear from us as soon as possible";
    } else {
        echo "You can't submit the same form twice";
    }
}
$database->closeConnection();
?>
<!-- <form method="POST" action="/customersupport">
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
</form> -->

<section id="customerSupport" class="wwi_50minheight wwi_50width wwi_center wwi_margin_top_normal wwi_mat_3">
    <form method="POST" action="/customersupport" class="wwi_padding_normal">
    <h1>Contact form</h1>
        <?php
            echo showInput(1, ['emailaddress'], ['csupportEmail'], ['Email address'], ['email'], [''], [''], ['wwi_mat_3'], [true]);
            echo '<div class="form-row">';
            echo showInput(2, ['firstname', 'lastname'], ['csupportFirstname', 'csupportLastname'], ['First name', 'Last name'], ['text', 'text'], ['col-md-6', 'col-md-6'], ['', ''], ['wwi_mat_3', 'wwi_mat_3'], [true, true]);
            echo '</div>';
            echo '<div class="form-row">';
            echo showInput(2, ['phonenumber', 'ordernumber'], ['csupportPhonenumber', 'csupportOrdernumber'], ['Phone number', 'Order Number'], ['tel', 'number'], ['col-md-6', 'col-md-6'], ['', ''], ['wwi_mat_3', 'wwi_mat_3'], [true, '']);
            echo '</div>';
        ?>
        
        <!-- * = required
        </br>
        *E-mail address: <input type="email" name="emailaddress" placeholder="example@example.com" maxlength="320" required>
        </br>
        *First name: <input type="text" name="firstname" maxlength="45" required>
        *Last name: <input type="text" name="lastname" maxlength="45" required>
        Mobile/Phonenumber: <input type='tel' name='phonenumber' placeholder='06-12345678'maxlength="11">
        </br>
        Order number: <input type="number" name="ordernumber" min="1" max="99999999" rows="20" maxlength="8"> -->
        <div class="form-group">
            <textarea class="wwi_mat_3 wwi_100procwidth" name="reasonofcontact" cols="50" rows="20" maxlength='1000' placeholder='*Type your questions or concerns here....'required></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submitform" value="Submit contact form">
        </div>
    </form>
</section>