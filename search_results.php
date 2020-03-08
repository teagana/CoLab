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
	<script src="jquery-3.4.1.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="container-xl">

	<!-- the header at the top -->
	<nav id="header">
        <div id="nav-logo"><img src="icons/nav-logo.png"></div>
        <div id="nav-menu">
            <ul>
                <li><a href="search.php">Home</a></li>
                <li><a href="profile_page.php" class="nav-pic"><img src="icons/nav-placeholder.png" alt="Pofile Picture"></a></li>
            </ul>
        </div>
        <div id="nav-logged-in">
            <div class="nav-profile"></div>
            <div class="nav-carrot"></div>
        </div>
    </nav>
		<div id="new-search">
			<div id="results-number"><h3># people found for 'Engineer'</h3></div> 
				<div class="input-group mb-3">
					<div class="input-group-prepend">
					   <button id="search-select" class="btn dropdown-toggle form-control" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Everyone</button>
					    <div class="dropdown-menu" id="search-dropdown">
					    	<a class="dropdown-item" href="#">Everyone</a>
					      	<a class="dropdown-item" href="#">Mentors</a>
					      	<a class="dropdown-item" href="#">Collaborators</a>
						</div>
					</div>
					  <!-- searchbar here -->
					<form class="form-inline" action="search_results.php" method="get">
				   		<input class="form-control" type="search" placeholder="Try 'Engineer'" name="search" id="searchbar">
				   		<div class="input-group-append">
	    					<button class="btn btn-outline-secondary" type="submit"><img src="icons/search.png"></button>
	  					</div>
					</form>	
				</div>
		</div>
