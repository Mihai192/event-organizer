<?php	
	require 'libraries/utility.php';
	require 'libraries/constants.php';
	require 'libraries/database.php';
	require "libraries/db_credentials.php";
	
	session_start();
	
	if (checkLogin())
		redirect('profile.php');
	
	
	$error = '';
	$success = '';


	
	if (isset($_POST['nume']) && isset($_POST['prenume']) && isset($_POST['email']) 
		&& isset($_POST['password']) && isset($_POST['repeat-password']))
	{
		$nume    = $_POST['nume'];
		$prenume = $_POST['prenume'];
		$email   = $_POST['email'];
		$pass    = $_POST['password'];

		$repeatedPassword = $_POST['repeat-password'];

		$servername = DB_SERVER;
		$username   = DB_USER;
		$password   = DB_PASS;
		$database   = DB_NAME;

		try {
			$test = checkEmail($email) && checkPass($pass);

			if ($repeatedPassword !== $pass)
				throw new Exception("Parolele sunt incorecte.");

			if (!$test)
				throw new Exception("Email sau parola invalida");


			// connect to database
			$conn = connectToDatabase($servername, $username, $password, $database);
			// create account
			$token = createAccount($conn, $nume, $prenume, $email, $pass);

			// send verification mail
			sendVerificationAccountMail($token);

		} catch(Exception $e) {
		 	$error = $e -> getMessage();
		}	
	}
?>

<!DOCTYPE html>
<html lang="ro-RO">
<head>
	<meta charset="utf-8">
	<title>Event Organizer - signup</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="styles/login-signup.css">
</head>
<body>
	<div class="wrapper">
		<div class="box">
			<h1> Sign up </h1>

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
			

			<form action="signup.php" method="POST" id="signup-form">
			  <div class="form-group">
			    <label for="emailAddress">Nume</label>
			    <input type="text" class="form-control" placeholder="Name" name="nume">
			    
			  </div>

			  <div class="form-group">
			    <label for="emailAddress">Prenume</label>
			    <input type="text" class="form-control" placeholder="Name" name="prenume">
			  </div>

			  <div class="form-group">
			    <label for="emailAddress">Email address</label>
			    <input type="email" class="form-control" placeholder="Enter email" name="email">
			    
			  </div>

			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" placeholder="Password" name="password">
			  </div>

			  <div class="form-group">
			    <label for="password">Repeat Password</label>
			    <input type="password" class="form-control" placeholder="Repeat Password" name="repeat-password">
			  </div>

			  <input type="submit" class="btn btn-primary">
			</form>

			<p> Ai cont ? log in aici <a href="login.php"> login </a> </p>
		</div>
		
	</div>

	<script type="text/javascript">
		function containsUppercaseLetter(text)
		{
			let bool = false;
			text.split("").forEach((letter) => {
				if (letter >= 'A' && letter <= 'Z')
					bool = true;
			});

			return bool;
		}

		function containsLowercaseLetter(text)
		{
			let bool = false;
		  	text.split("").forEach((letter) => {
				if (letter >= 'a' && letter <= 'z')
					bool = true;
			});

			return bool;
		}

		function checkName(text)
		{
			return text.length >= 1 && text.length <= 30;
		}

		function checkEmail(text)
		{
		  	let pattern = /^.*@.*\..*$/;
		 	return pattern.test(text);
		}

		function containsDigits(text)
		{
			let bool = false;

		  	text.split("").forEach((letter) => {
				if (letter >= '0' && letter <= '9')
					bool = true;
			});

			return bool;
		}

		function checkPass(text)
		{
		  return containsUppercaseLetter(text) && containsLowercaseLetter(text)
		           && containsDigits(text) && text.length > 7;
		}

		const form = document.getElementById("signup-form");
	    form.addEventListener('submit', (e) => {
			e.preventDefault();
			let formData = document.querySelectorAll('input');

			let name  			 = formData[0].value;
			let prenume          = formData[1].value;
			let email 			 = formData[2].value;
			let pass 			 = formData[3].value;
			let repeatedPass 	 = formData[4].value; 

			let nameBool  = checkName(name);
			let prenumeBool = checkName(prenume);
			let emailBool = checkEmail(email);
			let passBool  = checkPass(pass);
			
			

			if (nameBool && prenumeBool && emailBool && passBool && repeatedPass === pass)
				form.submit();
			else
			{
				const errorDiv = document.querySelector('div[role = alert]');
				let text = '';

				if (!nameBool)
					text += 'Numele trebuie sa fie intre 1 si 30 de caractere.\n';
				
				if (!prenumeBool)
					text += 'Prenumele trebuie sa fie intre 1 si 30 de caractere.\n';

				if (!emailBool)
					text += "Email-ul dat este unul invalid.\n";

				if (!passBool)
				{
					if (repeatedPass === pass)
						text += "Parola trebuie sa contina cel putin 7 caractere, litere mari, mici si cifre.\n"
					else
						text += "Parolele sunt diferite.\n";
				}

				if (errorDiv !== null)
					errorDiv.innerHTML = text;
				else
				{
					let headingNode = document.querySelector('h1');
					let div = document.createElement('div');

					div.setAttribute('class', 'alert alert-danger');
					div.setAttribute('role', 'alert');
					div.innerText = text;
					headingNode.after(div);

					setTimeout(() => {
						div.remove();
					}, 25000);
				}
			}
		});
	</script>
</body>
</html>