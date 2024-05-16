<?php
session_start();

include '../dbconnect.php';
include 'ReviewController.php';

$ReviewController = new ReviewController($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Ratings & Reviews</title>
    <link rel="stylesheet" href="buyer.css"> 

    
</head>
<body>
    <h2>Agent Ratings & Reviews</h2>
    <a href="buyer.php">Home</a>

    <table>
        <thead>
            <tr>
                <th>Agent Name</th>
                <th>Email</th>
                <th>Average Rating</th>
                <th>View Comments</th>
                <th>Write Review</th>
            </tr>
        </thead>
        <tbody>
            <?php $ReviewController->displayAgentRatings(); ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
