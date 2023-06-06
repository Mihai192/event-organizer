<?php
	require 'libraries/database.php';
	require "libraries/db_credentials.php";
	require 'libraries/utility.php';

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

	$result = $result->fetch_assoc();
	$nume   = $result['nume'];
	$prenume = $result['prenume'];
	$email  = $result['email'];
	$user_id = $result['id'];

	$eventType = [
		"nunta" => 1,
		"botez" => 2,
		"zi-de-nastere" => 3,
		"corporate" => 4
	];
	
	$reverseType = [
		1 => "nunta",
		2 => "botez",
		3 => "zi-de-nastere",
		4 => "corporate"
	];


	$event = "";

	if (isset($_GET['event-id']))
	{
		$event_id = $_GET['event-id']; // sanitizare
		$sql = "SELECT * FROM event WHERE id = {$event_id} LIMIT 1";

		$event = $conn -> query($sql) -> fetch_assoc();
		
		
	}
	else
	{
		header("Location: " . dirname($_SERVER['PHP_SELF']) . "/events.php");
		die();
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
	<link rel="stylesheet" type="text/css" href="styles/events.css">
	<link rel="stylesheet" type="text/css" href="styles/sidebar-animation.css">
</head>
<body>
	<?php require "templates/sidebar-event.php" ?>

	<main id="main">
		<?php require "templates/toggle-dropdown-user.php"; ?>

		<h1> Eveniment: <?php ?> </h1>
		<p> Nume: <?= $event['nume'] ?> </p>
		<p> Data: <?= $event['data'] ?> </p>
		<p> Tip Eveniment: <?= $reverseType[ $event['tipEveniment'] ] ?></p>
		<p> adresa: <?= $event['adresa'] ?> </p>
	</main> 

	<?php require "templates/footer-user.php" ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

	<script type="text/javascript" src="scripts/sidebar.js"></script>
</body>
</html>
