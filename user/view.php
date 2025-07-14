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

// Fetch enquiries where email matches and include adminremark & adminremarkdate
$query = "SELECT e.id, e.enquirynumber, e.enquirydate, e.status, e.message, e.adminremark, e.adminremarkdate, a.title 
          FROM tblenquiry e
          JOIN tblartproduct a ON e.artpdid = a.id
          WHERE e.email = $1
          ORDER BY e.enquirydate DESC";

$ret = pg_query_params($con, $query, array($user_email));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Enquiries | Art Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="css/style.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        body {
            background: linear-gradient(to right, #ece9e6, #ffffff);
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
        }

        /* .container {
            max-width: 100%;
            width: 90%;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
            margin-top: 40px;
        } */

        .panel {
            padding: 30px;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
        }

        h3 {
            font-weight: 700;
            color: #333;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-back {
            display: inline-block;
            background: #007bff;
            color: white;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 25px;
            text-decoration: none;
            transition: 0.3s;
            margin-bottom: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        }

        .btn-back:hover {
            background: #0056b3;
            color: white;
            transform: translateY(-2px);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            background: white;
        }

        .table thead {
            background: #007bff;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: 0.3s;
            background: #ffffff;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .table tbody tr:hover {
            background: #f1f1f1;
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }

        .badge {
            padding: 10px 14px;
            font-size: 14px;
            border-radius: 15px;
            font-weight: bold;
        }

        .text-muted {
            color: #6c757d !important;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            .btn-back {
                font-size: 14px;
                padding: 10px 16px;
            }

            .table {
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {

            .table th,
            .table td {
                font-size: 13px;
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <a href="../userin.php" class="btn btn-back mb-3"><i class="fas fa-arrow-left"></i> Back</a>

        <div class="panel">
            <h3 class="text-center"><i class="fas fa-list"></i> My Enquiries</h3>
            <hr>

            <?php if (pg_num_rows($ret) == 0) { ?>
                <h4 class="text-center text-muted">No enquiries found.</h4>
            <?php } else { ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Enquiry No</th>
                            <th>Art Name</th>
                            <th>Date</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Admin Remark</th>
                            <th>Admin Remark Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cnt = 1;
                        while ($row = pg_fetch_assoc($ret)) {
                            ?>
                            <tr>
                                <td><?php echo $cnt; ?></td>
                                <td><?php echo htmlspecialchars($row['enquirynumber']); ?></td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo date("d M Y, H:i", strtotime($row['enquirydate'])); ?></td>
                                <td><?php echo htmlspecialchars($row['message']); ?></td>
                                <td>
                                    <?php if (strtolower($row['status']) == "answer") { ?>
                                        <span class="badge bg-success">Answered</span>
                                    <?php } else { ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo !empty($row['adminremark']) ? htmlspecialchars($row['adminremark']) : '<span class="text-muted">No Remark</span>'; ?>
                                </td>
                                <td><?php echo !empty($row['adminremarkdate']) ? date("d M Y, H:i", strtotime($row['adminremarkdate'])) : '<span class="text-muted">No Date</span>'; ?>
                                </td>
                            </tr>
                            <?php
                            $cnt++;
                        }
                        ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>