<?php
	require "config.php";

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

//default is to just filter by dropdown and no search term
	$sql_users = "SELECT * FROM users 
		WHERE users.profile_type_id = " . $_GET['filter'] . ";";

	//IF THERE IS A SEARCH TERM SET
	if(isset($_GET['search'])) {
		
		$search_term = $_GET['search'];
		
		$sql_users = "SELECT * FROM users 
			JOIN school ON users.school_id = school.school_id 
			JOIN school_year ON users.school_year_id = school_year.year_id 
			JOIN major ON users.major_id = major.major_id 
			JOIN minor ON users.minor_id = minor.minor_id 
			JOIN industry ON users.industry_id = industry.industry_id 
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

//probably change this to a prepared statement

	echo $sql_users;

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
		<h3 id="results-number"># people found for 'Engineer'</h3>
		<div class="input-group mb-3">
			<select class="search" id="search-select" name="filter">
				<option value="" selected disabled>-- Select --</option>
					<?php while( $row = $results_profile_type->fetch_assoc() ): ?>

					<?php if ( $row['profile_type_id'] == $row_users['profile_type_id'] ) : ?>

				<option value="<?php echo $row['profile_type_id']; ?>" selected>
					<?php echo $row['profile_type']; ?></option>
					<?php else : ?>

				<option value="<?php echo $row['profile_type_id']; ?>">
					<?php echo $row['profile_type']; ?></option>
					<?php endif; ?>
					<?php endwhile; ?>
			</select>
	<!-- searchbar here -->
			<form class="form-inline" action="search_results.php" method="get">
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

						<h5 class="card-title card-name btn" data-toggle="modal" data-target="#exampleModalCenter" id="myBtn">
							<?php echo $row['user_first	']; ?>
						</h5>

						<div class="card-location profile-subhead">Los Angeles, CA</div>
						<!--profile modal-->
						<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header gradient">
										<img src="assets/person-1.png" alt="Profile Picture" class="person-pic">
										<div>
											<p class="profile-name modal-title profile-modal" id="exampleModalCenterTitle">Emily S.</p>
											<p class="profile-location profile-modal">Los Angeles, CA</p>
										</div>

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div id="left">
											<div id="about">
												<div class="card-location profile-subhead">ABOUT 
													<?php echo $row['user_first']; ?>
												</div>
												<p>
													<?php echo $row['bio']; ?>
												</p>
											</div>
											<div id="education">
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
												<div id="career">
													<div class="card-location profile-subhead">CAREER</div>

													<div class="xp">
														<img src="icons/profile-work.png" alt="Briefcase" class="detail-icon">Interface Design Intern<br/> 
														<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon">Apple
													</div>
												</div>
										</div>
										<div id="right">
											<div id="profile-skill">
												<div class="card-location profile-subhead">SKILLS</div>
												<div class="tagset">  
													<div class="tag skill">Adobe Creative Suite</div>
													<div class="tag skill">Figma</div>
													<div class="tag skill">Product Design</div>
													<div class="tag skill">Creative Problem Solving</div>
												</div>
											</div>
											<div id="profile-interest">
												<div class="card-location">INTERESTED IN</div>
												<div class="tagset">  
													<div class="tag interest">Social Impact</div>
													<div class="tag interest">Mental Health</div>
													<div class="tag interest">UX Design</div>
												</div>
											</div>
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn contact" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div id="user-info">
							<div id="users-school">
								<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> <div class="xp">USC</div>
							</div>
							<div id="users-field">
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">Arts, Technology, and the Business of Innovation</div>
							</div>
						</div>

						<div class="card-location profile-subhead">SKILLS</div>
						<div class="tagset">  
							<div class="tag skill">Adobe Creative Suite</div>
							<div class="tag skill">Figma</div>
							<div class="tag skill">Product Design</div>
							<div class="tag skill">Creative Problem Solving</div>
						</div>
						<div class="card-location">INTERESTED IN</div>
						<div class="tagset">  
							<div class="tag interest">Social Impact</div>
							<div class="tag interest">Mental Health</div>
							<div class="tag interest">UX Design</div>
						</div>
						<button class="btn contact contact-button" type="submit" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
						<!-- contact modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header card-name gradient">
										<p class="modal-title" id="exampleModalLabel">Leave a message for Emily S.</p>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body modal-body-txt">
										<form>
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">YOUR NAME</label>
												<input type="text" class="form-control search-bar" id="recipient-name">
												<label for="recipient-email" class="col-form-label">YOUR EMAIL</label>
												<input type="email" class="form-control" id="recipient-email search-bar">
											</div>
											<div class="form-group">
												<label for="message-text" class="col-form-label">MESSAGE</label>
												<textarea class="form-control" id="message-text"></textarea>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn send">Send</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php endwhile; ?>
			<!-- END LOOPING THROUGH RESULT CARDS -->

			<!-- card 2 -->
			<div class="col-3">
				<div class="card profile-card rounded">
					<div id="card-header" class="card-header">
						<img src="assets/person-2.png" alt="Profile Picture" class="person-pic">

						<h5 class="card-title card-name btn" data-toggle="modal" data-target="#exampleModalCenter" id="myBtn">Teagan A.</h5>

						<div class="card-location profile-subhead">Los Angeles, CA</div>
						<!--profile modal-->
						<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header gradient">
										<img src="assets/person-2.png" alt="Profile Picture" class="person-pic">
										<div>
											<p class="profile-name modal-title profile-modal" id="exampleModalCenterTitle">Teagan A.</p>
											<p class="profile-location profile-modal">Los Angeles, CA</p>
										</div>

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div id="left">
											<div id="about">
												<div class="card-location profile-subhead">ABOUT NAME</div>
												<p>TBD</p>
											</div>
											<div id="education">
													<div class="card-location profile-subhead">EDUCATION</div>

													<div class="xp">
														<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> USC <br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Computer Science<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon"> Class of 2021
													</div>
												</div>
												<div id="career">
													<div class="card-location profile-subhead">CAREER</div>

													<div class="xp">
														<img src="icons/profile-work.png" alt="Briefcase" class="detail-icon">Student<br/> 
													</div>
												</div>
										</div>
										<div id="right">
											<div id="profile-skill">
												<div class="card-location profile-subhead">SKILLS</div>
												<div class="tagset">  
													<div class="tag skill">HTML/CSS</div>
													<div class="tag skill">JavaScript</div>
													<div class="tag skill">Java</div>
													<div class="tag skill">Python</div>
													<div class="tag skill">PHP</div>
													<div class="tag skill">C++</div>
													<div class="tag skill">SQL</div>
												</div>
											</div>
											<div id="profile-interest">
												<div class="card-location">INTERESTED IN</div>
												<div class="tagset">  
													<div class="tag interest">Full Stack</div>
													<div class="tag interest">Sustainability</div>
													<div class="tag interest">LGBT Rights</div>
												</div>
											</div>
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn contact" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div id="user-info">
							<div id="users-school">
								<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> <div class="xp">USC</div>
							</div>
							<div id="users-field">
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">Computer Science</div>
							</div>
						</div>

						<div class="card-location profile-subhead">SKILLS</div>
						<div class="tagset">  
							<div class="tag skill">HTML/CSS</div>
							<div class="tag skill">JavaScript</div>
							<div class="tag skill">Java</div>
							<div class="tag skill">Python</div>
							<div class="tag skill">PHP</div>
							<div class="tag skill">C++</div>
							<div class="tag skill">SQL</div>
						</div>
						<div class="card-location">INTERESTED IN</div>
						<div class="tagset">  
							<div class="tag interest">Full Stack</div>
							<div class="tag interest">Sustainability</div>
							<div class="tag interest">LGBT Rights</div>
						</div>
						<button class="btn contact contact-button" type="submit" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
						<!-- contact modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header card-name gradient">
										<p class="modal-title" id="exampleModalLabel">Leave a message for Teagan A.</p>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body modal-body-txt">
										<form>
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">YOUR NAME</label>
												<input type="text" class="form-control search-bar" id="recipient-name">
												<label for="recipient-email" class="col-form-label">YOUR EMAIL</label>
												<input type="email" class="form-control" id="recipient-email search-bar">
											</div>
											<div class="form-group">
												<label for="message-text" class="col-form-label">MESSAGE</label>
												<textarea class="form-control" id="message-text"></textarea>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn send">Send</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- card 3 -->
			<div class="col-3">
				<div class="card profile-card rounded">
					<div id="card-header" class="card-header">
						<img src="assets/person-9.png" alt="Profile Picture" class="person-pic">

						<h5 class="card-title card-name btn" data-toggle="modal" data-target="#exampleModalCenter" id="myBtn">Lauren B.</h5>

						<div class="card-location profile-subhead">Dallas, TX</div>
						<!--profile modal-->
						<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header gradient">
										<img src="assets/person-9.png" alt="Profile Picture" class="person-pic">
										<div>
											<p class="profile-name modal-title profile-modal" id="exampleModalCenterTitle">Lauren B.</p>
											<p class="profile-location profile-modal">Dallas, TX</p>
										</div>

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div id="left">
											<div id="about">
												<div class="card-location profile-subhead">ABOUT NAME</div>
												<p>I am a business marketing student with a minor in web design and development. On weekends, you can find me in the gym, exploring Los Angeles, and spending time with friends.</p>
											</div>
											<div id="education">
													<div class="card-location profile-subhead">EDUCATION</div>

													<div class="xp">
														<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> USC <br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Business Administration<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Web Technologies and Applications<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon"> Class of 2020
													</div>
												</div>
												<div id="career">
													<div class="card-location profile-subhead">CAREER</div>

													<div class="xp">
														<img src="icons/profile-work.png" alt="Briefcase" class="detail-icon">Video Technitian<br/> 
														<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon">USC Marshall ELC
													</div>
												</div>
										</div>
										<div id="right">
											<div id="profile-skill">
												<div class="card-location profile-subhead">SKILLS</div>
												<div class="tagset">  
													<div class="tag skill">HTML/CSS (SASS)</div>
													<div class="tag skill">PHP</div>
													<div class="tag skill">JavaScript</div>
													<div class="tag skill">MySQL</div>
												</div>
											</div>
											<div id="profile-interest">
												<div class="card-location">INTERESTED IN</div>
												<div class="tagset">  
													<div class="tag interest">Marketing</div>
													<div class="tag interest">Front End</div>
													<div class="tag interest">UX Design</div>
												</div>
											</div>
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn contact" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div id="user-info">
							<div id="users-school">
								<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> <div class="xp">USC</div>
							</div>
							<div id="users-field">
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">Business Administration</div>
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">Web Technologies and Applications</div>
							</div>
						</div>

						<div class="card-location profile-subhead">SKILLS</div>
						<div class="tagset">  
							<div class="tag skill">HTML/CSS (SASS)</div>
							<div class="tag skill">PHP</div>
							<div class="tag skill">JavaScript</div>
							<div class="tag skill">MySQL</div>
						</div>
						<div class="card-location">INTERESTED IN</div>
						<div class="tagset">  
							<div class="tag interest">Marketing</div>
							<div class="tag interest">Front End</div>
							<div class="tag interest">UX Design</div>
						</div>
						<button class="btn contact contact-button" type="submit" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
						<!-- contact modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header card-name gradient">
										<p class="modal-title" id="exampleModalLabel">Leave a message for Lauren B.</p>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body modal-body-txt">
										<form>
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">YOUR NAME</label>
												<input type="text" class="form-control search-bar" id="recipient-name">
												<label for="recipient-email" class="col-form-label">YOUR EMAIL</label>
												<input type="email" class="form-control" id="recipient-email search-bar">
											</div>
											<div class="form-group">
												<label for="message-text" class="col-form-label">MESSAGE</label>
												<textarea class="form-control" id="message-text"></textarea>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn send">Send</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- card 4 -->
			<div class="col-3">
				<div class="card profile-card rounded">
					<div id="card-header" class="card-header">
						<img src="assets/person-4.png" alt="Profile Picture" class="person-pic">

						<h5 class="card-title card-name btn" data-toggle="modal" data-target="#exampleModalCenter" id="myBtn">Eumin L.</h5>

						<div class="card-location profile-subhead">Los Angeles, CA</div>
						<!--profile modal-->
						<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header gradient">
										<img src="assets/person-4.png" alt="Profile Picture" class="person-pic">
										<div>
											<p class="profile-name modal-title profile-modal" id="exampleModalCenterTitle">Eumin L.</p>
											<p class="profile-location profile-modal">Los Angeles, CA</p>
										</div>

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div id="left">
											<div id="about">
												<div class="card-location profile-subhead">ABOUT NAME</div>
												<p>Hello! I’m a multimedia storyteller with a passion for creating at the intersection of code and design. I’ve been working in product design for the past year & have a background in film and creative coding.</p>
											</div>
											<div id="education">
													<div class="card-location profile-subhead">EDUCATION</div>

													<div class="xp">
														<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> USC <br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Media Arts + Practice<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Web Technologies and Applications<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon"> Class of 2021
													</div>
												</div>
												<div id="career">
													<div class="card-location profile-subhead">CAREER</div>

													<div class="xp">
														<img src="icons/profile-work.png" alt="Briefcase" class="detail-icon">Product Designer<br/> 
														<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon">Raya
													</div>
												</div>
										</div>
										<div id="right">
											<div id="profile-skill">
												<div class="card-location profile-subhead">SKILLS</div>
												<div class="tagset">  
													<div class="tag skill">Adobe Creative Suite</div>
													<div class="tag skill">Figma</div>
													<div class="tag skill">HTML/CSS</div>
													<div class="tag skill">JavaScript</div>
													<div class="tag skill">Processing</div>
													<div class="tag skill">PHP</div>
													<div class="tag skill">Arduino</div>
												</div>
											</div>
											<div id="profile-interest">
												<div class="card-location">INTERESTED IN</div>
												<div class="tagset">  
													<div class="tag interest">Urban Planning</div>
													<div class="tag interest">Abstract Film</div>
													<div class="tag interest">Ethical Design</div>
													<div class="tag interest">Accessibility</div>
												</div>
											</div>
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn contact" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div id="user-info">
							<div id="users-school">
								<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> <div class="xp">USC</div>
							</div>
							<div id="users-field">
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">Media Arts + Practice</div>
							</div>
						</div>

						<div class="card-location profile-subhead">SKILLS</div>
						<div class="tagset">  
							<div class="tag skill">Adobe Creative Suite</div>
							<div class="tag skill">Figma</div>
							<div class="tag skill">HTML/CSS</div>
							<div class="tag skill">JavaScript</div>
							<div class="tag skill">Processing</div>
							<div class="tag skill">PHP</div>
							<div class="tag skill">Arduino</div>
						</div>
						<div class="card-location">INTERESTED IN</div>
						<div class="tagset">  
							<div class="tag interest">Urban Planning</div>
							<div class="tag interest">Abstract Film</div>
							<div class="tag interest">Ethical Design</div>
							<div class="tag interest">Accessibility</div>
						</div>
						<button class="btn contact contact-button" type="submit" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
						<!-- contact modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header card-name gradient">
										<p class="modal-title" id="exampleModalLabel">Leave a message for Eumin L.</p>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body modal-body-txt">
										<form>
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">YOUR NAME</label>
												<input type="text" class="form-control search-bar" id="recipient-name">
												<label for="recipient-email" class="col-form-label">YOUR EMAIL</label>
												<input type="email" class="form-control" id="recipient-email search-bar">
											</div>
											<div class="form-group">
												<label for="message-text" class="col-form-label">MESSAGE</label>
												<textarea class="form-control" id="message-text"></textarea>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn send">Send</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<!-- row 2 card 5 -->
			<div class="col-3">
				<div class="card profile-card rounded">
					<div id="card-header" class="card-header">
						<img src="assets/person-5.png" alt="Profile Picture" class="person-pic">

						<h5 class="card-title card-name btn" data-toggle="modal" data-target="#exampleModalCenter" id="myBtn">Latte A.</h5>

						<div class="card-location profile-subhead">Los Angeles, CA</div>
						<!--profile modal-->
						<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header gradient">
										<img src="assets/person-5.png" alt="Profile Picture" class="person-pic">
										<div>
											<p class="profile-name modal-title profile-modal" id="exampleModalCenterTitle">Latte A.</p>
											<p class="profile-location profile-modal">Los Angeles, CA</p>
										</div>

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div id="left">
											<div id="about">
												<div class="card-location profile-subhead">ABOUT NAME</div>
												<p>Latte is a filmmaker, designer, and researcher based in San Francisco, California. They work in the fields of media technology, product marketing, and interaction design. They currently attend USC School of Cinematic Arts.</p>
											</div>
											<div id="education">
													<div class="card-location profile-subhead">EDUCATION</div>

													<div class="xp">
														<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> USC <br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Film & Television Production<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Digital Studies<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon"> Class of 2022
													</div>
												</div>
												<div id="career">
													<div class="card-location profile-subhead">CAREER</div>

													<div class="xp">
														<img src="icons/profile-work.png" alt="Briefcase" class="detail-icon">Creative Communications<br/> 
														<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon">Blue Shield of California
													</div>
												</div>
										</div>
										<div id="right">
											<div id="profile-skill">
												<div class="card-location profile-subhead">SKILLS</div>
												<div class="tagset">  
													<div class="tag skill">Film Production</div>
													<div class="tag skill">Creative Design</div>
													<div class="tag skill">Post Production</div>
													<div class="tag skill">Composing Media</div>
												</div>
											</div>
											<div id="profile-interest">
												<div class="card-location">INTERESTED IN</div>
												<div class="tagset">  
													<div class="tag interest">Healthcare</div>
													<div class="tag interest">Media Architecture</div>
													<div class="tag interest">User Experience</div>
												</div>
											</div>
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn contact" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div id="user-info">
							<div id="users-school">
								<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> <div class="xp">USC</div>
							</div>
							<div id="users-field">
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">Film & Television Production</div>
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">Digital Studies</div>
							</div>
						</div>

						<div class="card-location profile-subhead">SKILLS</div>
						<div class="tagset">  
							<div class="tag skill">Film Production</div>
							<div class="tag skill">Creative Design</div>
							<div class="tag skill">Post Production</div>
							<div class="tag skill">Composing Media</div>
						</div>
						<div class="card-location">INTERESTED IN</div>
						<div class="tagset">  
							<div class="tag interest">Healthcare</div>
							<div class="tag interest">Media Architecture</div>
							<div class="tag interest">User Experience</div>
						</div>
						<button class="btn contact contact-button" type="submit" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
						<!-- contact modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header card-name gradient">
										<p class="modal-title" id="exampleModalLabel">Leave a message for Latte A.</p>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body modal-body-txt">
										<form>
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">YOUR NAME</label>
												<input type="text" class="form-control search-bar" id="recipient-name">
												<label for="recipient-email" class="col-form-label">YOUR EMAIL</label>
												<input type="email" class="form-control" id="recipient-email search-bar">
											</div>
											<div class="form-group">
												<label for="message-text" class="col-form-label">MESSAGE</label>
												<textarea class="form-control" id="message-text"></textarea>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn send">Send</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- card 6 -->
			<div class="col-3">
				<div class="card profile-card rounded">
					<div id="card-header" class="card-header">
						<img src="assets/person-6.png" alt="Profile Picture" class="person-pic">

						<h5 class="card-title card-name btn" data-toggle="modal" data-target="#exampleModalCenter" id="myBtn">Carrot J.</h5>

						<div class="card-location profile-subhead">Los Angeles, CA</div>
						<!--profile modal-->
						<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header gradient">
										<img src="assets/person-6.png" alt="Profile Picture" class="person-pic">
										<div>
											<p class="profile-name modal-title profile-modal" id="exampleModalCenterTitle">Carrot J.</p>
											<p class="profile-location profile-modal">Los Angeles, CA</p>
										</div>

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div id="left">
											<div id="about">
												<div class="card-location profile-subhead">ABOUT NAME</div>
												<p>Carrot is a multidisciplinary designer and creative technologist with an emphasis on storytelling and understanding how people interact with their digital and physical environments. My goal is to bridge the gaps across disciplines to allow design and innovation to improve the lives of individuals, teams, and organizations.</p>
											</div>
											<div id="education">
													<div class="card-location profile-subhead">EDUCATION</div>

													<div class="xp">
														<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> USC <br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Computer Science - Games<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Fine Art<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon"> Class of 2021
													</div>
												</div>
												<div id="career">
													<div class="card-location profile-subhead">CAREER</div>

													<div class="xp">
														<img src="icons/profile-work.png" alt="Briefcase" class="detail-icon">Designer/Developer<br/> 
														<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon">Crosstown LA
													</div>
												</div>
										</div>
										<div id="right">
											<div id="profile-skill">
												<div class="card-location profile-subhead">SKILLS</div>
												<div class="tagset">  
													<div class="tag skill">Computer-aided Design (CAD)</div>
													<div class="tag skill">SolidWorks</div>
													<div class="tag skill">AutoCAD Architecture</div>
													<div class="tag skill">Cinema 4D</div>
													<div class="tag skill">3D Design</div>
													<div class="tag skill">C++</div>
												</div>
											</div>
											<div id="profile-interest">
												<div class="card-location">INTERESTED IN</div>
												<div class="tagset">  
													<div class="tag interest">Social Impact</div>
													<div class="tag interest">Inofrmation Security</div>
													<div class="tag interest">Accessinle Design</div>
												</div>
											</div>
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn contact" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div id="user-info">
							<div id="users-school">
								<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> <div class="xp">USC</div>
							</div>
							<div id="users-field">
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">Computer Science - Games</div>
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">Fine Art</div>
							</div>
						</div>

						<div class="card-location profile-subhead">SKILLS</div>
						<div class="tagset">  
							<div class="tag skill">Computer-aided Design (CAD)</div>
							<div class="tag skill">SolidWorks</div>
							<div class="tag skill">AutoCAD Architecture</div>
							<div class="tag skill">Cinema 4D</div>
							<div class="tag skill">3D Design</div>
							<div class="tag skill">C++</div>
						</div>
						<div class="card-location">INTERESTED IN</div>
						<div class="tagset">  
							<div class="tag interest">Social Impact</div>
							<div class="tag interest">Inofrmation Security</div>
							<div class="tag interest">Accessinle Design</div>
						</div>
						<button class="btn contact contact-button" type="submit" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
						<!-- contact modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header card-name gradient">
										<p class="modal-title" id="exampleModalLabel">Leave a message for Carrot J.</p>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body modal-body-txt">
										<form>
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">YOUR NAME</label>
												<input type="text" class="form-control search-bar" id="recipient-name">
												<label for="recipient-email" class="col-form-label">YOUR EMAIL</label>
												<input type="email" class="form-control" id="recipient-email search-bar">
											</div>
											<div class="form-group">
												<label for="message-text" class="col-form-label">MESSAGE</label>
												<textarea class="form-control" id="message-text"></textarea>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn send">Send</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- card 7 -->
			<div class="col-3">
				<div class="card profile-card rounded">
					<div id="card-header" class="card-header">
						<img src="assets/person-7.png" alt="Profile Picture" class="person-pic">

						<h5 class="card-title card-name btn" data-toggle="modal" data-target="#exampleModalCenter" id="myBtn">Croissant T.</h5>

						<div class="card-location profile-subhead">Los Angeles, CA</div>
						<!--profile modal-->
						<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header gradient">
										<img src="assets/person-7.png" alt="Profile Picture" class="person-pic">
										<div>
											<p class="profile-name modal-title profile-modal" id="exampleModalCenterTitle">Croissant T.</p>
											<p class="profile-location profile-modal">Los Angeles, CA</p>
										</div>

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div id="left">
											<div id="about">
												<div class="card-location profile-subhead">ABOUT NAME</div>
												<p>Hello! I'm Croissant, an innovative creator, engineer, and adventurer living in Los Angeles. I'm a mechanical engineer passionate about utilizing user-centered design to create products for healthcare and emerging hardware that is changing the way we think about big problems. I love making things from physical products to digital media. Passionate about education, making an impact on the community, and women in tech. I also spend a lot of time climbing mountains, collecting patches for my jean jacket, and bullet journaling.</p>
											</div>
											<div id="education">
													<div class="card-location profile-subhead">EDUCATION</div>

													<div class="xp">
														<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> USC <br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Mechanical Engineering<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon"> Class of 2020
													</div>
												</div>
												<div id="career">
													<div class="card-location profile-subhead">CAREER</div>

													<div class="xp">
														<img src="icons/profile-work.png" alt="Briefcase" class="detail-icon">Project Manager<br/> 
														<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon">Willow Pump
													</div>
												</div>
										</div>
										<div id="right">
											<div id="profile-skill">
												<div class="card-location profile-subhead">SKILLS</div>
												<div class="tagset">  
													<div class="tag skill">Mechanical Engineering</div>
													<div class="tag skill">Computer-aided Design (CAD)</div>
													<div class="tag skill">Auto CAD Architecture</div>
													<div class="tag skill">Java</div>
												</div>
											</div>
											<div id="profile-interest">
												<div class="card-location">INTERESTED IN</div>
												<div class="tagset">  
													<div class="tag interest">Emergent Technology</div>
													<div class="tag interest">Education</div>
													<div class="tag interest">Women in STEM</div>
												</div>
											</div>
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn contact" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div id="user-info">
							<div id="users-school">
								<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> <div class="xp">USC</div>
							</div>
							<div id="users-field">
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">Mechanical Engineering</div>
							</div>
						</div>

						<div class="card-location profile-subhead">SKILLS</div>
						<div class="tagset">  
							<div class="tag skill">Mechanical Engineering</div>
							<div class="tag skill">Computer-aided Design (CAD)</div>
							<div class="tag skill">Auto CAD Architecture</div>
							<div class="tag skill">Java</div>
						</div>
						<div class="card-location">INTERESTED IN</div>
						<div class="tagset">  
							<div class="tag interest">Emergent Technology</div>
							<div class="tag interest">Education</div>
							<div class="tag interest">Women in STEM</div>
						</div>
						<button class="btn contact contact-button" type="submit" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
						<!-- contact modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header card-name gradient">
										<p class="modal-title" id="exampleModalLabel">Leave a message for Croissant T.</p>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body modal-body-txt">
										<form>
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">YOUR NAME</label>
												<input type="text" class="form-control search-bar" id="recipient-name">
												<label for="recipient-email" class="col-form-label">YOUR EMAIL</label>
												<input type="email" class="form-control" id="recipient-email search-bar">
											</div>
											<div class="form-group">
												<label for="message-text" class="col-form-label">MESSAGE</label>
												<textarea class="form-control" id="message-text"></textarea>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn send">Send</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- card 8 -->
			<div class="col-3">
				<div class="card profile-card rounded">
					<div id="card-header" class="card-header">
						<img src="assets/person-8.png" alt="Profile Picture" class="person-pic">

						<h5 class="card-title card-name btn" data-toggle="modal" data-target="#exampleModalCenter" id="myBtn">Beet R.</h5>

						<div class="card-location profile-subhead">Los Angeles, CA</div>
						<!--profile modal-->
						<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header gradient">
										<img src="assets/person-8.png" alt="Profile Picture" class="person-pic">
										<div>
											<p class="profile-name modal-title profile-modal" id="exampleModalCenterTitle">Beet R.</p>
											<p class="profile-location profile-modal">Los Angeles, CA</p>
										</div>

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div id="left">
											<div id="about">
												<div class="card-location profile-subhead">ABOUT NAME</div>
												<p>Beet is in their final year at the University of Southern California studying Public Relations. They expand their realm of knowledge with an emphasis in Design and Photography. Curiosity is one of Beet's greatest assets and compels them to constantly learn from different people, perspectives, and stories.</p>
											</div>
											<div id="education">
													<div class="card-location profile-subhead">EDUCATION</div>

													<div class="xp">
														<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> USC <br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Public Relations<br/> 
														<img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon"> Class of 2022
													</div>
												</div>
												<div id="career">
													<div class="card-location profile-subhead">CAREER</div>

													<div class="xp">
														<img src="icons/profile-work.png" alt="Briefcase" class="detail-icon">Public Relations Specialist<br/> 
														<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon">Merakite
													</div>
												</div>
										</div>
										<div id="right">
											<div id="profile-skill">
												<div class="card-location profile-subhead">SKILLS</div>
												<div class="tagset">  
													<div class="tag skill">Social Media Marketing</div>
													<div class="tag skill">Photography</div>
													<div class="tag skill">Content Strategy</div>
													<div class="tag skill">Journalism</div>
													<div class="tag skill">Adobe Creative Suite</div>
												</div>
											</div>
											<div id="profile-interest">
												<div class="card-location">INTERESTED IN</div>
												<div class="tagset">  
													<div class="tag interest">Collaborative Innovation</div>
													<div class="tag interest">Affordable Housing</div>
													<div class="tag interest">Climate Change</div>
												</div>
											</div>
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn contact" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div id="user-info">
							<div id="users-school">
								<img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> <div class="xp">USC</div>
							</div>
							<div id="users-field">
								<img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon"> <div class="xp">Public Relations</div>
							</div>
						</div>

						<div class="card-location profile-subhead">SKILLS</div>
						<div class="tagset">  
							<div class="tag skill">Social Media Marketing</div>
							<div class="tag skill">Photography</div>
							<div class="tag skill">Content Strategy</div>
							<div class="tag skill">Journalism</div>
							<div class="tag skill">Adobe Creative Suite</div>
						</div>
						<div class="card-location">INTERESTED IN</div>
						<div class="tagset">  
							<div class="tag interest">Collaborative Innovation</div>
							<div class="tag interest">Affordable Housing</div>
							<div class="tag interest">Climate Change</div>
						</div>
						<button class="btn contact contact-button" type="submit" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
						<!-- contact modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header card-name gradient">
										<p class="modal-title" id="exampleModalLabel">Leave a message for Beet R.</p>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body modal-body-txt">
										<form>
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">YOUR NAME</label>
												<input type="text" class="form-control search-bar" id="recipient-name">
												<label for="recipient-email" class="col-form-label">YOUR EMAIL</label>
												<input type="email" class="form-control" id="recipient-email search-bar">
											</div>
											<div class="form-group">
												<label for="message-text" class="col-form-label">MESSAGE</label>
												<textarea class="form-control" id="message-text"></textarea>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn send">Send</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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