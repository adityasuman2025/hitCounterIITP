<?php
	include_once 'encrypt.php';

//global variables		
	$session_time = 60*24; //in minutes //1 day
	$project_title = "Thesis Uploader IIT Patna";

	$depts = ["CB", "CE", "CH", "CS", "EE", "HS", "ME", "MM", "MC", "PH"];
	$depts_name = [ "Chemical & Biochemical Engineering", "Civil & Environmental Engineering", "Chemistry", "Computer Science & Engineering", "Electrical Engineering", "Humanities & Social Sciences", "Mechanical Engineering", "Metallurgical & Materials Engineering", "Maths", "Physics" ];
	$local_servers = [ "localhost", "localhost:8080" ];

	$thesis_approval_file = "approve.php?value=";

	$website = $_SERVER['HTTP_HOST']; //dns address of the site

	$secret_key = "&&_yo_yo__bhemu_singh_&&";

	$project_name = "thesisUploaderIITP";
	$project_url = "http://" . $website . "/" . $project_name . "/";

	if( in_array( $website, $local_servers ) )
	{	
		$project_address = "";

		$upload_folder = "pdf";
		$photo_folder = "../key_issue_api/stud_img/";
	}
	else
	{
		$project_address = "/var/www/html/" . $project_name . "/"; //change this address when deplying somewhere else

		$upload_folder = "pdf";
		$photo_folder = "../key_issue_api/stud_img/";
	}

	$isSomeOneLogged = false;
	if(isset($_COOKIE['thesis_uploader_logged_user_roll']) || isset($_COOKIE['thesis_uploader_logged_prof_roll']) )
	{
		$isSomeOneLogged = true;
	}
?>