<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');

// Check if session exists
if (empty($_SESSION['agmsaid'])) {
    header('location:logout.php');
    exit();
}

// Validate 'viewid'
if (!isset($_GET['viewid']) || !is_numeric($_GET['viewid'])) {
    die("Invalid request. View ID is missing or invalid.");
}

$cid = intval($_GET['viewid']); // Convert to integer for safety

// Ensure database connection is valid
if (!$con || pg_connection_status($con) !== PGSQL_CONNECTION_OK) {
    die("Database connection failed: " . pg_last_error());
}

// Handle form submission for answering enquiry
if (isset($_POST['submit'])) {
    $remark = pg_escape_string($con, $_POST['remark']); // Escape input
    $status = 'Answer';
    $remark_date = date("Y-m-d H:i:s");

    // Use a prepared statement to prevent SQL injection
    $query = "UPDATE tblenquiry SET adminremark = $1, status = $2, adminremarkdate = $3 WHERE id = $4";
    $result = pg_query_params($con, $query, array($remark, $status, $remark_date, $cid));

    if ($result) {
        echo '<script>alert("Remarks have been updated."); window.location.href="view-enquiry-detail.php?viewid=' . $cid . '";</script>';
    } else {
        echo '<script>alert("Something went wrong. Please try again.")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="img/favicon.png">
    <title>View Enquiry | Art Gallery Management System</title>

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
        <?php include_once('includes/header.php'); ?>
        <?php include_once('includes/sidebar.php'); ?>

        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="fa fa-table"></i> View Enquiry</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
                            <li><i class="fa fa-table"></i> Enquiry</li>
                            <li><i class="fa fa-th-list"></i> View Enquiry</li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <section class="panel">
                            <header class="panel-heading">View Enquiry Details</header>

                            <?php
                            // Fetch enquiry details using a prepared statement
                            $query = "SELECT tblartproduct.*, tblenquiry.* FROM tblenquiry 
                                      JOIN tblartproduct ON tblartproduct.id = tblenquiry.artpdid 
                                      WHERE tblenquiry.id = $1";
                            $result = pg_query_params($con, $query, array($cid));

                            if ($result && pg_num_rows($result) > 0) {
                                $row = pg_fetch_assoc($result);
                                ?>

                                <table class="table table-bordered">
                                    <tr>
                                        <th>Enquiry Number</th>
                                        <td colspan="3"><?php echo htmlspecialchars($row['enquirynumber']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Full Name</th>
                                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                        <th>Art Name</th>
                                        <td>
                                            <?php echo htmlspecialchars($row['title']); ?><br />
                                            <a href="edit-art-product-detail.php?editid=<?php echo $row['artpdid']; ?>" target="_blank">View Details</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Art Reference Number</th>
                                        <td><?php echo htmlspecialchars($row['refnum']); ?></td>
                                        <th>Email</th>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile Number</th>
                                        <td><?php echo htmlspecialchars($row['mobilenumber']); ?></td>
                                        <th>Enquiry Date</th>
                                        <td><?php echo htmlspecialchars($row['enquirydate']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Message</th>
                                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                                        <th>Status</th>
                                        <td><?php echo ($row['status'] == "Answer") ? "Answered" : "Unanswered"; ?></td>
                                    </tr>

                                    <?php if ($row['status'] != "Answer") { ?>
                                        <!-- Answer Enquiry Form -->
                                        <form method="post">
                                            <tr>
                                                <th>Remark:</th>
                                                <td colspan="3">
                                                    <textarea name="remark" rows="5" cols="50" class="form-control" required></textarea>
                                                </td>
                                            </tr>
                                            <tr align="center">
                                                <td colspan="4">
                                                    <button type="submit" name="submit" class="btn btn-primary">
                                                        <i class="fa fa-dot-circle-o"></i> Update
                                                    </button>
                                                </td>
                                            </tr>
                                        </form>
                                    <?php } else { ?>
                                        <tr>
                                            <th>Remark</th>
                                            <td colspan="3"><?php echo htmlspecialchars($row['adminremark']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Remark Date</th>
                                            <td colspan="3"><?php echo htmlspecialchars($row['adminremarkdate']); ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>

                            <?php
                            } else {
                                echo "<p style='color:red'>No enquiry found.</p>";
                            }
                            ?>
                        </section>
                    </div>
                </div>
            </section>
        </section>

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
