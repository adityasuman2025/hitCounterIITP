<?php
	include_once 'php/universal.php';

	if( !$isSomeOneLogged )
		die("wrong attempt is made to access this page");
?>

<html>
	<head>
		<title>Admin | <?php echo $project_title; ?></title>

		<link href="css/bootstrap.min.css" rel="stylesheet"/>
		<link href="css/style.css" rel="stylesheet"/>
		<link rel="icon" href="img/logo.png" />
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script src="js/jquery.redirect.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale= 1">	
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="language" content="English">
		<meta name="author" content="Aditya Suman">	
	</head>
	<body>
	<!--------navigation bar---->
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      	<a class="navbar-brand">
		      		<div class="row">		      	
		      			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 x_m-p header_bar_title">
		      				<img src="img/logo.png" class="" />
		      				<!-- Indian Institute Of Technology Patna -->
		      				<?php echo $project_title; ?>
		      			</div>
		      		</div>
				</a>
		    </div>
		   		
		   	<?php
		   	//displyaing name of the user if he is logged in
		   		if( $isSomeOneLogged )
		   		{
		   			$hit_counter_logged_admin_id = encrypt_decrypt('decrypt', $_COOKIE['hit_counter_logged_admin_id']);
		   	?>		   		
			    <ul class="nav navbar-nav navbar-right">
			    	<li class="active">
			    		<a id="logout_btn" class="log_btn" style="background-color: red;">Logout</a>
			    	</li>
			    </ul>
		   	<?php		
		   		}
		   		else //showing login button
		   		{	   			
		   	?>
			   	<ul class="nav navbar-nav navbar-right">
			    	<li class="active">
			    		<a href="login.php" class="log_btn" style="background-color: #4ac12c;" >Login</a>
			    	</li>
			    </ul>
		   	<?php		
		   		}
		   	?>
		  </div>
		</nav>

	<!--------main container------>
		<div class="container-fluid">
		<!------admin search and list by datetime feature-------->
			<div class="row sudent_card">
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 x_m-p">
					<?php
						$user_img_src = "img/user";
						$extension = ".png";
					?>
					<img src="<?php echo $user_img_src . $extension; ?>" >
					<center><h3>Welcome Admin</h3></center>
				</div>

				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 x_m-p">
					
				</div>
			</div>
			<br/>
			<div class="error" id="error1"></div>
			<br/>
			
		<!------tab content display area-------->
			<div class="row table_card">
				<table class="table">
					<thead class="thead-dark notif_table_title person_entry_list_title">
						<tr>
					    	<th scope="col">Sl.</th>
					    	<th scope="col">Module Name</th>
					    	<th scope="col">Total Hits</th>
					    </tr>
					</thead>

					<tbody class="notif_table_data"></tbody>
				</table>
			</div>
		</div>

	<!---------script--------->
		<script type="text/javascript">
			session_length = "<?php echo $session_time; ?>";

		//on clicking on logout btn
			$('#logout_btn').on('click', function()
			{
				$.post('php/logout.php', {}, function(data)
				{
					location.href = "index.php";
				});
			});

		</script>
	</body>
</html>