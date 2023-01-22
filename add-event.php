<?php
	require 'libraries/database.php';
	require "libraries/db_credentials.php";
	require 'libraries/utility.php';

	session_start();


	if (!isset($_SESSION['session_token']))
	{
		header('Location: login.php');
		die();
	}
	
	$servername = DB_SERVER;
	$username   = DB_USER;
	$password   = DB_PASS;
	$database   = DB_NAME;

	$error = '';
	$success = '';

	try {
		$conn = connectToDatabase($servername, $username, $password, $database);
		
		$sql = "SELECT * FROM User WHERE session_token = '{$_SESSION['session_token']}' LIMIT 1";
		$result = $conn->query($sql);

		if ($result->num_rows) 
		{
			$result = $result->fetch_assoc();
			$nume   = $result['nume'];
			$prenume   = $result['prenume'];
			


			if (isset($_POST['nume']) && isset($_POST['data']) && isset($_POST['tipEveniment']) && isset($_POST['adresa']))
			{
				

				if ($_POST['nume'] === '' || $_POST['nume'] > 128)
					throw new Exception('Nume prea lung sau vid. Numele evenimentului trebuie sa fie mai mic ca 128');

				if ($_POST['data'] === '' || !checkDate_($_POST['data']))
					throw new Exception('Data incorecta');

				if ($_POST['tipEveniment'] !== 'nunta' &&  $_POST['tipEveniment'] !== 'botez' 
							&& $_POST['tipEveniment'] !== 'zi-de-nastere'  && $_POST['tipEveniment'] !== 'corporate')
					throw new Exception('Tip eveniment incorect');

				if ($_POST['adresa'] === '' || $_POST['adresa'] > 128)
					throw new Exception('Adresa incorecta');

				$user_id = $result['id'];
				$eventType = [
					"nunta" => 1,
					"botez" => 2,
					"zi-de-nastere" => 3,
					"corporate" => 4
				];

				$nume_eveniment = $_POST['nume'];
				$data_eveniment = $_POST['data'];
				$tip_eveniment = $eventType[$_POST['tipEveniment']];
				$adresa_eveniment = $_POST['adresa'];

				$sql = "INSERT INTO Event (nume, data, tipEveniment, adresa) VALUES ('${nume_eveniment}', '${data_eveniment}', '${tip_eveniment}', '${adresa_eveniment}')";

				$conn->query($sql);

				$sql = "INSERT INTO EventUser (user_id, event_id, role_type) VALUES ('${user_id}', LAST_INSERT_ID(), 1)";
			
				$conn->query($sql);

				$success = 'Eveniment creat cu success!';
			}
			
		}
			
	} 
	catch(Exception $e)
	{
		$error = $e->getMessage();
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
	<?php require "templates/sidebar-user.php" ?>

	<main id="main">
		<?php require "templates/toggle-dropdown-user.php"; ?>

		<h1> Creeaza Eveniment </h1>

		<?php 
			if ($error !== '')
			{
				echo "<div class=\"alert alert-danger\" role=\"alert\">";
				echo  $error;
				echo " </div>";
			}
			else if ($success !== '')
			{
				echo "<div class=\"alert alert-success\" role=\"alert\">";
				echo  $success;
				echo " </div>";
			}
		?>

		<form method="POST" action="add-event.php" class="add-event-form">
		  <div class="form-group">
		    <label for="">Nume</label>
		    <input type="text" class="form-control" placeholder="Nume" name="nume">
		  </div>

		  <div class="form-group">
		    <label for="">Data</label>
		    <input type="date" class="form-control" placeholder="Data" name="data" required style="max-width: 400px;">
		  </div>

		  <div class="form-group">
		    <label for="">Tip eveniment</label>
		    <select name="tipEveniment" style="display:block;">
			  <option value="nunta">Nunta</option>
			  <option value="botez">Botez</option>
			  <option value="zi-de-nastere">Zi de nastere</option>
			  <option value="corporate">Corporate</option>
			</select>
		  </div>

		  <div class="form-group">
		    <label for="">Oras</label>
		    <input type="text" class="form-control"  placeholder="Adresa" name="adresa">
		  </div>
		  <button type="submit" class="btn btn-primary">Submit</button>
		</form>

		
	</main> 

	<?php require "templates/footer-user.php" ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

	<script type="text/javascript" src="scripts/sidebar.js"></script>


	<script type="text/javascript">
	    function getTodayDate(y = 0, m = 0, d = 0)
	    {
	    	const dtToday = new Date();

		    let month = dtToday.getMonth() + 1 + m;
		    let day   = dtToday.getDate() + d;
		    let year  = dtToday.getFullYear() + y;

		    if(month < 10)
		        month = '0' + month.toString();
		    if(day < 10)
		        day = '0' + day.toString();

		    let date = year + '-' + month + '-' + day; 
		    return date; 
	    }


	    let minDate = getTodayDate();
	    let maxDate = getTodayDate(100);
	    
	    let inputDate = document.querySelector('input[type=date]');
	    inputDate.setAttribute('min', minDate);
	    inputDate.setAttribute('max', maxDate);

	    let addEventForm = document.querySelector('.add-event-form');
	    addEventForm.addEventListener('submit', (e) => {
	    	e.preventDefault();
	    	let nume     = document.forms[0].elements[0].value;
			let adresa   = document.forms[0].elements[3].value;
			if (nume !== '' && adresa !== '')
				addEventForm.submit();
	    });	
	</script>
</body>
</html>