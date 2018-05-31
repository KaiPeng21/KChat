
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
	<center><h2>Create your KChat Account</h2></center>

	<?php
		$signupCheck = "";
		$first = "";
		$last = "";
		$email = "";
		$username = "";

		if (isset($_GET['signup'])){
			$signupCheck = $_GET['signup'];

			if (strpos($signupCheck, 'empty') !== false) {
				echo "<p class='error-message'>You did not fill in all fields!</p>";
			}
		}	

		if (isset($_GET['first'])){
			$first = $_GET['first'];
		}

		if (isset($_GET['last'])){
			$last = $_GET['last'];
		}

		if (isset($_GET['email'])){
			$email = $_GET['email'];
		}

		if (isset($_GET['username'])){
			$username = $_GET['username'];
		}

	?>

	<form class="form-group" action="includes/signup.inc.php" method="POST">
		<div class="form-group">
			<label>First Name:</label> 

			<?php
 			if (strpos($signupCheck, 'invalidfirstname') !== false) {
				echo '<input type="text" class="form-control" id="first" name="first" placeholder="Enter your Firstname">';
				echo "<p class='error-message'>You did not fill in a valid name!</p>";
			} else {
				echo '<input type="text" class="form-control" id="first" name="first" value="'.$first.'" placeholder="Enter your Firstname">';
			}
			?>
		</div>
		<div class="form-group">
			<label>Last Name:</label>
			<?php
			if (strpos($signupCheck, 'invalidlastname') !== false){
				echo '<input type="text" class="form-control" id="last" name="last" placeholder="Enter your Lastname">';
				echo "<p class='error-message'>You did not fill in a valid name!</p>";
			} else {
				echo '<input type="text" class="form-control" id="last" name="last" value="'.$last.'" placeholder="Enter your Lastname">';
			}
			?>
		</div>
		<div class="form-group">
			<label>Email:</label>
			<?php
			if (strpos($signupCheck, 'invalidemail') !== false){
				echo '<input type="text" class="form-control" id="name" name="email" placeholder="Enter your Email">';
				echo "<p class='error-message'>You did not fill in a valid email!</p>";
			} else{
				echo '<input type="text" class="form-control" id="name" name="email"  value="'.$email.'" placeholder="Enter your Email">';
			}
			?>
			
		</div>
		<div class="form-group">
			<label>Username:</label>
			<?php
			if (strpos($signupCheck, 'usertaken') !== false){
				echo '<input type="text" class="form-control" id="username" name="username" placeholder="Enter a username">';
				echo "<p class='error-message'>The usernmae and/or email is/are already taken!</p>";
			} else {
				echo '<input type="text" class="form-control" id="username" name="username" value="'.$username.'" placeholder="Enter a username">';
			}
			?>
			
		</div>
		<div class="form-group">
			<label>Password:</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Choose your password">
		</div>
		<div class="form-group">
			<label>Password:</label>
			<input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat your password">
			<?php
			if (strpos($signupCheck, 'password') !== false) {
				echo "<p class='error-message'>The two passwords do not match!</p>";
			}
			?>
		</div>



	<?php
		if ($signupCheck == "success") {
			echo "<p class='success-message'>You have been signed up</p>";
			
		}
	?>

		<button class="form-group btn btn-info" type="submit" name="signup">Signup</button>
	</form>
	
</div>
<script type="text/javascript">
	$(document).ready(function(){
		console.log(document.location.href);

	});

</script>

<?php
	include_once 'footer.php';
?>
</div>

</body>
</html>