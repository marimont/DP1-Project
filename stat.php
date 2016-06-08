<?php 
	function isLogged(){
		if(!isset($_SESSION["login_time"]) || time() - $_SESSION["login_time"] > 2*60)
			return false;
		else 
			return true;
	}
	
	function cookiesEnabled(){
		//to set an expiration date which is different from default you need to specify the domain
		//localhost won't work -> setcookie("test", "1", 0, "/", FALSE);
		setcookie("test", "1");
		if (!isset($_REQUEST["cookies"])) {
				header("Location: ". $_SERVER['PHP_SELF']."?cookies=1".$_SESSION['params']);
   		 }   		 
   		 if (!isset($_COOKIE["test"]) || (isset($_COOKIE["test"]) && $_COOKIE["test"] != "1"))
  			die("<h1>It seems that your browser doesn't accept cookies!</h1> <h3>Unfortunately we need cookies to provide you a good service.
   			In order to proceed on our website: enable them and reload the page</h3>");
   
	}
	
	function checkHTTPS(){
		if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on"){
			header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
			exit();
		}
	}
?>