<?php






if((isset($_POST['submit_ideal']) || isset($_POST['submit_credit'])) AND !(isset($_POST['submit_ideal']) AND isset($_POST['submit_credit']))){

    if(isset($_POST['submit_ideal'])){
        $_SESSION['bank'] = $_POST['bank'];
        $_SESSION['cardnumber'] = '';
        $_SESSION['cardname'] = '';
        $_SESSION['month'] = '';
        $_SESSION['year'] = '';
        $_SESSION['cvccid'] = '';
        echo('
            <div class="container">
                <div class="row">
                    <div class="col">
                    <br><br><br><br><br><br><br><br><br><br><br><br><br>
                        <div class="modal fade show" role="dialog" tabindex="-1" style="display: block;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Payment succeeded</h4><a href="/home"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></a></div>
                                    <div class="modal-body">
                                        <p>Thank you for paying with '.$_SESSION['bank'].'.<br>Until next time!</p>
                                    </div>
                                    <div class="modal-footer"><a href="/home"><button class="btn btn-primary" id="go-homepage-button" type="button">Go to homepage</button></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>');

        // var_dump($_SESSION['bank'].' '.$_SESSION['cardnumber'].' '.$_SESSION['cardname'].' '.$_SESSION['month'].' '.$_SESSION['year'].' '.$_SESSION['cvccid']);
    }
    
    
    if(isset($_POST['submit_credit'])){
        $_SESSION['bank'] = 'credit';
        $_SESSION['cardnumber'] = $_POST['cardnumber'];
        $_SESSION['cardname'] = $_POST['cardname'];
        $_SESSION['month'] = $_POST['month'];
        $_SESSION['year'] = $_POST['year'];
        $_SESSION['cvccid'] = $_POST['cvccid'];
        
        // var_dump($_SESSION['bank'].' '.$_SESSION['cardnumber'].' '.$_SESSION['cardname'].' '.$_SESSION['month'].' '.$_SESSION['year'].' '.$_SESSION['cvccid']);


        if(!empty($_SESSION['cardnumber']) AND !empty($_SESSION['cardname']) AND !empty($_SESSION['month']) AND !empty($_SESSION['year']) AND !empty($_SESSION['cvccid'])){
            echo('
            <div class="container">
                <div class="row">
                    <div class="col">
                    <br><br><br><br><br><br><br><br><br><br><br><br><br>
                        <div class="modal fade show" role="dialog" tabindex="-1" style="display: block;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Payment succeeded</h4><a href="/home"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></a></div>
                                    <div class="modal-body">
                                        <p>Thank you for paying with '.$_SESSION['bank'].'.<br>Until next time!</p>
                                    </div>
                                    <div class="modal-footer"><a href="/home"><button class="btn btn-primary" id="go-homepage-button" type="button">Go to homepage</button></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>');
        }else{
            echo('You didn\'t correctly fill in the form. Please fill all fields!');
        }
    }
}else{
    header('Location: /checkout');
}



?>