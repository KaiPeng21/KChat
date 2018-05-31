
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
	<h2>KChat Public Room</h2>
    <br>
    
	<?php
		if (!isset($_SESSION['u_uid']) || empty($_SESSION['u_uid'])) {
            // if the user is not logged in, re-direct to the index page
            header('Location: index.php');
            die();

		} else {

            ?>

            <div id="chat">
                <div id="msg-content">
                    
                </div>
            </div>

            <!-- Invoke chatting javascript code only when the user is logged in -->
            <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
            <script type="text/javascript" src="JS/chat.js"></script>
            <?php


		}
	?>

</div>

<?php
	include_once 'footer.php';
?>

</div>

</body>
</html>