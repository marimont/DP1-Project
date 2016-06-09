<?php
	session_start();
	require 'stat.php';
	/*I need to save eventual arguments coming from GET requests:
	 *when I come back from authentication form, the current page will check the result
	 *which is URL encoded. But, since, cookies will be checked by means of GET params too, I must be certain
	 *that I'm not going to lose add/rem reservation result*/
	if(isset($_REQUEST['result']))
		$_SESSION["params"] = "&result=".$_REQUEST['result'];
	else
		$_SESSION["params"] = "";
	cookiesEnabled();
	checkHTTPS();
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
   	 $("#addpanel").slideDown("slow");
    	$(".buttonsPanel").hide();
 	 });
 	$("#remove").click(function(){
	    $("#removepanel").slideDown("slow");
	    $(".buttonsPanel").hide();
	 });
	$(".cancel").click(function(){
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

	function checkRemform(){
		startH = document.getElementById("startH_r").value;
		startM = document.getElementById("startM_r").value;
		machine = document.getElementById("machine").value;

		if(startH == "" || startM == "" || machine == ""){
			alert("Empty fields!"); return;
		}
		if(startH < 0 || startH > 23){
			alert("Start Hour: " + startH + " - Value not allowed!"); return;
		}
	
		if(startM < 0 || startM > 59){
			alert("Start Minute: " + startM + " - Value not allowed!"); return;
		}
	
		startH = parseInt(startH);
		startM = parseInt(startM);
		machine = parseInt(machine);

		if(isNaN(startH) || isNaN(startM)
				|| isNaN(machine)){
			alert("Bad input!"); return;
		}

		if(isNaN(startH) || isNaN(startM) || isNaN(machine)){
			alert("Bad input!"); return;
		}
	
		document.getElementById("my_remform").submit();
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
<body onload="my_form.reset(); my_remform.reset();">
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
    	In order to be able to use this website, you must enable javascript.<br>
    	WITHOUT JAVASCRIPT THE WEBSITE WON'T WORK!
  		</font></h3>
	</div>
	</noscript>
	<?php 
	/*In this case I'm gonna show user reservations in any case, so
	 *there's only an additional message in case we reach the page from a redirection 
	 *as a result of a rem/del reservation action*/
	if(isset($_REQUEST["result"]) && $_REQUEST["result"] == 1){
		/*add/rem ok*/
		echo "<div style=\"display: table; margin: 0 auto; text-align: center; padding-top: 10px;\">";
		echo "<h2 style=\"text-align: center;\">Operation correctly executed</h2><br>";
		echo "</div>";
		
	} else if (isset($_REQUEST["result"]) && $_REQUEST["result"] == 0){
		echo "<div style=\"display: table; margin: 0 auto; text-align: center; padding-top: 10px;\">";
		echo "<h2 style=\"text-align: center;\">Requested operation failed<br>".$_SESSION["resFailure"];
		echo "</h2>";
		echo "</div>";
	}
	?>
	<div style="display: table; margin: 0 auto; text-align: center;">
	<div style="display: inline-block;">
	<h2 style="text-align: center;">My reservations</h2>
	<?php 
		require 'manageDB.php';
		loadUserReservations($_SESSION["username"]);
	?>
	</div>
	<div class="panel" id ="addpanel">
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
		<input type="button" class="cancel" value="Cancel" style="margin: 5px;">
	</form>
	</div>
	<div class="panel" id ="removepanel">
	<form id="my_remform" action="delRES.php" method="post">
		<table>
		<tr>
			<td>Machine</td>
			<td><input type="text" id="machine" name ="machine" style= "text-align: right" placeholder="machine ID"></td>
		</tr>
		<tr>
			<td>Starting Time</td>
			<td><input type="text" id="startH_r" name ="startH" style= "text-align: right" placeholder="HH" maxlength="2"> : </td>
			<td><input type="text" id="startM_r" name ="startM" style= "text-align: right" placeholder="MM" maxlength="2"></td>
		</tr>
		</table>
		<input type="button" id="confirm" value="Confirm" style="margin: 5px;" onclick="checkRemform()" >
		<input type="button" class="cancel" value="Cancel" style="margin: 5px;">
	</form>
	</div>
	<div class="buttonsPanel">
		<input type="button" id="add" value="Add Reservation" style="margin: 5px;">
		<input type="button" id="remove" value="Remove Reservation" style="margin: 5px;">
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