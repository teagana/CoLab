<?php
	require "config.php";

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql_users = "SELECT * FROM users;";

	$results_users = $mysqli->query( $sql_users );

	if ( $results_users == false ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	// var_dump($results_users);

	$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>CoLab</title>
	
	<!-- BOOTSTRAP CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<!-- the header at the top -->
	<nav id="header">
        <div id="nav-logo"></div>
        <div id="nav-menu">
            <ul>
                <li><a href="search.php">Home</a></li>
                <li><a href="profile_page.php" class="nav-pic"><img src="icons/nav-placeholder.png" alt="Pofile Picture"></a></li>
            </ul>
        </div>
    </nav>

    <!-- main body, including login/signup card -->
    <div id="container" class="container d-flex justify-content-start align-items-center">
    	<div class="card login-card rounded">
		  <div id="card-body" class="card-body">
		  	<h5 class="card-title card-name">Log In to CoLab</h5>

		  	<!-- form for logging in -->
		  	<!-- temporarily just redirect to home page -->
		  	<form id="login-form" action="search.php">
			  <div class="form-group">
			    <label class="card-subtitle mb-2 text-muted" for="email"><h4 class="label">EMAIL ADDRESS</h4></label>
			    <input type="email" class="form-control" id="email" name="email">
			  </div>
			  <div class="form-group">
			    <label class="card-subtitle mb-2 text-muted" for="password"><h4 class="label">PASSWORD</h4></label>
			    <input type="password" class="form-control" id="password" name="password">
			  </div>
			  <button id="login-button" class="btn btn-primary" type="submit">Log In</button>

			  <small id="signup-message" class="form-text text-center">Don’t have an account yet? <a id="signup-link" href="signup.php">Sign up</a></small>
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