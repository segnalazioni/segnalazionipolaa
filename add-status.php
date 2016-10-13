<?php
	include_once 'includes/db_connect.php';

	if (isset($_POST['text'], $_POST['id'])) {
    	$text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING);
    	$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

		$sql = "INSERT INTO updates (update_text, id_segnalazione) VALUES ('".$text."', ".$id.")";

		if ($mysqli->query($sql) === TRUE) {
    		echo "si";
		} else {
    		echo "no - query";
		}
	}else{
		echo "no - set";
	}
?>
