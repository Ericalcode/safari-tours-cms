<?php
session_start();
require 'db_connect.php';

// 1. SECURITY: Only admins allowed
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: unauthorized.php");
    exit();
}

// 2. FETCH DATA: Get the current package details
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM packages WHERE id = $id");
    $data = mysqli_fetch_assoc($result);
    if (!$data) { die("Package not found."); }
} else {
    header("Location: admin_manage.php");
    exit();
}

// 3. UPDATE LOGIC: Process the form submission
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = $_POST['price'];
    $cat   = $_POST['category'];
    $desc  = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Image handling
    if (!empty($_FILES['photo']['name'])) {
        $img = $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/$img");
        $sql = "UPDATE packages SET title='$title', price='$price', category='$cat', description='$desc', image_url='$img' WHERE id=$id";
    } else {
        $sql = "UPDATE packages SET title='$title', price='$price', category='$cat', description='$desc' WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_manage.php?msg=updated");
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Package | Safari Tours</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .edit-form { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 15px; font-weight: bold; color: #333; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        .save-btn { background: #1b5e20; color: white; border: none; padding: 12px 20px; cursor: pointer; margin-top: 20px; width: 100%; font-size: 16px; border-radius: 4px; }
        .cancel-link { display: block; text-align: center; margin-top: 15px; color: #d32f2f; text-decoration: none; }
    </style>
</head>
<body class="container">
    <div class="edit-form">
        <h2>Edit Destination</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Package Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($data['title']); ?>" required>

            <label>Price (KES)</label>
            <input type="number" name="price" value="<?php echo $data['price']; ?>" required>

            <label>Category</label>
            <select name="category">
                <option <?php if($data['category'] == 'Wildlife') echo 'selected'; ?>>Wildlife</option>
                <option <?php if($data['category'] == 'Culture') echo 'selected'; ?>>Culture</option>
                <option <?php if($data['category'] == 'Hotels') echo 'selected'; ?>>Hotels</option>
                <option <?php if($data['category'] == 'Beaches') echo 'selected'; ?>>Beaches</option>
            </select>

            <label>Description</label>
            <textarea name="description" rows="5"><?php echo htmlspecialchars($data['description']); ?></textarea>

            <label>Update Photo (Optional)</label>
            <input type="file" name="photo">
            <p style="font-size: 12px; color: #666;">Current: <?php echo $data['image_url']; ?></p>

            <button type="submit" name="update" class="save-btn">Save Changes</button>
            <a href="admin_manage.php" class="cancel-link">Cancel / Back</a>
        </form>
    </div>
</body>
</html>
