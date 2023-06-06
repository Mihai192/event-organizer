<?php
	require 'libraries/constants.php';
	require 'libraries/database.php';
	require 'libraries/utility.php';
	require "libraries/db_credentials.php";
	
	// TODO measures against XSS and SQL injection
	
	if (isset($_GET['token']))
	{
		$servername = DB_SERVER;
		$username   = DB_USER;
		$password   = DB_PASS;
		$database   = DB_NAME;

		$conn = connectToDatabase($servername, $username, $password, $database);

		$token = $_GET['token'];
		$sql = "SELECT * FROM Token where hash = '$token'";

		$result = $conn->query($sql);
		

		if ($result->num_rows)
		{
			$user_id = $result->fetch_assoc()["user_id"]; 
    			
			$status = ACTIVE_ACCOUNT;
			$session_token = hash('sha256', generateString(64));
  			
  			$sql = "UPDATE User SET status='${status}', session_token = '${session_token}' WHERE id=$user_id";

			if ($conn->query($sql) === TRUE) 
			{
			  $sql = "DELETE FROM Token where hash = '$token'";
			  $conn->query($sql);

			  echo "Account activated succesfully... redirecting";
			  header("Refresh: 5;Location: profile.php");
			}
			else
				echo "Something went wrong... Try again later!";
		}
		else
			echo "Incorrect token";	
	}
