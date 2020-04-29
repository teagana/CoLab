<?php
    ob_start();

    require "config.php";

    //if the user is already logged in, redirect them to the search page
    if( isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {

		header('Location: search.php');
	}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <!-- meta tag for SEO -->
    <meta  name="description" content="Join and search coLab's community of college students to find your next collaborator or mentor.">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    
    <title>Welcome to coLab</title>
    <style>
        .center {
            margin: auto;
            margin-top: 10%;
            width: 60%;
            padding: 10px;
            text-align: center;
        }
        h5 {
            font-family: Calibre-Semibold;
            font-style: normal;
            font-size: 18pt;
            line-height: 22pt;
            color: #000000;
        }
        .login-card:hover {
            box-shadow: 0px 0px 50px rgba(255, 108, 108, 0.3);
            transition: 0.2s;
        }

        #cards {
            font-family: Calibre;
            font-style: normal;
            font-weight: normal;
            font-size: 20pt;
            line-height: 25pt;
            color: #999999;
        }
    </style>

</head>

<body>
    <!-- the header at the top -->
    <nav id="header">
        <div><img src="icons/nav-logo.png" alt="CoLab" class="nav-profile"></div>   
    </nav>

    <div class="center">
        <h1>Welcome to CoLab</h1>
        <h2>A community of college student mentors and collaborators.</h2>
    </div>
    <br><br>

    <div class="container">
        <div id="cards" class="row align-items-center">
            <!--<h2>Card Header and Footer</h2>-->
            <div class="col-4 card login-card rounded-extra">
                <!--<div class="card-header">Header</div>-->

                <div class="card-body">
                    <h4>Mentors &amp; Collaborators</h4>
                    <br>
                    <h5>Get started by creating a profile on CoLab</h5>
                    <a id="login-button" class="btn btn-primary" href="index.php">Sign up or Log In</a>
                </div> 

            </div>
            <div class="col-4 card login-card rounded-extra">
                <div class="card-body">
                    <h4>Search CoLab's community</h4>
                    <br>
                    <h5>Start searching for mentors and collaborators</h5>
                    <a id="login-button" class="btn btn-primary" href="search.php">Go to search</a>
                </div> 

            </div>
        </div>
    </div>
</body>
</html>