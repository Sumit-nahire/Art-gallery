<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (!isset($_SESSION['agmsaid']) || strlen($_SESSION['agmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $mobnum = $_POST['mobnum'];
    $email = $_POST['email'];
    $edudetails = $_POST['edudetails'];
    $awarddetails = $_POST['awarddetails'];
    $eid = $_GET['editid'];

    // Secure update query
    $query = pg_prepare($con, "update_artist", "UPDATE tblartist SET name=$1, mobilenumber=$2, email=$3, education=$4, award=$5 WHERE id=$6");
    $result = pg_execute($con, "update_artist", array($name, $mobnum, $email, $edudetails, $awarddetails, $eid));

    if ($result) {
        echo "<script>alert('Artist details have been updated.');</script>";
    } else {
        echo "<script>alert('Something Went Wrong: " . pg_last_error($con) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  
  <title>Update Artist | Art Gallery Management System</title>

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/daterangepicker.css" rel="stylesheet" />
  <link href="css/bootstrap-datepicker.css" rel="stylesheet" />
  <link href="css/bootstrap-colorpicker.css" rel="stylesheet" />
  <!-- date picker -->

  <!-- color picker -->

  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />

</head>

<body>

  <!-- container section start -->
  <section id="container" class="">
    <!--header start-->
    <?php include_once('includes/header.php');?>
    <!--header end-->

    <!--sidebar start-->
   <?php include_once('includes/sidebar.php');?>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Update Artist Detail</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Artist</li>
              <li><i class="fa fa-file-text-o"></i>Artist Detail</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
               Update Company Detail
              </header>
              <div class="panel-body">
                <form class="form-horizontal " method="post" action="">
                  <p style="font-size:16px; color:red" align="left"> <?php if($msg){
    echo $msg;
  }  ?> </p>

  <?php
 $cid=$_GET['editid'];
$ret=pg_query($con,"select * from tblartist where id='$cid'");
$cnt=1;
while ($row=pg_fetch_array($ret,null,PGSQL_ASSOC)) {

?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="name" name="name"  type="text" required="true" value="<?php  echo $row['name'];?>">
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-sm-2 control-label">Mobile Number</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="mobnum" maxlength="10" name="mobnum"  type="text" required="true" pattern="[0-9]+" value="<?php  echo $row['mobilenumber'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="email" name="email"  type="email" required="true" value="<?php  echo $row['email'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Education Details</label>
                    <div class="col-sm-10">
                     
                      <textarea class="form-control" name="edudetails" required="true"><?php  echo $row['education'];?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Award Details</label>
                    <div class="col-sm-10">
                    
                      <textarea class="form-control" name="awarddetails" required="true"><?php  echo $row['award'];?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Profile Pics</label>
                    <div class="col-sm-10">
                      <img src="images/<?php echo $row['Profilepic'];?>" width="200" height="150" value="<?php  echo $row['Profilepic'];?>"><a href="changepropic.php?imageid=<?php echo $row['ID'];?>" class="btn btn-success">  Edit Image</a>
                    </div>
                   
                  </div>
                <?php } ?>
                 <p style="text-align: center;"> <button type="submit" name='submit' class="btn btn-primary">Update</button></p>
                </form>
              </div>
            </section>
            
          </div>
        </div>
        <!-- Basic Forms & Horizontal Forms-->

        
         
      
        <!-- page end-->
      </section>
    </section>
 <?php include_once('includes/footer.php');?>
  </section>
  <!-- container section end -->
  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

  <!-- jquery ui -->
  <script src="js/jquery-ui-1.9.2.custom.min.js"></script>

  <!--custom checkbox & radio-->
  <script type="text/javascript" src="js/ga.js"></script>
  <!--custom switch-->
  <script src="js/bootstrap-switch.js"></script>
  <!--custom tagsinput-->
  <script src="js/jquery.tagsinput.js"></script>

  <!-- colorpicker -->

  <!-- bootstrap-wysiwyg -->
  <script src="js/jquery.hotkeys.js"></script>
  <script src="js/bootstrap-wysiwyg.js"></script>
  <script src="js/bootstrap-wysiwyg-custom.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/bootstrap-colorpicker.js"></script>
  <script src="js/daterangepicker.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <!-- ck editor -->
  <script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
  <!-- custom form component script for this page-->
  <script src="js/form-component.js"></script>
  <!-- custome script for all page -->
  <script src="js/scripts.js"></script>


</body>

</html>
<?php   ?>