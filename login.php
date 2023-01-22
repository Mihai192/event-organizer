<?php
	require "libraries/database.php";
	require "libraries/db_credentials.php";
	require 'libraries/constants.php';
	require "libraries/utility.php";

	session_start();


	if (isset($_SESSION['session_token']))
	{
		header("Location: profile.php");
		die();
	}

	$error = '';

	
	if (!empty($_POST))
	{
		$email = $_POST['email'];
		$pass  = $_POST['password'];

		$servername = DB_SERVER;
		$username   = DB_USER;
		$password   = DB_PASS;
		$database   = DB_NAME;

		$conn = connectToDatabase($servername, $username, $password, $database);


		

		$pass = hash("sha256", $pass);

		$sql = "SELECT * FROM User WHERE email = '${email}' AND password = '${pass}' LIMIT 1";
		$result = $conn->query($sql);

		
		if ($result->num_rows)
		{
			$result = $result->fetch_assoc();
			
			if ((int)$result['status'] === ACTIVE_ACCOUNT)
			{
				
				$_SESSION['session_token'] = $result['session_token'];
				header('Location: profile.php');
			}
			else
				$error = "Account not activated";
		}	
		else
			$error = "Incorrect credentials";
		

	}
	
?>
<!DOCTYPE html>
<html lang="ro-RO">
<head>
	<meta charset="utf-8">
	<title>Event Organizer - login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="styles/login-signup.css">
</head>
<body>

	<div class="wrapper">
		<div class="box">

			<h1> Login </h1>
			<?php 
				if ($error !== '')
				{
					echo "<div class=\"alert alert-danger\" role=\"alert\">";
					echo  $error;
					echo " </div>";
				}
			?>
			

			<form action="login.php" method="POST">
			  <div class="form-group">
			    <label for="emailAddress">Email address</label>
			    <input type="email" class="form-control" placeholder="Enter email" name="email">
			    
			  </div>

			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" placeholder="Password" name="password">
			  </div>

			  <input type="submit" class="btn btn-primary">
			</form>

			<p> Nu ai cont ? creeaza unul aici <a href="signup.php"> signup </a> </p>
		</div>
	</div>


</body>
</html>