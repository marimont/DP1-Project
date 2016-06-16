<?php
	require 'checkStatusAndSession.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<link rel="stylesheet" href="css/layouts/pure-mini.css">
<link rel="stylesheet" href="css/layouts/side-menu.css">
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
			return false;
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
			return false;
		}

		//check that the password matched the check_password field
		if(password != check_password){
			alert("The two inserted passwords don't match");
			return false;
		}

		return true;
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
<div id="layout">

    <div id="menu">
        <div class="pure-menu">
        <p class="pure-menu-heading"><br></p>
         	 <?php 
				if($isLogged)
				echo "<div style=\"display: table; margin: 10px auto; align-text: center;\"><b>".$_SESSION["name"]." ".$_SESSION["surname"]."</b></div>";
			?>
			<ul class="pure-menu-list">
				<li class="pure-menu-item"><a href="index.php" class="pure-menu-link">Homepage</a></li>
				<li class="pure-menu-item"><a href="reservations.php" class="pure-menu-link">Manage Reservations</a></li>
				<li class="pure-menu-item"><a href="registration.php" class="pure-menu-link">Registration</a></li>
			<?php 
				if($isLogged){
					echo "<li class=\"pure-menu-item\"><a href=\"logout.php\" class=\"pure-menu-link\">Logout</a></li>";
				} else {
					echo "<li class=\"pure-menu-item\"><a href=\"login.php\" class=\"pure-menu-link\">Login</a></li>";
				}
			?>
			</ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>Registration</h1>
        </div>

        <div class="content" style="display: table; margin: 0 auto">
        	
 			<h3 class="error">
 			 	<noscript>
    			You should enable javascript or the website may not work properly
    			</noscript>
  			</h3>
  				
  			<?php 
				if(!isset($_REQUEST["result"])){
				/*registration form*/
				echo "<form id=my_form class=\"pure-form pure-form-aligned\" action=\"do_reg.php\" method=\"post\" onsubmit=\"return checkform()\">";
				echo "<div class=\"pure-control-group\"> <label for=\"name\">Name</label>";
				echo "<input type=\"text\" id=\"name\" name=\"name\" maxlength=\"50\" placeholder=\"Name\" required></div>";
				echo "<div class=\"pure-control-group\"> <label for=\"suname\">Surame</label>";
				echo "<input type=\"text\" id=\"surname\" name=\"surname\" maxlength=\"50\" placeholder=\"Surname\" required></div>";
				echo "<div class=\"pure-control-group\"> <label for=\"eame\">Email</label>";
				echo "<input type=\"text\" id=\"email\" name=\"email\" maxlength=\"50\" placeholder=\"Email\" required></div>";
				echo "<div class=\"pure-control-group\"> <label for=\"password\">Password</label>";
				echo "<input type=\"password\" id=\"password\" name=\"password\" maxlength=\"50\" placeholder=\"Password\" required></div>";
				echo "<div class=\"pure-control-group\"> <label for=\"check_password\">Repeat password</label>";
				echo "<input type=\"password\" class=\"input_field\" id=\"check_password\" name=\"check_password\" maxlength=\"50\" placeholder=\"Repeat Password\" required></div>";
				echo "<div class=\"pure-controls\">";
				echo "<input type=\"submit\" class=\"pure-button pure-button-primary\" value=\"Register\" style=\"margin: 5px;\"></div>";
				echo "</form>";
			} else if($_REQUEST["result"] == 1){
				/*registration successful*/
				echo "<h2 class=\"success\">Welcome to my site,<br>".$_SESSION["email"]."!</h2>";
			} else{
				/*registration failed*/
				
				echo "<h2 class=\"error\">Registration failed: ".$_SESSION["regFailure"];
				echo "</h2>";
				
				/*i show again the registration form*/
				/*registration form*/
				echo "<form id=my_form class=\"pure-form pure-form-aligned\" action=\"do_reg.php\" method=\"post\" onsubmit=\"return checkform()\">";
				echo "<div class=\"pure-control-group\"> <label for=\"name\">Name</label>";
				echo "<input type=\"text\" id=\"name\" name=\"name\" maxlength=\"50\" placeholder=\"Name\" required></div>";
				echo "<div class=\"pure-control-group\"> <label for=\"suname\">Surame</label>";
				echo "<input type=\"text\" id=\"surname\" name=\"surname\" maxlength=\"50\" placeholder=\"Surname\" required></div>";
				echo "<div class=\"pure-control-group\"> <label for=\"eame\">Email</label>";
				echo "<input type=\"text\" id=\"email\" name=\"email\" maxlength=\"50\" placeholder=\"Email\" required></div>";
				echo "<div class=\"pure-control-group\"> <label for=\"password\">Password</label>";
				echo "<input type=\"password\" id=\"password\" name=\"password\" maxlength=\"50\" placeholder=\"Password\" required></div>";
				echo "<div class=\"pure-control-group\"> <label for=\"check_password\">Repeat password</label>";
				echo "<input type=\"password\" class=\"input_field\" id=\"check_password\" name=\"check_password\" maxlength=\"50\" placeholder=\"Repeat Password\" required></div>";
				echo "<div class=\"pure-controls\">";
				echo "<input type=\"submit\" class=\"pure-button pure-button-primary\" value=\"Register\" style=\"margin: 5px;\"></div>";
				echo "</form>";
			}
		?>		
  				
			
            <h2 class="content-subhead">Reservations</h2>
            <p>
               <?php 
				require 'manageDB.php';
				loadDB();
				?>
            </p>
        </div>
    </div>
</div>
</body>
</html>