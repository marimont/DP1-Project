<?php
	session_start();
	require 'stat.php';
	/*I'm gonna use session variables, so I definitely need to check if cookies are still enabled*/
	cookiesEnabled();
	/*If a user logs in and then, immediately logs out it isn't redirected to the "login success" page, 
	 * but to the login form*/
	if($_SESSION["page"] == "login.php" && isset($_REQUEST["result"]))
		unset($_REQUEST["result"]); 
	unset($_SESSION["username"]);
	unset($_SESSION["login_time"]);
	header("Location:".$_SESSION["page"]);
	//echo $_SESSION["page"];
?>