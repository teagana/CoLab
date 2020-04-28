<?php
	require "config.php";

	//don't allow access to this page if user isn't logged in
    if( !isset($_SESSION['logged_in']) ) {
        //redirect to search page if not logged in
        header('Location: search.php');
	}
	
	//logged in; proceed to page
	else {
		// Establish MySQL Connection.
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$sql_users = "SELECT * FROM users;";
		$results_users = $mysqli->query( $sql_users );

		if ( $results_users == false ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		//SELECT EVERYTHING FROM PROFILE, GIVEN USER ID FROM SESSION
		$user_id = $_SESSION['user_id'];

		$sql_profile = "SELECT * FROM users 
        WHERE users.user_id = " . $user_id . ";";

        $results_profile = $mysqli->query( $sql_profile );

        if ( $results_profile == false ) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        //should only be one row returned, since user ids are unique
		$profile_row = $results_profile->fetch_assoc();
		
		//nothing is filled out -- this is a NEW PROFILE
		if($profile_row['bio'] == "" && $profile_row['school_id'] == "" && $profile_row['profile_type_id'] == "") {

		}

		//things are filled out -- this is a person editing their profile
		else {
			//need to prepopulate everything
			$sql_profile = "SELECT * FROM users 
				LEFT JOIN school ON users.school_id = school.school_id 
				LEFT JOIN school_year ON users.school_year_id = school_year.year_id 
				LEFT JOIN major ON users.major_id = major.major_id 
				LEFT JOIN minor ON users.minor_id = minor.minor_id 
				LEFT JOIN industry ON users.industry_id = industry.industry_id 
			WHERE users.user_id = " . $user_id . ";";

			$results_edit_profile = $mysqli->query( $sql_profile );

			if ( $results_edit_profile == false ) {
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}

			//has all the values for an existing profile to prepopulate
			$profile_row = $results_edit_profile->fetch_assoc();
		}

	// Schools:
		$sql_school = "SELECT * FROM school;";
		$results_school = $mysqli->query($sql_school);
		if ( $results_school == false ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

	// Yeah in School:
		$sql_school_year = "SELECT * FROM school_year;";
		$results_school_year = $mysqli->query($sql_school_year);
		if ( $results_school_year== false ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

	// Major:
		$sql_major = "SELECT * FROM major;";
		$results_major = $mysqli->query($sql_major);
		if ( $results_major == false ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

	// Minor:
		$sql_minor = "SELECT * FROM minor;";
		$results_minor = $mysqli->query($sql_minor);
		if ( $results_minor == false ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

	// Industry:
		$sql_industry = "SELECT * FROM industry;";
		$results_industry = $mysqli->query($sql_industry);
		if ( $results_industry == false ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

	// Close DB Connection
		$mysqli->close();
	}

	
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">

	<title>Edit your profile</title>

	<style>
		#bio-id, #school-id, #school-year-id, #major-id, #minor-id, #industry-id {
			background: #F2F2F2;
			border: none;
		}
		.checkboxes {
			margin-left: 10px;
		}
	</style>

</head>

<body>
	<!-- the header at the top -->
    <nav id="header">
        <div><a href="search.php"><img src="icons/nav-logo.png" alt="CoLab" class="nav-profile"></a></div>   
    </nav>

	<div class="container">
		<div class="row align-items-center justify-content-center">
			<div class="card login-card rounded col-6">
				<div id="card-body" class="card-body">
					<h5 class="card-title card-name">Edit your profile</h5>
					<span id="firstName"><?php echo $profile_row['user_first'] ?></span> <span id="lastName"><?php echo $profile_row['user_last'] ?></span><br>
					<span id="email" style="color:dodgerblue;">euminlee@usc.edu</span><br><br>
				<!-- edit profile form -->
					<form id="signup-form" method="POST">
						<div class="form-group">

							<input type="checkbox" id="mentor" name="mentor" value="">
 								<label for="mentor" class="checkboxes card-subtitle mb-2 text-muted">Mentor</label><br>
							<input type="checkbox" id="collaborator" name="collaborator" value="">
								<label for="collaborator" class="checkboxes card-subtitle mb-2 text-muted">Collaborator</label><br>
							<input type="checkbox" id="everyone" name="everyone" value="">
								<label for="everyone" class="checkboxes card-subtitle mb-2 text-muted">Both</label><br>

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
								<option value="" selected disabled>-- Select One --</option>
									<?php while( $row = $results_school->fetch_assoc() ): ?>

									<?php if ( $row['school_id'] == $row_users['school_id'] ) : ?>

								<option value="<?php echo $row['school_id']; ?>" selected>
									<?php echo $row['school_name']; ?></option>
									<?php else : ?>

								<option value="<?php echo $row['school_id']; ?>">
									<?php echo $row['school_name']; ?></option>
									<?php endif; ?>
									<?php endwhile; ?>
							</select>
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="email"><h4 class="label">YEAR IN SCHOOL</h4></label>

							<select name="school-year" id="school-year-id" class="form-control">
								<option value="" selected disabled>-- Select One --</option>
									<?php while( $row = $results_school_year->fetch_assoc() ): ?>

									<?php if ( $row['school_year_id'] == $row_users['school_year_id'] ) : ?>

								<option value="<?php echo $row['school_year_id']; ?>" selected>
									<?php echo $row['year']; ?></option>
									<?php else : ?>

								<option value="<?php echo $row['school_year_id']; ?>">
									<?php echo $row['year']; ?></option>
									<?php endif; ?>
									<?php endwhile; ?>
							</select>
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="major"><h4 class="label">MAJOR</h4></label>
							<select name="major" id="major-id" class="form-control">
								<option value="" selected disabled>-- Select One --</option>
									<?php while( $row = $results_major->fetch_assoc() ): ?>

									<?php if ( $row['major_id'] == $row_users['major_id'] ) : ?>

								<option value="<?php echo $row['major_id']; ?>" selected>
									<?php echo $row['major']; ?></option>
									<?php else : ?>

								<option value="<?php echo $row['major_id']; ?>">
									<?php echo $row['major']; ?></option>
									<?php endif; ?>
									<?php endwhile; ?>
							</select>
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="minor"><h4 class="label">MINOR</h4></label>
							<select name="minor" id="minor-id" class="form-control">
								<option value="" selected disabled>-- Select One --</option>
									<?php while( $row = $results_minor->fetch_assoc() ): ?>

									<?php if ( $row['minor_id'] == $row_users['minor_id'] ) : ?>

								<option value="<?php echo $row['minor_id']; ?>" selected>
									<?php echo $row['minor']; ?></option>
									<?php else : ?>

								<option value="<?php echo $row['minor_id']; ?>">
									<?php echo $row['minor']; ?></option>
									<?php endif; ?>
									<?php endwhile; ?>
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
							<select name="industry" id="industry-id" class="form-control">
								<option value="" selected disabled>-- Select One --</option>
									<?php while( $row = $results_industry->fetch_assoc() ): ?>

									<?php if ( $row['industry_id'] == $row_users['industry_id'] ) : ?>

								<option value="<?php echo $row['industry_id']; ?>" selected>
									<?php echo $row['industry']; ?></option>
									<?php else : ?>

								<option value="<?php echo $row['industry_id']; ?>">
									<?php echo $row['industry']; ?></option>
									<?php endif; ?>
									<?php endwhile; ?>
							</select>
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="skills"><h4 class="label">SKILLS<small>  (SEPARATED BY COMMAS)</small></h4></label>
							<input class="form-control" id="skills-id" name="skills">
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="interests"><h4 class="label">INTERESTS<small>  (SEPARATED BY COMMAS)</small></h4></label>
							<input class="form-control" id="interests-id" name="interests">
						</div>

						<button id="signup-button" class="btn btn-primary" type="submit">Save changes</button>
						<input type="button" value="Back" onclick="history.back()" class="btn contact"/>
					</form>

				</div>
			</div>

		</div>
	</div>
</body>
</html>