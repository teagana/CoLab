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
<html lang="en" dir="ltr">

<head>

	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">

	<title>Edit your profile</title>

	<style>
		#bio-id, #school-id {
			background: #F2F2F2;
			border: none;
		}
	</style>

</head>

<body>
	<!-- the header at the top -->
	<nav id="header">
		<div id="nav-logo"></div>
		<div id="nav-menu">
			<ul>
				<li><a href="search.php">Home</a></li>
			</ul>
		</div>
		<div id="nav-logged-in">
			<div class="nav-profile"><a href="profile_page.php"><img src="icons/nav-placeholder.png" alt="Pofile Picture" class="nav-profile"></a></div>
		</div>
	</nav>

	<div class="container">
		<div class="row align-items-center">
			<div class="card login-card rounded col-6">
				<div id="card-body" class="card-body">
					<h5 class="card-title card-name">Edit your profile</h5>
					<span id="firstName">Eumin</span> <span id="lastName">Lee</span><br>
					<span id="email" style="color:dodgerblue;">euminlee@usc.edu</span><br><br>
				
				<!-- edit profile form -->
					<form id="signup-form">
						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="bio"><h4 class="label">BIO</h4></label>
							<textarea class="form-control" id="bio-id" name="bio"></textarea>
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="location"><h4 class="label">CITY</h4></label>
							<input type="text" class="form-control" id="location-id" name="location">
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="email"><h4 class="label">SCHOOL</h4></label>
							<select name="school" id="school-id" class="form-control">
								<option value="" selected>-- Select One --</option>
								<option value="<?php echo $row['label_id']; ?>"></option>
							</select>
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="email"><h4 class="label">YEAR IN SCHOOL</h4></label>

							<select name="school-year" id="school-id" class="form-control">
								<option value="" selected>-- Select One --</option>
								<option value="<?php echo $row['label_id']; ?>"></option>
							</select>
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="major"><h4 class="label">MAJOR</h4></label>
							<select name="major" id="school-id" class="form-control">
								<option value="" selected>-- Select One --</option>
								<option value="<?php echo $row['label_id']; ?>">
								</option>
							</select>
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="minor"><h4 class="label">MINOR</h4></label>
							<select name="minor" id="school-id" class="form-control">
								<option value="" selected>-- Select One --</option>
								<option value="<?php echo $row['label_id']; ?>">
								</option>
							</select>
						</div>
						
						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="company"><h4 class="label">COMPANY</h4></label>
							<input class="form-control" id="company-id" name="company">
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="job-title"><h4 class="label">JOB TITLE</h4></label>
							<input class="form-control" id="job-title-id" name="job-title">
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="industry"><h4 class="label">INDUSTRY</h4></label>
							<select name="industry" id="school-id" class="form-control">
								<option value="" selected>-- Select One --</option>
								<option value="<?php echo $row['label_id']; ?>">
								</option>
							</select>
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="skills"><h4 class="label">SKILLS</h4></label>
							<input class="form-control" id="skills-id" name="skills">
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="interests"><h4 class="label">INTERESTS</h4></label>
							<input class="form-control" id="interests-id" name="interests">
						</div>

						<button id="signup-button" class="btn btn-primary" type="submit">Save changes</button>
					</form>

				</div>
			</div>

		</div>
	</div>
</body>
</html>