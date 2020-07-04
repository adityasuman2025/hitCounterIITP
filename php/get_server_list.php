<?php
	include_once "connect_db.php";

	$mysql_qry   = "SELECT * FROM hit_counter_server_list ORDER BY server_sr";
	
	$data_array = array();
	if( $result = @mysqli_query($connect_link ,$mysql_qry) ) {
		
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($data_array, $row);
		}

		print_r(json_encode($data_array));
	}
?>