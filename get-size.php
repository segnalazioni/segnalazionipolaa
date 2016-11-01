<?php
	include_once 'includes/db_connect.php';

	if (isset($_POST['id'])) {
    	$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

		$sql = "SELECT COUNT(id_update) FROM updates WHERE id_segnalazione = ".$id;

		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			echo $result;
		} else {
			echo 0;
		}
	}
?>
