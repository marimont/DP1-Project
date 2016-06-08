<?php
	session_start();
	require 'configDB.php';
	
	if(isset($_REQUEST["name"]) && isset($_REQUEST["surname"]) 
			&& isset($_REQUEST["email"]) && isset($_REQUEST["password"]) && isset($_REQUEST["check_password"])){
		$name = htmlentities($_REQUEST["name"]);
		$surname = htmlentities($_REQUEST["surname"]);
		$email = htmlentities($_REQUEST["email"]);
		$pwd = $_REQUEST["password"];
		/*I'm not sanitizing pwds in order to avoid weakening them
		 * Thet're gonna be processed by a hash function, so they won't be offensive
		 * */
	} else die("<h1>Access forbidden</h1>");
	
	//double check on email format validity
	$subject = $email;
	$pattern = '/[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+(?:com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum|[a-zA-Z]{2})/';
	if(!preg_match($pattern, $subject)){
		$_SESSION["regFailure"] = "Invalid email format";
		header("Location:registration.php?result=0.php");
		exit();
	}
		
	mysqli_report(MYSQLI_REPORT_ERROR);
	if($link = my_connect()){
		mysqli_autocommit($link, false);
		try{
			$name = mysqli_real_escape_string($link, $name);
			$surname = mysqli_real_escape_string($link, $surname);
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