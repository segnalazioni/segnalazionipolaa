<?php
	include_once 'includes/db_connect.php';

	if (isset($_POST['id'])) {
    	$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

		$sql = "SELECT update_text, update_time FROM updates WHERE id_segnalazione = ".$id;

		$result = $mysqli->query($sql);
		$output = array(array());
		$i = 0;

		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$output[$i]['latitudine'] = $row["latitudine"];
				$output[$i]['longitudine'] = $row["longitudine"];
				$i++;
			}
			echo json_encode($output);
		} else {
			echo "0 results";
		}
	}
?>
