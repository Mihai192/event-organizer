<?php
	require 'libraries/database.php';
	require "libraries/db_credentials.php";
	require 'libraries/utility.php';

	session_start();

	if (!checkLogin())
		_redirect('login.php');

	$error = '';
	$success = '';

	try {
		$conn = connectToDatabase(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

		$sql = "SELECT * FROM User WHERE session_token = '{$_SESSION['session_token']}' LIMIT 1";
		
		$result = $conn->query($sql);

		if ($result)
		{	
			$result = $result->fetch_assoc();

			$nume    = $result['nume'];
			$prenume = $result['prenume'];
			$email   = $result['email'];

			if (isset($_POST['new-password']) && isset($_POST['old-password']) && isset($_POST['repeat-new-password']))
			{
				if ($_POST['new-password'] != $_POST['repeat-new-password'])
					$error = 'Different passwords';
				else
				{

					if ($result['password'] == hash('sha256', $_POST['old-password']))
					{
						$user_id = $result['id'];

						try
						{
							if (!checkPass($_POST['new-password']))
								throw new Exception("Not valid password");

							

							$new_password = hash('sha256', $_POST['new-password']);
							$sql = "UPDATE User SET password='${new_password}' WHERE id=$user_id";
							
							
							if ($conn->query($sql) === true)
								$success = "Parola schimbata cu success";
							else
								throw new Exception("Parola nu a putut fi schimbata. incearca mai tarziu.");


						} catch(Exception $e) {
							$error = $e -> getMessage();
						}
					}
					else
						$error = 'Not correct password';
				}
			}
		}

	} catch(Exception $e) {
		 $error = $e -> getMessage();
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

		<p> 
			<?php 
				if (isset($error)) 
					echo $error; 
			?>
		</p>

		<h1>Change password</h1>

		<form method="POST" action="change-password.php">
		  <div class="form-group">
		    <label for="">old-password</label>
		    <input type="password" class="form-control" placeholder="Old password" name="old-password">
		  </div>
		  <div class="form-group">
		    <label for="">new-password</label>
		    <input type="password" class="form-control"  placeholder="New password" name="new-password">
		  </div>

		  <div class="form-group">
		    <label for="">repeat-new-password</label>
		    <input type="password" class="form-control"  placeholder="Repeat new password" name="repeat-new-password">
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