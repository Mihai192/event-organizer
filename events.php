<?php
	require 'libraries/database.php';
	require "libraries/db_credentials.php";
	require 'libraries/utility.php';

	session_start();

	if (!checkLogin())
		_redirect('login.php');

	$eventType = [
		1 => "nunta",
		2 => "botez",
		3 => "zi-de-nastere",
		4 => "corporate"
	];

	$servername = DB_SERVER;
	$username   = DB_USER;
	$password   = DB_PASS;
	$database   = DB_NAME;

	$conn = connectToDatabase($servername, $username, $password, $database);

	$sql = "SELECT * FROM User WHERE session_token = '{$_SESSION['session_token']}' LIMIT 1";
	$result = $conn->query($sql);

	if ($result->num_rows) 
	{
		$result = $result->fetch_assoc();
		$nume   = $result['nume'];
		$prenume = $result['prenume'];
		$email  = $result['email'];
		$user_id = $result['id'];

		$sql = "SELECT * FROM EventUser WHERE user_id = '${user_id}'";

		
		$result_ = $conn->query($sql);
		while($event = $result_->fetch_assoc()) {
			$event_id = $event['event_id'];

			$sql = "SELECT * FROM Event WHERE id = '${event_id}' LIMIT 1";


	        $events[] = $conn->query($sql)->fetch_assoc();
	    }
		
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

		<div>
			<h2>Evenimentele tale</h2>
			<a class="btn btn-link" href="add-event.php">Adauga Evenimente</a>

			<?php  if (isset($events) && count($events)) {	?>
					<div class="events">
					<?php
						foreach ($events as $event) 
						{
							$event_id = $event['id'];
							$event_name = $event['nume'];
							$event_type = $eventType[$event['tipEveniment']];
							$event_date = $event['data'];
							$event_adresa = $event['adresa'];
					?>	
						
						<div class="event">
							<span><?= $event_name ?> </span>
							<p><?= substr($event_date, 0, 10); ?> </p>
							<p><?= $event_type ?></p>
							<a href=<?php echo dirname($_SERVER['PHP_SELF']) . "/delete-event.php?event-id=" . $event_id ?> >sterge</a>
							<a href=<?= dirname($_SERVER['PHP_SELF']) . "/event-sumar.php?event-id=" . $event_id ?> >modifica</a>
						</div>
						
				<?php } ?>
					</div>
				<?php
					} else
					  echo "<p> Nu ai evenimente. Începe să planifici evenimentul tău folosind butonul de mai sus. </p>";
				?>


	
			<h2>Evenimente la care contribui</h2>
			<p> Nu ai evenimente la care contribui. </p>
		</div>

		
	</main> 

	<?php require "templates/footer-user.php" ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

	<script type="text/javascript" src="scripts/sidebar.js"></script>
</body>
</html>