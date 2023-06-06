<?php
	require 'libraries/database.php';
	require "libraries/db_credentials.php";
	require 'libraries/utility.php';

	session_start();

	if (!checkLogin())
		redirect('login.php');

	

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

	

	$event = "";

	if (isset($_POST['event-id']))
	{
		$event_id = $_POST['event-id']; // sanitizare
		
		$sql = "DELETE FROM eventuser WHERE event_id = {$event_id}";
		$conn->query($sql);
		
		$sql = "DELETE FROM `event` WHERE id = {$event_id}";
		$conn->query($sql);
		
		header("Location: " . dirname($_SERVER['PHP_SELF']) . "/events.php");
		die();
	}
	else
	{
		$event_id = $_GET['event-id'];

		if (!isset($event_id))
		{
			header("Location: " . dirname($_SERVER['PHP_SELF']) . "/events.php");
			die();
		}

		$sql = "SELECT * FROM Event WHERE id = '${event_id}' LIMIT 1";
		$event = $conn->query($sql)->fetch_assoc();
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
	<?php require "templates/sidebar-user.php" ?>

	<main id="main">
		<?php require "templates/toggle-dropdown-user.php"; ?>

		<h1>Sterge Eveniment</h1>

		<p>Esti sigur ca vrei sa stergi evenimentul cu numele <?= $event['nume'] ?> ? (Nu vei putea sa recuperezi progresul) </p>

		<p> 
			<?php if (isset($error)) 
				echo $error ?>
		</p>

		<form method="POST" action="delete-event.php">
			<input type="text" name="event-id" value="<?= $event_id ?>" hidden>
			<button type="submit" class="btn btn-primary">Da</button>
		</form>

		<a href="<?= dirname($_SERVER['PHP_SELF']) . "/events.php"  ?>" style="display:inline-block; margin-top:2rem">Back</a>
		
	</main> 

	<?php require "templates/footer-user.php" ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

	<script type="text/javascript" src="scripts/sidebar.js"></script>
</body>
</html>