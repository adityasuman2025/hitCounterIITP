<?php
	include_once ('php/universal.php');
?>
<html>
<head>
	<title>Login | <?php echo $project_title; ?></title>
	<link href="css/login.css" rel="stylesheet"/>
	<link rel="icon" href="img/logo.png" />
	<script type="text/javascript" src="js/jquery.min.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale= 1">	
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="English">
	<meta name="author" content="Aditya Suman">	
</head>
<body>
	<center>		
		<form class="login_form" style="display: none;">
			<div class="header">
				<img src="img/logo.png" id="iitp_logo" />
				<br />
				<?php echo $project_title; ?>
			</div>
			<br>
			<div id="mail_server_list"></div>
			
			<input type="text" id="user_login" placeholder="Webmail ID">
			<br><br>

			<input type="password" id="user_password" placeholder="Password">
			<br><br>

			<input class="button" id="btn" type="submit" value="Submit">		
		</form>
		<div class="error" id="error1"></div>
		<br>
	</center>

	<script type="text/javascript">
	//populating mail server radio buttons in the form	
		$('#error1').html("<img class=\"gif_loader\" src=\"img/loaders2.gif\">");

		$.get('php/get_server_list.php', {}, function(data)
		{
			$('#error1').text("");			

			var html = "";
			var arr = JSON.parse(data);		
			for(i in arr)
			{			
				var domain_name = (arr[i]['domain_name']);
				var domain_ip = (arr[i]['domain_ip']);
				var server_name = (arr[i]['server_name']);
				var domain_name_short = (arr[i]['domain_name_short']);	

				html += '<input class="radio_input" type="radio" name="selected_server" value="' + domain_ip + '" /> ' + server_name + " ";
			}	

			$('#mail_server_list').html(html);
			$('.login_form').fadeIn(100);

		//on clicking on submit btn
			$('#btn').on('click', function(e)
			{	
				e.preventDefault();
				
				var user_login = $('#user_login').val().trim();
				var user_password = $('#user_password').val();
				var selected_server = $('[name="selected_server"]:checked').val();

				if(user_login!="" && user_password !="" && selected_server!=undefined)
				{
					$('#error1').text("");
					$('#error1').html("<img class=\"gif_loader\" src=\"img/loaders2.gif\">");

					$.post('php/verify_user.php', {user_login: user_login, user_password: user_password, selected_server:selected_server}, function(data)
					{
						console.log(data);
						
						if(data == 0)
						{
							$('#error1').text("Please fill all the fields");
						}
						else if(data == -100)
						{
							$('#error1').text("Database connection failed");
						}
						else if(data == -1)
						{
							$('#error1').text("Invalid email or password");	
						}
						else if(data == -2)
						{
							var website = "<?php echo $website ?>";
							var registerURL = "http://" + website + "/profile/";

							$('#error1').html('<br/>You are not registered on the portal - <a href="' + registerURL + '" target="_blank" style="color: cyan; text-decoration: none; ">' + registerURL + '</a> <br />Please register and sign in back to this portal.').css("color", "#f1f1f1");
						}
						else if(data == 1) //stud
						{
							location.href = "student.php";
						}
						else if(data == 2) //prof
						{
							location.href = "prof.php";
						}
						else if(data == 3) //admin
						{
							location.href = "admin.php";
						}
						else
						{
							$('#error1').text("Unknown error");	
						}
					});	
				}
				else
				{
					$('#error1').text("Please fill all the fields");
				}
			});
		});
	</script>
</body>
</html>