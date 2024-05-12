<?php
session_start(); 
include dbconnect.php;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM Users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        
        switch ($user['role']) {
            case 'System Administrator':
                header("Location: admin/admin.php");
                break;
            case 'Real Estate Agent':
                header("Location: agent/agent.php");
                break;
            case 'Buyer':
                header("Location: buyer/buyer.php");
                break;
            case 'Seller':
                header("Location: seller/seller.php");
                break;
            default:
                header("Location: login.php?error=1");
                break;
        }
        exit;
    } else {
        header("Location: login.php?error=1");
        exit;
    }
}

$conn->close();
?>
