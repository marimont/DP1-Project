<?php
/*this script performs some check which are performed by each page and sets some session variables.
 * Moreover it sets some session variables which are specific for certain pages.
 * But that's not a big deal because it checks URL-encoded parameters so in those cases which are not required
 * GET parameters will be unset, so it will set an empty session variable*/

session_start();
require 'stat.php';
checkHTTPS();
/*I need to save eventual arguments coming from GET requests to avoid
 * to lose them when I'm redirected back from checkCookies function, which
 * will attach nother GET argument (cookies=1) after the already existing ones.*/
if(isset($_REQUEST['result']))
	/*used by pages which performs database actions which can return a success or a failure.
	 * In both cases I need to know that in order to show the proper view to the  user*/
	$_SESSION["params"] = "&result=".$_REQUEST['result'];
else if(isset($_REQUEST['manageReservations']) && $_REQUEST['manageReservations'] == 1)
	/*used by login page to understand if the user has been redirected here by reservations page.
	 * In this case I need to show a message to inform the user*/
	$_SESSION["params"] = "&manageReservations=".$_REQUEST['manageReservations'];
else
	/*no function results. no redirection from reservations page*/
	$_SESSION["params"] = "";
cookiesEnabled();
if(isLogged()){
	/*update session*/
	$_SESSION["login_time"] = time();
	/*used by logout script to know where the user must be redirected*/
	$_SESSION["page"] = $_SERVER["REQUEST_URI"];
	$isLogged = true;
} else
	$isLogged = false;
?>