<?php

if (isset($_POST['signup'])) {
	include 'dbh.inc.php';
	include 'tool.inc.php';

	// access signup info from post method
	$first = mysqli_real_escape_string($conn, $_POST['first']);
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$uid = mysqli_real_escape_string($conn, $_POST['username']);
	$pass = mysqli_real_escape_string($conn, $_POST['password']);
	$pass2 = mysqli_real_escape_string($conn, $_POST['password2']);

	// initialize header location
	$headerloc = "../signup.php";
	
	// error validation
	$passthrough = True;
	$getParam = array();

	// validate first name
	if (empty($first)){
		$getParam['signup'][] = 'empty';
		$passthrough = False;
	} elseif (!preg_match("/^[a-zA-Z'-]/", $first)) {
		$getParam['signup'][] = 'invalidfirstname';
		$passthrough = False;
	} else {
		$getParam['first'][] = $first;
	}

	// validate last name
	if (empty($last)){
		$getParam['signup'][] = 'empty';
		$passthrough = False;
	} elseif (!preg_match("/^[a-zA-Z'-]/", $last)) {
		$getParam['signup'][] = 'invalidlastname';
		$passthrough = False;
	} else {
		$getParam['last'][] = $last;
	}

	// validate email
	if (empty($email)){
		$getParam['signup'][] = 'empty';
		$passthrough = False;
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$getParam['signup'][] = 'invalidemail';
		$passthrough = False;
	} else {
		$getParam['email'][] = $email;
	}

	// validate password
	if (empty($pass) || empty($pass2)){
		$getParam['signup'][] = 'empty';
		$passthrough = False;
	} elseif (!empty($pass) && !empty($pass2) && $pass != $pass2) {
		$getParam['signup'][] = 'password';
		$passthrough = False;
	} 


	// validate unique user id
	$sql = "SELECT * FROM users WHERE uid=? OR email=?";
	$stmt = mysqli_stmt_init($conn);
	if (mysqli_stmt_prepare($stmt, $sql)){
		mysqli_stmt_bind_param($stmt, 'ss', $uid, $email);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$rows = mysqli_num_rows($result);
		if (empty($uid)){
			$getParam['signup'][] = 'empty';
			$passthrough = False;
		} elseif ($rows > 0){
			$getParam['signup'][] = 'usertaken';
			$passthrough = False;
		}  else {
			$getParam['username'][] = $uid;
		}

		if ($passthrough == True){

			// hash password and insert signup info to database
			$passHash = password_hash($pass, PASSWORD_DEFAULT);

			// insert user info to database
			$sql = "INSERT INTO users (uid, firstname, lastname, email, pwd) VALUES (?, ?, ?, ?, ?)";
			$stmt = mysqli_stmt_init($conn);
			if (mysqli_stmt_prepare($stmt, $sql)){
				mysqli_stmt_bind_param($stmt, 'sssss', $uid, $first, $last, $email, $passHash);
				mysqli_stmt_execute($stmt);

				header("Location: ../signup.php?signup=success");
				exit();
			}
		} else {

			// if any info is invalid, append valid part to the url so the user doesn't have to re-type the valid parts again
			foreach ($getParam as $key => $value) {
				$val = join('-', $value);
				if (!empty($val)) {
					$headerloc = addGetParaToURL($headerloc, $key, $val);
				}
			}

			header("Location: ".$headerloc);
		}

	}

} else{
	header("Location: ../signup.php?signup=error");
}

