<?php
	require 'checkStatusAndSession.php';
	if($isLogged)
		/*I overwrite this session variable so that if the user performs a logout
		 * from the "login success" view he won't be redirected there but to the login page*/
		$_SESSION["page"] = "login.php";
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

	function my_reset(){
	<?php 
		/*In this way I will not receive an alert on firebug when the page is reached by redirection
		 * after performing login, considering that I'm not showing the form, in that case*/
		if(!isset($_REQUEST['result']))
			echo "document.getElementById(\"my_form\").reset();";
		
		
	?>
	}
//-->
</script>
<link href="mystyle.css" rel=stylesheet type="text/css">
<title>Login</title>
</head>

<body onload="my_reset()">
<div id="header">
	<h1>Login</h1>
</div>
<div id="nav">
	<?php 
		if($isLogged)
			echo "<div style=\"display: table; margin: 10px auto; align-text: center;\"><b>".$_SESSION["name"]." ".$_SESSION["surname"]."</b></div>";
	?>
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
	<?php 
		if(!isset($_REQUEST["result"]) || isset($_REQUEST["result"]) && $_REQUEST["result"] == 1 && !$isLogged){
			/*I need to check both conditions (result and isLogged) because I could have
			 * been performed a successful login and being inactive on the login success page.
			 * If I reaload the page after two minutes, result is still set to 1 but I don't want to
			 * see the "success" page, but the form, again: so I check if the user is still logged in
			 * or not*/
			if(isset($_REQUEST["manageReservations"]) && $_REQUEST["manageReservations"] = 1){
				/*The user has been redirected from reservations page 
				 * and I let him know that*/
				$toBeLogged = true;
			} else{
				$toBeLogged = false;
			}
			/*Login form*/
			if($toBeLogged){
				echo "<h3 style=\"color: red; text-align: center;\"><font face=\"Verdana,Arial,Helvetica,sans-serif;\">
    				You must be logged in order to manage your reservations
    				</font></h3>";
			}
			echo "<div style=\"display: table; margin: 0 auto; text-align: center; padding-top: 10px;\">";
			echo "<h2 style=\"text-align: center;\">Login</h2>";
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
			echo "<h2 style=\"color: red; text-align: center;\">Login failed: ".$_SESSION["loginFailure"];
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
	  	require 'manageDB.php';
		loadDB();
	?>
	</div>
</div>
</body>
</html>