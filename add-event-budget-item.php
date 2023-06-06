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


$name = $requestData['name'];
$budgetListId = $requestData['budget_list_id'];
$eventId = $requestData['event_id'];


$query = "INSERT INTO budgetlistitem (nume, nr_unitati, pret_unitate, cost_total, avans, rest_de_plata, budget_list_id, event_id) VALUES ('$name', 0, 0, 0, 0, 0, {$budgetListId}, {$eventId})";
$stmt = $conn->query($query);

    
    

?>