<?php
include dbconnect.php;

$user_id = $_GET['id'];

$sql = "DELETE FROM Users WHERE user_id=$user_id";

if ($conn->query($sql) === TRUE) {
    echo "User deleted successfully";
} else {
    echo "Error deleting user: " . $conn->error;
}

$conn->close();
?>
