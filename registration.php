<?php
	require 'checkStatusAndSession.php';
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
		name = document.getElementById("name").value;
		surname = document.getElementById("surname").value;
		email = document.getElementById("email").value;
		password = document.getElementById("password").value;
		check_password = document.getElementById("check_password").value;

		//check if fields have been filled in
		
		if(name == "" || surname == "" || email == "" || password == "" || check_password == ""){
			alert("Empty fields!");
			return;
		}

		//check email validity
		var str = email;
		
		//regex taken from the official standard is known as RFC 2822
		//it's a simplified version that will still match 99.99% of all email addresses in actual use today
		//It allows any two-letter country code top level domain, and only specific generic top level domains. 
		//This regex filters dummy email addresses like asdf@adsf.adsf
		
		regex = /[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+(?:com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum|[a-zA-Z]{2})/;
		var res = str.match(regex);
		if(res != email){
			alert(email + " is not a valid email address");
			return;
		}

		//check that the password matched the check_password field
		if(password != check_password){
			alert("The two inserted passwords don't match");
			return;
		}

		document.getElementById("my_form").submit();
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
<title>Registration</title>
</head>
<body onload="my_reset()">
<div id="header">
	<h1>Registration</h1>
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
	<?php 
		if(!isset($_REQUEST["result"])){
			/*registration form*/
			echo "<div style=\"display: table; margin: 0 auto; text-align: center; padding-top: 10px;\">";
			echo "<h2 style=\"text-align: center;\">Registration</h2>";
			echo "<form id=my_form action=\"do_reg.php\" method=\"post\">";
			echo "<table>";
			echo "<tr><th>Name</th>
			<td><input type=\"text\" class=\"input_field\" id=\"name\" name=\"name\" maxlength=\"50\" placeholder=\"your name\" ></td>
			</tr>";
			echo "<tr><th>Surname</th>
				<td><input type=\"text\" class=\"input_field\" id=\"surname\" name=\"surname\" maxlength=\"50\" placeholder=\"your surname\" ></td>
			</tr>";
			echo "<tr><th>Email Address</th>
			<td><input type=\"text\" class=\"input_field\" id=\"email\" name=\"email\" maxlength=\"50\" placeholder=\"sample@domain.com\"></td>
			</tr>";
			echo "<tr><th>Password</th>
			<td><input type=\"password\" class=\"input_field\" id=\"password\" name=\"password\" maxlength=\"50\" placeholder=\"password\" ></td>
			</tr>";
			echo "<tr><th>Repeat Password</th>
			<td><input type=\"password\" class=\"input_field\" id=\"check_password\" name=\"check_password\" maxlength=\"50\" placeholder=\"repeat password\" ></td>
			</tr>";
			echo "</table>";
			echo "<input type=\"button\" value=\"Register\" style=\"margin: 5px;\" onclick=\"checkform()\" >";
			echo "</form>";
			echo "</div>";
		} else if($_REQUEST["result"] == 1){
			/*registration successful*/
			echo "<div style=\"display: table; margin: 0 auto; text-align: center; padding-top: 10px;\">";
			echo "<h2 style=\"text-align: center;\">Welcome to my site,<br>".$_SESSION["email"]."!</h2><br>";
			echo "<h3>Your registration has been successfully completed</h3>";
			echo "</div>";
		} else{
			/*registration failed*/
			echo "<div style=\"display: table; margin: 0 auto; text-align: center; padding-top: 10px;\">";
			echo "<h2 style=\"text-align: center;\">Registration failed: ".$_SESSION["regFailure"];
			echo "</h2>";
			echo "</div>";
			
			/*i show again the registration form*/
			/*registration form*/
			echo "<div style=\"display: table; margin: 0 auto; text-align: center; padding-top: 10px;\">";
			echo "<h2 style=\"text-align: center;\">Registration</h2>";
			echo "<form id=my_form action=\"do_reg.php\" method=\"post\">";
			echo "<table>";
			echo "<tr><th>Name</th>
			<td><input type=\"text\" class=\"input_field\" id=\"name\" name=\"name\" maxlength=\"50\" placeholder=\"your name\" ></td>
			</tr>";
			echo "<tr><th>Surname</th>
				<td><input type=\"text\" class=\"input_field\" id=\"surname\" name=\"surname\" maxlength=\"50\" placeholder=\"your surname\" ></td>
			</tr>";
			echo "<tr><th>Email Address</th>
			<td><input type=\"text\" class=\"input_field\" id=\"email\" name=\"email\" maxlength=\"50\" placeholder=\"sample@domain.com\"></td>
			</tr>";
			echo "<tr><th>Password</th>
			<td><input type=\"password\" class=\"input_field\" id=\"password\" name=\"password\" maxlength=\"50\" placeholder=\"password\" ></td>
			</tr>";
			echo "<tr><th>Repeat Password</th>
			<td><input type=\"password\" class=\"input_field\" id=\"check_password\" name=\"check_password\" maxlength=\"50\" placeholder=\"repeat password\" ></td>
			</tr>";
			echo "</table>";
			echo "<input type=\"button\" value=\"Register\" style=\"margin: 5px;\" onclick=\"checkform()\" >";
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