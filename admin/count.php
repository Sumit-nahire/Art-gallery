<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['agmsaid']) == 0) {
    header('location:logout.php');
} else {
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Artists | Art Gallery Management System</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <style>
        .count-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            text-align: center;
        }
    </style>
</head>

<body>
    <section id="container">
        <!-- Header & Sidebar -->
        <?php include_once('includes/header.php'); ?>
        <?php include_once('includes/sidebar.php'); ?>

        <!-- Main Content -->
        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="fa fa-table"></i> Manage Artists</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
                            <li><i class="fa fa-table"></i>Artists</li>
                            <li><i class="fa fa-th-list"></i>Manage Artists</li>
                        </ol>
                    </div>
                </div>

                <!-- Display Total Artists Count -->
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <div class="count-box">
                            <?php
                            $count_query = pg_query($con, "SELECT COUNT(*) AS total FROM tblartist");
                            $count_result = pg_fetch_assoc($count_query);
                            echo "Total Artists: " . $count_result['total'];
                            ?>
                        </div>
                    </div>
                </div>

                <br>

                <!-- Artist Table -->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Manage Artists
                            </header>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile Number</th>
                                        <th>Registration Date</th>
                                        <th>Total Visits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Query to get artists and their visit counts
                                    $ret = pg_query($con, "SELECT a.*, 
                                        COALESCE(v.visit_count, 0) AS total_visits 
                                        FROM tblartist a
                                        LEFT JOIN (
                                            SELECT artist_id, COUNT(*) AS visit_count 
                                            FROM tblartist_visits 
                                            GROUP BY artist_id
                                        ) v ON a.id = v.artist_id");

                                    $cnt = 1;
                                    while ($row = pg_fetch_array($ret, null, PGSQL_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['mobilenumber']); ?></td>
                                            <td><?php echo htmlspecialchars($row['creationdate']); ?></td>
                                            <td><?php echo htmlspecialchars($row['total_visits']); ?></td>
                                        </tr>
                                    <?php 
                                        $cnt++;
                                    }
                                    if ($cnt == 1) { // No artists found
                                        echo "<tr><td colspan='6' class='text-center'>No artists found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
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
