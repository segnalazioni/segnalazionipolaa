<?php
	include_once 'includes/db_connect.php';

	$sql = "SELECT latitudine, longitudine, descrizione, tipo, stato, user, quando, cat_id, seg_id FROM segnalazioni";

	$result = $mysqli->query($sql);
	$output = array(array());
	$i = 0;

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$output[$i]['latitudine'] = $row["latitudine"];
			$output[$i]['longitudine'] = $row["longitudine"];
			$output[$i]['descrizione'] = $row["descrizione"];
			$output[$i]['tipo'] = $row["tipo"];
			$output[$i]['stato'] = $row["stato"];
			$output[$i]['user'] = $row["user"];
			$output[$i]['quando'] = $row["quando"];
			$output[$i]['cat_id'] = $row["cat_id"];
			$output[$i]['seg_id'] = $row["seg_id"];
			$i++;
		}
		echo json_encode($output);
	} else {
		echo "0 results";
	}
?>
