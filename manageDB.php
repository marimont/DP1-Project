<?php
require 'configDB.php';

function loadDB(){
	try{
		if($link = my_connect()){
		//mysqli_report(MYSQLI_REPORT_ERROR);
			checkDB($link);
			$query = "SELECT U.Name, U.Surname, M.Name, M.ID, R.StartTime, R.EndTime 
					FROM reservations AS R, users AS U, machines AS M
					WHERE R.IDU = U.ID AND R.IDM = M.ID
					ORDER BY R.IDU, R.StartTime";
			if($res = mysqli_query($link, $query)){
				if(mysqli_num_rows($res) > 0){
					echo "<table class=\"pure-table\">";
					echo "<thead><tr><th>User</th><th>Machine</th><th>StartTime</th><th>Duration(min)</th></tr></thead>";
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
		if($link = my_connect()){
			$query = "SELECT M.Name, M.ID, R.StartTime, R.EndTime, R.ID
				FROM reservations AS R, users AS U, machines AS M
				WHERE R.IDU = U.ID AND R.IDM = M.ID AND U.Email = '$username'
				ORDER BY R.StartTime";
			if($res = mysqli_query($link, $query)){
					if(mysqli_num_rows($res) > 0){
					echo "<table class=\"pure-table\" style=\"margin:20px;\">";
					echo "<thead><tr><th>Machine</th><th>StartTime</th><th>Duration(min)</th><th></th></tr></thead>";
					while ($row = mysqli_fetch_array($res)){
						$machine = $row[0];
						$machineID = $row[1];
						$duration = $row[3] - $row[2];
						$reservationID = $row[4];
						$startTimeH = intval($row[2]/60);
						$startTimeHstr = sprintf("%02d", $startTimeH);
						$startTimeM = $row[2]%60;
						$startTimeMstr = sprintf("%02d", $startTimeM);
						echo "<tr>";
						echo "<td>$machine (ID = $machineID)</td><td>$startTimeHstr:$startTimeMstr</td><td>$duration</td>
						<td><input type=\"submit\" name=\"$reservationID\" class=\"pure-button pure-button-primary\" value=\"Remove\" style=\"margin: 5px;\"></td>";
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

