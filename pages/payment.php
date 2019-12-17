<?php






if($_POST['submit_ideal']){

    $bank = $_POST['bank'];

    // var_dump($bank);
    print('Thank you for paying with '.$bank.'<br>Have a nice day!');


}elseif($_POST['submit_credit']){

    $cardnumber = $_POST['cardnumber'];
    $cardname = $_POST['cardname'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $cvccid = $_POST['cvccid'];
    
    if(!empty($cardnumber) AND !empty($cardname) AND !empty($month) AND !empty($year) AND !empty($cvccid)){
        print('goedzo');
    }else{
        print('nog niet alles ingevuld!');
    }


}else{ 
    echo('laatste else, gaat iets fout hierzo');
}




?>