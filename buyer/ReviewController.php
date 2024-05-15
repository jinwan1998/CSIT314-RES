<?php
    class ReviewController {
        private $review;
        private $rating;
        private $buyerId;
        private $sellerId;
        private $propertyId;
        private $reviewDate;
        private $reviewId;

        public function __construct($review = "", $rating = 0, $buyerId = 0, $sellerId = 0, $propertyId = 0, $reviewDate = "", $reviewId = 0) {
            $this->review = $review;
            $this->rating = $rating;
            $this->buyerId = $buyerId;
            $this->sellerId = $sellerId;
            $this->propertyId = $propertyId;
            $this->reviewDate = $reviewDate;
            $this->reviewId = $reviewId;
        }

        public function writeReview($user_id, $agent_id, $rating, $comments) {
            include '../dbconnect.php';

            $insert_review = "INSERT INTO Reviews (user_id, agent_id, rating, comments) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_review);
            $stmt->bind_param("iiis", $this->buyerId, $this->sellerId, $this->rating, $this->review);

            if ($stmt->execute()) {
                header("Location: agent_ratings.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        }

    }

?>