<?php
	session_start();
	include 'stat.php';
	cookiesEnabled();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<link href="mystyle.css" rel=stylesheet type="text/css">
<title>Login</title>
</head>
<body onload="my_form.reset()">
<div id="header">
	<h1>Login</h1>
</div>
<div id="nav">
	<ul>
	<li><a href="index.php">Homepage</a></li>
	<li><a href="registration.php">Registration</a></li>
	</ul>
</div>
<div id="section">
	<noscript>
	<div style="text-align: center;">
 		<h3><font face="Verdana,Arial,Helvetica,sans-serif">
    	In order to be able to use this website, you must enable javascript.
  		</font></h3>
	</div>
	</noscript>
	<div style="display: table; margin: 0 auto; text-align: center; padding-top: 10px;">
	<h2 style="text-align: center;">Login failed: 	
	<?php 
		$loginFailure = $_SESSION["loginFailure"];
		echo " ".$loginFailure;
	?>
	</h2>
	<h3><a href="login.php">Go back to login page</a></h3>
	</div>
	<div style="display: table; margin: 0 auto; padding-top: 10px;">
	<h2 style="text-align: center;">Reservations</h2>
	<?php 
		include_once 'manageDB.php';
		loadDB();
	?>
	</div>
</div>
</body>
</html>