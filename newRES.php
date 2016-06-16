<?php
	require 'checkStatusAndSession.php';
	require 'configDB.php';
	
	if(!$isLogged){
		/*i redirect the user to login page, letting him know, throught this GET parameter
		 * that  he has been redirected there from here.
		 */
		header("Location:login.php?manageReservations=1");
		exit;
	}
	
	if(isset($_REQUEST["startH"]) && isset($_REQUEST["startM"]) 
			&& isset($_REQUEST["endH"]) && isset($_REQUEST["endM"])){
		if($_REQUEST["startH"] != "" && $_REQUEST["startM"] != ""
				&& $_REQUEST["endH"] != "" && $_REQUEST["endM"] != ""){
		$startH = htmlentities($_REQUEST["startH"]);
		$startM = htmlentities($_REQUEST["startM"]);
		$endH = htmlentities($_REQUEST["endH"]);
		$endM = htmlentities($_REQUEST["endM"]);
		} else die("<h1>Access forbidden</h1>");
	} else die("<h1>Access forbidden</h1>");
	
	if(!is_numeric($startH) || !is_numeric($startM)
			|| !is_numeric($endH) || !is_numeric($endM)){
		$_SESSION["resFailure"] = "Wrong input values: not numeric";
		header("Location:reservations.php?result=0");
		exit();
	}
		
	//double check on input validity;
	if($startH < 0 || $startH > 23
			|| $startM < 0 || $startM >59
			|| $endH < 0 || $endH > 23
			|| $endM < 0 || $endM > 59 ){
		$_SESSION["resFailure"] = "Wrong input values: out of range";
		header("Location:reservations.php?result=0");
		exit();
	}
	
	$startT = $startH*60 + $startM;
	$endT = $endH*60 + $endM;
	
	if(($endT - $startT) <= 0){
		$_SESSION["resFailure"] = "Wrong input values: negative time slot";
		header("Location:reservations.php?result=0");
		exit();
	}
	
	
	//mysqli_report(MYSQLI_REPORT_ERROR);
	if($link = my_connect()){
		mysqli_autocommit($link, false);
		try{
			$startH = mysqli_real_escape_string($link, $startH);
			$startM = mysqli_real_escape_string($link, $startM);
			$endH = mysqli_real_escape_string($link, $endH);
			$endM = mysqli_real_escape_string($link, $endM);
			$subquery = "SELECT IDM FROM reservations AS R WHERE (R.StartTime > $startT AND R.StartTime < $endT)
							OR (R.EndTime < $endT AND R.EndTime > $startT)
							OR (R.StartTime <= $startT AND R.EndTime >= $endT) ";
			$query = "SELECT ID from machines WHERE ID NOT IN ($subquery) FOR UPDATE";
			$res = mysqli_query($link, $query);
			if(!$res)
				throw new Exception("Query failed");
		
			if(mysqli_num_rows($res) == 0 )
				throw new Exception("No printers available for the desired time slot");
			$row = mysqli_fetch_array($res);
			$idm = $row[0];
			mysqli_free_result($res);
			
			$user = $_SESSION['username'];
			$query = "SELECT ID FROM users WHERE Email = '$user'";
			$res = mysqli_query($link, $query);
			if($res && mysqli_num_rows($res) == 1){
				$row = mysqli_fetch_array($res);
				$idu = $row[0];
			}else throw new Exception("User identification failed");

			mysqli_free_result($res);
			
			/*Saving current timestamp in order to satisfy the time constraint on removal
			 * One key point is that I cannot save just hrs and minutes of the current
			 * date otherwise, if I try to remove one reservation some days after the
			 * day it has been inserted, but at a time in a day which preceeds the time
			 * in day when the reservation was inserted, I cannot remove it because
			 * the system would consider the constraint on time violated*/
			$timestamp = time();
			
			$query = "INSERT INTO reservations(IDU, IDM, StartTime, EndTime, TimeStamp) VALUES('$idu', '$idm', $startT, $endT, $timestamp)";
			$res = mysqli_query($link, $query);
			if($res && mysqli_affected_rows($link) == 1){
				mysqli_commit($link);
				header("Location:reservations.php?result=1");
				exit();
			} else throw new Exception("Insertion failed");
			
			}catch(Exception $e){
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
		$_SESSION["resFailure"] = "Can't connect to the database";
		header("Location:reservations.php?result=0");
		exit();
	}
	
?>