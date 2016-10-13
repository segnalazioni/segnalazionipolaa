<?php
	include_once 'includes/db_connect.php';

	if (isset($_POST['nuovostato'], $_POST['id'])) {
    	$stato = filter_input(INPUT_POST, 'nuovostato', FILTER_SANITIZE_STRING);
    	$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

		$sql = "UPDATE segnalazioni SET stato=".$stato." WHERE seg_id=".$id.";";


		if ($mysqli->query($sql) === TRUE) {
    		echo "si";
		} else {
    		echo "no - query";
		}
	}else{
		echo "no - set";
	}
?>
