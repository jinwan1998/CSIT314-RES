<?php
session_start();
include '../dbconnect.php';
require_once 'AgentController.php';


if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Real Estate Agent') {
    header("Location: login.php");
    exit();
}

$agentController = new AgentController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $propertyType = $_POST['property_type'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $agentId = $_SESSION['user_id']; 
    $status = 'Active'; 

    if ($agentController->addPropertyListing($agentId, $title, $description, $propertyType, $price, $location, $status)) {
        header("Location: agent.php");
        exit();
    } else {
        echo "Error: Unable to add new listing.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Listing - Real Estate System</title>
    <link rel="stylesheet" type="text/css" href="agent.css">
</head>
<body>
    <header>
        <h1>Create New Property Listing</h1>
        <nav>
            <a href="agent.php">Back to Dashboard</a>
        </nav>
    </header>

    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea><br><br>

            <label for="property_type">Property Type:</label>
            <input type="text" id="property_type" name="property_type" required><br><br>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required><br><br>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required><br><br>

            <input type="submit" value="Create Listing">
        </form>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Real Estate System
    </footer>
</body>
</html>