<!-- profile cards -->    
    <div id="results-container" class="container-xl align-items-start justify-content-between">

	<!-- card 1 -->
	    <div class="row row-cols-xl-4">
	    	<div class="col mb-4">
		    	<div class="card profile-card rounded">
				  <div id="card-header" class="card-header">
				  	<img src="icons/person-1.png" alt="Profile Picture">
				  	
				  	<h5 class="card-title card-name btn" data-toggle="modal" data-target="#exampleModalCenter" id="myBtn">Lauren Blonien</h5>
				  	
				  	<div class="card-location profile-subhead">Los Angeles, CA</div>
				  		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Quick View</button>
		<!--profile modal-->
							<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered" role="document">
							    <div class="modal-content">
							      <div class="modal-header gradient">
							        <span class="profile-name modal-title" id="exampleModalCenterTitle">Lauren B.</span><br/>
							        <span class="profile-location">Los Angeles, CA</span>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							        <div class="modal-body">
							            <div id="about">
							                <div class="card-location profile-subhead">ABOUT NAME</div>
							                <p>Hello! This is all about me...</p>
							            </div>
							            <div id="education">
							                <div class="card-location profile-subhead">EDUCATION</div>
							                    <img src="icons/profile-school.png" alt="School Icon"> 
							                    <div class="xp">
							                        USC <br/> Computer Science<br/> Class of 2020
							                    </div>
							            </div>
							            <div id="career">
							                <div class="card-location profile-subhead">CAREER</div>
							                    <img src="icons/profile-in-progress.png" alt="Graduation Hat"> 
							                    <div class="xp">
							                        Software Engineer <br/> Bird Scooters
							                    </div>
							            </div>
							            <div id="profile-skill">
							                <div class="card-location profile-subhead">SKILLS</div>
							                <div class="tagset">  
							                    <div class="tag skill">Skill 1</div>
							                    <div class="tag skill">Skill 2</div>
							                    <div class="tag skill">Skill 3</div>
							                </div>
							            </div>
							            <div id="profile-interest">
							                <div class="card-location">INTERESTED IN</div>
							                <div class="tagset">  
							                    <div class="tag interest">Interest 1</div>
							                    <div class="tag interest">Interest 2</div>
							                    <div class="tag interest">Interest 3</div>
							                </div>
							            </div>
							            <button type="button" class="btn contact" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
							        </div>
							      <div class="modal-footer">
							      </div>
							    </div>
							  </div>
							</div>
				  	<hr>
				  <div id="user-info">
				  	<div id="users-school">
				  		<img src="icons/profile-school.png" alt="School Icon"> <div class="xp">USC</div>
				  	</div>
				  	<div id="users-field">
				  		<img src="icons/profile-in-progress.png" alt="Graduation Hat"> <div class="xp">Computer Science</div>
				  	</div>
				  </div>

					<div class="card-location profile-subhead">SKILLS</div>
					    <div class="tagset">  
					        <div class="tag skill">Skill 1</div>
					        <div class="tag skill">Skill 2</div>
					        <div class="tag skill">Skill 3</div>
					    </div>
					<div class="card-location">INTERESTED IN</div>
					    <div class="tagset">  
					        <div class="tag interest">Interest 1</div>
					        <div class="tag interest">Interest 2</div>
					        <div class="tag interest">Interest 3</div>
					</div>
					<button id="contact-button" class="btn contact" type="submit" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Contact</button>
					<!-- contact modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header card-name gradient">
						        <p class="modal-title" id="exampleModalLabel">Leave a message for fname ll.</p>
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
	<!-- card 2 -->
			<div class="col mb-4">
		    	<div class="card profile-card rounded">
				  <div id="card-header" class="card-header">
				  	<img src="icons/person-1.png" alt="Profile Picture">
				  	<h5 class="card-title card-name">fname lname</h5>
				  	<div class="card-location profile-subhead">Location, ST</div><hr>
				  <div id="user-info">
				  	<div id="users-school">
				  		<img src="icons/profile-school.png" alt="School Icon"> <div class="xp">School Name</div>
				  	</div>
				  	<div id="users-field">
				  		<img src="icons/profile-in-progress.png" alt="Graduation Hat"> <div class="xp">Feild of work/study</div>
				  	</div>
				  </div>

					<div class="card-location profile-subhead">SKILLS</div>
					    <div class="tagset">  
					        <div class="tag skill">Skill 1</div>
					        <div class="tag skill">Skill 2</div>
					        <div class="tag skill">Skill 3</div>
					    </div>
					<div class="card-location">INTERESTED IN</div>
					    <div class="tagset">  
					        <div class="tag interest">Interest 1</div>
					        <div class="tag interest">Interest 2</div>
					        <div class="tag interest">Interest 3</div>
					</div>

					  <button id="contact-button" class="btn contact" type="submit">Contact</button>

				  </div>
				</div>
			</div>
	<!-- card 3 -->
			<div class="col mb-4">
		    	<div class="card profile-card rounded">
				  <div id="card-header" class="card-header">
				  	<img src="icons/person-1.png" alt="Profile Picture">
				  	<h5 class="card-title card-name">fname lname</h5>
				  	<div class="card-location profile-subhead">Location, ST</div><hr>
				  <div id="user-info">
				  	<div id="users-school">
				  		<img src="icons/profile-school.png" alt="School Icon"> <div class="xp">School Name</div>
				  	</div>
				  	<div id="users-field">
				  		<img src="icons/profile-in-progress.png" alt="Graduation Hat"> <div class="xp">Feild of work/study</div>
				  	</div>
				  </div>

					<div class="card-location profile-subhead">SKILLS</div>
					    <div class="tagset">  
					        <div class="tag skill">Skill 1</div>
					        <div class="tag skill">Skill 2</div>
					        <div class="tag skill">Skill 3</div>
					    </div>
					<div class="card-location">INTERESTED IN</div>
					    <div class="tagset">  
					        <div class="tag interest">Interest 1</div>
					        <div class="tag interest">Interest 2</div>
					        <div class="tag interest">Interest 3</div>
					</div>

					  <button id="contact-button" class="btn contact" type="submit">Contact</button>

				  </div>
				</div>
			</div>
	<!-- card 4 -->
			<div class="col mb-4">
		    	<div class="card profile-card rounded">
				  <div id="card-header" class="card-header">
				  	<img src="icons/person-1.png" alt="Profile Picture">
				  	<h5 class="card-title card-name">fname lname</h5>
				  	<div class="card-location profile-subhead">Location, ST</div><hr>
				  <div id="user-info">
				  	<div id="users-school">
				  		<img src="icons/profile-school.png" alt="School Icon"> <div class="xp">School Name</div>
				  	</div>
				  	<div id="users-field">
				  		<img src="icons/profile-in-progress.png" alt="Graduation Hat"> <div class="xp">Feild of work/study</div>
				  	</div>
				  </div>

					<div class="card-location profile-subhead">SKILLS</div>
					    <div class="tagset">  
					        <div class="tag skill">Skill 1</div>
					        <div class="tag skill">Skill 2</div>
					        <div class="tag skill">Skill 3</div>
					    </div>
					<div class="card-location">INTERESTED IN</div>
					    <div class="tagset">  
					        <div class="tag interest">Interest 1</div>
					        <div class="tag interest">Interest 2</div>
					        <div class="tag interest">Interest 3</div>
					</div>

					  <button id="contact-button" class="btn contact" type="submit">Contact</button>

				  </div>
			</div>
		</div>
