<?php
	require "config.php";

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	//if filter is set to everyone, just don't filter by type
	if($_GET['filter'] == 3) {
		$sql_users = "SELECT * FROM users;";
	}

	//otherwise, filter by type
	else {
		//default is to just filter by dropdown and no search term
		$sql_users = "SELECT * FROM users 
			WHERE users.profile_type_id = " . $_GET['filter'] . ";";
	}


	//IF THERE IS A SEARCH TERM SET
	if(isset($_GET['search'])) {
		
		$search_term = $_GET['search'];

		//again, don't add filter if set to everyone
		if($_GET['filter'] == 3) {
			$sql_users = "SELECT * FROM users 
			LEFT JOIN school ON users.school_id = school.school_id 
			LEFT JOIN school_year ON users.school_year_id = school_year.year_id 
			LEFT JOIN major ON users.major_id = major.major_id 
			LEFT JOIN minor ON users.minor_id = minor.minor_id 
			LEFT JOIN industry ON users.industry_id = industry.industry_id 
			WHERE school.school_name LIKE '%" . $search_term . "%' 
				OR users.bio LIKE '%" . $search_term . "%'
				OR school_year.year LIKE '%" . $search_term . "%' 
				OR major.major LIKE '%" . $search_term . "%' 
				OR minor.minor LIKE '%" . $search_term . "%' 
				OR industry.industry LIKE '%" . $search_term . "%' 
				OR users.company LIKE '%" . $search_term . "%' 
				OR users.job_role LIKE '%" . $search_term . "%' 
				OR users.skills LIKE '%" . $search_term . "%';";
		}

		//otherwise add in the profile type filter
		else {
			$sql_users = "SELECT * FROM users 
			LEFT JOIN school ON users.school_id = school.school_id 
			LEFT JOIN school_year ON users.school_year_id = school_year.year_id 
			LEFT JOIN major ON users.major_id = major.major_id 
			LEFT JOIN minor ON users.minor_id = minor.minor_id 
			LEFT JOIN industry ON users.industry_id = industry.industry_id 
			WHERE users.profile_type_id = " . $_GET['filter'] . 
			" AND (
				school.school_name LIKE '%" . $search_term . "%' 
				OR users.bio LIKE '%" . $search_term . "%'
				OR school_year.year LIKE '%" . $search_term . "%' 
				OR major.major LIKE '%" . $search_term . "%' 
				OR minor.minor LIKE '%" . $search_term . "%' 
				OR industry.industry LIKE '%" . $search_term . "%' 
				OR users.company LIKE '%" . $search_term . "%' 
				OR users.job_role LIKE '%" . $search_term . "%' 
				OR users.skills LIKE '%" . $search_term . "%'
			);";
		}
		
	}

