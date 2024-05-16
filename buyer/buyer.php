<?php
session_start();
require_once '../dbconnect.php';
require_once '../class_user.php';
require_once 'BuyerController.php';

// Ensure redirect to login page if user is not logged in or correct page for respective role
if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'System Administrator':
            header("Location: ../admin/admin.php");
            break;
        case 'Real Estate Agent':
            header("Location: ../agent/agent.php");
            break;
        case 'Seller':
            header("Location: ../seller/seller.php");
            break;
    }
}
else {
    header("Location: ../index.php?error=2");
}

$buyerController = new BuyerController($conn, $_SESSION['user_id']);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['listing_id'])) {
    $listing_id = $_GET['listing_id'];
    $buyer_id = $_SESSION['user_id'];
    $buyerController->saveListing($listing_id);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['remove_listing_id'])) {
    $listing_id = $_GET['remove_listing_id'];
    $buyer_id = $_SESSION['user_id'];
    $buyerController->removeSavedListing($listing_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard - Real Estate System</title>
    <link rel="stylesheet" href="buyer.css">
</head>

<body>
    <header>
        <h1>Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Buyer'; ?>!
        </h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="mortgage_calculator.php">Mortgage Calculator</a></li>
                <li><a href="agent_ratings.php">Agent Ratings & Reviews</a></li>
                <li><a href="accounts.php">Account</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Property Listings Section -->
        <section>
            <h2>New Property Listings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Property Type</th>
                        <th>Price</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $buyerController->displayListing(); ?>
                </tbody>
            </table>
        </section>

        <!-- Saved Listings Section -->
        <section>
            <h2>Saved Listings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Property Type</th>
                        <th>Price</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $buyerController->displaySavedListing(); ?>
                </tbody>
            </table>
        </section>



    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Real Estate System
    </footer>
</body>

</html>

<?php
// Close database connection
$conn->close();
?>