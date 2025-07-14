<?php
session_start();
include('../includes/dbconnection.php');

// Check if user is logged in
if (!isset($_SESSION['userid']) || empty($_SESSION['userid'])) {
    die("<h3 style='color:red;'>User not logged in. Redirecting...</h3>");
}

// Get logged-in user ID
$userid = $_SESSION['userid'];

// Fetch user's email from tblusers
$query_user = "SELECT email FROM tblusers WHERE id = $1";
$result_user = pg_query_params($con, $query_user, array($userid));

if (!$result_user || pg_num_rows($result_user) == 0) {
    die("<h3 style='color:red;'>Error fetching user details.</h3>");
}

$user_data = pg_fetch_assoc($result_user);
$user_email = $user_data['email'];

// Fetch orders where the email matches the logged-in user's email
$query_orders = "SELECT * FROM orders WHERE email = $1 ORDER BY order_date DESC";
$result_orders = pg_query_params($con, $query_orders, array($user_email));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background: #007bff;
            color: white;
        }

        .table td,
        .table th {
            padding: 15px;
            text-align: center;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
            transition: 0.3s;
        }

        .no-orders {
            text-align: center;
            color: red;
            font-size: 20px;
            margin-top: 20px;
        }

        .back-btn {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .title {
            text-align: center;
            flex-grow: 1;
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <a href="../userin.php" class="back-btn">Back</a>
            <h2 class="title">My Orders</h2>
            <div></div> <!-- Empty div for spacing -->
        </div>

        <?php if (pg_num_rows($result_orders) > 0) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Payment Method</th>
                            <th>Price</th>
                            <th>Order Date</th>
                            <th>Quantity</th>
                            <th>Size</th>
                            <th>Dimension</th>
                            <th>Address</th>
                            <th>Delivery Date</th> <!-- Added Delivery Date Column -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = pg_fetch_assoc($result_orders)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                                <td>$<?php echo number_format($order['price'], 2); ?></td>
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($order['size']); ?></td>
                                <td><?php echo htmlspecialchars($order['dimension']); ?></td>
                                <td><?php echo htmlspecialchars($order['address']); ?></td>
                                <td><?php echo htmlspecialchars($order['deli']); ?></td> <!-- Added Delivery Date Display -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="no-orders">No orders found.</div>
        <?php } ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
