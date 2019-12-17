<?php


if (isset($_GET['itemid']) && isset($_GET['redirect'])) {
    // unset();
    $itemid = $_GET['itemid'];
    $redirect = $_GET['redirect'];

    if (isset($_SESSION['shoppingCart'])) {
        for ($i=0; $i < count($_SESSION['shoppingCart']); $i++) {
            if ($_SESSION['shoppingCart'][$i] !== 'nAn') {
                if ($_SESSION['shoppingCart'][$i]['ItemID'] == $itemid) {
                    $_SESSION['shoppingCart'][$i] = 'nAn';
                    header('location: '.$redirect.'#cart');
                }
            } else {
                header('location: /home');
            }
        }
    } else {
        header('location: /home');
    }
} else {
    header('location: /home');
}
