<?php
	require 'checkStatusAndSession.php';
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
<!-- Google Chrome bug: some Google Chrome versions are affected by a bug: when disabling JavaScript
	you have to refresh the page twice in order to be able to see correctly <noscript> element content 
	(reference: https://bugs.chromium.org/p/chromium/issues/detail?id=232410) 
	
	For this reason I encapsulated <noscript> tag within other tags: seeing  html tags at first reloas is quite annoying!-->
	
	<div style="text-align: center; color:red;">
 		<h3><font face="Verdana,Arial,Helvetica,sans-serif">
 		 <noscript>
    	You must enable javascript or the website won't work
    	</noscript>
  		</font></h3>
	</div>
		

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