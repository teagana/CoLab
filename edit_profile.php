<?php
	require "config.php";

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
        <div><a href="search.php"><img src="icons/nav-logo.png" alt="CoLab" class="nav-profile"></a></div>   
    </nav>

	<div class="container">
		<div class="row align-items-center">
			<div class="card login-card rounded col-6">
				<div id="card-body" class="card-body">
					<h5 class="card-title card-name">Edit your profile</h5>
					<span id="firstName">Eumin</span> <span id="lastName">Lee</span><br>
					<span id="email" style="color:dodgerblue;">euminlee@usc.edu</span><br><br>
				
				<!-- edit profile form -->
					<form id="signup-form" method="POST">
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

							<select name="school-year" id="school-id" class="form-control">
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
							<select name="major" id="school-id" class="form-control">
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
							<select name="minor" id="school-id" class="form-control">
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
							<select name="industry" id="school-id" class="form-control">
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
							<label class="card-subtitle mb-2 text-muted" for="skills"><h4 class="label">SKILLS</h4></label>
							<input class="form-control" id="skills-id" name="skills">
						</div>

						<div class="form-group">
							<label class="card-subtitle mb-2 text-muted" for="interests"><h4 class="label">INTERESTS</h4></label>
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