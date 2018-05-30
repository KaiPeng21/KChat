
<?php
	session_start();
?>

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


<header class="header-wrapper">

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">KChat</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li>
    </ul>

    <div class="login-wrapper">


    	<?php

    		if (!isset($_SESSION['u_uid'])) {
    			echo '<form class="form-inline" action="includes/login.inc.php" method="POST">
	    					<input type="text" class="form-control" name="uid" placeholder="Username or Email">
	    					<input type="password" class="form-control" name="password" placeholder="Password">
    						<button type="submit" class="btn btn-primary" name="login">Login</button>
    						<a href="signup.php" class="btn btn-default form-control">Signup</a>
    					</form>';
    		} else {
    			echo '<form class="form-inline" action="includes/logout.inc.php" method="POST">
    						<button type="submit" class="btn btn-primary" name="logout">Logout</button>
    					</form>';
    		}

    	?>

	</div>

  </div>
</nav>



</header>


</body>
</html>

