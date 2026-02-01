<?php
session_start();
require 'db_connect.php';

// 1. SECURITY: Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// 2. DELETE LOGIC
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM packages WHERE id = $id");
    header("Location: admin_manage.php?msg=deleted");
    exit();
}

// 3. ADD NEW PACKAGE LOGIC
if (isset($_POST['add_item'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = $_POST['price'];
    $cat = $_POST['category'];
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    
    $img = $_FILES['photo']['name'];
    if ($img) {
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/$img");
    }

    mysqli_query($conn, "INSERT INTO packages (title, category, price, description, image_url) VALUES ('$title', '$cat', '$price', '$desc', '$img')");
    header("Location: admin_manage.php?msg=added");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | Safari Tours</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; background: #1b5e20; color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .action-btn { padding: 8px 15px; border-radius: 4px; text-decoration: none; font-weight: bold; color: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        tr:hover { background-color: #f5f5f5; }
    </style>
</head>
<body class="container">

    <div class="dashboard-header">
        <div>
            <h2>Safari Admin CMS</h2>
            <p>Welcome, <?php echo $_SESSION['admin_user']; ?></p>
        </div>
        <div>
            <a href="export_bookings.php" style="background: #ff8f00;" class="action-btn">📥 Download Bookings</a>
            <a href="logout.php" style="background: #d32f2f; margin-left: 10px;" class="action-btn">Logout</a>
        </div>
    </div>

    <div class="admin-box">
        <h3>Add New Destination</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Tour Name (e.g. Maasai Mara)" required>
            <input type="number" name="price" placeholder="Price (KES)" required>
            <select name="category">
                <option>Wildlife</option><option>Culture</option><option>Hotels</option><option>Beaches</option>
            </select>
            <textarea name="description" placeholder="Short description..."></textarea>
            <input type="file" name="photo">
            <button type="submit" name="add_item">Post Package</button>
        </form>
    </div>

    <h3>Manage Existing Tours</h3>
    <table>
        <thead>
            <tr>
                <th>Title</th><th>Category</th><th>Price</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                    <td>" . htmlspecialchars($row['title']) . "</td>
                    <td>{$row['category']}</td>
                    <td>KES " . number_format($row['price']) . "</td>
                    <td>
                        <a href='edit.php?id={$row['id']}' style='color: #1b5e20;'>Edit</a> | 
                        <a href='admin_manage.php?delete={$row['id']}' onclick='return confirm(\"Delete this package?\")' style='color: #d32f2f;'>Delete</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
