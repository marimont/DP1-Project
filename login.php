<?php
	session_start();
	include 'stat.php';
	checkHTTPS();
	/*I need to save eventual arguments coming from GET requests:
	 *when I come back from authentication form, the current page will check the result
	 *which is URL encoded. But, since, cookies will be checked by means of GET params too, I must be certain
	 *that I'm not going to lose login result*/
	if(isset($_REQUEST['result']))
		$_SESSION["params"] = "&result=".$_REQUEST['result'];
	else
		$_SESSION["params"] = "";
	cookiesEnabled();
	if(isLogged()){
		$_SESSION["login_time"] = time();
		/*when performing logout I want to be redirected to the main login page, it makes no sense
		 * redirecting to one of the result page!!*/
		$_SESSION["page"] = "login.php";
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
	<?php 
		if(!isset($_REQUEST["result"])){
			/*Login form*/
			echo "<div style=\"display: table; margin: 0 auto; text-align: center; padding-top: 10px;\">";
			echo "<h2 style=\"text-align: center;\">Login</h2>";
			if($isLogged)
				echo "<h2><font face=�Verdana,Arial,Helvetica,sans-serif�>
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
			
			echo "</div>";
			
		} else if($_REQUEST["result"] == "1"){
			/*login sussessfully performed*/
			echo "<div style=\"display: table; margin: 0 auto; text-align: center; padding-top: 10px;\">";
			echo "<h2 style=\"text-align: center;\">Welcome back, <br>".$_SESSION["username"]."!</h2><br>";
			echo "<h3>You are now logged in</h3>";
			echo "</div>";
		} else{
			/*login failed*/
			echo "<div style=\"display: table; margin: 0 auto; text-align: center; padding-top: 10px;\">";
			echo "<h2 style=\"text-align: center;\">Login failed: ".$_SESSION["loginFailure"];
			echo "</h2>";
			echo "</div>";
			
			/*show login form again*/
			echo "<div style=\"display: table; margin: 0 auto; text-align: center; padding-top: 10px;\">";
			echo "<h2 style=\"text-align: center;\">Login</h2>";
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
			echo "</div>";
		}
	?>

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