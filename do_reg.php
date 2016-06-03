<?php
	session_start();
	
	if(isset($_REQUEST["name"]) && isset($_REQUEST["surname"]) 
			&& isset($_REQUEST["email"]) && isset($_REQUEST["password"]) && isset($_REQUEST["check_password"])){
		$name = htmlentities($_REQUEST["name"]);
		$surname = htmlentities($_REQUEST["surname"]);
		$email = htmlentities($_REQUEST["email"]);
		$pwd = htmlentities($_REQUEST["password"]);
	} else die("<h1>Access forbidden</h1>");
	
	//double check on email format validity
	$subject = $email;
	$pattern = '/.+@.+\..{2,3}/';
	if(!preg_match($pattern, $subject)){
		$_SESSION["regFailure"] = "Invalid email format";
		header("Location:regFailure.php");
		exit();
	}
	
	
	mysqli_report(MYSQLI_REPORT_ERROR);
	if($link = mysqli_connect('localhost', 'root', '', 'assignment')){
		$name = mysqli_real_escape_string($link, $name);
		$surname = mysqli_real_escape_string($link, $surname);
		$email = mysqli_real_escape_string($link, $email);
		$pwd = md5($pwd);
		$query = "SELECT * FROM users WHERE Email = '$email'";
		$res = mysqli_query($link, $query);
		if(mysqli_num_rows($res) > 0 ){
			$_SESSION["regFailure"] = "Email already in use";
			header("Location:regFailure.php");
			exit();
		}
		mysqli_free_result($res);
		$query = "INSERT INTO users(Name, Surname, Email, Password) VALUES('$name', '$surname', '$email', '$pwd')";
		$res = mysqli_query($link, $query);
		if(mysqli_affected_rows($link) == 1){
			$_SESSION["email"] = $email;
			header("Location:regOk.php");
			exit();
		} else{ 
			$_SESSION["regFailure"] = "Registration insertion failed";
			header("Location:regFailure.php");
			exit();
		}
		mysqli_free_result($res);
	}else{
		$_SESSION["regFailure"] = "Can't connect to the database";
		header("Location:regFailure.php");
		exit();
	}
	mysqli_close($link);
?>