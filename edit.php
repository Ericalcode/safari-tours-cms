<?php
session_start();
require 'db_connect.php';

// 1. Security Check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: unauthorized.php");
    exit();
}

// 2. Fetch Existing Data
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM packages WHERE id = $id");
    $data = mysqli_fetch_assoc($result);
}

// 3. Handle Update Logic
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = $_POST['price'];
    $cat   = $_POST['category'];
    $desc  = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Check if a new image was uploaded
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
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Destination | Safari Tours</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <div class="admin-box" style="margin-top: 50px;">
        <h2>Edit Destination: <?php echo htmlspecialchars($data['title']); ?></h2>
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
            </select>

            <label>Description</label>
            <textarea name="description" rows="5"><?php echo htmlspecialchars($data['description']); ?></textarea>

            <label>Change Photo (Leave blank to keep current)</label>
            <input type="file" name="photo">
            
            <div style="margin-top:20px;">
                <button type="submit" name="update" style="background:#1b5e20;">Save Changes</button>
                <a href="admin_manage.php" style="margin-left:15px; color:#555;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
