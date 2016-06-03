<?php 
	function isLogged(){
		if(!isset($_SESSION["login_time"]) || time() - $_SESSION["login_time"] > 2*60)
			return false;
		else 
			return true;
	}
	
	function cookiesEnabled(){
		setcookie('test', 1, 60);
		if(!isset($_GET['cookies'])){
			header("Location: " . $_SERVER["REQUEST_URI"]."?cookies=true");
		}else{
			unset($_GET['cookies']);
		}
		if(count($_COOKIE) <= 0)
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