<?php

?>
<form action='/checkout.php' method='POST'>
<select name='Kies uw bank'>
    <option>Kies uw bank..</option>
    <option value='ABN AMRO'>ABN AMRO</option>
    <option value='ASN Bank'>ASN Bank</option>
    <option value='Handelsbanken'>Handelsbanken</option>
    <option value='ING'>ING</option>
    <option value='Knab'>Knab</option>
    <option value='Moneyou'>Moneyou</option>
    <option value='Rabobank'>Rabobank</option>
    <option value='RegioBank'>RegioBank</option>
    <option value='SNS'>SNS</option>
    <option value='Triodos Bank'>Triodos Bank</option>
    <option value='Van Lanschot'>Van Lanschot</option>
    <option value='bunq'>bunq</option>
</select>
<br>
<input type='submit' value="Verder">
</form>

<?php

$abnamro = $_POST['ABN AMRO'];
$asnbank = $_POST['ASN Bank'];
$handelsbanken = $_POST['Handelsbanken'];
$ing = $_POST['ING'];
$knab = $_POST['Knab'];
$moneyou = $_POST['Moneyou'];
$rabobank = $_POST['Rabobank'];
$regiobank = $_POST['RegioBank'];
$sns = $_POST['SNS'];
$triodosbank = $_POST['Triodos Bank'];
$vanlanschot = $_POST['Van Lanschot'];
$bunq = $_POST['bunq'];

$verder = $_POST['Verder'];

if(!isset($verder)){
    if(isset($abnamro) || isset($asnbank) || isset($handelsbanken) || isset($ing)| isset($knab) || isset($moneyou) || isset($rabobank) || isset($regiobank) || isset($sns) || isset($triodosbank) || isset($vanlanschot) || isset($bunq)){
        echo('Gaat u verder');
        header('Location: /home');
    }else{
        echo('Kies een bank!');
    }

}



?>