<!-- Row 2 - Card 5 -->
		<div class="row row-cols-xl-4">
			<div class="col mb-4">
		    	<div class="card profile-card rounded">
				  <div id="card-header" class="card-header">
				  	<img src="icons/person-1.png" alt="Profile Picture">
				  	<h5 class="card-title card-name">fname lname</h5>
				  	<div class="card-location profile-subhead">Location, ST</div><hr>
				  <div id="user-info">
				  	<div id="users-school">
				  		<img src="icons/profile-school.png" alt="School Icon"> <div class="xp">School Name</div>
				  	</div>
				  	<div id="users-field">
				  		<img src="icons/profile-in-progress.png" alt="Graduation Hat"> <div class="xp">Feild of work/study</div>
				  	</div>
				  </div>

					<div class="card-location profile-subhead">SKILLS</div>
					    <div class="tagset">  
					        <div class="tag skill">Skill 1</div>
					        <div class="tag skill">Skill 2</div>
					        <div class="tag skill">Skill 3</div>
					    </div>
					<div class="card-location">INTERESTED IN</div>
					    <div class="tagset">  
					        <div class="tag interest">Interest 1</div>
					        <div class="tag interest">Interest 2</div>
					        <div class="tag interest">Interest 3</div>
					</div>

					  <button id="contact-button" class="btn contact" type="submit">Contact</button>

				  </div>
				</div>
			</div>
	<!-- card 6 -->
			<div class="col mb-4">
		    	<div class="card profile-card rounded">
				  <div id="card-header" class="card-header">
				  	<img src="icons/person-1.png" alt="Profile Picture">
				  	<h5 class="card-title card-name">fname lname</h5>
				  	<div class="card-location profile-subhead">Location, ST</div><hr>
				  <div id="user-info">
				  	<div id="users-school">
				  		<img src="icons/profile-school.png" alt="School Icon"> <div class="xp">School Name</div>
				  	</div>
				  	<div id="users-field">
				  		<img src="icons/profile-in-progress.png" alt="Graduation Hat"> <div class="xp">Feild of work/study</div>
				  	</div>
				  </div>

					<div class="card-location profile-subhead">SKILLS</div>
					    <div class="tagset">  
					        <div class="tag skill">Skill 1</div>
					        <div class="tag skill">Skill 2</div>
					        <div class="tag skill">Skill 3</div>
					    </div>
					<div class="card-location">INTERESTED IN</div>
					    <div class="tagset">  
					        <div class="tag interest">Interest 1</div>
					        <div class="tag interest">Interest 2</div>
					        <div class="tag interest">Interest 3</div>
					</div>

					  <button id="contact-button" class="btn contact" type="submit">Contact</button>

				  </div>
				</div>
			</div>
	<!-- card 7 -->
			<div class="col mb-4">
		    	<div class="card profile-card rounded">
				  <div id="card-header" class="card-header">
				  	<img src="icons/person-1.png" alt="Profile Picture">
				  	<h5 class="card-title card-name">fname lname</h5>
				  	<div class="card-location profile-subhead">Location, ST</div><hr>
				  <div id="user-info">
				  	<div id="users-school">
				  		<img src="icons/profile-school.png" alt="School Icon"> <div class="xp">School Name</div>
				  	</div>
				  	<div id="users-field">
				  		<img src="icons/profile-in-progress.png" alt="Graduation Hat"> <div class="xp">Feild of work/study</div>
				  	</div>
				  </div>

					<div class="card-location profile-subhead">SKILLS</div>
					    <div class="tagset">  
					        <div class="tag skill">Skill 1</div>
					        <div class="tag skill">Skill 2</div>
					        <div class="tag skill">Skill 3</div>
					    </div>
					<div class="card-location">INTERESTED IN</div>
					    <div class="tagset">  
					        <div class="tag interest">Interest 1</div>
					        <div class="tag interest">Interest 2</div>
					        <div class="tag interest">Interest 3</div>
					</div>

					  <button id="contact-button" class="btn contact" type="submit">Contact</button>

				  </div>
				</div>
			</div>
	<!-- card 8 -->
			<div class="col mb-4">
		    	<div class="card profile-card rounded">
				  <div id="card-header" class="card-header">
				  	<img src="icons/person-1.png" alt="Profile Picture">
				  	<h5 class="card-title card-name">fname lname</h5>
				  	<div class="card-location profile-subhead">Location, ST</div><hr>
				  <div id="user-info">
				  	<div id="users-school">
				  		<img src="icons/profile-school.png" alt="School Icon"> <div class="xp">School Name</div>
				  	</div>
				  	<div id="users-field">
				  		<img src="icons/profile-in-progress.png" alt="Graduation Hat"> <div class="xp">Feild of work/study</div>
				  	</div>
				  </div>

					<div class="card-location profile-subhead">SKILLS</div>
					    <div class="tagset">  
					        <div class="tag skill">Skill 1</div>
					        <div class="tag skill">Skill 2</div>
					        <div class="tag skill">Skill 3</div>
					    </div>
					<div class="card-location">INTERESTED IN</div>
					    <div class="tagset">  
					        <div class="tag interest">Interest 1</div>
					        <div class="tag interest">Interest 2</div>
					        <div class="tag interest">Interest 3</div>
					</div>

					  <button id="contact-button" class="btn contact" type="submit">Contact</button>

				  </div>
				</div>
			</div>
		</div>

    </div>


	<!-- BOOTSTRAP JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script></script>

</body>
</html>