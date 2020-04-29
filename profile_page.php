<?php
    ob_start();

    require "config.php";
    
    //don't allow access to this page if user isn't logged in
    if( !isset($_SESSION['logged_in']) ) {
        //redirect to search page if not logged in
        header('Location: search.php');
    }
    
    //user is logged in; populate profile page
    else {

        //get logged in user's user_id from the current session
        $user_id = $_SESSION['user_id'];

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ( $mysqli->connect_errno ) {
            echo $mysqli->connect_error;
            exit();
        }

        //select user that's currently logged in
        $sql_profile = "SELECT * FROM users 
            LEFT JOIN school ON users.school_id = school.school_id 
            LEFT JOIN school_year ON users.school_year_id = school_year.year_id 
            LEFT JOIN major ON users.major_id = major.major_id 
            LEFT JOIN minor ON users.minor_id = minor.minor_id 
            LEFT JOIN industry ON users.industry_id = industry.industry_id 
        WHERE users.user_id = " . $user_id . ";";

        $results_profile = $mysqli->query( $sql_profile );

        if ( $results_profile == false ) {
            echo $mysqli->error;
            $mysqli->close();
            exit();
        }

        // var_dump($results_users);

        //should only be one row returned, since user ids are unique
        $row = $results_profile->fetch_assoc(); 

        $mysqli->close();
    }

	
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

<style>
    /* OVERWRITING STYLE FOR GRAY BOXES SINCE I MOVED THEM A BIT */
    #career {
        width: 260px;
        padding-bottom: 15px;
    }
</style>

</head>
<body class="container-xl">

    <!-- the header at the top -->
    <nav id="header">
        <div><a href="search.php"><img src="icons/nav-logo.png" alt="CoLab" class="nav-profile"></a></div>
       
        <div id="edit">
            <a href="logout.php"><input id="logout-btn" type="button" class="btn" value="Logout"/></a>
            <a href="edit_profile.php"><input id="edit-btn" type="button" class="btn" value="Edit"/></a>
        </div>
    </nav>
    <div id="profile-person">
    	<img src="assets/person-1.png" id="main-profile" class="margin">
    	<p class="card-name">
            <?php echo $row['user_first'] . " " . $row['user_last'][0] . "."; ?>
        </p>
    	<!-- <p class="card-location">Los Angeles, CA</p> -->
        <p id="bio" class="profile-bio">
            <?php echo $row['bio']; ?>
        </p>
    </div>
    <div id="profile-details">
        <div class="left">
            <div id="school" class="text-body">
                <div class="card-location profile-subhead">EDUCATION</div>
                    <div class="xp">
                        <img src="icons/profile-school.png" alt="School Icon" class="detail-icon"> 
                            <?php echo $row['school_name']; ?>
                    </div>
                <div class="card-location profile-subhead">MAJOR</div>
                    <div class="xp">
                        <img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon">
                            <?php echo $row['major']; ?>
                    </div>
                <div class="card-location profile-subhead">MINOR</div>
                    <div class="xp">
                        <img src="icons/profile-in-progress.png" alt="School Icon" class="detail-icon"> 
                            <?php echo $row['minor']; ?>
                    </div>
            </div>
            <!-- THIS ISN'T ACTUALLY SOMETHING WE'RE KEEPING TRACK OF IN OUR DB -->
            <!-- <div id="course-work" class="text-body">
                <div class="card-location profile-subhead">RELEVANT COURSEWORK</div>
                <ul>
                    <li>Design Strategy</li>
                    <li>Typography</li>
                    <li>Motion graphics</li>
                    <li>Web Application Security</li>
                </ul>
            </div> -->

            <!-- MOVED CAREER BOX UP HERE TO MAKE THE PAGE LOOK MORE BALANCED -->
            <div id="career" class="text-body">
                <div class="card-location profile-subhead">CAREER</div>
                    <div class="xp">
                        <img src="icons/profile-in-progress.png" alt="Graduation Hat" class="detail-icon">
                            <?php echo $row['job_role']; ?>
                        <br/>
                        <img src="icons/profile-work.png" alt="Briefcase" class="detail-icon">
                            <?php echo $row['company']; ?>
                    </div>
            </div>
        </div>
        <div class="right">
            <div id="skills" class="text-body">
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
            <div id="interests" class="text-body">
                <div class="card-location">INTERESTED IN</div>
                    <div class="tagset">  

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

</body>
</html>