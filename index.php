<?php
	ob_start();

	require "config.php";
	
	// If user is logged in, redirect user to search page. Don't allow them to see the login page.
	if( isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {

		//CHANGE THIS TO BE THE MAIN URL AFTER BEFORE ACTUAL DEPLOYMENT
		header('Location: search.php');
	}

	//user is not currently logged in
	else {

		// echo "user not currently logged in";

		// If user attempted to log in (aka submitted the form)
		if( isset($_POST['email']) && isset($_POST['password'])){
			
			// echo "email + password fields filled";
			
			//error if fields are empty
			if( empty($_POST['email']) || empty($_POST['password']) ) {

				$error = "please enter an email and password";
			}

			//both fields filled in; try to log user in
			else {
				$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

				if ( $mysqli->connect_errno ) {
					echo $mysqli->connect_error;
					exit();
				}

				$emailInput = $_POST["email"];
				$passwordInput = $_POST["password"];
				//hash user input of password to compare this string to the password stored in the users table
				$passwordInput = hash("sha256", $passwordInput);

				//query database for that email/password combo
				$sql = "SELECT * FROM users
					WHERE user_email = '" . $emailInput . "' AND user_password = '" . $passwordInput . "';";

				$results = $mysqli->query($sql);
				if(!$results) {
					echo $mysqli->error;
					exit();
				}

				//if there is a match, we will get at least one result back
				if($results->num_rows > 0) {
					//log them in

					echo "at least one match";

					$row = $results->fetch_assoc();

					$_SESSION['logged_in'] = true;
					$_SESSION['email'] = $emailInput;
					$_SESSION['user_id'] = $row['user_id'];
					
					//redirect them to the search page

					//CHANGE THIS TO BE THE MAIN URL AFTER BEFORE ACTUAL DEPLOYMENT
					header('Location: search.php');
				}

				//no match
				else {
					$error = "invalid email or password";
				}
			}

		}

		// $sql_users = "SELECT * FROM users;";

		// $results_users = $mysqli->query( $sql_users );

		// if ( $results_users == false ) {
		// 	echo $mysqli->error;
		// 	$mysqli->close();
		// 	exit();
		// }

		// var_dump($results_users);

		// $mysqli->close();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CoLab</title>
	
	<!-- BOOTSTRAP CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta charset=“utf-8”>

	<!-- Hotjar Tracking Code for https://460.itpwebdev.com/~colab/ -->
<!-- <script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1758353,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script> -->
</head>
<body>

	<!-- the header at the top -->
    <nav id="header">
        <div><a href="search.php"><img src="icons/nav-logo.png" alt="CoLab" class="nav-profile"></a></div>
        <div id="nav-logged-in">
            <div class="nav-profile"><a href="profile_page.php"><img src="icons/nav-placeholder.png" alt="Pofile Picture" class="nav-profile"></a></div>
        </div>    
    </nav>

    <!-- main body, including login/signup card -->
    <div id="container" class="container d-flex justify-content-start align-items-center">
    	<div class="card login-card rounded">
		  <div id="card-body" class="card-body">
		  	<h5 class="card-title card-name">Log In to CoLab</h5>

		  	<!-- form for logging in -->
		  	<!-- temporarily just redirect to home page -->
		  	<form id="login-form" action="index.php" method="POST">
			  <div class="form-group">
			    <label class="card-subtitle mb-2 text-muted" for="email"><h4 class="label">EMAIL ADDRESS</h4></label>
			    <input type="email" class="form-control" id="email" name="email">
			  </div>
			  <div class="form-group">
			    <label class="card-subtitle mb-2 text-muted" for="password"><h4 class="label">PASSWORD</h4></label>
			    <input type="password" class="form-control" id="password" name="password">
			  </div>

				<!-- div to hold possible login errors -->
				<div id="errors">
					<small class="text-danger text-center">
						<?php
							if ( isset($error) && !empty($error) ) {
								echo $error;
							}
						?>
					</small>
				</div>

			  <button id="login-button" class="btn btn-primary" type="submit">Log In</button>

			  <small id="signup-message" class="form-text text-center">Don't have an account yet? <a id="signup-link" href="signup.php">Sign up</a></small>
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