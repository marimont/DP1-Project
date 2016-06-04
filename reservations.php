<?php
	session_start();
	include 'stat.php';
	cookiesEnabled();
	if(isLogged()){
		$_SESSION["login_time"] = time();
		$_SESSION["page"] = $_SERVER["REQUEST_URI"];
		$isLogged = true;
	} else {
		header("Location:login.php");
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<link href="mystyle.css" rel=stylesheet type="text/css">
<title>Reservations</title>
<script type="text/javascript" src="jquery-1.12.4.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){
 $("#add").click(function(){
    $(".panel").slideDown("slow");
    $(".buttonsPanel").hide();
  });
 $("#cancel").click(function(){
	    $(".panel").slideUp("slow");
	    $(".buttonsPanel").show();
	});
});
</script>
<script type="text/javascript">
<!--
	function checkform(){
		startH = document.getElementById("startH").value;
		startM = document.getElementById("startM").value;
		endH = document.getElementById("endH").value;
		endM = document.getElementById("endM").value;

		if(startH == "" || startM == "" || endH == "" || endM == ""){
			alert("Empty fields!"); return;
		}
		if(startH < 0 || startH > 23){
			alert("Start Hour: " + startH + " - Value not allowed!"); return;
		}
		if(endH < 0 || endH > 23){
			alert("End Hour: " + endH + " - Value not allowed!"); return;
		}
		if(startM < 0 || startM > 59){
			alert("Start Minute: " + startM + " - Value not allowed!"); return;
		}
		if(endM < 0 || endM > 59){
			alert("End Minute: " + endM + " - Value not allowed!"); return;
		}
		startH = parseInt(startH);
		startM = parseInt(startM);
		endH = parseInt(endH);
		endM = parseInt(endM);

		if(isNaN(startH) || isNaN(startM)
				|| isNaN(endH) || isNaN(endM)){
			alert("Bad input!"); return;
		}
		
		startT = startH *60 + startM;
		endT = endH*60 + endM;

		if((endT - startT) <= 0){
			alert("Wrong input: ending time must follow starting time!"); return;
		}
		
		document.getElementById("my_form").submit();
	}
//-->
</script>
<style type="text/css">
	.panel{
		background-color: #eeeeee;
		display: none;
		margin: 5px auto;
	}
</style>
</head>
<body onload="my_form.reset()">
<div id="header">
	<h1>Reservations Managment</h1>
</div>
<div id="nav">
	<ul>
	<li><a href="index.php">Homepage</a></li>
	<li><a href="registration.php">Registration</a></li>
	<li><a href="logout.php">Logout</a></li>
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
	<div style="display: table; margin: 0 auto; text-align: center;">
	<div style="display: inline-block;">
	<h2 style="text-align: center;">My reservations</h2>
	<?php 
		include 'manageDB.php';
		loadUserReservations($_SESSION["username"]);
	?>
	</div>
	<div class="panel">
	<form id="my_form" action="newRES.php" method="post">
		<table>
		<tr>
			<td>Starting Time</td>
			<td><input type="text" id="startH" name ="startH" style= "text-align: right" placeholder="HH" maxlength="2" > : </td>
			<td><input type="text" id="startM" name ="startM" style= "text-align: right" placeholder="MM" maxlength="2"></td>
		</tr>
		<tr>
			<td>Ending Time</td>
			<td><input type="text" id="endH" name ="endH" style= "text-align: right" placeholder="HH" maxlength="2"> : </td>
			<td><input type="text" id="endM" name ="endM" style= "text-align: right" placeholder="MM" maxlength="2"></td>
		</tr>
		</table>
		<input type="button" id="confirm" value="Confirm" style="margin: 5px;" onclick="checkform()" >
		<input type="button" id="cancel" value="Cancel" style="margin: 5px;">
	</form>
	</div>
	<div class="buttonsPanel">
		<input type="button" id="add" value="Add Reservation" style="margin: 5px;">
	</div>
	</div>
	<div style="display: table; margin: 0 auto;">
	<h2 style="text-align: center;">Reservations</h2>
	<?php 
		loadDB();
	?>
	</div>
</div>
</body>
</html>