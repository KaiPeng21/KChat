<?php

if (isset($_POST['logout'])) {
	// end the session
	session_start();
	session_unset();
	session_destroy();
	header("Location: ../index.php");
	exit();
}