<?php

////////////////////////////////////////////////////////////////////
/// Send query to db, return data[]
function dbQuery($query) {

	$db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if (mysqli_connect_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with database connection.'];
		header('Location: ../index.php');
		die;
	}

	$result = mysqli_query($db, $query);

	if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Problem with query.'];
		header('Location: ../index.php');
		die;
	}
	
	if (mysqli_num_rows($result)>0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}
	}
	mysqli_free_result($result);
	mysqli_close($db);

	if ( !empty($data) ) {
		return $data;
	}
	else {
		return NULL;
	}
}

////////////////////////////////////////////////////////////////////
/// Send SELECT query to db, return data[]
function sqlQuery($query, $action = "SELECT") {
	$mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if ($mysqli->connect_errno) {
	    print $mysqli->connect_error;
	}

	$data = [];
	if ($result = $mysqli->query($query)) {
		if ($action == "SELECT") {
			while($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
			$result->close();
		}	
	}

	$mysqli->close();
	return $data;
}

////////////////////////////////////////////////////////////////////
/// Check if user in session/logged in, return bool
function isLoggedIn() {
	if (isset($_SESSION['user']))
		return true;
	else 
		return false;
}

//////////////////////////////////////////////////////////////////
/// Returns a string with random a-z, 0-9
function randomString($length = 10) {
	$letters = array_merge(range("a", "z"), range(0, 9));
	$string = "";

	for ($i = 0; $i < $length; $i++) {
		$letter = array_rand($letters);
		$string .= $letters[$letter];
	}
	return $string;
}