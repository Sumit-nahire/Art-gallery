<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['agmsaid'] == 0)) {
  header('location:logout.php');
} else {

  if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = pg_query($con, "delete from tblartist where id='$rid'");
    echo "<script>alert('Data deleted');</script>";
    echo "<script>window.location.href = 'manage-artist.php'</script>";


  }

  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <title>Manage Artist | Art Gallery Management System</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
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
              <h3 class="page-header"><i class="fa fa-table"></i> Manage Artist</h3>
              <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
                <li><i class="fa fa-table"></i>Artist</li>
                <li><i class="fa fa-th-list"></i>Manage Artist</li>
              </ol>
            </div>
          </div>

          <!-- Artist Table -->
          <div class="row">
            <div class="col-sm-12">
              <section class="panel">
                <header class="panel-heading">Manage Artists</header>
                <table class="table">
                  <thead>
                    <tr>
                      <th>S.NO</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Mobile Number</th>
                      <th>Registration Date</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <?php
                  $ret = pg_query($con, "SELECT * FROM tblartist");
                  $cnt = 1;
                  while ($row = pg_fetch_assoc($ret)) {
                    ?>
                    <tr>
                      <td><?php echo $cnt; ?></td>
                      <td><?php echo htmlspecialchars($row['name']); ?></td>
                      <td><?php echo htmlspecialchars($row['email']); ?></td>
                      <td><?php echo htmlspecialchars($row['phone']); ?></td>
                      <td><?php echo htmlspecialchars($row['creationdate']); ?></td>
                      <td>
                        <a href="edit-artist-detail.php?editid=<?php echo $row['artist_id']; ?>"
                          class="btn btn-success">Edit</a>
                        <a href="manage-artist.php?delid=<?php echo $row['id']; ?>" class="btn btn-danger"
                          onclick="return confirm('Are you sure?');">Delete</a>
                        <a href="add-art-product.php?artistid=<?php echo $row['artist_id']; ?>" class="btn btn-warning">Add
                          Product</a>
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