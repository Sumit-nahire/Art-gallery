<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['agmsaid']) == 0) {
    header('location:logout.php');
} else {
    // Handle delivery date update request
    if (isset($_POST['update_delivery'])) {
        $order_id = intval($_POST['order_id']);
        $new_delivery_date = $_POST['delivery_date'];

        if (!empty($new_delivery_date)) {
            $update_query = "UPDATE orders SET deli = $1 WHERE id = $2";
            $result = pg_query_params($con, $update_query, array($new_delivery_date, $order_id));

            if ($result) {
                echo "<script>alert('Delivery date updated successfully!');</script>";
                echo "<script>window.location.href = 'manage-orders.php'</script>";
                exit();
            } else {
                echo "<script>alert('Error updating delivery date. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Please select a valid delivery date.');</script>";
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Manage Orders | Art Gallery Management System</title>

        <!-- Bootstrap CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <!-- External CSS -->
        <link href="css/elegant-icons-style.css" rel="stylesheet" />
        <link href="css/font-awesome.min.css" rel="stylesheet" />
        <!-- Custom Styles -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet" />

    </head>

    <body>
        <section id="container">
            <!-- Header -->
            <?php include_once('includes/header.php'); ?>

            <!-- Sidebar -->
            <?php include_once('includes/sidebar.php'); ?>

            <!-- Main Content -->
            <section id="main-content">
                <section class="wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="page-header"><i class="fa fa-table"></i> Manage Orders</h3>
                            <ol class="breadcrumb">
                                <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
                                <li><i class="fa fa-table"></i>Orders</li>
                                <li><i class="fa fa-th-list"></i>Manage Orders</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="row">
                        <div class="col-sm-12">
                            <section class="panel">
                                <header class="panel-heading">Manage Orders</header>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Order ID</th>
                                            <th>Customer Email</th>
                                            <th>Payment Method</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Size</th>
                                            <th>Dimension</th>
                                            <th>Order Date</th>
                                            <th>Address</th>
                                            <th>Delivery Date</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $ret = pg_query($con, "SELECT * FROM orders ORDER BY order_date DESC");
                                    $cnt = 1;
                                    while ($row = pg_fetch_assoc($ret)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                            <td><?php echo htmlspecialchars($row['size']); ?></td>
                                            <td><?php echo htmlspecialchars($row['dimension']); ?></td>
                                            <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                                            <td>
                                                <form method="post" action="">
                                                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                                    <input type="date" name="delivery_date"
                                                        value="<?php echo htmlspecialchars($row['deli']); ?>" required>
                                                    <button type="submit" name="update_delivery"
                                                        class="btn btn-primary btn-sm">Update</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                        $cnt++;
                                    }
                                    ?>
                                </table>
                            </section>
                        </div>
                    </div>
                </section>
            </section>

            <!-- Footer -->
            <?php include_once('includes/footer.php'); ?>
        </section>

        <!-- JavaScripts -->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.scrollTo.min.js"></script>
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/scripts.js"></script>

    </body>

    </html>
<?php } ?>