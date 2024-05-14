<?php
require_once '../class_user.php'; // Include the User class definition

class BuyerController {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function saveListing($buyer_id, $listing_id) {
        $save_query = "INSERT INTO SavedListings (buyer_id, listing_id) VALUES ($buyer_id, $listing_id)";
        if ($this->conn->query($save_query) === TRUE) {
            header("Location: buyer.php");
            exit();
        } else {
            echo "Error: " . $this->conn->error;
        }
    }

    public function removeSavedListing($buyer_id, $listing_id) {
        $remove_query = "DELETE FROM SavedListings WHERE buyer_id = $buyer_id AND listing_id = $listing_id";
        if ($this->conn->query($remove_query) === TRUE) {
            header("Location: buyer.php");
            exit();
        } else {
            echo "Error: " . $this->conn->error;
        }
    }
}
?>
