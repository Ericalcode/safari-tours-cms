<?php
session_start();
require 'db_connect.php';

// 1. Security Check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: unauthorized.php");
    exit();
}

// 2. Fetch Existing Data based on ID
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = "SELECT * FROM packages WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die("Tour package not found.");
    }
} else {
    header("Location: admin_manage.php");
    exit();
}

// 3. Handle the Update Logic
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = $_POST['price'];
    $cat   = $_POST['category'];
    $desc  = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Check if a new image was uploaded
    if (!empty($_FILES['photo']['name'])) {
        $img = $_FILES['photo']['name'];
        $target = "uploads/" . basename($img);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
        
        $sql = "UPDATE packages SET title='$title', price='$price', category='$cat', description='$desc', image_url='$img' WHERE id=$id";
    } else {
        // Update without changing the existing image
        $sql = "UPDATE packages SET title='$title', price='$price', category='$cat', description='$desc' WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_manage.php?status=success");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Safari Package | Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .edit-container { max-width: 600px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-save { background: #1b5e20; color: white; border: none; padding: 12px 20px; cursor: pointer; margin-top: 20px; font-weight: bold; }
        .btn-cancel { color: #d32f2f; text-decoration: none; margin-left: 15px; }
    </style>
</head>
<body class="container">
    <div class="edit-container">
        <h2>Edit Destination</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Tour Name</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($data['title']); ?>" required>

            <label>Price (KES)</label>
            <input type="number" name="price" value="<?php echo $data['price']; ?>" required>

            <label>Category</label>
            <select name="category">
                <option <?php if($data['category'] == 'Wildlife') echo 'selected'; ?>>Wildlife</option>
                <option <?php if($data['category'] == 'Culture') echo 'selected'; ?>>Culture</option>
                <option <?php if($data['category'] == 'Hotels') echo 'selected'; ?>>Hotels</option>
                <option <?php if($data['category'] == 'Food') echo 'selected'; ?>>Food</option>
            </select>

            <label>Description</label>
            <textarea name="description" rows="4"><?php echo htmlspecialchars($data['description']); ?></textarea>

            <label>Current Image: <?php echo $data['image_url']; ?></label>
            <input type="file" name="photo">
            <small>Leave blank to keep the current photo.</small>

            <div style="margin-top:20px;">
                <button type="submit" name="update" class="btn-save">Update Package</button>
                <a href="admin_manage.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
