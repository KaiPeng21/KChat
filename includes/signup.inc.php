<?php

if (isset($_POST['signup'])) {
	include 'dbh.inc.php';
	include 'tool.inc.php';

	// access signup info from post method
	$first = mysqli_real_escape_string($conn_users, $_POST['first']);
	$last = mysqli_real_escape_string($conn_users, $_POST['last']);
	$email = mysqli_real_escape_string($conn_users, $_POST['email']);
	$uid = mysqli_real_escape_string($conn_users, $_POST['username']);
	$pass = mysqli_real_escape_string($conn_users, $_POST['password']);
	$pass2 = mysqli_real_escape_string($conn_users, $_POST['password2']);
	
	

	// error validation
	/*
	if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pass) || empty($pass2)) {
		header("Location: ../signup.php?signup=empty");
		exit();
	} elseif (!preg_match("/^[a-zA-Z'-]/", $first)) {
		header("Location: ../signup.php?signup=invalidfirstname");
		exit();
	} elseif (!preg_match("/^[a-zA-Z'-]/", $last)) {
		header("Location: ../signup.php?signup=invalidlastname&first=$first");
		exit();
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header("Location: ../signup.php?signup=invalidemail&first=$first&last=$last");
		exit();
	} elseif ($pass != $pass2) {
		header("Location: ../signup.php?signup=password&first=$first&last=$last&email=$email");
		exit();
	} else {

		$sql = "SELECT * FROM users WHERE uid='$uid' OR email='$email'";
		$result = mysqli_query($conn_users, $sql);
		$rows = mysqli_num_rows($result);

		if ($rows > 0){
			header("Location: ../signup.php?signup=usertaken&first=$first&last=$last&email=$email");
			exit();
		} else{

			// hash password and insert signup info to database
			$passHash = password_hash($pass, PASSWORD_DEFAULT);

			$sql = "INSERT INTO users(uid, firstname, lastname, email, pwd) VALUES ('$uid', '$first', '$last', '$email', '$passHash')";

			mysqli_query($conn_users, $sql);
			header("Location: ../signup.php?signup=success");
			exit();
		}

	}
	*/


	// initialize header location
	$headerloc = "../signup.php";
	
	// error validation
	$passthrough = True;
	$getParam = array();

	/*
	if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pass) || empty($pass2)) {
		//$headerloc = addGetParaToURL($headerloc, 'signup', 'empty');
		$getParam['signup'][] = 'empty';
		$passthrough = False;
	}
	*/

	if (empty($first)){
		$getParam['signup'][] = 'empty';
		$passthrough = False;
	} elseif (!preg_match("/^[a-zA-Z'-]/", $first)) {
		//header("Location: ../signup.php?signup=invalidfirstname");
		$getParam['signup'][] = 'invalidfirstname';
		$passthrough = False;
	} else {
		$getParam['first'][] = $first;
	}

	if (empty($last)){
		$getParam['signup'][] = 'empty';
		$passthrough = False;
	} elseif (!preg_match("/^[a-zA-Z'-]/", $last)) {
		//header("Location: ../signup.php?signup=invalidlastname&first=$first");
		$getParam['signup'][] = 'invalidlastname';
		$passthrough = False;
	} else {
		$getParam['last'][] = $last;
	}

	if (empty($email)){
		$getParam['signup'][] = 'empty';
		$passthrough = False;
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		//header("Location: ../signup.php?signup=invalidemail&first=$first&last=$last");
		$getParam['signup'][] = 'invalidemail';
		$passthrough = False;
	} else {
		$getParam['email'][] = $email;
	}

	if (empty($pass) || empty($pass2)){
		$getParam['signup'][] = 'empty';
		$passthrough = False;
	} elseif (!empty($pass) && !empty($pass2) && $pass != $pass2) {
		//header("Location: ../signup.php?signup=password&first=$first&last=$last&email=$email");
		$getParam['signup'][] = 'password';
		$passthrough = False;
	} 

	$sql = "SELECT * FROM users WHERE uid='$uid' OR email='$email'";
	$result = mysqli_query($conn_users, $sql);
	$rows = mysqli_num_rows($result);
	if (empty($uid)){
		$getParam['signup'][] = 'empty';
		$passthrough = False;
	} elseif ($rows > 0){
		//header("Location: ../signup.php?signup=usertaken&first=$first&last=$last&email=$email");
		$getParam['signup'][] = 'usertaken';
		$passthrough = False;
	}  else {
		$getParam['username'][] = $uid;
	}

	if ($passthrough == True){

		// hash password and insert signup info to database
		$passHash = password_hash($pass, PASSWORD_DEFAULT);

		$sql = "INSERT INTO users(uid, firstname, lastname, email, pwd) VALUES ('$uid', '$first', '$last', '$email', '$passHash')";

		mysqli_query($conn_users, $sql);
		header("Location: ../signup.php?signup=success");
		exit();
	} else {

		foreach ($getParam as $key => $value) {
			$val = join('-', $value);
			if (!empty($val)) {
				$headerloc = addGetParaToURL($headerloc, $key, $val);
			}
		}

		header("Location: ".$headerloc);
	}

} else{
	header("Location: ../signup.php?signup=error");
}

