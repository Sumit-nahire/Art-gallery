<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/dbconnection.php'); // Ensure this file is correct

// Check database connection
if (!$con) {
    die(json_encode(["error" => "Database connection failed: " . pg_last_error()]));
}

// Debug: Check if the table exists
$query = "SELECT title, dimension, size, artist, arttype, artmedium, sellingpricing, creationdate FROM tblartproduct";
$result = pg_query($con, $query);

if (!$result) {
    die(json_encode(["error" => "Query failed: " . pg_last_error($con)]));
}

// Fetch and check data
$products = [];
while ($row = pg_fetch_assoc($result)) {
    $products[] = $row;
}

// Debugging: If no data found
if (empty($products)) {
    die(json_encode(["error" => "No products found in tblartproduct"]));
}

// Return the fetched data as JSON
header('Content-Type: application/json');
echo json_encode($products);
?>
