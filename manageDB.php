<?php

$N = 4;

function checkDB($link){
	global $N;
	//if($link = mysqli_connect('localhost', 'root', '', 'assignment')){
		$query = "SELECT COUNT(*) FROM machines";
		if($res = mysqli_query($link, $query)){
			/*row[0] contains the number of machines into the db
			 * -if row[0] != N we need to update both reservations table (if N < row[0]) and machines table (both cases)
			 * */
			$row = mysqli_fetch_array($res);
			mysqli_free_result($res);
			if($row[0] < $N){
				//TODO add machines
				for($id = $row[0] + 1; $id <= $N; $id++ ){
					$query = "INSERT INTO machines(Name) VALUES('Printer".$id."')";
					$res = mysqli_query($link, $query);
					if($res){
						if(mysqli_affected_rows($link) != 1)
							die("<h1>Database insertion failed: cannot  insert new machine</h1>");	
						//insert and update don't return msqli_result object, so, no need to perform free
					}	
				}
			}else if($row[0] > $N){
				//TODO remove machines
				$query = "SELECT ID FROM machines WHERE ID = (SELECT MAX(ID) FROM machines)";	
				for($i = $N; $i < $row[0]; $i++){
					$res = mysqli_query($link, $query);
					$deleteRow = mysqli_fetch_array($res);
					$deleteQuery = "DELETE FROM reservations WHERE IDM='".$deleteRow[0]."'";
					$deleteQuery1 = "DELETE FROM machines WHERE ID='".$deleteRow[0]."'";
					mysqli_query($link, $deleteQuery);
					mysqli_query($link, $deleteQuery1);
					mysqli_free_result($res);
				}
				
			}
		} else die("<h1>Can't execute query</h1>");
		//mysqli_close($link);
	//} else die("<h1>Can't connect to DB</h1>");
}

function loadDB(){
	mysqli_report(MYSQLI_REPORT_ERROR);
	if($link = mysqli_connect('localhost', 'root', '', 'assignment')){
		checkDB($link);
		$query = "SELECT U.Name, U.Surname, M.Name, R.StartTime, R.EndTime 
				FROM reservations AS R, users AS U, machines AS M
				WHERE R.IDU = U.ID AND R.IDM = M.ID
				ORDER BY R.IDU, R.StartTime";
		if($res = mysqli_query($link, $query)){
			echo "<table class=\"reservations_table\">";
			echo "<th>User</th><th>Machine</th><th>StartTime</th><th>Duration(min)</th>";
			while ($row = mysqli_fetch_array($res)){
				$name = $row[0];
				$surname = $row[1];
				$machine = $row[2];
				$duration = $row[4] - $row[3];
				$startTimeH = intval($row[3]/60);
				$startTimeHstr = sprintf("%02d", $startTimeH);
				$startTimeM = $row[3]%60;
				$startTimeMstr = sprintf("%02d", $startTimeM);
				echo "<tr>";
				echo "<td>$name $surname</td><td>$machine</td><td>$startTimeHstr:$startTimeMstr</td><td>$duration</td>";
				echo "</tr>";
			}
			echo "</table>";
			mysqli_free_result($res);
		} else die("<h1>Can't execute query</h1>");
		mysqli_close($link);
	} else die("<h1>Can't connect to DB</h1>");
}

	function loadUserReservations($username){
		mysqli_report(MYSQLI_REPORT_ERROR);
		if($link = mysqli_connect('localhost', 'root', '', 'assignment')){
			$query = "SELECT M.Name, R.StartTime, R.EndTime
				FROM reservations AS R, users AS U, machines AS M
				WHERE R.IDU = U.ID AND R.IDM = M.ID AND U.Email = '$username'
				ORDER BY R.StartTime";
			if($res = mysqli_query($link, $query)){
				echo "<table class=\"reservations_table\">";
				echo "<th>Machine</th><th>StartTime</th><th>Duration(min)</th>";
				while ($row = mysqli_fetch_array($res)){
					$machine = $row[0];
					$duration = $row[2] - $row[1];
					$startTimeH = intval($row[1]/60);
					$startTimeHstr = sprintf("%02d", $startTimeH);
					$startTimeM = $row[1]%60;
					$startTimeMstr = sprintf("%02d", $startTimeM);
					echo "<tr>";
					echo "<td>$machine</td><td>$startTimeHstr:$startTimeMstr</td><td>$duration</td>";
					echo "</tr>";
				}
				echo "</table>";
						mysqli_free_result($res);
			} else die("<h1>Can't execute query</h1>");
			mysqli_close($link);
		} else die("<h1>Can't connect to DB</h1>");
	}


?>

