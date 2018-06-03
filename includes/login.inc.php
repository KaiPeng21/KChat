<?php

session_start();

if (isset($_POST['login'])) {
	include 'dbh.inc.php';
	include 'tool.inc.php';

	// connect to database
	$conn = db_connect();
	if ($conn === false){
		header("Location: ../index.php?login=dberror");
		exit();
	}

	// get user id and password from the input form
	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	// check if any field is empty
	if (empty($uid) || empty($password)) {
		header("Location: ../index.php?login=empty");
		mysqli_close($conn);
		exit();
	} else {

		// query user info from datbase
		// 	create a template and a prepared statement
		$sql = "SELECT * FROM users WHERE uid=?";
		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)){
			// bind the prepared statement parameter with the user id
			mysqli_stmt_bind_param($stmt, 's', $uid);
			// execute the statement
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$rows = mysqli_num_rows($result);
		
			if ($rows < 1) {
				// error: the userid is not in the database
				header("Location: ../index.php?login=error");
				mysqli_close($conn);
				exit();
			} else {
				if ($row = mysqli_fetch_assoc($result)){

					// verify the password
					$hashPassCheck = password_verify($password, $row['pwd']);
					if ($hashPassCheck === true) {

						// add user info to session
						$_SESSION['u_uid'] = $row['uid'];
						$_SESSION['u_firstname'] = $row['firstname'];
						$_SESSION['u_lastname'] = $row['lastname'];
						$_SESSION['u_email'] = $row['email'];

						header("Location: ../index.php?login=success");
						mysqli_close($conn);
						exit();

					} else {
						// incorrect password
						header("Location: ../index.php?login=error");
						mysqli_close($conn);
						exit();
					}
				}
			}
		}
	}


} else {
	header("Location: ../index.php?login=error");
}