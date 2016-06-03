<?php
	session_start();
	if(isset($_REQUEST["username"]) && isset($_REQUEST["password"])){
		$username = htmlentities($_REQUEST["username"]);
		$pwd = htmlentities($_REQUEST["password"]);
	} else die("<h1>Access forbidden</h1>");
	
	mysqli_report(MYSQLI_REPORT_ERROR);
	if($link = mysqli_connect('localhost', 'root', '', 'assignment')){
		$username = mysqli_real_escape_string($link, $username);
		$query = "SELECT Password FROM users WHERE Email = '$username'";
		$res = mysqli_query($link, $query);
		if(mysqli_num_rows($res) > 0 ){
			$row = mysqli_fetch_array($res);
			if($row[0] == md5($pwd)){
				$_SESSION["username"] = $username;
				$_SESSION["login_time"] = time();
				header("Location:loggedIn.php");
			} else {
				$_SESSION["loginFailure"] = "Wrong username or password";
				header("Location:loginFailure.php");
			}
		} else{ 
			$_SESSION["loginFailure"] = "Username not found in the database";
			header("Location:loginFailure.php");
		}
		mysqli_free_result($res);
	}else{
		$_SESSION["loginFailure"] = "Can't connect to the database";
		header("Location:loginFailure.php");
	}
	mysqli_close($link);
?>