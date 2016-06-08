<?php
	session_start();
	
	require 'configDB.php';
	if(isset($_REQUEST["username"]) && isset($_REQUEST["password"])){
		$username = htmlentities($_REQUEST["username"]);
		$pwd = $_REQUEST["password"];
		/*I'm not sanitizing pwds in order to avoid weakening them
		 * Thet're gonna be processed by a hash function, so they won't be offensive
		 * */
	} else die("<h1>Access forbidden</h1>");
	
	mysqli_report(MYSQLI_REPORT_ERROR);
	try{
		if($link = my_connect()){
			$username = mysqli_real_escape_string($link, $username);
			$query = "SELECT Password FROM users WHERE Email = '$username'";
			$res = mysqli_query($link, $query);
			if(mysqli_num_rows($res) > 0 ){
				$row = mysqli_fetch_array($res);
				if($row[0] == md5($pwd)){
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