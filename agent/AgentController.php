<?php
class AgentController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getPropertyListings($agentId) {
        $listings = [];
        // Use a placeholder "?" for the agent_id parameter
        $query = "SELECT * FROM PropertyListings WHERE agent_id = ?";
        $stmt = $this->conn->prepare($query);
        // Now, bind_param will correctly bind the $agentId variable to the placeholder
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
        // Use a placeholder "?" for the agent_id parameter
        $query = "SELECT r.rating, r.comments, u.username AS buyer_name
                  FROM Reviews r
                  INNER JOIN Users u ON r.user_id = u.user_id
                  WHERE r.agent_id = ?";
        $stmt = $this->conn->prepare($query);
        // Now, bind_param will correctly bind the $agentId variable to the placeholder
        $stmt->bind_param("i", $agentId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
        return $reviews;
    }
    // Closing brace for the class
}