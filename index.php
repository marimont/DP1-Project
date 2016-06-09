<?php
	session_start();
	require 'stat.php';
	/*to be sure that ckeckcookies function will not attach other parameters*/
	$_SESSION["params"] = "";
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
	<noscript>
	<div style="text-align: center;">
	<!-- Google Chrome bug: some Google Chrome versions are affected by a bug: when disabling JavaScript
	you have to refresh the page twice in order to be able to see correctly <noscript> element content 
	(reference: http://stackoverflow.com/a/18116982) -->
 		<h3><font face="Verdana,Arial,Helvetica,sans-serif">
    	In order to be able to use this website, you must enable javascript.<br>
    	WITHOUT JAVASCRIPT THE WEBSITE WON'T WORK!
  		</font></h3>
	</div>
	</noscript>
	<div style="display: table; margin: 0 auto;">
	<h2 style="text-align: center;">Reservations</h2>
	<?php 
		require 'manageDB.php';
		loadDB();
	?>
	</div>
</div>
</body>
</html>