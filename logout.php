<?php

	session_start();

	if (isset($_SESSION['session_token']))
		session_destroy();
	

		

	header('Location: login.php');
?>