<?php
    class ReviewController {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function writeReview($user_id, $agent_id, $rating, $comments) {
            include '../dbconnect.php';

            $insert_review = "INSERT INTO Reviews (user_id, agent_id, rating, comments) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_review);
            $stmt->bind_param("iiis", $user_id, $agent_id, $rating, $comments);

            if ($stmt->execute()) {
                header("Location: agent_ratings.php");
                exit();
            } else {
                echo "Error: " . $this->conn->error;
            }
        }

        public function displayAgentRatings() {
            $sql = "SELECT u.user_id, u.username, u.email, AVG(r.rating) AS avg_rating
            FROM Users u
            LEFT JOIN Reviews r ON u.user_id = r.agent_id
            WHERE u.role = 'Real Estate Agent'
            GROUP BY u.user_id, u.username, u.email";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>" . number_format($row['avg_rating'], 1) . "</td>";
                    echo "<td><a href='agent_comments.php?agent_id={$row['user_id']}'>View Comments</a></td>";
                    echo "<td><a href='write_review.php?agent_id={$row['user_id']}'>Write Review</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No agents found.</td></tr>";
            }
        }

        public function displayAgentComments($agent_id) {
            $sql = "SELECT u.username, r.rating, r.comments
            FROM Reviews r
            INNER JOIN Users u ON r.user_id = u.user_id
            WHERE r.agent_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $agent_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<h2>Agent Comments</h2>";
                echo "<table>";
                echo "<thead><tr><th>User</th><th>Rating</th><th>Comment</th></tr></thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['rating']}</td>";
                    echo "<td>{$row['comments']}</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No comments found for this agent.";
            }
        }

    }

?>