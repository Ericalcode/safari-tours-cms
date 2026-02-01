<?php
session_start();

// RESTORED SECURITY: Kick out unauthorized users
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: unauthorized.php");
    exit();
}

require 'db_connect.php'; 

// Delete Logic
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM packages WHERE id = $id");
    header("Location: admin_manage.php");
    exit();
}

// Add Item Logic
if(isset($_POST['add_item'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = $_POST['price'];
    $cat   = $_POST['category'];
    $desc  = mysqli_real_escape_string($conn, $_POST['description']);
    $img   = $_FILES['photo']['name'];
    if($img) { move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/$img"); }

    mysqli_query($conn, "INSERT INTO packages (title, category, price, description, image_url) VALUES ('$title', '$cat', '$price', '$desc', '$img')");
    header("Location: admin_manage.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | Safari Tours</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; background:#f4f4f4; padding:15px; border-radius:8px; margin-bottom:20px;">
        <div>
            <h1>Admin Panel</h1>
            <a href="index.php">← View Site</a>
        </div>
        <div>
            <a href="export_bookings.php" style="background:#2e7d32; color:white; padding:10px 15px; text-decoration:none; border-radius:5px; font-weight:bold;">📥 Download Bookings (Excel)</a>
            <a href="logout.php" style="color:#d32f2f; margin-left:20px; font-weight:bold;">Logout</a>
        </div>
    </div>

    <div class="admin-box">
        <h3>Post New Destination</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" required>
            <input type="number" name="price" placeholder="Price (KES)" required>
            <select name="category">
                <option>Wildlife</option><option>Food</option><option>Transport</option>
                <option>Places</option><option>Hotels</option><option>Culture</option>
            </select>
            <textarea name="description" placeholder="Description"></textarea>
            <input type="file" name="photo">
            <button type="submit" name="add_item">Post Destination</button>
        </form>
    </div>

    <h3>Manage Destinations</h3>
    <table border="1" style="width:100%; border-collapse:collapse; background:white;">
        <tr style="background:#1b5e20; color:white;">
            <th>Title</th><th>Category</th><th>Price</th><th>Actions</th>
        </tr>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC");
        while($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
                <td>".htmlspecialchars($row['title'])."</td>
                <td>{$row['category']}</td>
                <td>KES ".number_format($row['price'])."</td>
                <td>
                    <a href='edit.php?id=<?php echo $row['id']; ?>' style='color:#1b5e20; font-weight:bold;'>Edit</a> 
                    <a href='admin_manage.php?delete={$row['id']}' onclick='return confirm(\"Delete this?\")' style='color:red;'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
