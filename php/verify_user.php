<?php
	include_once 'universal.php';
	include_once "connect_db.php";
	include_once 'Encryption.php';

	if(isset($_POST["selected_server"]) && isset($_POST["user_login"]) && isset($_POST["user_password"]))
	{
		$mailhost = $_POST["selected_server"];
	
	//decrypting password
		$encrypted_password   = $_POST["user_password"];
		$Encryption = new Encryption();
		$passwd = $Encryption->decrypt($encrypted_password, $passwordEncryptionKeyword);
		
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

		//inserting user's hit in db
			$hit_counter_qry = "INSERT INTO `hit_counter_hits` (`module_name`, `accessed_by`) VALUES ('Hit Counter', '$user')";
			@mysqli_query($connect_link ,$hit_counter_qry);

		//checking if user is admin
			if( contains("aditya.me16", $user) || contains("pic_auto", $user) ) //user is admin
			{
				setcookie('hit_counter_logged_admin_id', encrypt_decrypt('encrypt', $user), time()+($session_time*60), "/");
			    echo 3;
			}
			else
			{
				echo 2;
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