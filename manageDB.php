<!DOCTYPE html>
<html>
<head>
<style type="text/css">
	table{
		border: 1px solid black;
	}
	
	th, td{
		padding: 5px;
	}
	
	
	#this_table tr:nth-child(even) {background: #CCC}
	#this_table tr:nth-child(odd) {background: #FFF}
	
</style>
</head>
<body>
<?php

function loadDB(){
	mysqli_report(MYSQLI_REPORT_ERROR);
	if($link = mysqli_connect('localhost', 'root', '', 'assignment')){
		$query = "SELECT U.Name, U.Surname, M.Name, R.StartTime, R.EndTime 
				FROM reservations AS R, users AS U, machines AS M
				WHERE R.IDU = U.ID AND R.IDM = M.ID
				ORDER BY R.IDU, R.StartTime";
		if($res = mysqli_query($link, $query)){
			echo "<table id=\"this_table\">";
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
?>
</body>
</html>
