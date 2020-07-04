<?php
	include_once 'encrypt.php';

//global variables		
	$session_time = 60*24; //in minutes //1 day
	$project_title = "Hit Counter IIT Patna";

	$local_servers = [ "localhost", "localhost:8080" ];
	$website = $_SERVER['HTTP_HOST']; //dns address of the site
	if( in_array( $website, $local_servers ) )
	{	
		$project_address = "";

		$photo_folder = "../key_issue_api/stud_img/";
	}
	else
	{
		$project_address = "/var/www/html/hitCounterIITP/"; //change this address when deplying somewhere else

		$photo_folder = "../key_issue_api/stud_img/";
	}

	$isSomeOneLogged = false;
	if( isset($_COOKIE['hit_counter_logged_admin_id']) ) {
		$isSomeOneLogged = true;
	}
?>