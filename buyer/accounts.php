<?php
session_start();

include '../dbconnect.php';
include 'BuyerController.php';

$buyerController = new BuyerController($conn, $_SESSION['user_id']);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Query to fetch user information
$user_query = "SELECT * FROM Users WHERE user_id = $user_id";
$user_result = $conn->query($user_query);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="buyer.css"> 

</head>
<body>
    <h2>My Account Information</h2>
    <a href="buyer.php">Home</a>

    <?php
    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        echo "<p><strong>Username:</strong> {$user['username']}</p>";
        echo "<p><strong>Email:</strong> {$user['email']}</p>";
        echo "<p><strong>Phone:</strong> {$user['phone']}</p>";
    } else {
        echo "<p>No user information found.</p>";
    }
    ?>

    <h2>Transaction History</h2>
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php $buyerController->displayTransaction(); ?>
        </tbody>
    </table>
</body>
</html>
