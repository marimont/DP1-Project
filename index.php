<?php
	require 'checkStatusAndSession.php';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Homepage</title>
<link rel="stylesheet" href="css/layouts/pure-mini.css">  
<link rel="stylesheet" href="css/layouts/side-menu.css">  
</head>
<body>

<div id="layout">

    <div id="menu">
        <div class="pure-menu">
        <p class="pure-menu-heading"><br></p>
         	 <?php 
				if($isLogged)
				echo "<div style=\"display: table; margin: 10px auto; align-text: center;\"><b>".$_SESSION["name"]." ".$_SESSION["surname"]."</b></div>";
			?>
			<ul class="pure-menu-list">
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
            <h1>Homepage</h1>
        </div>

        <div class="content" style="display: table; margin: 0 auto">
        	
 				<h3 class="error">
 			 	<noscript>
    			You should enable javascript or the website may not work properly
    			</noscript>
  				</h3>
			
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
