<?php
include_once 'db_connect.php';
include_once 'functions.php';

session_start();

if (isset($_POST['user'], $_POST['p'])) {
    $user = $_POST['user'];
    $password = $_POST['p'];
    $result = $mysqli->query("SELECT times FROM login_attempts INNER JOIN users ON login_attempts.user_id = users.id WHERE username='$user' LIMIT 1;");

    while ($row = $result->fetch_assoc()) {
        $times = $row["times"];
    }

    if($times < 5) {
        $loggato = login($user, $password, $mysqli);

        echo $loggato;
    }else{
        echo "over";
    }
} else {
    // The correct POST variables were not sent to this page.
    echo "comp";
}
