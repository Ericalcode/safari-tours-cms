<?php require 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<header style="background: #1b5e20; padding: 15px; display: flex; align-items: center; border-bottom: 4px solid #ffb300;">
    <img src="assets/logo.png" alt="Safari Tours Logo" style="height: 70px; width: auto; margin-right: 20px; border-radius: 50%;">
    <h1 style="color: white; font-family: 'Trebuchet MS', sans-serif; margin: 0;">Safari Tours Kenya</h1>
</header>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safari Tours | Book Your Adventure</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">Safari Tours</div>
    <ul class="nav-links">
        <li><a href="#destinations">Destinations</a></li>
        <li><a href="#booking">Book Now</a></li>
        <li><a href="admin_manage.php">Admin Panel</a></li>
    </ul>
</nav>

<header>
    <h1>Explore the Wild</h1>
    <p>Authentic Kenyan Safaris Tailored for You</p>
</header>

<div class="container">
    <section id="destinations">
        <h2>Places to Visit & Packages</h2>
        <div class="grid">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($result)) {
                $img = (!empty($row['image_url']) && file_exists("uploads/".$row['image_url'])) ? "uploads/".$row['image_url'] : "https://via.placeholder.com/400x250?text=Safari+Kenya";
                echo "<div class='card'>";
                echo "<img src='$img' style='width:100%; height:200px; object-fit:cover; border-radius:8px;'>";
                echo "<h3>".htmlspecialchars($row['title'])."</h3>";
                echo "<p>Category: <strong>".$row['category']."</strong></p>";
                echo "<p>".$row['description']."</p>";
                echo "<p class='price-tag'>KES ".number_format($row['price'])."</p>";
                echo "</div>";
            }
            ?>
        </div>
    </section>

    <section id="booking" class="admin-box">
        <h2>Book Your Safari</h2>
        <p>Choose your destination below. You will receive an instant confirmation email.</p>
        <form action="submit_booking.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Your Email Address" required>
            <select name="tour" required>
                <option value="">-- Select Destination --</option>
                <?php
                $res = mysqli_query($conn, "SELECT title FROM packages ORDER BY title ASC");
                while($t = mysqli_fetch_assoc($res)) echo "<option value='".htmlspecialchars($t['title'])."'>".$t['title']."</option>";
                ?>
            </select>
            <button type="submit">Confirm Booking</button>
        </form>
    </section>
</div>

<footer>
    <p>&copy; 2026 Safari Tours Kenya. All Rights Reserved.</p>
</footer>

</body>
</html>
