<?php
	session_start();
	include_once 'stat.php';
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
		var res = str.match(/.+@.+\..{2,3}/);
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
//-->
</script>
<link href="mystyle.css" rel=stylesheet type="text/css">
<title>Registration</title>
</head>
<body onload="my_form.reset()">
<div id="header">
	<h1>Registration</h1>
</div>
<div id="nav">
	<ul>
	<li><a href="index.php">Homepage</a></li>
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
	<h2 style="text-align: center;">Registration</h2>
	
	<form id=my_form action="do_reg.php" method="post">
	<table>
		<tr>
			<th>Name</th>
			<td><input type="text" class="input_field" id="name" name="name" maxlength="50"></td>
		</tr>
		<tr>
			<th>Surname</th>
			<td><input type="text" class="input_field" id="surname" name="surname" maxlength="50"></td>
		</tr>
		<tr>
			<th>Email Address</th>
			<td><input type="text" class="input_field" id="email" name="email" maxlength="50"></td>
		</tr>
		<tr>
			<th>Password</th>
			<td><input type="password" class="input_field" id="password" name="password" maxlength="50"></td>
		</tr>
		<tr>
			<th>Repeat Password</th>
			<td><input type="password" class="input_field" id="check_password" name="check_password" maxlength="50"></td>
		</tr>
	</table>
	<input type="button" value="Register" onclick="checkform()" >
	</form>
	
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