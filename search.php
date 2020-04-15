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
    <meta charset=“utf-8”>
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
    <div id="home-container" class="container d-flex justify-content-start">
    	<div id="home-content">
    		<div id="search-heading">
   				<h1>Find your next collaborator or mentor</h1>
    		</div>
    		<div id="search-desc">
    			<h2>Search coLab's community of college students to find your next collaborator or mentor</h2>
    		</div>
    		<div id="search-bar" class="input-group ">
    			

    			<!-- WILL NEED JS TO MAKE THE INNERHTML OF SEARCH-SELECT TO SELECTED OPTION -->
				<div class="input-group-prepend">
				    <button id="search-select" class="btn dropdown-toggle form-control" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Everyone</button>
				    <div class="dropdown-menu" id="search-dropdown">
				    	<a class="dropdown-item" href="#" onclick="dropdownClick('Everyone');">Everyone</a>
				      	<a class="dropdown-item" href="#" onclick="dropdownClick('Mentors');">Mentors</a>
				      	<a class="dropdown-item" href="#" onclick="dropdownClick('Collaborators');">Collaborators</a>
				    </div>
				</div>
				  <!-- searchbar here -->
				<form class="form-inline" action="search_results.php" method="get">
			   		<input class="form-control" type="search" placeholder="Try 'Engineer'" name="search" id="searchbar">
			   		<div class="input-group-append">
    					<button class="btn btn-outline-secondary" type="submit"><img src="icons/search.png"></button>
  					</div>

                    <!-- hidden input to submit with search for filtering type of user -->
                    <input id="search-filter" type="hidden" value="Everyone">
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

    <!-- js to change text of button when selected search filter changes -->
    <script>
        
        function dropdownClick(text) {
            document.querySelector("#search-select").innerHTML = text;
            document.querySelector("#search-filter").value = text;
        }

    </script>

</body>
</html>