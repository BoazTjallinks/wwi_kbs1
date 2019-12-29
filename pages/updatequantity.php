<?php

if (isset($_GET['redirect']) && isset($_GET['catid']) && isset($_GET['newnr'])) {
    header('location: '.$_GET['redirect']);
}
else {
    header('location: /home');
}