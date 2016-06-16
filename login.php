<?php
require 'checkStatusAndSession.php';
if ($isLogged)
		/*I overwrite this session variable so that if the user performs a logout
		 * from the "login success" view he won't be redirected there but to the login page*/
		$_SESSION ["page"] = "login.php";
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
		username = document.getElementById("username").value;
		password = document.getElementById("password").value;
		if(username != "" && password != ""){
			return true;
		}else{
			alert("Empty fields!");
			return false;
		}
	}

	function my_reset(){
	<?php
	/*
	 * In this way I will not receive an alert on firebug when the page is reached by redirection
	 * after performing login, considering that I'm not showing the form, in that case
	 */
	if (! isset ( $_REQUEST ['result'] ))
		echo "document.getElementById(\"my_form\").reset();";
	
	?>
	}
//-->
</script>
<title>Login</title>
</head>

<body onload="my_reset()">
	<div id="layout">

		<div id="menu">
			<div class="pure-menu">
				<p class="pure-menu-heading">
					<br>
				</p>
         	 <?php
					if ($isLogged)
					echo "<div style=\"display: table; margin: 10px auto; align-text: center;\"><b>" . $_SESSION ["name"] . " " . $_SESSION ["surname"] . "</b></div>";
			?>
			<ul class="pure-menu-list">
					<li class="pure-menu-item"><a href="index.php"
						class="pure-menu-link">Homepage</a></li>
					<li class="pure-menu-item"><a href="reservations.php"
						class="pure-menu-link">Manage Reservations</a></li>
					<li class="pure-menu-item"><a href="registration.php"
						class="pure-menu-link">Registration</a></li>
				<?php
				if ($isLogged) {
					echo "<li class=\"pure-menu-item\"><a href=\"logout.php\" class=\"pure-menu-link\">Logout</a></li>";
				}
				?>
			</ul>
			</div>
		</div>

		<div id="main">
			<div class="header">
				<h1>Login</h1>
			</div>

			<div class="content" style="display: table; margin: 0 auto">

				<h3 class="error">
					<noscript>You should enable javascript or the website may not work properly</noscript>
				</h3>
				<?php
				if (! isset ( $_REQUEST ["result"] ) || isset ( $_REQUEST ["result"] ) && $_REQUEST ["result"] == 1 && ! $isLogged) {
					/*
					 * I need to check both conditions (result and isLogged) because I could have
					 * been performed a successful login and being inactive on the login success page.
					 * If I reaload the page after two minutes, result is still set to 1 but I don't want to
					 * see the "success" page, but the form, again: so I check if the user is still logged in
					 * or not
					 */
					if (isset ( $_REQUEST ["manageReservations"] ) && $_REQUEST ["manageReservations"] = 1) {
						/*
						 * The user has been redirected from reservations page
						 * and I let him know that
						 */
						$toBeLogged = true;
					} else {
						$toBeLogged = false;
					}
					/* Login form */
					if ($toBeLogged) {
						echo "<h3 class=\"error\">
    						You must be logged in order to manage your reservations
    						</h3>";
							}
					if ($isLogged)
						echo "<h2 class=\"error\">
						You are already logged in! No further action needed!</font></h2>";
					else{
						echo "<form id=\"my_form\" class=\"pure-form\" action=\"auth.php\" method=\"post\" onsubmit=\"return checkform()\">";	
						echo "<input type=\"text\" id=\"username\" name=\"username\" maxlength=\"50\" placeholder=\"Email\" required>";
						echo "<input type=\"password\" id=\"password\" name=\"password\" maxlength=\"50\" placeholder=\"Password\" required>";
						echo "<input type=\"submit\" class=\"pure-button pure-button-primary\" value=\"Login\" style=\"margin: 5px;\">";
						echo "</form>";
					}
				} else if ($_REQUEST ["result"] == "1") {
					/* login sussessfully performed */
					echo "<h2 class=\"success\">Welcome back, " . $_SESSION ["username"]."!";
				} else {
					/* login failed */
					echo "<h2 class=\"error\">Login failed: " . $_SESSION ["loginFailure"];
					echo "</h2>";
					
					/* show login form again */
					echo "<form id=\"my_form\" class=\"pure-form\" action=\"auth.php\" method=\"post\" onsubmit=\"return checkform()\">";	
					echo "<input type=\"text\" id=\"username\" name=\"username\" maxlength=\"50\" placeholder=\"Email\" required>";
					echo "<input type=\"password\" id=\"password\" name=\"password\" maxlength=\"50\" placeholder=\"Password\" required>";
					echo "<input type=\"submit\" class=\"pure-button pure-button-primary\" value=\"Login\" style=\"margin: 5px;\" >";
					echo "</form>";
				}
				?>

	
				<h2 class="content-subhead">Reservations</h2>
				<?php
					require 'manageDB.php';
					loadDB ();
				?>
            
        </div>
      </div>
</div>
</body>
</html>