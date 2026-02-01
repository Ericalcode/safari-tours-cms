<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: unauthorized.php");
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM packages WHERE id = $id");
    header("Location: admin_manage.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel | Safari Tours</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-nav { background: #0a210d; padding: 15px; display: flex; justify-content: space-between; align-items: center; color: white; }
        .btn-add { background: #ffb300; color: black; padding: 10px 20px; text-decoration: none; font-weight: bold; border-radius: 5px; }
        table { width: 90%; margin: 30px auto; border-collapse: collapse; background: white; }
        th, td { padding: 15px; border: 1px solid #ddd; text-align: left; }
        th { background: #1b5e20; color: white; }
    </style>
</head>
<body>
    <div class="admin-nav">
        <img src="assets/logo.png" style="height: 60px;">
        <h2>Safari CMS Dashboard</h2>
        <a href="logout.php" style="color: white;">Logout</a>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <a href="add_package.php" class="btn-add">+ Add New Safari Package</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Package Name</th>
                <th>Price (KES)</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = mysqli_query($conn, "SELECT * FROM packages");
            while($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                    <td>{$row['title']}</td>
                    <td>" . number_format($row['price']) . "</td>
                    <td>{$row['category']}</td>
                    <td>
                        <a href='edit.php?id={$row['id']}' style='color: green;'>Edit</a> | 
                        <a href='admin_manage.php?delete={$row['id']}' style='color: red;' onclick='return confirm(\"Delete?\")'>Delete</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
