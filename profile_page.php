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
        <div id="nav-logo"></div>
        <div id="nav-menu">
            <ul>
                <li><a href="search.php">Home</a></li>
<!--                 <li><a href="profile_page.html" class="nav-pic"><img src="icons/nav-placeholder.png" alt="Pofile Picture"></a></li> -->
            </ul>
        </div>
        <div id="nav-logged-in">
            <div class="nav-profile"><a href="profile_page.php"><img src="icons/nav-placeholder.png" alt="Pofile Picture" class="nav-profile"></a></div>
<!--             <div class="nav-carrot"></div> -->
        </div>
    </nav>
    <div id="profile-person">
    	<img src="assets/person-1.png" id="main-profile" class="margin">
    	<p class="card-name">Emily S</p>
    	<p class="card-location">Los Angeles, CA</p>
        <p id="bio" class="profile-bio">
            I am a designer/developer hybrid with an emphasis on web design and development and a minor in applied computer security. On weekends, you can find me skiing, hiking, surfing, creating playlists, or generating a secret list of the best coffee shops in Los Angeles.
        </p>
    </div>
    <div id="profile-details">
        <div class="left">
            <div id="school" class="text-body">
                <div class="card-location profile-subhead">EDUCATION - CLASS OF 2021</div>
                    <div class="xp">
                        <img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> USC
                    </div>
                <div class="card-location profile-subhead">MAJOR</div>
                    <div class="xp">
                        <img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Arts, Technology, and the Business of Innovation
                    </div>
                <div class="card-location profile-subhead">MINOR</div>
                    <div class="xp">
                        <img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">Applied Computer Security 
                    </div>
            </div>
            <div id="course-work" class="text-body">
                <div class="card-location profile-subhead">RELEVANT COURSEWORK</div>
                <ul>
                    <li>Design Strategy</li>
                    <li>Typography</li>
                    <li>Motion graphics</li>
                    <li>Web Application Security</li>
                </ul>
            </div>
        </div>
        <div class="right">
            <div id="career" class="text-body">
                <div class="card-location profile-subhead">CAREER</div>
                    <div class="xp">
                        <img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon">Interface Design Intern<br/>
                        <img src="icons/profile-work.png" alt="Briefcase" class="detail-icon">Apple
                    </div>
            </div>
            <div id="skills" class="text-body">
                <div class="card-location profile-subhead">SKILLS</div>
                <div class="tagset">  
                    <div class="tag skill">Adobe Creative Suite</div>
                    <div class="tag skill">Figma</div>
                    <div class="tag skill">Product Design</div>
                    <div class="tag skill">Creative Problem Solving</div>
                </div>
            </div>
            <div id="interests" class="text-body">
                <div class="card-location">INTERESTED IN</div>
                    <div class="tagset">  
                        <div class="tag interest">Social Impact</div>
                        <div class="tag interest">Mental Health</div>
                        <div class="tag interest">UX Design</div>
                    </div>
                </div>
        </div>
    </div>

</body>
</html>