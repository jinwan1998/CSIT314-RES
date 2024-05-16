<?php
require_once '../dbconnect.php'; 

class SellerController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getSellerListings($sellerId) {
        $listingsQuery = "SELECT pl.*, 
                          COUNT(DISTINCT pi.interaction_id) AS views, 
                          COUNT(DISTINCT sl.listing_id) AS shortlisted
                          FROM PropertyListings pl
                          LEFT JOIN PropertyInteractions pi ON pl.listing_id = pi.listing_id AND pi.interaction_type = 'View'
                          LEFT JOIN SavedListings sl ON pl.listing_id = sl.listing_id
                          WHERE pl.agent_id = ?
                          GROUP BY pl.listing_id";

        $stmt = $this->conn->prepare($listingsQuery);
        $stmt->bind_param("i", $sellerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $listings = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $listings;
    }
}