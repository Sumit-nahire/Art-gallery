<?php
header("Content-Type: application/json");
include('includes/dbconnection.php');
// Get JSON data from request
$data = json_decode(file_get_contents("php://input"), true);

$payment_method = pg_escape_string($con, $data["payment_method"]);
$price = pg_escape_string($con, $data["price"]);
$order_date = pg_escape_string($con, $data["order_date"]);
$quantity = pg_escape_string($con, $data["quantity"]);
$size = pg_escape_string($con, $data["size"]);
$dimension = pg_escape_string($con, $data["dimension"]);
$address = pg_escape_string($con, $data["address"]);
$email = pg_escape_string($con, $data["email"]);

// SQL query to insert data
$sql = "INSERT INTO orders (payment_method, price, order_date, quantity, size, dimension, address, email) 
        VALUES ('$payment_method', '$price', '$order_date', '$quantity', '$size', '$dimension', '$address', '$email')";

$result = pg_query($con, $sql);

if ($result) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . pg_last_error($con)]);
}

pg_close($con);
?>
