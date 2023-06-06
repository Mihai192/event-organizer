<?php


require 'libraries/database.php';
require 'libraries/utility.php';
require "libraries/db_credentials.php";

$servername = DB_SERVER;
$username   = DB_USER;
$password   = DB_PASS;
$database   = DB_NAME;


$conn = connectToDatabase($servername, $username, $password, $database );



$requestData = json_decode(file_get_contents('php://input'), true);



$budgetListId = $requestData['budget_list_id'];
$eventId = $requestData['event_id'];


$query = "DELETE FROM budgetlistid WHERE budget_list_id = {$budgetListId} AND event_id = {$eventId}";
$stmt = $conn->query($query);

    
    

?>