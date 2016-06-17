<?php

$config = 1;	//0 for localhost and 1 for the other db
$N = 4;

function my_connect(){
	global $config;
	if($config == 0)
		return mysqli_connect('localhost', 'root', '', 'assignment');
	else
		return mysqli_connect('localhost', 's231579', 'nisterea', 's231579');
}

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
					else
						mysqli_commit($link);
						
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
					else
						mysqli_commit($link);
					mysqli_free_result($res);
				}

			}
		} else throw new Exception("<h1>Can't execute query</h1>");
	}catch (Exception $e){
		mysqli_rollback($link);
		die($e -> getMessage());
	}
}


?>