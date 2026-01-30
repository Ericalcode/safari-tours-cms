<?php
// 1. Setup error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Load PHPMailer and Database Connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form data
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tour  = mysqli_real_escape_string($conn, $_POST['tour']);

    // 3. Save Booking to MySQL
    $sql = "INSERT INTO bookings (customer_name, email, tour_package) VALUES ('$name', '$email', '$tour')";
    
    if (mysqli_query($conn, $sql)) {
        
        // 4. Trigger Automated Welcome Email
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ericalmaina00@gmail.com'; // Your Email
            $mail->Password   = 'cmvzzlrhdqbhpjih';        // Your App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Localhost SSL Fix
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Email Identity
            $mail->setFrom('ericalmaina00@gmail.com', 'Safari Tours');
            $mail->addAddress($email, $name); 

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = 'Karibu! Your Safari Booking is Confirmed';
            $mail->Body    = "
                <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #eee;'>
                    <h2 style='color: #2e7d32;'>Jambo $name,</h2>
                    <p>Thank you for booking your adventure with <strong>Safari Tours</strong>!</p>
                    <p>We have successfully reserved your spot for the <strong>$tour</strong> package.</p>
                    <p>Our team will reach out to you within 24 hours to finalize your travel itinerary and payment details.</p>
                    <br>
                    <p>Best Regards,<br><strong>The Safari Tours Team</strong></p>
                </div>
            ";

            $mail->send();
            
            // 5. REDIRECT TO SUCCESS PAGE
            header("Location: success.php");
            exit();

        } catch (Exception $e) {
            // Fallback if email fails but DB worked
            echo "<h1>Booking Saved</h1>";
            echo "<p>Your booking is in our system, but we couldn't send the confirmation email.</p>";
            echo "<p>Error: {$mail->ErrorInfo}</p>";
            echo "<a href='index.php'>Return Home</a>";
        }
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
?>
