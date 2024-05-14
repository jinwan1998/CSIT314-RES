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

$buyerController = new BuyerController($conn);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['listing_id'])) {
    $listing_id = $_GET['listing_id'];
    $buyer_id = $_SESSION['user_id'];

    // Call the saveListing function from the BuyerController instance
    if ($buyerController->saveListing($buyer_id, $listing_id)) {
        // Redirect to buyer.php after successfully saving the listing
        header("Location: buyer.php");
        exit();
    } else {
        // Handle error if the listing cannot be saved
        echo "Error: Listing could not be saved.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['remove_listing_id'])) {
    $listing_id = $_GET['remove_listing_id'];
    $buyer_id = $_SESSION['user_id'];

    // Call the removeSavedListing function from the BuyerController instance
    if ($buyerController->removeSavedListing($buyer_id, $listing_id)) {
        // Redirect to buyer.php after successfully removing the listing
        header("Location: buyer.php");
        exit();
    } else {
        // Handle error if the listing cannot be removed
        echo "Error: Listing could not be removed.";
    }
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
                <li><a href="../admin/logout.php">Logout</a></li>
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
                    <?php
                    // Retrieve and display new property listings
                    $listingsQuery = "SELECT * FROM PropertyListings WHERE status = 'Active'";
                    $listingsResult = $conn->query($listingsQuery);

                    if ($listingsResult->num_rows > 0) {
                        while ($row = $listingsResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['title']}</td>";
                            echo "<td>{$row['description']}</td>";
                            echo "<td>{$row['property_type']}</td>";
                            echo "<td>$" . number_format($row['price'], 2) . "</td>";
                            echo "<td>{$row['location']}</td>";
                            echo "<td><a href='buyer.php?listing_id={$row['listing_id']}'>Save</a></td>"; // Add save functionality
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No new listings found.</td></tr>";
                    }
                    ?>
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
                    <?php
                    // Retrieve and display saved listings for the current user
                    if (isset($_SESSION['user_id'])) {
                        $buyerId = $_SESSION['user_id'];
                        $savedQuery = "SELECT p.* FROM PropertyListings p
                                       JOIN SavedListings s ON p.listing_id = s.listing_id
                                       WHERE s.buyer_id = $buyerId";
                        $savedResult = $conn->query($savedQuery);

                        if ($savedResult->num_rows > 0) {
                            while ($row = $savedResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['title']}</td>";
                                echo "<td>{$row['description']}</td>";
                                echo "<td>{$row['property_type']}</td>";
                                echo "<td>$" . number_format($row['price'], 2) . "</td>";
                                echo "<td>{$row['location']}</td>";
                                echo "<td><a href='buyer.php?remove_listing_id={$row['listing_id']}'>Remove</a></td>"; // Add remove functionality
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No saved listings found.</td></tr>";
                        }
                    }
                    ?>
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