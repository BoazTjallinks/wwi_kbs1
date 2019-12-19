<?php
$auth = new auth();
if (isset($_SESSION['isloggedIn'])) {
    echo $auth->logout();
}
header('location: /home');
