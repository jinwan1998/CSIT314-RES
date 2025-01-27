<?php
session_start(); 
include '../dbconnect.php';
include_once 'AgentController.php';

$agentController = new AgentController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_listing'])) {
    $listingId = $_POST['listing_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $property_type = $_POST['property_type'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    
    if ($agentController->updatePropertyListing($listingId, $title, $description, $property_type, $price, $location)) {
        header("Location: agent.php");
        exit();
    } else {
        echo "Error updating listing: " . $conn->error;
    }
}

if (isset($_GET['listing_id'])) {
    $listing = $agentController->getPropertyListingById($_GET['listing_id']);
    if (!$listing) {
        echo "Listing not found.";
        exit();
    }
} else {
    echo "Listing ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property Listing</title>
    <link rel="stylesheet" type="text/css" href="agent.css">
</head>
<body>
    <header>
        <h1>Edit Property Listing</h1>
    </header>

    <main>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="listing_id" value="<?php echo $listing['listing_id']; ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $listing['title']; ?>" required><br><br>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo $listing['description']; ?></textarea><br><br>
            
            <label for="property_type">Property Type:</label>
            <input type="text" id="property_type" name="property_type" value="<?php echo $listing['property_type']; ?>" required><br><br>
            
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $listing['price']; ?>" required><br><br>
            
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo $listing['location']; ?>" required><br><br>
            
            <input type="submit" name="update_listing" value="Update Listing">
        </form>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Real Estate System
    </footer>
</body>
</html>

<?php

$conn->close();
?>
