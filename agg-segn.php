<?php
	include_once 'includes/db_connect.php';

	if (isset($_POST['tipo'], $_POST['descr'], $_POST['lat'], $_POST['lng'], $_POST['user'])) {
    	$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
    	$descr = filter_input(INPUT_POST, 'descr', FILTER_SANITIZE_STRING);
		$lat = filter_input(INPUT_POST, 'lat', FILTER_SANITIZE_STRING);
		$lng = filter_input(INPUT_POST, 'lng', FILTER_SANITIZE_STRING);
		$user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);

		$sql = "INSERT INTO segnalazioni (descrizione, latitudine, longitudine, stato, tipo, user, cat_id) VALUES ('".$descr."', ".$lat.", ".$lng.", 0, '".$tipo."', '".$user."', 1)";

		if ($mysqli->query($sql) === TRUE) {
    		echo "si";
		} else {
    		echo "no - query";
		}
	}else{
		echo "no - set";
	}
?>
