<?php

$N = 4;

function checkDB($link){
	global $N;
	//if($link = mysqli_connect('localhost', 'root', '', 'assignment')){
	mysqli_autocommit($link, false);
		try {
			$query = "SELECT COUNT(*) FROM machines FOR UPDATE";
			if($res = mysqli_query($link, $query)){
				/*row[0] contains the number of machines into the db
				 * -if row[0] != N we need to update both reservations table (if N < row[0]) and machines table (both cases)
				 * */
				$row = mysqli_fetch_array($res); //$row[0] <- current number of machines in db
				mysqli_free_result($res);
				if($row[0] < $N){
					//add machines
					for($id = $row[0] + 1; $id <= $N; $id++ ){
						$query = "INSERT INTO machines(Name) VALUES('Printer".$id."')";
						$res = mysqli_query($link, $query);
						if(!$res || mysqli_affected_rows($link) != 1 )
							throw new Exception("<h1>Database insertion failed: cannot  insert new machine</h1>");
							//insert and update don't return msqli_result object, so, no need to perform free
							
					}
				}else if($row[0] > $N){
					//remove machines
					$query = "SELECT MAX(ID) FROM machines FOR UPDATE";	
					for($i = $N; $i < $row[0]; $i++){
						$res = mysqli_query($link, $query);
						if(!$res || mysqli_num_rows($res) != 1)
							throw new Exception("<h1>Can't find maximun machine ID</h1>");
						$deleteRow = mysqli_fetch_array($res);
						$deleteQuery = "DELETE FROM reservations WHERE IDM='".$deleteRow[0]."'";
						$deleteQuery1 = "DELETE FROM machines WHERE ID='".$deleteRow[0]."'";
						if(!mysqli_query($link, $deleteQuery))
							throw new Exception("<h1>Elimination from reservations table failed</h1>");
						if(!mysqli_query($link, $deleteQuery1))
							throw new Exception("<h1>Elimination from machines table failed</h1>");
						mysqli_free_result($res);
					}	
				
				}
			} else throw new Exception("<h1>Can't execute query</h1>");
		}catch (Exception $e){
			die($e -> getMessage());
		}
}

function loadDB(){
	try{
		if($link = mysqli_connect('localhost', 'root', '', 'assignment')){
		//mysqli_report(MYSQLI_REPORT_ERROR);
			checkDB($link);
			$query = "SELECT U.Name, U.Surname, M.Name, M.ID, R.StartTime, R.EndTime 
					FROM reservations AS R, users AS U, machines AS M
					WHERE R.IDU = U.ID AND R.IDM = M.ID
					ORDER BY R.IDU, R.StartTime";
			if($res = mysqli_query($link, $query)){
				if(mysqli_num_rows($res) > 0){
					echo "<table class=\"reservations_table\">";
					echo "<th>User</th><th>Machine</th><th>StartTime</th><th>Duration(min)</th>";
					while ($row = mysqli_fetch_array($res)){
						$name = $row[0];
						$surname = $row[1];
						$machine = $row[2];
						$machineID = $row[3];
						$duration = $row[5] - $row[4];
						$startTimeH = intval($row[4]/60);
						$startTimeHstr = sprintf("%02d", $startTimeH);
						$startTimeM = $row[4]%60;
						$startTimeMstr = sprintf("%02d", $startTimeM);
						echo "<tr>";
						echo "<td>$name $surname</td><td>$machine (ID = $machineID)</td><td>$startTimeHstr:$startTimeMstr</td><td>$duration</td>";
						echo "</tr>";
					}
					echo "</table>";
				} else {
					echo "<h3 style=\"background-color: #eeeeee; border: 1px solid black; padding: 5px;\">No reservations to be shown</h3>";
				}
				mysqli_free_result($res);
			} else  throw new Exception("<h1>Can't execute query</h1>"); 
			mysqli_close($link);	
		} else throw new Exception("<h1>Can't connect to DB</h1>");  
	}catch(Exception $e){
		die($e -> getMessage());
	}
}

function loadUserReservations($username){
	try{
		if($link = mysqli_connect('localhost', 'root', '', 'assignment')){
			$query = "SELECT M.Name, M.ID, R.StartTime, R.EndTime
				FROM reservations AS R, users AS U, machines AS M
				WHERE R.IDU = U.ID AND R.IDM = M.ID AND U.Email = '$username'
				ORDER BY R.StartTime";
			if($res = mysqli_query($link, $query)){
					if(mysqli_num_rows($res) > 0){
					echo "<table class=\"reservations_table\">";
					echo "<th>Machine</th><th>StartTime</th><th>Duration(min)</th>";
					while ($row = mysqli_fetch_array($res)){
						$machine = $row[0];
						$machineID = $row[1];
						$duration = $row[3] - $row[2];
						$startTimeH = intval($row[2]/60);
						$startTimeHstr = sprintf("%02d", $startTimeH);
						$startTimeM = $row[2]%60;
						$startTimeMstr = sprintf("%02d", $startTimeM);
						echo "<tr>";
						echo "<td>$machine (ID = $machineID)</td><td>$startTimeHstr:$startTimeMstr</td><td>$duration</td>";
						echo "</tr>";
					}
					echo "</table>";
				} else {
					echo "<h3 style=\"background-color: #eeeeee; border: 1px solid black; padding: 5px;\">You have no reservations</h3>";
				}
				mysqli_free_result($res);
			} else throw new Exception("<h1>Can't execute query</h1>"); 
			mysqli_close($link);
		} else throw new Exception("<h1>Can't connect to DB</h1>"); 

	} catch(Exception $e){
		die($e -> getMessage());
	}
}

?>

