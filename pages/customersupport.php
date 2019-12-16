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
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['submitform'])){
    $checkContactForm= $database->DBQuery("SELECT first_name, last_name, email, reason_contact, order_nmr, phone_nmr FROM customerservice WHERE first_name = ? AND last_name = ? AND email = ? AND reason_contact = ? AND order_nmr = ? AND phone_nmr = ?",[$firstName, $lastName, $email, $reasonOfContact, $orderNmr, $phoneNumber]); 
    if($checkContactForm == "0 results found!"){
        $contactForm= $database->DBQuery("INSERT INTO customerservice (first_name, last_name, email, reason_contact, order_nmr, phone_nmr) values (?, ?, ?, ?, ?, ?)", [$firstName, $lastName, $email, $reasonOfContact, $orderNmr, $phoneNumber]); 
        echo "Thank you for your message, you will hear from us as soon as possible";
    }else
    echo "You can't submit the same form twice";
}
?>

<html>
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
</html>