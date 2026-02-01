// --- EMAIL NOTIFICATION PUSH ---
    $to = "your-email@example.com"; // Your professional email
    $subject = "New Safari Booking: " . $package['title'];
    $message = "You have a new booking request!\n\n" .
               "Customer: " . $cust_name . "\n" .
               "Phone: " . $cust_phone . "\n" .
               "Package: " . $package['title'];
    $headers = "From: webmaster@safari-tours.com";

    // This sends the email using your server's mail system
    mail($to, $subject, $message, $headers);
    // -------------------------------