//probably change this to a prepared statement
	$results_users = $mysqli->query( $sql_users );
	if ( $results_users == false ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

// Profile Type:
	$sql_profile_type = "SELECT * FROM profile_type;";
	$results_profile_type = $mysqli->query($sql_profile_type);
	if ( $results_profile_type == false ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

// Contact Modal Email
	if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['msg'])) {
		$name = @trim(stripslashes($_POST['name'])); 
		$email = @trim(stripslashes($_POST['email'])); 
		$subject = "Connecting on CoLab";
		$msg = @trim(stripslashes($_POST['msg']));
		$msg = wordwrap($msg,70);

		$email_from = $email;
		$email_to = $row['user_email'];

 	 $body = 'body';
 	 // 'Name: ' . $name . "\n\n" . 'Email: ' . $email_from. "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' $msg;

	 	mail($email_to, $subject, $body, 'From: <'.$email_from.'>');
	 	
	 	alert('Email sent. Thank you!');


	} else {
	 	echo "Please include required fields so that you can connect.";
	};

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
<body class="container-xl">

	<!-- the header at the top -->
    <nav id="header">
        <div><a href="search.php"><img src="icons/nav-logo.png" alt="CoLab" class="nav-profile"></a></div>
        <div id="nav-logged-in">
            <div class="nav-profile"><a href="profile_page.php"><img src="icons/nav-placeholder.png" alt="Pofile Picture" class="nav-profile"></a></div>
        </div>    
    </nav>
	<div id="new-search">
		<h3 id="results-number"><?php echo $results_users->num_rows ?> people found for '<?php echo $search_term ?>'</h3>
		<div class="input-group mb-3">
			
	<!-- searchbar here -->
			<form class="form-inline" action="search_results.php" method="get">
				<select class="search" id="search-select" name="filter">
					<!-- <option value="" selected disabled>-- Select --</option> -->
					<?php while( $row = $results_profile_type->fetch_assoc() ): ?>

						<!-- select by default the one your profile is set to? -->
						<?php if ( $row['profile_type_id'] == $row_users['profile_type_id'] ) : ?>
							<option value="<?php echo $row['profile_type_id']; ?>" selected>
								<?php echo $row['profile_type']; ?></option>

						<?php else : ?>
							<option value="<?php echo $row['profile_type_id']; ?>">
								<?php echo $row['profile_type']; ?></option>

						<?php endif; ?>
					<?php endwhile; ?>
				</select>
				<input class="form-control" type="search" placeholder="Try 'Engineer'" name="search" id="searchbar">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="submit"><img src="icons/search.png"></button>
				</div>

				<!-- hidden input to submit with search for filtering type of user -->
				<!-- <input id="search-filter" name="filter" type="hidden" value="Everyone"> -->
			</form>	
		</div>
	</div>

	<!-- profile cards -->    
	<div id="results-container" class="container-xl align-items-start justify-content-between">
		<div class="row">
			<!-- card 1 -->
			
			<!-- LOOP THROUGH ALL THE RESULT CARDS -->
			<?php while ( $row = $results_users->fetch_assoc() ) : ?>

			<div class="col-3">
				<div class="card profile-card rounded">
					<div id="card-header" class="card-header">
						<img src="assets/person-1.png" alt="Profile Picture" class="person-pic">

						<h5 class="card-title card-name btn" data-toggle="modal" data-target="#modal<?php echo $row['user_id'] ?>" id="myBtn">
							<?php echo $row['user_first'] . " " . $row['user_last'][0] . "."; ?>
						</h5>
						<!-- college (formerly location) -->
						<div class="card-location profile-subhead">
							<?php echo $row['school_name']; ?>
						</div>
						<!--profile modal-->
						<div class="modal fade" id="modal<?php echo $row['user_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header gradient">
										<img src="assets/person-1.png" alt="Profile Picture" class="person-pic">
										<div>
											<p class="profile-name modal-title profile-modal" id="exampleModalCenterTitle">
												<?php echo $row['user_first'] . " " . $row['user_last'][0] . "."; ?>
											</p>
											<!-- NOT INCLUDING LOCATION -->
											<!-- <p class="profile-location profile-modal">
											</p> -->
										</div>

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="left">
											<div class="about">
												<div class="card-location profile-subhead">ABOUT 
													<?php echo $row['user_first'] . " " . $row['user_last'][0] . "."; ?>
												</div>
												<p>
													<?php echo $row['bio']; ?>
												</p>
											</div>
											<div class="education">
													<div class="card-location profile-subhead">EDUCATION</div>

													<div class="xp">
														<img src="icons/profile-school.png" alt="School Icon" class="detail-icon">
															<?php echo $row['school_name']; ?>
														<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">
															<?php echo $row['major']; ?>
														<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">
															<?php echo $row['year']; ?>

													</div>
												</div>
												<div class="career">
													<div class="card-location profile-subhead">CAREER</div>

													<div class="xp">
														<img src="icons/profile-work.png" alt="Briefcase" class="detail-icon">
															<?php echo $row['job_role']; ?>
														<br/> 
														<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon">
															<?php echo $row['company']; ?>
													</div>
												</div>
										</div>
										<div class="right">
											<div class="profile-skill">
												<div class="card-location profile-subhead">SKILLS</div>
												<div class="tagset">  
													
													<!-- loop through skills separated by commas -->
													<?php foreach(explode(",", $row['skills']) as $skill): ?>
														<div class="tag skill">
															<?php echo $skill; ?>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
											<div class="profile-interest">
												<div class="card-location">INTERESTED IN</div>
												<div class="tagset">  
													<!-- <div class="tag interest">Social Impact</div>
													<div class="tag interest">Mental Health</div>
													<div class="tag interest">UX Design</div> -->

													<!-- loop through interests separated by commas -->
													<?php foreach(explode(",", $row['interest']) as $interest): ?>
														<div class="tag interest">
															<?php echo $interest; ?>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn contact" data-toggle="modal" data-target="#contactModal<?php echo $row['user_id'] ?>" data-whatever="@mdo">Contact</button>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="user-info">
							<div class="users-school">
								<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> <div class="xp">
									<?php echo $row['school_name']; ?>	
								</div>
							</div>
							<div class="users-field">
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">
									<?php echo $row['major']; ?>
								</div>
							</div>
						</div>

						<div class="card-location profile-subhead">SKILLS</div>
						<div class="tagset">  
							<!-- <div class="tag skill">Adobe Creative Suite</div>
							<div class="tag skill">Figma</div>
							<div class="tag skill">Product Design</div>
							<div class="tag skill">Creative Problem Solving</div> -->

							<!-- loop through skills separated by commas -->
							<?php foreach(explode(",", $row['skills']) as $skill): ?>
								<div class="tag skill">
									<?php echo $skill; ?>
								</div>
							<?php endforeach; ?>

						</div>
						<div class="card-location">INTERESTED IN</div>
						<div class="tagset">  
							<!-- <div class="tag interest">Social Impact</div>
							<div class="tag interest">Mental Health</div>
							<div class="tag interest">UX Design</div> -->
							
							<!-- loop through interests separated by commas -->
							<?php foreach(explode(",", $row['interest']) as $interest): ?>
								<div class="tag interest">
									<?php echo $interest; ?>
								</div>
							<?php endforeach; ?>
						</div>
						<button class="btn contact contact-button" type="submit" data-toggle="modal" data-target="#contactModal<?php echo $row['user_id'] ?>" data-whatever="@mdo">Contact</button>
				<!-- contact modal -->
						<div class="modal fade" id="contactModal<?php echo $row['user_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header card-name gradient">
										<p class="modal-title" id="exampleModalLabel">Leave a message for <?php echo $row['user_first'] . " " . $row['user_last'][0] . "."; ?></p>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body modal-body-txt">
										<form action="" method="POST">
											<div class="form-group">
												<label for="recipient-name" class="col-form-label" name="name">YOUR NAME</label>
												<input type="text" class="form-control search-bar" id="recipient-name">
												<label for="recipient-email" class="col-form-label">YOUR EMAIL</label>
												<input type="email" class="form-control" class="recipient-email search-bar" name="email">
											</div>
											<div class="form-group">
												<label for="message-text" class="col-form-label">MESSAGE</label>
												<textarea class="form-control" class="message-text" name="msg"></textarea>
											</div>
										
											<div class="modal-footer">
												<button type="submit" class="btn send">Send</button>
											</div>
										</form>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php endwhile; ?>
			<!-- END LOOPING THROUGH RESULT CARDS -->

			<!-- BEGINNING OF DUMMY CARDS -->
			<!-- card 2 -->
			<!-- DELETED DUMMY CARDS FOR THE TIME BEING TO MAKE THINGS CLEARER -->
			<!-- END OF CARDS -->
		</div>
	</div>


	<!-- BOOTSTRAP JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<!-- <script src="jquery-3.4.1.min.js"></script> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</body>
</html>