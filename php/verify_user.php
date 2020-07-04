<?php
	include_once "connect_db.php";

	if(isset($_POST["selected_server"]) && isset($_POST["user_login"]) && isset($_POST["user_password"]))
	{
		$mailhost = $_POST["selected_server"];
		$passwd   = $_POST["user_password"];
		
	//accepting full or short email both
		$user     = $_POST["user_login"];
		if(contains("@iitp.ac.in", $user))
		{
			$user = str_replace("@iitp.ac.in", "", $user);
		}
		
		if( in_array( $website, $local_servers ) )
			$pop = true;
		else
			$pop = imap_open('{' . $mailhost . '}', $user, $passwd);

		if ($pop == false) //email id not found in official iit patna's database
		{
			echo -1;
		} 
		else 
		{
			if( in_array( $website, $local_servers ) )
			{}
			else
				imap_close($pop);

		//inserting user's hit in db (adityas_module_hit_counter)
			$hit_counter_qry = "INSERT INTO `adityas_module_hit_counter` (`module_name`, `accessed_by`) VALUES ('Thesis Uploader', '$user')";
			@mysqli_query($connect_link ,$hit_counter_qry);

		//checking if user is admin
			if(contains("Adean_academic", $user) || contains("adean_academic", $user) || contains("asb", $user) || contains("pic_auto", $user) || contains("pic_library", $user)) //user is admin
			{
				setcookie('thesis_uploader_admin_user_id', encrypt_decrypt('encrypt', $user), time()+($session_time*60), "/");
			    echo 3;
			}
			else
			{
			//checking if user is registered or not
				$email_address = $user . "@iitp.ac.in";
				$sql   = "SELECT * FROM studentinfo where email = '$email_address'";

				$query = mysqli_query($connect_link ,$sql);
				if ($query->num_rows == 0) // user is not registered
				{			
					echo -2;				
				}
				else 
				{				
					$row      = $query->fetch_assoc();
					
					$rollno   = $row['Roll No'];
			        $name     = $row['Name'];
			        $prog     = $row['prog'];
			      	
		      	//getting branch of the logged user
			      	$branch = "Invalid Branch";
			      	foreach ( $depts as $key => $dept ) {
			      		if ( strpos( $rollno, $dept ) == True ) { 
						   $branch = $depts_name[ $key ];
						}
			      	}

			    //if logging user is a prof
			      	if( $prog == "Faculty" ) {
			      		setcookie('thesis_uploader_logged_prof_roll', encrypt_decrypt('encrypt', $rollno), time()+($session_time*60), "/");
						setcookie('thesis_uploader_logged_prof_name', encrypt_decrypt('encrypt', $name), time()+($session_time*60), "/");
						setcookie('thesis_uploader_logged_prof_id', encrypt_decrypt('encrypt', $user), time()+($session_time*60), "/");

						echo 2;
			      	} else {
			      	//student
					//setting cookie							
						setcookie('thesis_uploader_logged_user_roll', encrypt_decrypt('encrypt', $rollno), time()+($session_time*60), "/");
						setcookie('thesis_uploader_logged_user_name', encrypt_decrypt('encrypt', $name), time()+($session_time*60), "/");
						setcookie('thesis_uploader_logged_user_id', encrypt_decrypt('encrypt', $user), time()+($session_time*60), "/");
						setcookie('thesis_uploader_logged_user_branch', encrypt_decrypt('encrypt', $branch), time()+($session_time*60), "/");
						setcookie('thesis_uploader_logged_user_course', encrypt_decrypt('encrypt', $prog), time()+($session_time*60), "/");

						echo 1;
			      	}
				}
			}
		}
	}
	else
	{
		echo 0;
	}

	function contains($needle, $haystack)
	{
	    return strpos($haystack, $needle) !== false;
	}
?>