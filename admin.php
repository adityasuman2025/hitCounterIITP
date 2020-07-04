<?php
	include_once 'php/universal.php';

	if( !isset($_COOKIE['thesis_uploader_admin_user_id']) )
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
		   		if( isset($_COOKIE['thesis_uploader_admin_user_id']) )
		   		{
		   			$thesis_uploader_admin_user_id = encrypt_decrypt('decrypt', $_COOKIE['thesis_uploader_admin_user_id']);
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
					<center style="align-content: flex-start; justify-content: center; align-items: flex-start; align-self: flex-start; " >
						<br />
						<div class="row">
							<span>Search By Roll or Name</span>
							<input type="text" id="serachInput" style="width: 210px;" />
						</div>
						<br />
						<div class="row">
							<span>Filter &nbsp</span>
							<input type="submit" class="btn filter_btn" value="Approved" style="width: 100px;" />
							<input type="submit" class="btn filter_btn" value="Not Approved" style="width: 100px;" />
						</div>
					</center>
					<br />
				</div>
			</div>
			<br/>
			<div class="error" id="error1"></div>
			<br/>
			
		<!------tab content display area-------->
			<div class="row table_card">
				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 tab_bar" style="border-right: 0px solid grey; " >
					<input type="submit" class="tabButton tabButton2 highlightedTabButton tabAll" value="All" />
					<input type="submit" class="tabButton tabButton2" value="BTech" />
					<input type="submit" class="tabButton tabButton2" value="MTech" />
					<input type="submit" class="tabButton tabButton2" value="PhD" />
					<input type="submit" class="tabButton tabButton2" value="Msc" />
				</div>
				<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 table_card2">
					<table class="table">
						<thead class="thead-dark notif_table_title person_entry_list_title">
							<tr>
						    	<th scope="col">Sl.</th>
						    	<th scope="col">Name</th>
						    	<th scope="col">Roll</th>
						    	<th scope="col">Title</th>
						    	<th scope="col">Supervisor Name</th>
						    	<th scope="col">Co-Supervisor Name</th>
						    	<th scope="col">Thesis</th>
						    	<th scope="col">Approved</th>
						    	<th scope="col">Add Supervisor</th>
						    	<th scope="col">Unlock</th>
						    </tr>
						</thead>

						<tbody class="notif_table_data"></tbody>
					</table>
				</div>
			</div>
		</div>

	<!--------overlay modal--------->
		<div class="overlay_backgrnd"></div>
		<div class="overlay_div">
			<div class="close_overlay_btn"></div>
			<br />
			<div class="overlay_content">
				<form style="width: 80%; margin: auto; color: #f1f1f1; " id="submit_thesis_form">
					<div class="form-group">
						<label >Supervisor Name</label>
						<input type="text" class="form-control" id="supervisor_name" >
					</div>

					<div class="form-group">
						<label >Supervisor Webmail</label>
						<input type="email" class="form-control" id="supervisor_email" >
					</div>

					<div class="form-group">
						<label>Co-Supervisor Name (optional)</label>
						<input type="text" class="form-control" id="co_supervisor_name" >
					</div>

					<div class="form-group">
						<label>Co-Supervisor Webmail (optional)</label>
						<input type="email" class="form-control" id="co_supervisor_email" >
					</div>
					<button type="submit" id="update_supervisors_btn" class="btn btn-success">Update</button>
				</form>
				<br/>
				<div class="error" id="error1"></div>
				<br/>
			</div>
		</div>

	<!---------script--------->
		<script type="text/javascript">
			session_length = "<?php echo $session_time; ?>";
			
		//on clicking on close btn
			$('.close_overlay_btn, .overlay_backgrnd').on("click", function()
			{
				$('.overlay_backgrnd').fadeOut(200);
				$('.overlay_div').fadeOut(200);
			});

		//function to handle cookies  
		    function setCookie(name,value,mins) 
		    {
		       var now = new Date();
		        var time = now.getTime();
		        var expireTime = time + 60000 * mins;
		        now.setTime(expireTime);
		        var tempExp = 'Wed, 31 Oct 2012 08:50:17 GMT';

		      document.cookie =  name + "=" + value + ";expires=" + now.toGMTString() + ";path=/";
		    }

		    function getCookie(name) {
		        var nameEQ = name + "=";
		        var ca = document.cookie.split(';');
		        for(var i=0;i < ca.length;i++) {
		            var c = ca[i];
		            while (c.charAt(0)==' ') c = c.substring(1,c.length);
		            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		        }
		        return null;
		    }

		    function eraseCookie(name) 
		    {
		    	var now = new Date(); 
		        document.cookie = name + '=; expires=' + now.toGMTString() + ";path=/";
		    }

		//fuction to handle when any tab button is pressed
			function handleTabBtnPressed( type ) {
				$('.tab_bar').find(".tabButton").each( function() {
					var tempType = $(this).attr('value');
					
					if( tempType == type ) {
						$(this).addClass("highlightedTabButton");
					} else {
						$(this).removeClass("highlightedTabButton");
					}
				});

				$('#serachInput').val("");

			//fetching and displaying data from database
				fetch_thesis_list( type );
			}

		//function to return selected tab_type
			function getSelectedTabType() {
				var tab_type = "All";
			//getting the selected tab type
				$('.tab_bar').find(".tabButton").each( function() {
					if( $(this).hasClass("highlightedTabButton") ) {
						var tempType = $(this).attr('value');
						tab_type = tempType;
					}
				});

				return tab_type;
			}
		
		//on clicking on logout btn
			$('#logout_btn').on('click', function()
			{
				$.post('php/logout.php', {}, function(data)
				{
					location.href = "index.php";
				});
			});

		//on clicking on any tab btn
			$('.tabButton').on("click", function() {
				var type = $(this).attr('value');
				handleTabBtnPressed( type );
			});

		//on clicking on filter btn
			$('.filter_btn').on("click", function(){
				var type = $(this).attr('value').trim();
				setCookie('thesis_uploader_filter_option', type, session_length);

				if($(this).hasClass("highlightedFilterBtn")) {
					$(this).removeClass("highlightedFilterBtn");
					setCookie('thesis_uploader_filter_option', "", session_length);
					location.reload();

					return;
				}

				$('.filter_btn').each( function() {
					var tempType = $(this).attr('value').trim();
					
					if( tempType == type ) {
						$(this).addClass("highlightedFilterBtn");
					} else {
						$(this).removeClass("highlightedFilterBtn");
					}
				});

				location.reload();
			});

		//on typing in search bar for searching by name or id
			$('#serachInput').keyup( function() {
				var input = $(this).val().trim();
				if( input == "" ) {
				//displaying content of the selected tab type
					handleTabBtnPressed( getSelectedTabType() );
				} else {
				//fetching data from server
					$.post( "php/search_thesis.php", { input: input }, function( result ) {
						// console.warn(result);
						if( result == "0" ) {
							$('.error').text("Failed to fetch data from database");
						} else if( result == "-1" ) {
							$('.error').text("Something went wrong");
						} else {
							$('.error').text("");

						//rendering list
							var jsonData = JSON.parse(result);
							render_thesis_list( jsonData );
						}
					});
				}
			});

		//function to fetch list from database as per selected tab and from datetime and to datetime
			function fetch_thesis_list( tab_type ) {
				$('.error').html("<img class=\"gif_loader\" src=\"img/loaders2.gif\">");

				$.post( "php/get_thesis_list.php", { tab_type: tab_type }, function( result ) {
					if( result == "0" ) {
						$('.error').text("Failed to fetch data from database");
					} else if( result == "-1" ) {
						$('.error').text("Something went wrong");
					} else {
						$('.error').text("");

					//rendering list
						var jsonData = JSON.parse(result);
						render_thesis_list( jsonData );
					}
				});
			}

		//function to render list from json fetched from database
			function render_thesis_list( jsonData ) {
				var project_url = "<?php echo $project_url; ?>";
				var upload_folder = "<?php echo $upload_folder; ?>";

				var filter_cookie = getCookie("thesis_uploader_filter_option");

				var html = "";

				var sl = 1;
				for( i in jsonData ) {
					var row_id					= jsonData[i].id;

					var roll 					= jsonData[i].roll;
					var name 					= jsonData[i].Name || jsonData[i].name || "NA";

					var thesis_title 			= jsonData[i].thesis_title || "NA";
					var supervisor 				= jsonData[i].supervisor || "NA";
					var cosupervisor 			= jsonData[i].cosupervisor || "NA";

					var thesis_link 			= jsonData[i].thesis_link;
					var thesis_location			= project_url + upload_folder + "/" + thesis_link;

				//approve status html
					var approve_status 			= jsonData[i].approve_status;
					var approve_html 			= "";
					var add_supervisor_html 	= "";
					if( approve_status == 0 ) {
					//pending
						approve_html = '<td class="warn_box"><span class="btn btn-primary resend_btn" row_id = "' + row_id + '" >Resend</td>';
						add_supervisor_html = '<span class="btn btn-primary add_supervisor_btn" array_key = "' + i + '" >Add</span>';
					} else if( approve_status == 1 ) {
					//approved
						approve_html = '<td class="strength_box">Yes</td>';
						add_supervisor_html = '';
					}

				//checking if filter is applied and showing list according to filter content
					if( filter_cookie == "Approved" ) {
						if( approve_status == 1 ) {
						} else {
							continue;
						}
					} else if( filter_cookie == "Not Approved" ) {
						if( approve_status == 0 ) {
						} else {
							continue;
						}
					}

				//html to render
					unlock_html = '<span class="btn btn-primary unlock_btn" row_id = "' + row_id + '">Unlock</span>';

					html += '<tr><th>' + ( sl ) + '</th><td>' + name + '</td><td>' + roll + '</td><td>' + thesis_title + '</td><td>' + supervisor + '</td><td>' + cosupervisor + '</td><td><a class="btn btn-xs btn-default view_btn" target="_blank" href="' + thesis_location + '"><img src="img/view.png" /></a></td>' + approve_html + '<td>' + add_supervisor_html + '</td><td>' + unlock_html +'</td></tr>';
					sl++;
				}

				$('.notif_table_data').html( html );

			//when clicked on unlock btn
				$('.unlock_btn').off().on( "click", function() {
					var row_id = $(this).attr('row_id');

				//sending rqst to api
					$.post( "php/unlock_thesis_by_id.php", { row_id: row_id }, function( resp ) {
						if(resp == 1 ) {
							$('.error').text("successfully unlocked").css("color", 'green');
							location.reload();
						} else if( resp == 0 ) {
							$('.error').text("failed to unlock").css("color", 'red');
						} else if( resp == -1 ) {
							$('.error').text("something went wrong").css("color", 'red');
						} else {
							$('.error').text("unkown error").css("color", 'red');

							console.log(resp);
						}
					});
				});

			//when clicked on resend btn
				$('.resend_btn').off().on( "click", function() {
					var row_id = $(this).attr('row_id');

				//sending rqst to api
					$.post( "php/resend_for_approval.php", { row_id: row_id }, function( resp ) {
						if(resp == 1 ) {
							$('.error').text("successfully sent").css("color", 'green');
							location.reload();
						} else if( resp == 0 ) {
							$('.error').text("failed to send").css("color", 'red');
						} else if( resp == -1 ) {
							$('.error').text("something went wrong").css("color", 'red');
						} else {
							$('.error').text("unknown error").css("color", 'red');

							console.log(resp);
						}
					});
				});

			//when clicked on resend btn
				$('.add_supervisor_btn').off().on( "click", function() {
					var key = $(this).attr('array_key');
					
				//displaying the overlay div and its content	
					$('.overlay_backgrnd').fadeIn(400);
					$('.overlay_div').fadeIn(400);

					var row_id					= jsonData[key].id;

					var supervisor 				= jsonData[key].supervisor || "";
					var cosupervisor 			= jsonData[key].cosupervisor || "";

					var supervisor_email 		= jsonData[key].semail || "";
					var cosupervisor_email 		= jsonData[key].cemail || "";

					$('#supervisor_name').val(supervisor);
					$('#co_supervisor_name').val(cosupervisor);
					$('#supervisor_email').val(supervisor_email);
					$('#co_supervisor_email').val(cosupervisor_email);

					$('#update_supervisors_btn').attr( "row_id", row_id );
				});
			}

		//on clciking on update supervisor btn
			$('#update_supervisors_btn').on( "click", function(e) {
				e.preventDefault();

				var row_id						= $('#update_supervisors_btn').attr("row_id").trim();
				
				var supervisor_name 			= $('#supervisor_name').val().trim();
				var co_supervisor_name 			= $('#co_supervisor_name').val().trim();

				var supervisor_email 			= $('#supervisor_email').val().trim();
				var co_supervisor_email 		= $('#co_supervisor_email').val().trim();

				if( row_id != "" && supervisor_name != "" && supervisor_email != "" ) {
					$('.error').html("<img class=\"gif_loader\" src=\"img/loaders2.gif\">");

					$.post( "php/update_thesis_supervisors.php", { row_id: row_id, supervisor_name: supervisor_name, co_supervisor_name: co_supervisor_name, supervisor_email: supervisor_email, co_supervisor_email: co_supervisor_email,  }, function( resp ) {
						if(resp == -1 ) {
							$('.error').text("Something went wrong").css("color", 'red');
						} else if(resp == -100 ) {
							$('.error').text("Database connection failed").css("color", 'red');
						} else if(resp == 0 ) {
							$('.error').text("Failed to update supervisors").css("color", 'red');
						} else if(resp == -4 ) {
							$('.error').text("Invalid supervisor or co-supervisor email").css("color", 'red');
						} else if(resp == 1 ) {
							$('.error').text("supervisors updated successfully").css("color", 'green');

							location.reload();
						} else {
							$('.error').text("Unknown error").css("color", 'red');
							console.log(resp);
						}
					});
				} else {
					$('.error').text("Supervisor name & email can't be empty").css("color", 'red');
				}
			});

		//by default All will be shown
			fetch_thesis_list( "All" );

		//by default some filter may be applied when screen is loaded
			var filter_cookie = getCookie("thesis_uploader_filter_option");
			$('.filter_btn').each( function() {
				var tempType = $(this).attr('value').trim();
				
				if( tempType == filter_cookie ) {
					$(this).addClass("highlightedFilterBtn");
				} else {
					$(this).removeClass("highlightedFilterBtn");
				}
			});
		</script>
	</body>
</html>