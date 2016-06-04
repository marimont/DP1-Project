<?php
	session_start();
	include 'stat.php';
	checkHTTPS();
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
<style type="text/css">
	th{
	text-align: left;
	}
	
	.input_field{
	text-align: right;
	}
</style>
<script type="text/javascript">
<!--
	function checkform(){
		username = document.getElementById("username").value;
		password = document.getElementById("password").value;
		if(username != "" && password != ""){
			document.getElementById("my_form").submit();
		}else
			alert("Empty fields!");
	}
//-->
</script>
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
	<li><a href="reservations.php">Manage Reservations</a></li>
	<li><a href="registration.php">Registration</a></li>
	<?php 
		if($isLogged){
			echo "<li><a href=\"logout.php\">Logout</a></li>";
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
	<h2 style="text-align: center;">Login</h2>
	<?php 
		
		if($isLogged)
			echo "<h2><font face=”Verdana,Arial,Helvetica,sans-serif”>
			You are already logged in! No further action needed!</font></h2>";
		else{
			echo "<form id=\"my_form\" action=\"auth.php\" method=\"post\">";
			echo "<table>";
			echo "<tr>
			<th>Username</th>
			<td><input type=\"text\" class=\"input_field\" id=\"username\" name=\"username\" maxlength=\"50\" placeholder=\"sample@domain.com\"></td>
			</tr>";
			echo "<tr><th>Password</th><td><input type=\"password\" class=\"input_field\" id=\"password\" name=\"password\" maxlength=\"50\" placeholder=\"your password\"></td></tr>";
			echo "</table>";
			echo "<input type=\"button\" value=\"Login\" style=\"margin: 5px;\" onclick=\"checkform()\" >";
			echo "</form>";
		}
	?>
	</div>
	<div style="display: table; margin: 0 auto; padding-top: 10px;">
	<h2 style="text-align: center;">Reservations</h2>
	<?php 
	  	include 'manageDB.php';
		loadDB();
	?>
	</div>
</div>
</body>
</html>