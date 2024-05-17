<?php
session_start();
include '../dbconnect.php';
include_once 'AgentController.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$agentController = new AgentController($conn);

if (isset($_GET['listing_id'])) {
    $listingId = $_GET['listing_id'];
    if ($agentController->deletePropertyListing($listingId)) {
        header("Location: agent.php");
        exit();
    } else {
        echo "Error deleting listing.";
    }
} else {
    echo "Listing ID not provided.";
    exit();
}

$conn->close();
?>