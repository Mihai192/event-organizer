<?php
	require 'libraries/database.php';
	require "libraries/db_credentials.php";
	session_start();

	if (!isset($_SESSION['session_token']))
	{
		header('Location: login.php');
		die();
	}

	$error = '';

	$servername = DB_SERVER;
	$username   = DB_USER;
	$password   = DB_PASS;
	$database   = DB_NAME;

	$conn = connectToDatabase($servername, $username, $password, $database);

	// $sql = "SELECT * FROM User WHERE session_token = '{$_SESSION['session_token']}' LIMIT 1";
	$sql = "SELECT * FROM User WHERE session_token = '{$_SESSION['session_token']}' LIMIT 1";
	$result = $conn->query($sql);


	if ($result)
	{	
		$result = $result->fetch_assoc();
		$nume   = $result['nume'];
		$prenume = $result['prenume'];
		$email  = $result['email'];

		if (!empty($_POST))
		{
			if ($_POST['password'] != $_POST['repeat-password'])
				$error = 'Different passwords';
			else
			{

				if ($result['password'] == hash('sha256', $_POST['password']))
				{
					$sql = "DELETE FROM User where session_token = '{$_SESSION['session_token']}'";
					$conn->query($sql);


					session_destroy();
					header('Location: signup.php');
				}
				else
					$error = 'Not correct password';
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Event organizer - delete account</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="styles/profile.css">
	<link rel="stylesheet" type="text/css" href="styles/sidebar-animation.css">
</head>
<body>
	<?php require "templates/sidebar-user.php" ?>

	<main id="main">
		<?php require "templates/toggle-dropdown-user.php"; ?>

		

		<h1>Delete Account</h1>

		<p>Are you sure you want to delete your account ? (all your date associate with it will be deleted, and you won't be able to recover it) </p>

		<p> 
			<?php if (isset($error)) 
				echo $error ?>
		</p>
		
		<form method="POST" action="delete.php">
		  <div class="form-group">
		    <label for="">password</label>
		    <input type="password" class="form-control" placeholder="password" name="password">
		  </div>
		  
		  <div class="form-group">
		    <label for="">repeat-password</label>
		    <input type="password" class="form-control"  placeholder="Repeat password" name="repeat-password">
		  </div>

		  <button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</main> 

	<?php require "templates/footer-user.php" ?>

	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

	<script type="text/javascript" src="scripts/sidebar.js"></script>
</body>
</html>