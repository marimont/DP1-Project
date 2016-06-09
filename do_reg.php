<?php
	session_start();
	require 'configDB.php';
	
	if(isset($_REQUEST["name"]) && isset($_REQUEST["surname"]) 
			&& isset($_REQUEST["email"]) && isset($_REQUEST["password"]) && isset($_REQUEST["check_password"])){
		if($_REQUEST["name"]!= "" && $_REQUEST["surname"] != ""
			&& $_REQUEST["email"] != "" && $_REQUEST["password"] != "" && $_REQUEST["check_password"] != ""){
			$name = htmlentities($_REQUEST["name"]);
			$surname = htmlentities($_REQUEST["surname"]);
			$email = htmlentities($_REQUEST["email"]);
			$pwd = $_REQUEST["password"];
		/*I'm not sanitizing pwds in order to avoid weakening them
		 * Thet're gonna be processed by a hash function, so they won't be offensive
		 * */
		} else die("<h1>Access forbidden</h1>");
	} else die("<h1>Access forbidden</h1>");
	
	/*Sanitizing strings is good practise but it's also a good idea to limit
	 * the numbers of chars that the  user can input*/
	
	if(strlen($name) > 50){
		$_SESSION["regFailure"] = "name maximum length is of 50 characters";
		header("Location:registration.php?result=0.php");
		exit();
	}
	
	if(strlen($surname) > 50){
		$_SESSION["regFailure"] = "surname maximum length is of 50 characters";
		header("Location:registration.php?result=0.php");
		exit();
	}
	
	if(strlen($email) > 50){
		$_SESSION["regFailure"] = "email maximum length is of 50 characters";
		header("Location:registration.php?result=0.php");
		exit();
	}
	
	if(strlen($pwd) > 50){
		$_SESSION["regFailure"] = "password maximum length is of 50 characters";
		header("Location:registration.php?result=0.php");
		exit();
	}
	
	//double check on email format validity
	$subject = $email;
	$pattern = '/[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+(?:com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum|[a-zA-Z]{2})/';
	if(!preg_match($pattern, $subject)){
		$_SESSION["regFailure"] = "Invalid email format";
		header("Location:registration.php?result=0.php");
		exit();
	}
		
	//mysqli_report(MYSQLI_REPORT_ERROR);
	if($link = my_connect()){
		mysqli_autocommit($link, false);
		try{
			$name = mysqli_real_escape_string($link, $name);
			$surname = mysqli_real_escape_string($link, $surname);
			$email = mysqli_real_escape_string($link, $email);
			$pwd = md5($pwd);
			$query = "SELECT * FROM users WHERE Email = '$email' FOR UPDATE";
			$res = mysqli_query($link, $query);
			if(mysqli_num_rows($res) > 0 ) 
				throw new Exception("Email already in use");			
			mysqli_free_result($res);
			$query = "INSERT INTO users(Name, Surname, Email, Password) VALUES('$name', '$surname', '$email', '$pwd')";
			$res = mysqli_query($link, $query);
			if($res && mysqli_affected_rows($link) == 1){
				$_SESSION["email"] = $email;
				mysqli_commit($link);
				header("Location:registration.php?result=1");
				exit();
			} else throw new Exception("Registration insertion failed");
			mysqli_free_result($res);
		}catch (Exception $e){
			mysqli_rollback($link);
			$_SESSION["regFailure"] = $e -> getMessage();
			header("Location:registration.php?result=0");
			exit();
		}
		mysqli_close($link);
	}else{
		$_SESSION["regFailure"] = "Can't connect to the database";
		header("Location:registration.php?result=0");
		exit();
	} 
	
	
?>