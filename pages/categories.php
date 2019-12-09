<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * Shows al items in categorie
 */

function checkGetParams() {
    if (!isset($_GET['catid']) || !isset($_GET['page'])){
        header('location: /home');
    }
}

function checkFilterSession() {
    $options = [
        "limit",
        "colorid",
        "minprice",
        "maxprice",
        "size"
    ];

    $defaultvalue = [
        25,
        0,
        0,
        0,
        "na"
    ];
    
    for ($i=0; $i < count($options); $i++) {
        if (!isset($_SESSION[$options[$i]])) {
            $_SESSION[$options[$i]] = $defaultvalue[$i];
        }
    }
}

function clearSession($clearId) {
    $options = [
        "limit",
        "colorid",
        "minprice",
        "maxprice",
        "size"
    ];

    $defaultvalue = [
        25,
        0,
        0,
        0,
        "na"
    ];

    for ($i=0; $i < count($options); $i++) {
        if ($clearId == $options[$i]) {
            $_SESSION[$options[$i]] = $defaultvalue[$i];
        }
    }
}

checkGetParams();
checkFilterSession();
print_r($_SESSION);