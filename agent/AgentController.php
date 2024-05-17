<?php
class AgentController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getPropertyListings($agentId) {
        $listings = [];
        $query = "SELECT * FROM PropertyListings WHERE agent_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $agentId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $listings[] = $row;
            }
        }
        return $listings;
    }
    
    public function getAgentReviews($agentId) {
        $reviews = [];
        $query = "SELECT r.rating, r.comments, u.username AS buyer_name
                  FROM Reviews r
                  INNER JOIN Users u ON r.user_id = u.user_id
                  WHERE r.agent_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $agentId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
        return $reviews;
    }

    public function addPropertyListing($agentId, $title, $description, $propertyType, $price, $location, $status) {
        $sql = "INSERT INTO PropertyListings (agent_id, title, description, property_type, price, location, status)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing statement: " . $this->conn->error;
            return false;
        }
        $stmt->bind_param("isssiss", $agentId, $title, $description, $propertyType, $price, $location, $status);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $stmt->error;
            return false;
        }
    }

    public function deletePropertyListing($listingId) {
        $sql = "DELETE FROM PropertyListings WHERE listing_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing statement: " . $this->conn->error;
            return false;
        }
        $stmt->bind_param("i", $listingId);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error deleting listing: " . $stmt->error;
            return false;
        }
    }

    public function updatePropertyListing($listingId, $title, $description, $property_type, $price, $location) {
        $sql = "UPDATE PropertyListings SET
                title = ?,
                description = ?,
                property_type = ?,
                price = ?,
                location = ?,
                updated_at = NOW()
            WHERE listing_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssdss", $title, $description, $property_type, $price, $location, $listingId);
        return $stmt->execute();
    }
    
    public function getPropertyListingById($listingId) {
        $query = "SELECT * FROM PropertyListings WHERE listing_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $listingId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return $row;
            }
        }
        return null;
    }

}