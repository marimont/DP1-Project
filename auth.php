<?php
	session_start();
	require 'configDB.php';
	require 'stat.php';
	cookiesEnabled();
	checkHTTPS();
	/*here it makes no sense to check if the user is logged in or not:
	 * the login page sent its form here to perform login, so he is logged out!
	 */
	
	if(isset($_POST["username"]) && isset($_POST["password"])){
		if($_POST["username"] !="" || $_POST["password"] != ""){
		$username = htmlentities($_POST["username"]);
		$pwd = $_POST["password"];
		/*I'm not sanitizing pwds in order to avoid weakening them
		 * Thet're gonna be processed by a hash function, so they won't be offensive
		 * */
		} else {
			$_SESSION["loginFailure"] = "empty fields";
			header("Location: login.php?result=0");
			exit();
		}
	} else die("<h1>Access forbidden</h1>");
	
	/*Sanitizing strings is good practise but it's also a good idea to limit 
	 * the numbers of chars that the  user can input*/
	
	if(strlen($username) > 50){
		$_SESSION["loginFailure"] = "username maximum length is of 50 characters";
		header("Location: login.php?result=0");
		exit();
	}
	
	if(strlen($pwd) > 50){
		$_SESSION["loginFailure"] = "password maximum length is of 50 characters";
		header("Location: login.php?result=0");
		exit();
	}
	
	//mysqli_report(MYSQLI_REPORT_ERROR);
	try{
		if($link = my_connect()){
			$username = mysqli_real_escape_string($link, $username);
			$query = "SELECT Password, Name, Surname FROM users WHERE Email = '$username'";
			$res = mysqli_query($link, $query);
			if(mysqli_num_rows($res) > 0 ){
				$row = mysqli_fetch_array($res);
				if($row[0] == md5($pwd)){
					$_SESSION["name"] = $row[1];
					$_SESSION["surname"] = $row[2];
					$_SESSION["username"] = $username;
					$_SESSION["login_time"] = time();
					header("Location: login.php?result=1");
				} else throw new Exception("Wrong username or password");
			} else throw new Exception("Wrong username or password");
			mysqli_free_result($res);
			mysqli_close($link);
		}else throw new Exception( "Can't connect to the database");
	} catch(Exception $e){
		$_SESSION["loginFailure"] = $e -> getMessage();
		header("Location: login.php?result=0");
		exit();
	}
	
?>