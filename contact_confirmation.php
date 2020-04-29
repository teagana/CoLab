<?php

// Contact Modal Email
	if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['msg'])) {
		$name = @trim(stripslashes($_POST['name'])); 
		$email = @trim(stripslashes($_POST['email'])); 
		$subject = "Connecting on CoLab";
		$msg = @trim(stripslashes($_POST['msg']));
		$msg = wordwrap($msg,70);

		$email_from = $email;
		$email_to = @trim(stripslashes($_POST['email_to']));

 	 	$body = 'Name: '.$name."\n\nEmail: ".$email_from."\n\nMessage: ".$msg;

	 	mail($email_to, $subject, $body, 'From: <'.$email_from.'>');
	 	
	} else {
		die ('Nothing was submitted.');
	};
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
        <div><a href="javascript:history.go(-1)"><img src="icons/nav-logo.png" alt="CoLab" class="nav-profile"></a></div>  
    </nav>
 	
<!-- main body, including login/signup card -->
    <div id="home-container" class="container d-flex justify-content-start">
    	<div id="home-content">
    		<div id="search-heading">
   				<h1>Your email has been sent.</h1>
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

</body>
</html>