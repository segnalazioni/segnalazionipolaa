<?php
include_once 'db_connect.php';
include_once 'functions.php';

session_start();

if (isset($_POST['user'], $_POST['p'])) {
    $user = $_POST['user'];
    $password = $_POST['p'];
 	$loggato = login($user, $password, $mysqli);

    echo $loggato;
} else {
    // The correct POST variables were not sent to this page.
    echo "comp";
}
