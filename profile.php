<?php
	require 'libraries/database.php';
	require 'libraries/utility.php';
	require "libraries/db_credentials.php";

	session_start();

	if (!checkLogin())
		_redirect('login.php');

	
	$servername = DB_SERVER;
	$username   = DB_USER;
	$password   = DB_PASS;
	$database   = DB_NAME;

	$conn = connectToDatabase($servername, $username, $password, $database);

	$sql = "SELECT * FROM User WHERE session_token = '{$_SESSION['session_token']}' LIMIT 1";
	$result = $conn->query($sql);

	if ($result->num_rows) 
	{
		$result  = $result->fetch_assoc();
		$nume    = htmlspecialchars($result['nume']);
		$prenume = htmlspecialchars($result['prenume']);
		$email   = htmlspecialchars($result['email']);
		$adresa  = $result['adresa'] ? htmlspecialchars($result['adresa']) : 'Adresa nu este setata';
	}
		
	
?>

<!DOCTYPE html>
<html lang="ro-RO">
<head>
	<meta charset="utf-8">
	<title>Event organizer - profil</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="styles/profile.css">
	<link rel="stylesheet" type="text/css" href="styles/sidebar-animation.css">
</head>
<body>
	<?php require "templates/sidebar-user.php"; ?>

	<main id="main">
		<?php require "templates/toggle-dropdown-user.php"; ?>


		<div>
			<p>Nume: <?php echo $nume ?></p>
			<p>Prenume: <?php echo $prenume ?></p>
			<p>Adresa: <?php echo $adresa ?></p>
			<p>Email: <?php echo $email ?></p>
			<a href="change-password.php"> Change Password </a> <br>
			<a href="update-profile.php"> Update profile </a> <br>
			<a href="logout.php"> logout </a> <br>
			<a href="delete.php"> delete account </a>
		</div>
	</main> 

	<?php require "templates/footer-user.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

	<script type="text/javascript" src="scripts/sidebar.js"></script>
</body>
</html>
