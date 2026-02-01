<?php
session_start();
require 'db_connect.php';

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    // Search for the admin by username
    $result = mysqli_query($conn, "SELECT * FROM admins WHERE username='$user'");
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the hashed password
        if (password_verify($pass, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $user;
            header("Location: admin_manage.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Admin username not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login | Safari Tours</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <div class="admin-box" style="max-width:400px; margin: 100px auto; padding: 30px; border-top: 5px solid #1b5e20;">
        <h2 style="text-align:center;">Admin Login</h2>
        <?php if(isset($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
        <div style="text-align: center; margin-bottom: 20px;">
    <img src="assets/logo.png" alt="Safari Tours" style="width: 100px; height: auto;">
    <h2 style="color: #1b5e20;">Admin Portal</h2>
</div>
        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" placeholder="e.g. eric_admin" required>
            
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
            
            <button type="submit" name="login" style="width:100%; margin-top:10px;">Login to Dashboard</button>
        </form>
        <p style="text-align:center; margin-top:15px;"><a href="index.php" style="text-decoration:none; color:#666;">← Back to Site</a></p>
    </div>
</body>
</html>
