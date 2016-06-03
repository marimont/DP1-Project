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
<title>Homepage</title>
</head>
<body>
<div id="header">
	<h1>Homepage</h1>
</div>
<div id="nav">
	<ul>
	<li><a href="reservations.php">Manage Reservations</a></li>
	<li><a href="registration.php">Registration</a></li>
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
	<div style="display: table; margin: 0 auto;">
	<h2 style="text-align: center;">Reservations</h2>
	<?php 
		include 'manageDB.php';
		loadDB();
	?>
	</div>
</div>
</body>
</html>