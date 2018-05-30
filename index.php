
<!DOCTYPE html>
<html>
<head>
	<title>KChat</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" type="text/css" href="style.css">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="wrapper">
<?php
	include_once 'header.php';
?>

<div class="home-wrapper">
	<h2>KChat - Home</h2>

	<?php
		if (isset($_SESSION['u_uid'])) {
			echo "<p>You are logged in as ".$_SESSION['u_uid']."</p>";
		} else {
			echo "<p>You are logged out. Login or <a href='signup.php'>signup</a> an account</p>";
		}
	?>

</div>

<?php
	include_once 'footer.php';
?>

</div>

</body>
</html>