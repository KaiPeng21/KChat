<?php

session_start();

if (isset($_POST['login'])) {
	include 'dbh.inc.php';
	include 'tool.inc.php';

	$uid = mysqli_real_escape_string($conn_users, $_POST['uid']);
	$password = mysqli_real_escape_string($conn_users, $_POST['password']);

	if (empty($uid) || empty($password)) {
		header("Location: ../index.php?login=empty");
		exit();
	} else {
		$sql = "SELECT * FROM users WHERE uid='$uid'";
		$result = mysqli_query($conn_users, $sql);
		$rows = mysqli_num_rows($result);
		if ($rows < 1) {
			header("Location: ../index.php?login=error");
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)){

				$hashPassCheck = password_verify($password, $row['pwd']);
				if ($hashPassCheck === true) {
					$_SESSION['u_uid'] = $row['uid'];
					$_SESSION['u_firstname'] = $row['firstname'];
					$_SESSION['u_lastname'] = $row['lastname'];
					$_SESSION['u_email'] = $row['email'];

					header("Location: ../index.php?login=success");
					exit();

				} else {
					header("Location: ../index.php?login=error");
					exit();
				}
			}
		}
	}


} else {
	header("Location: ../index.php?login=error");
}