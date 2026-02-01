<?php
require 'db_connect.php';
$id = (int)$_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM packages WHERE id = $id");
$package = mysqli_fetch_assoc($res);

if (isset($_POST['submit_booking'])) {
    $cust_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $cust_phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $tour_id = $id;

    $sql = "INSERT INTO bookings (package_id, customer_name, customer_phone) VALUES ('$tour_id', '$cust_name', '$cust_phone')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Booking Successful! We will call you soon.'); window.location='index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book <?php echo $package['title']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background: #f4f7f6; padding: 50px;">
    <div style="max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <img src="assets/logo.png" style="width: 150px; display: block; margin: 0 auto 20px;">
        <h2 style="color: #1b5e20;">Book Your Safari</h2>
        <p>You are booking: <strong><?php echo $package['title']; ?></strong></p>
        <p>Price: <strong>KES <?php echo number_format($package['price']); ?></strong></p>
        
        <form method="POST">
            <label>Full Name</label><br>
            <input type="text" name="full_name" style="width:100%; padding:10px; margin:10px 0;" required><br>
            <label>Phone Number</label><br>
            <input type="text" name="phone" style="width:100%; padding:10px; margin:10px 0;" required><br>
            <button type="submit" name="submit_booking" style="width:100%; padding:15px; background:#1b5e20; color:white; border:none; border-radius:5px; font-weight:bold; cursor:pointer;">Confirm Booking</button>
        </form>
        <br>
        <a href="index.php" style="color: #666; text-decoration: none;">← Back to Gallery</a>
    </div>
</body>
</html>

