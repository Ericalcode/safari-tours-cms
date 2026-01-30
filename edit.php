<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
// ... rest of your existing code starts here ...
<?php 
require 'db_connect.php'; 

$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM packages WHERE id=$id");
$item = mysqli_fetch_assoc($res);

if(isset($_POST['update_item'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = $_POST['price'];
    $cat   = $_POST['category'];
    $desc  = mysqli_real_escape_string($conn, $_POST['description']);
    
    $update_sql = "UPDATE packages SET title='$title', price='$price', category='$cat', description='$desc' WHERE id=$id";
    if(mysqli_query($conn, $update_sql)) {
        header("Location: admin_manage.php?msg=Updated");
    }
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body class="container">
    <h2>Edit Destination: <?php echo $item['title']; ?></h2>
    <form method="POST" class="admin-box">
        <input type="text" name="title" value="<?php echo $item['title']; ?>" required>
        <input type="number" name="price" value="<?php echo $item['price']; ?>" required>
        <select name="category">
            <option <?php if($item['category']=='Wildlife') echo 'selected'; ?>>Wildlife</option>
            <option <?php if($item['category']=='Food') echo 'selected'; ?>>Food</option>
            <option <?php if($item['category']=='Transport') echo 'selected'; ?>>Transport</option>
            <option <?php if($item['category']=='Places') echo 'selected'; ?>>Places</option>
        </select>
        <textarea name="description"><?php echo $item['description']; ?></textarea>
        <button type="submit" name="update_item">Save Changes</button>
        <a href="admin_manage.php">Cancel</a>
    </form>
</body>
</html>
