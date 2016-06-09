<?php
	session_start();
	require 'configDB.php';
	
	if(isset($_REQUEST["startH"]) && isset($_REQUEST["startM"]) 
			&& isset($_REQUEST["machine"])){
		if($_REQUEST["startH"] != "" && $_REQUEST["startM"]
				&& $_REQUEST["machine"]){
			$startH = htmlentities($_REQUEST["startH"]);
			$startM = htmlentities($_REQUEST["startM"]);
			$machineID = htmlentities($_REQUEST["machine"]);
		} else die("<h1>Access forbidden</h1>");
	} else die("<h1>Access forbidden</h1>");
	
	if(!is_numeric($startH) || !is_numeric($startM) || !is_numeric($machineID)){
		$_SESSION["resFailure"] = "Wrong input values: not numeric";
		header("Location:reservations.php?result=0");
		exit();
	}
		
	//double check on input validity;
	if($startH < 0 || $startH > 23
			|| $startM < 0 || $startM >59){
		$_SESSION["resFailure"] = "Wrong input values: out of range";
		header("Location:reservations.php?result=0");
		exit();
	}
		
	//mysqli_report(MYSQLI_REPORT_ERROR);
	if($link = my_connect()){
		mysqli_autocommit($link, false);
		try{
			$startH = mysqli_real_escape_string($link, $startH);
			$startM = mysqli_real_escape_string($link, $startM);
			$machineID = mysqli_real_escape_string($link, $machineID);
			$startT = $startH*60 + $startM;
			$prequery = "SELECT ID FROM users WHERE Email = '".$_SESSION["username"]."'";
			$res = mysqli_query($link, $prequery);
			if(!$res)
				throw new Exception("Query failed");
			if(mysqli_num_rows($res) == 0 )
				throw new Exception("User identification failed");
			$row = mysqli_fetch_array($res);
			$idu = $row[0];		
			mysqli_free_result($res);
		
			/*User identification: if someone tries to delete other user reservations will be blocked*/
			$query = "SELECT ID, TimeStamp from reservations WHERE IDM = $machineID AND StartTime = $startT AND IDU = $idu";
			$res = mysqli_query($link, $query);
			if(!$res)
				throw new Exception("Query failed");
			if(mysqli_num_rows($res) == 0 )
				throw new Exception("No reservation found for the specified machine <br> at the specified time slot at your name!");
			
			$row = mysqli_fetch_array($res);
			$id = $row[0];
			$timestamp = $row[1];
			mysqli_free_result($res);
			
			$current_time_array = getdate();
			$current_time = $current_time_array['hours']*60 + $current_time_array['minutes'];
			
			if(($current_time - $timestamp) < 1)
				throw new Exception("Reservation can't be cancelled: at least 1 minute from the reservation <br> registration
				must be elapsed!");
		
			$query = "DELETE FROM reservations WHERE ID = $id";
			$res = mysqli_query($link, $query);
			if($res && mysqli_affected_rows($link) == 1){
				mysqli_commit($link);
				header("Location:reservations.php?result=1");
				exit();
			} else throw new Exception("Elimination failed");
		} catch(Exception $e){
			mysqli_rollback($link);
			$_SESSION["resFailure"] = $e -> getMessage();
			header("Location:reservations.php?result=0");
			exit();
		}
		/*Using mysql_close() isn't usually necessary, as non-persistent open
		 *links are automatically closed at the end of the script's execution.
		 *(from php manual) 
		 */
		mysqli_close($link);
	}else{
		$_SESSION["resFailure"] = "Can't connect to database";
		header("Location:reservations.php?result=0");
		exit();
	}
	
?>