<?php
	include_once "connect_db.php";

	$mysql_qry   = "SELECT module_name, COUNT(id) AS hit_count FROM hit_counter_hits GROUP BY module_name ORDER BY module_name";
	
	$data_array = array();
	if( $result = @mysqli_query($connect_link ,$mysql_qry) ) {
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($data_array, $row);
		}
	}
?>