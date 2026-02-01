<?php require 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Safari Tours | Experience Kenya</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <img src="assets/logo.png" alt="Safari Tours" style="height: 100px; width: auto; margin-right: 25px;">
    <div>
        <h1 style="color: var(--accent); margin: 0; font-size: 2.2rem;">Safari Tours Kenya</h1>
        <p style="color: white; margin: 0; letter-spacing: 1px;">CONNECTING KENYA'S WILD</p>
    </div>
</header>

<section class="hero">
    <h1>Discover the Heart of Kenya’s Wild</h1>
    <p>Experience breathtaking wildlife safaris, rich cultural encounters, and exclusive luxury tours.</p>
    <a href="#tours" style="background: var(--accent); color: black; padding: 12px 25px; text-decoration: none; font-weight: bold; border-radius: 5px;">View Our Packages</a>
</section>

<div class="about-box">
    <h2>About Our Heritage</h2>
    <p>Based in the heart of Kenya, Safari Tours is dedicated to providing authentic African adventures. From the golden plains of the Maasai Mara to the white sands of Diani, we curate experiences that support local communities and protect our magnificent wildlife. Our expert guides ensure every journey is safe, educational, and unforgettable.</p>
</div>

<h2 class="section-title" id="tours">Top Destinations</h2>
<div style="display: flex; flex-wrap: wrap; justify-content: center; padding: 20px;">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM packages");
    while($row = mysqli_fetch_assoc($result)) {
        echo "<div style='background: white; margin: 15px; width: 300px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);'>";
        echo "<img src='uploads/".$row['image_url']."' style='width: 100%; height: 200px; object-fit: cover;'>";
        echo "<div style='padding: 15px;'>";
        echo "<h3>".$row['title']."</h3>";
        echo "<p style='color: #1b5e20; font-weight: bold;'>KES ".number_format($row['price'])."</p>";
        echo "<p style='font-size: 14px; color: #666;'>".$row['description']."</p>";
        echo "<a href='book.php?id=".$row['id']."' style='display: block; text-align: center; background: #0a210d; color: white; padding: 10px; text-decoration: none; border-radius: 4px;'>Book Now</a>";
        echo "</div></div>";
    }
    ?>
</div>

</body>
</html>
