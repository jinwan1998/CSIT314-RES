<?php
include 'dbconnect.php';

$user_id = $_GET['id'];
$action = $_GET['action'];


$new_status = ($action === 'suspend') ? 0 : 1;


$sql = "UPDATE Users SET is_active=$new_status WHERE user_id=$user_id";

if ($conn->query($sql) === TRUE) {
    echo "User " . ($action === 'suspend' ? 'suspended' : 'unsuspended') . " successfully";
} else {
    echo "Error " . ($action === 'suspend' ? 'suspending' : 'unsuspending') . " user: " . $conn->error;
}

// Close connection
$conn->close();


header("Location: admin.php?action=users");
exit();
?>
