<?php
	session_start();
	unset($_SESSION["username"]);
	unset($_SESSION["login_time"]);
	header("Location:".$_SESSION["page"]);
?>