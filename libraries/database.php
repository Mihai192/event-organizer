<?php

function connectToDatabase(string $servername, string $username, string $password, string $database) : mysqli
{
	$conn = new mysqli($servername, $username, $password, $database);
	if ($conn->connect_error) 
		throw new Exception("Couldn't connect to database");
	return $conn;
}