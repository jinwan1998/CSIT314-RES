<?php
session_start();

include '../dbconnect.php';
include 'ReviewController.php';

$ReviewController = new ReviewController($conn);

if (isset($_GET['agent_id'])) {
    $agent_id = $_GET['agent_id'];
    $ReviewController->displayAgentComments($agent_id);
} else {
    echo "Agent ID not specified.";
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Comments</title>
    <link rel="stylesheet" href="buyer.css"> 
    <a href="agent_ratings.php">Back to Agent Ratings</a>

   
</head>