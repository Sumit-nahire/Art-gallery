<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['agmsaid'] == 0)) {
  header('location:logout.php');
} else {

  if (isset($_POST['submit'])) {
    $aid = $_SESSION['agmsaid'];
    $title = $_POST['title'];
    $dimension = $_POST['dimension'];
    $orientation = $_POST['orientation'];
    $size = $_POST['size'];
    $arttype = $_POST['arttype'];
    $artmed = $_POST['artmed'];
    $sprice = $_POST['sprice'];
    $description = $_POST['description'];
    $refno = mt_rand(100000000, 999999999);

    // Featured Image
    $pic = $_FILES["images"]["name"];
    $extension = substr($pic, strlen($pic) - 4, strlen($pic));

    // Allowed extensions
    $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");

    if (!in_array($extension, $allowed_extensions)) {
      echo "<script>alert('Featured image has an invalid format. Only jpg / jpeg / png / gif formats allowed.');</script>";
    } else {
      // Rename image
      $pic = md5($pic) . time() . $extension;
      move_uploaded_file($_FILES["images"]["tmp_name"], "images/" . $pic);

      $query = pg_query($con, "INSERT INTO tblartproduct(title, dimension, orientation, size, arttype, artmedium, sellingpricing, description, image, refnum) VALUES ('$title', '$dimension', '$orientation', '$size', '$arttype', '$artmed', '$sprice', '$description', '$pic', '$refno')");

      if ($query) {
        echo "<script>alert('Art product details have been submitted.');</script>";
        echo "<script>window.location.href ='add-art-product.php'</script>";
      } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
      }
    }
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Add Art Product | Art Gallery Management System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/daterangepicker.css" rel="stylesheet" />
  <link href="css/bootstrap-datepicker.css" rel="stylesheet" />
  <link href="css/bootstrap-colorpicker.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
  </head>

  <body>
    <section id="container">
      <?php include_once('includes/header.php'); ?>
      <?php include_once('includes/sidebar.php'); ?>

      <section id="main-content" style="color:#000">
        <section class="wrapper">
          <div class="row">
            <div class="col-lg-12">
              <h3 class="page-header">Add Art Product Detail</h3>
            </div>
          </div>
          <div class="row">
            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
              <div class="col-lg-6">
                <section class="panel">
                  <header class="panel-heading">Add Art Product Detail</header>
                  <div class="panel-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Title</label>
                      <div class="col-sm-10">
                        <input class="form-control" id="title" name="title" type="text" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Featured Image</label>
                      <div class="col-sm-10">
                        <input type="file" class="form-control" name="images" id="images" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Dimension</label>
                      <div class="col-sm-10">
                        <input class="form-control" id="dimension" name="dimension" type="text" required>
                      </div>
                    </div>
                  </div>
                </section>
              </div>
              <div class="col-lg-6">
                <section class="panel">
                  <div class="panel-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Orientation</label>
                      <div class="col-sm-10">
                        <select class="form-control" id="orientation" name="orientation" required>
                          <option value="">Choose orientation</option>
                          <option value="Portrait">Portrait</option>
                          <option value="Landscape">Landscape</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Size</label>
                      <div class="col-sm-10">
                        <select class="form-control" id="size" name="size" required>
                          <option value="">Choose Size</option>
                          <option value="Small">Small</option>
                          <option value="Medium">Medium</option>
                          <option value="Large">Large</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Art Type</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="arttype" id="arttype">
                          <option value="">Choose Art Type</option>
                          <?php
                          $query = pg_query($con, "SELECT * FROM tblarttype");
                          while ($row = pg_fetch_array($query, null, PGSQL_ASSOC)) {
                            ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['arttype']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Art Medium</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="artmed" id="artmed">
                          <option value="">Choose Art Medium</option>
                          <?php
                          $query = pg_query($con, "SELECT * FROM tblartmedium");
                          while ($row = pg_fetch_array($query, null, PGSQL_ASSOC)) {
                            ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['artmedium']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Selling Price</label>
                      <div class="col-sm-10">
                        <input class="form-control" id="sprice" type="text" name="sprice" required>
                      </div>
                    </div>
                    <p style="text-align: center;"> <button type="submit" name='submit'
                        class="btn btn-primary">Submit</button></p>
                  </div>
                </section>
              </div>
            </form>
          </div>
        </section>
      </section>
    </section>
  </body>

  </html>
<?php } ?>