<?php 
	$db['db_host']='localhost';
	$db['db_user']='root';
	$db['db_pass']='';
	$db['db_name']='login_db';

	foreach ($db as $key => $value) {
		define(strtoupper($key), $value);
	}

	$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (!$con) {
		echo "<script>alert('Connection to the database failed.')</script>";
	}


	function row_count($result){
		global $con;
		return mysqli_num_rows($result);
	}

	function query($query){
		global $con;
		return mysqli_query($con, $query);
	}

	function escape($string){
		global $con;
		return mysqli_real_escape_string($con, $string);
	}

	function fetch_array($result){
		global $con;
		return mysqli_fetch_array($result);
	}

	function confirm($result){
		global $con;
		if (!$result) {
			die('Query failed.' . mysqli_error($con));
		}
	}
?>