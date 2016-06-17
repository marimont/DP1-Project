<?php
	require 'checkStatusAndSession.php';
	if(!$isLogged){
		/*i redirect the user to login page, letting him know, throught this GET parameter
		 * that  he has been redirected there from here.
		 */
		header("Location:login.php?manageReservations=1");
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Reservations</title>
<script type="text/javascript">
<!--
	function checkform(){
		startH = document.getElementById("startH").value;
		startM = document.getElementById("startM").value;
		endH = document.getElementById("endH").value;
		endM = document.getElementById("endM").value;

		if(startH == "" || startM == "" || endH == "" || endM == ""){
			alert("Empty fields!"); return false;
		}
		if(startH < 0 || startH > 23){
			alert("Start Hour: " + startH + " - Value not allowed!"); return false;
		}
		if(endH < 0 || endH > 23){
			alert("End Hour: " + endH + " - Value not allowed!"); return false;
		}
		if(startM < 0 || startM > 59){
			alert("Start Minute: " + startM + " - Value not allowed!"); return false;
		}
		if(endM < 0 || endM > 59){
			alert("End Minute: " + endM + " - Value not allowed!"); return false;
		}
		startH = parseInt(startH);
		startM = parseInt(startM);
		endH = parseInt(endH);
		endM = parseInt(endM);

		if(isNaN(startH) || isNaN(startM)
				|| isNaN(endH) || isNaN(endM)){
			alert("Bad input!"); return false;
		}
		
		startT = startH *60 + startM;
		endT = endH*60 + endM;

		if((endT - startT) <= 0){
			alert("Wrong input: ending time must follow starting time!"); 
			return false;
		}
		
		return true;
	}
	
//-->
</script>
<link rel="stylesheet" href="css/layouts/pure-mini.css">
<link rel="stylesheet" href="css/layouts/side-menu.css">
</head>
<body onload="my_form.reset(); my_remform.reset();">
<div id="layout">

    <div id="menu">
        <div class="pure-menu">
        <p class="pure-menu-heading"><br></p>
         	 <?php 
				echo "<div style=\"display: table; margin: 10px auto; align-text: center;\"><b>".$_SESSION["name"]." ".$_SESSION["surname"]."</b></div>";
			?>
			<ul class="pure-menu-list">
				<li class="pure-menu-item"><a href="index.php" class="pure-menu-link">Homepage</a></li>
				<li class="pure-menu-item"><a href="registration.php" class="pure-menu-link">Registration</a></li>
				<li class="pure-menu-item"><a href="logout.php" class="pure-menu-link">Logout</a></li>
			</ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>Reservations Management</h1>
        </div>

        <div class="content" style="display: table; margin: 0 auto">
        	
 			<h3 class="error">
 			 	<noscript>
    			You should enable javascript or the website may not work properly
    			</noscript>
  			</h3>
  			
			<?php 
			/*In this case I'm gonna show user reservations in any case, so
		 	*there's only an additional message in case we reach the page from a redirection 
			 *as a result of a rem/del reservation action*/
			if(isset($_REQUEST["result"]) && $_REQUEST["result"] == 1){
				/*add/rem ok*/
				echo "<h2 class=\"success\">Operation correctly executed</h2><br>";
			} else if (isset($_REQUEST["result"]) && $_REQUEST["result"] == 0){
				echo "<h2 class=\"error\">Requested operation failed: ".$_SESSION["resFailure"];
				echo "</h2>";
			}
			?>
		<h2 class="content-subhead">My reservations</h2>
		<?php 
			require 'manageDB.php';
			loadUserReservations($_SESSION["username"]);
		?>
			<form id="my_form" class="pure-form pure-form-aligned" action="newRES.php" method="post" onsubmit="return checkform()">
			<fieldset>
			<legend>Add a new reservation</legend>
				<div class="pure-control-group">
          		 	<label for="startH">Start Time</label>
            		<input type="text" id="startH" name ="startH" style= "text-align: right" placeholder="HH" maxlength="2" required>
            		<input type="text" id="startM" name ="startM" style= "text-align: right" placeholder="MM" maxlength="2" required>
       			</div>
       			<div class="pure-control-group">
       				<label for="endH">End Time</label>
					<input type="text" id="endH" name ="endH" style= "text-align: right" placeholder="HH" maxlength="2" required> 
					<input type="text" id="endM" name ="endM" style= "text-align: right" placeholder="MM" maxlength="2" required>
       			</div>
				<div class="pure-controls">
					<input type="submit" class="pure-button pure-button-primary" id="confirm" value="Confirm" style="margin: 5px;" >
					<input type="reset" class="pure-button pure-button-primary" value="Cancel" style="margin: 5px;">		
				</div>
			</fieldset>
		</form>
	
            <h2 class="content-subhead">Reservations</h2>
            <p>
               <?php 
				loadDB();
				?>
            </p>
	</div>
	
        
    </div>
</div>

</body>
</html>