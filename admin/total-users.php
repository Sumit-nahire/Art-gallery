<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['agmsaid'] == 0)) {
  header('location:logout.php');
} else {

  if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = pg_query($con, "DELETE FROM tblusers WHERE id='$rid'");
    echo "<script>alert('User deleted');</script>";
    echo "<script>window.location.href = 'total-users.php'</script>";
  }

  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <title>Manage Users | Art Gallery Management System</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

  </head>

  <body>
    <!-- container section start -->
    <section id="container" class="">
      <!--header start-->
      <?php include_once('includes/header.php'); ?>
      <!--header end-->

      <!--sidebar start-->
      <?php include_once('includes/sidebar.php'); ?>

      <!--main content start-->
      <section id="main-content">
        <section class="wrapper">
          <div class="row">
            <div class="col-lg-12">
              <h3 class="page-header"><i class="fa fa-table"></i> Manage Users</h3>
              <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
                <li><i class="fa fa-table"></i>Users</li>
                <li><i class="fa fa-th-list"></i>Manage Users</li>
              </ol>
            </div>
          </div>

          <!-- User Table -->
          <div class="row">
            <div class="col-sm-12">
              <section class="panel">
                <header class="panel-heading">Manage Users</header>
                <table class="table">
                  <thead>
                    <tr>
                      <th>S.NO</th>
                      <th>Full Name</th>
                      <th>Email</th>
                      <th>Mobile Number</th>
                      <th>Registration Date and Time</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <?php
                  $ret = pg_query($con, "SELECT * FROM tblusers");
                  $cnt = 1;
                  while ($row = pg_fetch_assoc($ret)) {
                    ?>
                    <tr>
                      <td><?php echo $cnt; ?></td>
                      <td><?php echo htmlspecialchars($row['name']); ?></td>
                      <td><?php echo htmlspecialchars($row['email']); ?></td>
                      <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                      <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                      <td>
                        <a href="edit-user-detail.php?editid=<?php echo $row['id']; ?>"
                          class="btn btn-success">Edit</a>
                        <a href="total-users.php?delid=<?php echo $row['id']; ?>" class="btn btn-danger"
                          onclick="return confirm('Are you sure?');">Delete</a>
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

      <!-- page end-->
    </section>
    </section>
    <!--main content end-->
    <?php include_once('includes/footer.php'); ?>
    </section>
    <!-- container section end -->
    <!-- javascripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- nicescroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>

  </body>

  </html>
<?php } ?>
