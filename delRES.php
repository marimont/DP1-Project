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
	
	/*in this way I'm sure I arrived here from a form*/
	if(!isset($_POST["resID"]) || $_POST["resID"] == ""){
		$_SESSION["resFailure"] = "access forbidden";
		header("Location:reservations.php?result=0");
		exit();
	}
	
	/*I sanitize input as I would do for any other input field
	 * to a avoid a malicious usage  of the hidden field*/
	$reservationID = htmlentities($_POST["resID"]);
	if(!is_numeric($reservationID)){
		$_SESSION["resFailure"] = "access forbidden";
		header("Location:reservations.php?result=0");
		exit();
	}
	
	//mysqli_report(MYSQLI_REPORT_ERROR);
	if($link = my_connect()){
		mysqli_autocommit($link, false);
		try{
			/*This check is needed to avoid some code injection: somebody could send
			 * some post from the outside and so it is important to check that the user
			 * that is trying to delete a reservation is eliminating its own reservations*/
			$prequery = "SELECT ID FROM users WHERE Email = '".$_SESSION["username"]."'";
			$res = mysqli_query($link, $prequery);
			if(!$res)
				throw new Exception("Query failed");
			if(mysqli_num_rows($res) == 0 )
				throw new Exception("user identification failed");
			$row = mysqli_fetch_array($res);
			$idu = $row[0];		
			mysqli_free_result($res);
		
			$reservationID = mysqli_real_escape_string($link, $reservationID);
			$query = "SELECT TimeStamp from reservations WHERE ID = $reservationID AND IDU = $idu";
			$res = mysqli_query($link, $query);
			if(!$res)
				throw new Exception("Query failed");
			if(mysqli_num_rows($res) == 0 )
				throw new Exception("reservation can't be found!");
			
			$row = mysqli_fetch_array($res);
			$timestamp = $row[0];
			mysqli_free_result($res);
			
			$current_time = time();
			
			if(($current_time - $timestamp) < 60)
				throw new Exception("at least 1 minute from the reservation insertion
				must be elapsed");
		
			$query = "DELETE FROM reservations WHERE ID = $reservationID";
			$res = mysqli_query($link, $query);
			if($res && mysqli_affected_rows($link) == 1){
				mysqli_commit($link);
				header("Location:reservations.php?result=1");
				exit();
			} else throw new Exception("elimination failed");
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