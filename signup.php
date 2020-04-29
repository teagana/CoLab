<?php
	ob_start();
	
	require "config.php";

	//if the user is already logged in, redirect them to the search page
	//since they shouldn't be able to sign up when they're logged in
    if( isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {

		header('Location: search.php');

	}

	//user not logged in; let them sign up
	else {

		//open SQL connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}
		
		//if the user hit the signup button
		if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) 
			&& isset($_POST['password']) && isset($_POST['confirm-password'])) {
			
			//if any of the fields are empty, set error
			if(empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['email']) 
			|| empty($_POST['password']) || empty($_POST['confirm-password'])) {
				$error = "please fill out all fields";
			}
			
			//make sure the password and confirm-password match
			else if($_POST['password'] != $_POST['confirm-password']) {
				$error = "make sure your password confirmation matches your password";
			}

			//user correctly filled out all fields; sign them up
			else {
				
				$first_name = $_POST['fname'];
				$last_name = $_POST['lname'];
				$emailInput = $_POST["email"];
				$passwordInput = $_POST["password"];
				//hash user input of password to compare this string to the password stored in the users table
				$passwordInput = hash("sha256", $passwordInput);
				
				//check to make sure no one with this email has already signed up
				$sql_registered = "SELECT * FROM users WHERE user_email='" . $emailInput . "';";

				$results_registered = $mysqli->query($sql_registered);
				if(!$results_registered) {
					echo $mysqli->error;
				}

				//if there is one match or more, that means a user with this username or email already exists -- display error
				if($results_registered->num_rows > 0) {
					$error = "email is already taken. please user a different one.";
				}

				//email is NOT already in use; insert into db, set session variables, redirect to edit_profile page
				else {

					//insert new user into the database
					//FINISH THIS
					$sql = "INSERT INTO users(user_first, user_last, user_email, user_password)
						VALUES('" . $first_name . "', '" . $last_name . "', '" . $emailInput . "', '" . $passwordInput . "');";

					$results = $mysqli->query($sql);
					if(!$results) {
						echo $mysqli->error;
					}

					//get the user_id from that insertion
					$get_user_id = $mysqli->query($sql_registered);
					if(!$get_user_id) {
						echo $mysqli->error;
					}

					$row = $get_user_id->fetch_assoc();

					//log user in
					$_SESSION['logged_in'] = true;
					$_SESSION['email'] = $emailInput;
					$_SESSION['user_id'] = $row['user_id'];

					
					header('Location: edit_profile.php');
				}
			}
		}
	}
		
	// hidding pofile if not looged in and showing when is.
		if ($_SESSION['logged_in'] == 'profile-hide') {
			$showdiv = 'profile-hide';
		} else if ($_SESSION[''] == '') {

		}

		echo "<script>document.getElementById('".$showdiv."').style.display = 'block';</script>";

	// $sql_users = "SELECT * FROM users;";

	// $results_users = $mysqli->query( $sql_users );

	// if ( $results_users == false ) {
	// 	echo $mysqli->error;
	// 	$mysqli->close();
	// 	exit();
	// }

	// $mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>CoLab</title>
	
	<!-- BOOTSTRAP CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta charset=“utf-8”>

	<style>
		#container {
			height: initial;
		}
	</style>

	<!-- Hotjar Tracking Code for https://460.itpwebdev.com/~colab/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1758353,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
</head>
<body>

	<!-- the header at the top -->
    <nav id="header">
        <div><a href="search.php"><img src="icons/nav-logo.png" alt="CoLab" class="nav-profile"></a></div>
        <div id="nav-logged-in">
            <div class="nav-profile" id="profile-hide" style="display: none;"><a href="profile_page.php"><img src="icons/nav-placeholder.png" alt="Pofile Picture" class="nav-profile"></a></div>
        </div>    
    </nav>

    <!-- main body, including login/signup card -->
    <div id="container" class="container d-flex justify-content-start align-items-center">
    	<div class="card login-card rounded">
		  <div id="card-body" class="card-body">
		  	<h5 class="card-title card-name">Sign-up for CoLab</h5>

		  	<!-- form for signing up -->
		  	<!-- temporarily just redirect to home page -->
		  	<form id="signup-form" action="signup.php" method="POST">
			  <div class="form-group">
			    <label class="card-subtitle mb-2 text-muted" for="fname"><h4 class="label">FIRST NAME *</h4></label>
			    <input type="text" class="form-control" id="fname" name="fname">
			  </div>
			  <div class="form-group">
			    <label class="card-subtitle mb-2 text-muted" for=";name"><h4 class="label">LAST NAME *</h4></label>
			    <input type="text" class="form-control" id="lname" name="lname">
			  </div>
			  <div class="form-group">
			    <label class="card-subtitle mb-2 text-muted" for="email"><h4 class="label">EMAIL ADDRESS *</h4></label>
			    <input type="email" class="form-control" id="email" name="email">
			  </div>
			  <div class="form-group">
			    <label class="card-subtitle mb-2 text-muted" for="password"><h4 class="label">PASSWORD *</h4></label>
			    <input type="password" class="form-control" id="password" name="password">
			  </div>
			  <div class="form-group">
			    <label class="card-subtitle mb-2 text-muted" for="confirm-password"><h4 class="label">CONFIRM PASSWORD *</h4></label>
			    <input type="password" class="form-control" id="confirm-password" name="confirm-password">
			  </div>

			  <!-- div to hold possible signup errors -->
				<div id="errors">
					<small class="text-danger text-center">
						<?php
							if ( isset($error) && !empty($error) ) {
								echo $error;
							}
						?>
					</small>
				</div>
			  
			  <button id="signup-button" class="btn btn-primary" type="submit">Sign Up</button>

			  <small id="signup-message" class="form-text text-center">Already have an account? <a id="signup-link" href="index.php">Log In</a></small>
			</form>

		  </div>
		</div>
    </div>

    <!-- the image on right side of page -->
	<div id="side-image">
		<img src="assets/login-illustration.png">
	</div>

	<!-- BOOTSTRAP JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>