<?php
require_once '../class_user.php'; // Include the User class definition

class BuyerController {
    protected $conn;
    protected $userID;

    public function __construct($conn, $userID) {
        $this->conn = $conn;
        $this->userID = $userID;
    }

    public function saveListing($listing_id) {
        $save_query = "INSERT INTO SavedListings (buyer_id, listing_id) VALUES ($this->userID, $listing_id)";
        if ($this->conn->query($save_query) === TRUE) {
            header("Location: buyer.php");
            exit();
        } else {
            echo "Error: Listing cannot be saved." . $this->conn->error;
        }
    }

    public function removeSavedListing($listing_id) {
        $remove_query = "DELETE FROM SavedListings WHERE buyer_id = $this->userID AND listing_id = $listing_id";
        if ($this->conn->query($remove_query) === TRUE) {
            header("Location: buyer.php");
            exit();
        } else {
            echo "Error: Listing cannot be removed" . $this->conn->error;
        }
    }

    public function displayListing() {
        $listingsQuery = "SELECT * FROM PropertyListings WHERE status = 'Active'";
        $listingsResult = $this->conn->query($listingsQuery);

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
    }

    public function displaySavedListing(){
        $savedQuery = "SELECT p.* FROM PropertyListings p
                        JOIN SavedListings s ON p.listing_id = s.listing_id
                        WHERE s.buyer_id = $this->userID";
        $savedResult = $this->conn->query($savedQuery);

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

    public function displayTransaction(){
        $transaction_query = "SELECT * FROM Transactions WHERE user_id = $this->userID ORDER BY transaction_date DESC";
        $transaction_result = $this->conn->query($transaction_query);
        if ($transaction_result->num_rows > 0) {
            while ($row = $transaction_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['transaction_id']}</td>";
                echo "<td>{$row['amount']}</td>";
                echo "<td>{$row['transaction_date']}</td>";
                echo "<td>{$row['description']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No transactions found.</td></tr>";
        }
    }
}
?>
