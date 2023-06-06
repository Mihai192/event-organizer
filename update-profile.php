<?php
	require 'libraries/database.php';
	require 'libraries/utility.php';
	require "libraries/db_credentials.php";
	session_start();

	if (!isset($_SESSION['session_token']))
	{
		header('Location: login.php');
		die();
	}

	$error = '';
	$success = '';

	$servername = DB_SERVER;
	$username   = DB_USER;
	$password   = DB_PASS;
	$database   = DB_NAME;

	$conn = connectToDatabase($servername, $username, $password, $database);

	$sql = "SELECT * FROM User WHERE session_token = '{$_SESSION['session_token']}' LIMIT 1";
	$result = $conn->query($sql);

	if ($result) 
	{
		$result = $result->fetch_assoc();
		$nume      = $result['nume'];
		$prenume   = $result['prenume'];
		$adresa    = $result['adresa'];

		if (isset($_POST['adresa']) || isset($_POST['nume']) || isset($_POST['prenume']))
		{
			if ($_POST['adresa'] === '' && $_POST['nume'] === '' && $_POST['prenume'] === '' )
				$success = "no changes made";
			else
			{
				if (isset($_POST['nume']) && $_POST['nume'] !== '')
					$nume = $_POST['nume'];
			
				if (isset($_POST['prenume']) && $_POST['prenume'] !== '')
					$prenume = $_POST['prenume'];

				if (isset($_POST['adresa']) && $_POST['adresa'] !== '')
					$adresa  = $_POST['adresa'];

				$sql = "UPDATE User SET";

				$prev = false;

				if (strlen($nume) >= 1 && strlen($nume) <= 30)
				{
					$sql .= " nume='${nume}'";
					$prev = true;
				}


				if (strlen($prenume) >= 1 && strlen($prenume) <= 30)
				{
					if ($prev)
						$sql .= ",";

					$sql .= " prenume='${prenume}' ";

					$prev = true;
				}

				

				if (strlen($adresa) >= 1 && strlen($adresa) <= 64)
				{
					if ($prev)
						$sql .= ",";

					$sql .= " adresa='${adresa}'";
				}

				$sql .= " WHERE id='${result['id']}'";

				
				
				if ($conn->query($sql) === TRUE) 
					_redirect('profile.php');
				else
					$error = "Ceva nu a mers bine. Mai incearca mai tarziu.";
			}
			
		}
		
	}
?>

<!DOCTYPE html>
<html lang="ro-RO">
<head>
	<meta charset="utf-8">
	<title>Event organizer - Update profile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="styles/profile.css">
	<link rel="stylesheet" type="text/css" href="styles/sidebar-animation.css">
</head>
<body>
	<?php require "templates/sidebar-user.php"; ?>

	<main id="main">
		<?php require "templates/toggle-dropdown-user.php"; ?>

		<h1> Update Profile </h1>
		<?php 
			if ($error !== '')
			{
				echo "<div class=\"alert alert-danger\" role=\"alert\">";
				echo  $error;
				echo " </div>";
			}
		?>
			
		<form method="POST" action="update-profile.php">
		  <div class="form-group">
		    <label for="">Nume</label>
		    <input type="text" class="form-control" placeholder="Nume" name="nume">
		  </div>
		  <div class="form-group">
		    <label for="">Prenume</label>
		    <input type="text" class="form-control"  placeholder="Prenume" name="prenume">
		  </div>

		  <div class="form-group">
		    <label for="">Adresa</label>
		    <input type="text" class="form-control"  placeholder="Adresa" name="adresa">
		  </div>

		  <button type="submit" class="btn btn-primary">Submit</button>
		</form>

	</main> 

	<?php require "templates/footer-user.php"; ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

	<script type="text/javascript" src="scripts/sidebar.js"></script>
</body>
</html>
