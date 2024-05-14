<?php
session_start(); 

if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
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
            header("Location: index.php");
            break;
    }
}

$error_message = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] == 1) {
        $error_message = 'Invalid username or password. Please try again.';
    }
    elseif ($_GET['error'] == 2) {
        $error_message = 'Please login first.';
    } 
    elseif ($_GET['error'] == 'suspended') {
        $error_message = 'Your account is suspended. Please contact the administrator.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Real Estate System</title>
    <link rel="stylesheet" type="text/css" href="Login.css">
</head>
<body>
    <header>
        <h1>Login to Real Estate System</h1>
    </header>

    <main>
        <?php if (!empty($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>

        <form action="LoginController.php" method="post">
            <div class="login-form">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br><br>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>
                
                <input type="submit" value="Login">
            </div>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Real Estate System
    </footer>
</body>
</html>
