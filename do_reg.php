<?php
	require 'checkStatusAndSession.php';
	require 'configDB.php';
	
	if(isset($_POST["name"]) && isset($_POST["surname"]) 
			&& isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["check_password"])){
		if($_POST["name"]!= "" && $_POST["surname"] != ""
			&& $_POST["email"] != "" && $_POST["password"] != "" && $_POST["check_password"] != ""){
			$name = htmlentities($_POST["name"]);
			$surname = htmlentities($_POST["surname"]);
			$email = htmlentities($_POST["email"]);
			$pwd = $_POST["password"];
			$pwd2 = $_POST["check_password"];
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
	
	if($pwd != $pwd2){
		$_SESSION["regFailure"] = "passwords not matching";
		header("Location:registration.php?result=0.php");
		exit();
	}
	
	//double check on email format validity
	/*I didn't find a function similar to javascript str.match which returns the string and you can 
	 * perform a comparison berween the email and the returned matching string, so that if partial match
	 * is found the email would be discarded in any case. PHP preg_match only returns TRUE or FALSE 
	 * so, if only a partial match is found, the email is accepted in any case! It's better to use 
	 * this built-in function*/
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
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