<?php
session_start();

include '../dbconnect.php';
include 'ReviewController.php';

$review = new ReviewController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agent_id'], $_POST['rating'], $_POST['comments'])) {
        $user_id = $_SESSION['user_id'];
        $agent_id = $_POST['agent_id'];
        $rating = $_POST['rating'];
        $comments = $_POST['comments'];

        $review->writeReview($user_id, $agent_id, $rating, $comments);

    } else {
        echo "Incomplete form data";
    }
}

if (isset($_GET['agent_id'])) {
    $agent_id = $_GET['agent_id'];

    $agent_query = "SELECT username FROM Users WHERE user_id = ?";
    $stmt = $conn->prepare($agent_query);
    $stmt->bind_param("i", $agent_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $agent = $result->fetch_assoc();
        $agent_username = $agent['username'];
    } else {
        $agent_username = "Unknown";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Review</title>
    <link rel="stylesheet" href="buyer.css"> 

   
</head>
<body>
    <h2>Write Review for Agent: <?php echo isset($agent_username) ? htmlspecialchars($agent_username) : 'Unknown'; ?></h2>
    <a href="agent_ratings.php">Back to Agent Ratings</a>

    <form method="post">
        <input type="hidden" name="agent_id" value="<?php echo isset($agent_id) ? $agent_id : ''; ?>">

        <label for="rating">Rating (1-5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>

        <label for="comments">Comments:</label>
        <textarea id="comments" name="comments" rows="4" required></textarea>

        <button type="submit">Submit Review</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
