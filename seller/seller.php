<?php
session_start();
require_once '../dbconnect.php'; 
require_once 'SellerController.php';
require_once 'SellerView.php';

$sellerController = new SellerController($conn);
$sellerId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$listings = [];

if ($sellerId !== null) {
    $listings = $sellerController->getSellerListings($sellerId);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - Real Estate System</title>
    <link rel="stylesheet" type="text/css" href="seller.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Seller'; ?>!</h1>
        <nav>
            <ul>
                <li><a href="seller.php">My Property Listings</a></li>
                <li><a href="../buyer/agent_ratings.php">Rate Agents</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>My Property Listings</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Shortlisted</th>
                </tr>
            </thead>
            <tbody>
                <?php SellerView::renderListings($listings); ?>
            </tbody>
        </table>
        <footer>
        &copy; <?php echo date("Y"); ?> Real Estate System
    </footer>
    </main>
</body>
</html>