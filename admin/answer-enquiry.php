<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');

// Correct session validation
if (!isset($_SESSION['agmsaid']) || strlen($_SESSION['agmsaid']) == 0) {
    header('location:logout.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Answered Enquiries | Art Gallery Management System</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!-- Font Icons -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles -->
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
                        <h3 class="page-header"><i class="fa fa-table"></i> Answered Enquiries</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
                            <li><i class="fa fa-table"></i> Enquiry</li>
                            <li><i class="fa fa-th-list"></i> Answered Enquiries</li>
                        </ol>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Answered Enquiries
                            </header>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Enquiry Number</th>
                                        <th>Full Name</th>
                                        <th>Mobile Number</th>
                                        <th>Enquiry Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch only required columns
                                    $query = "SELECT id, enquirynumber, fullname, mobilenumber, enquirydate FROM tblenquiry WHERE LOWER(status) = 'answer'";
                                    $ret = pg_query($con, $query);

                                    if (!$ret) {
                                        echo "<tr><td colspan='6' style='color:red;'>Error fetching data: " . pg_last_error($con) . "</td></tr>";
                                    } else {
                                        $cnt = 1;
                                        while ($row = pg_fetch_assoc($ret)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo htmlspecialchars($row['enquirynumber']); ?></td>
                                                <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                                <td><?php echo htmlspecialchars($row['mobilenumber']); ?></td>
                                                <td><?php echo htmlspecialchars($row['enquirydate']); ?></td>
                                                <td>
                                                    <a href="view-enquiry-detail.php?viewid=<?php echo urlencode($row['id']); ?>" class="btn btn-success">View Details</a>
                                                </td>
                                            </tr>
                                    <?php 
                                            $cnt++;
                                        }
                                    } ?>
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
