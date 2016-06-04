<?php
	session_start();
	include 'stat.php';
	cookiesEnabled();
	if(isLogged()){
		$_SESSION["login_time"] = time();
		$_SESSION["page"] = $_SERVER["REQUEST_URI"];
		$isLogged = true;
	} else
		$isLogged = false;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<link href="mystyle.css" rel=stylesheet type="text/css">
<title>Registration</title>
</head>
<body>
<div id="header">
	<h1>Registration</h1>
</div>
<div id="nav">
	<ul>
	<li><a href="index.php">Homepage</a></li>
	<li><a href="reservations.php">Manage Reservations</a></li>
	<?php 
		if($isLogged){
			echo "<li><a href=\"logout.php\">Logout</a></li>";
		} else {
			echo "<li><a href=\"login.php\">Login</a></li>";
		}
	?>
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
	<h2 style="text-align: center;">Registration failed: 	
	<?php 
		$regFailure = $_SESSION["regFailure"];
		echo " ".$regFailure;
	?>
	</h2>
	<h3><a href="registration.php">Go back to registration page</a></h3>
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