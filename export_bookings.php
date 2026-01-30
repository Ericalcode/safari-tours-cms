<?php
session_start();
// Security: Only logged-in admins can download data
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: unauthorized.php");
    exit();
}

require 'db_connect.php';

// 1. Set headers to force download as CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Safari_Bookings_Report_' . date('Y-m-d') . '.csv');

// 2. Open the output stream
$output = fopen('php://output', 'w');

// 3. Set the column headers for the Excel file
fputcsv($output, array('ID', 'Customer Name', 'Email', 'Tour Package', 'Booking Date'));

// 4. Fetch data from MySQL
$query = "SELECT id, customer_name, email, tour_package, created_at FROM bookings ORDER BY id DESC";
$rows = mysqli_query($conn, $query);

// 5. Loop through data and write to CSV
while ($row = mysqli_fetch_assoc($rows)) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
