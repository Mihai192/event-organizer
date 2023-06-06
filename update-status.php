<?php

require 'libraries/database.php';
require 'libraries/utility.php';
require "libraries/db_credentials.php";

$data = json_decode(file_get_contents('php://input'), true);

// Extract the eventActivityId and newStatus from the request data



$eventActivityId = $data['eventActivityId'];
$newStatus = $data['newStatus'] ;


// Prepare and execute the UPDATE query

session_start();

	if (!checkLogin())
		_redirect('login.php');

$servername = DB_SERVER;
$username   = DB_USER;
$password   = DB_PASS;
$database   = DB_NAME;

$conn = connectToDatabase($servername, $username, $password, $database);


print_r($data);

$sql = "UPDATE eventactivity SET status = {$newStatus} WHERE id = {$eventActivityId}";
$result = $conn->query($sql);




// Check if the query was successful
if ($result) {
    // Return a success response
    $response = ['success' => true, 'message' => 'Status updated successfully'];
} else {
    // Return an error response
    $response = ['success' => false, 'message' => 'Failed to update status'];
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);


?>