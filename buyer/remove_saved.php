<?php
session_start();

include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['listing_id'])) {
    $listing_id = $_GET['listing_id'];
    $buyer_id = $_SESSION['user_id'];

    $remove_query = "DELETE FROM SavedListings WHERE buyer_id = $buyer_id AND listing_id = $listing_id";
    if ($conn->query($remove_query) === TRUE) {
        header("Location: buyer.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
