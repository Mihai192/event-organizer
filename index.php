<?php

	header("Location: login.php");
	die();
?>

<!DOCTYPE html>
<html lang="ro-RO">
<head>
	<meta charset="utf-8">
	<title> Event Organizer </title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="styles/general.css">
	<link rel="stylesheet" type="text/css" href="styles/header.css">
	<link rel="stylesheet" type="text/css" href="styles/home.css">
</head>
<body>
	<header>
		<div id="header-wrapper">
			<ul id="social-media-links">
				<li>
					<a href="#" class="fa fa-facebook"></a>
				</li>
				<li>
					<a href="#" class="fa fa-instagram"></a>
				</li>
				<li>
					<a href="#" class="fa fa-youtube"></a>
				</li>
			</ul>

			<div id="logo-wrapper">
				<img id="logo-img" src="images/logo.png">
			</div>

			<button>
				<div class="burger">
					<span class="line"></span>
					<span class="line"></span>
					<span class="line"></span>	
				</div>
			</button>
			
			<nav>
				<ul>
					<li> 
						<a href="#">Acasa</a>
					</li>
					<li>
						<a href="#">Blog</a>
					</li>
					<li>
						<a href="#">Compani</a>
					</li>
					<li>
						<a href="#">Preturi</a>
					</li>
					<li>
						<a href="login.php">Login</a>
					</li>
				</ul>
			</nav>
		</div>
	</header>

	<main>
		<section id="hero-section">
			<div id="hero-section-text">
				<h2>Organizarea evenimentului tău începe aici</h2>
				<p>EpicPlan este o platformă online special concepută să te ajute în planificarea pas cu pas a evenimentului tău.</p>
				<div id="buttons-group">
					<button>Creeaza Cont Gratuit</button>
					<button>Vezi DEMO</button>	
				</div>
			</div>
			<div id="hero-section-img">
				<img src="images/laptop-phone.png">
			</div>
		</section>

		<section id="advantages-section">
			<div>
				<img src="">
				<h3></h3>
				<p></p>
			</div>
			<div>
				<img src="">
				<h3></h3>
				<p></p>
			</div>
			<div>
				<img src="">
				<h3></h3>
				<p></p>
			</div>
		</section>

	</main>

	<footer>
		
	</footer>
</body>
</html>