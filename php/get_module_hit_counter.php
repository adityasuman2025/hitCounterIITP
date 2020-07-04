<?php
	include_once "connect_db.php";

	$mysql_qry   = "SELECT * FROM hit_counter_hits WHERE module_name = '$module_name' ";
	
	$data_array = array();
	if( $result = @mysqli_query($connect_link ,$mysql_qry) ) {
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($data_array, $row);
		}
	}
?>