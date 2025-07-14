<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['agmsaid']==0)) {
  header('location:logout.php');
  }
  else{

if(isset($_POST['submit']))
  {
   
    $title=$_POST['title'];
    $dimension=$_POST['dimension'];
    $orientation=$_POST['orientation'];
    $size=$_POST['size'];
    $artist=$_POST['artist'];
    $arttype=$_POST['arttype'];
    $artmed=$_POST['artmed'];
    $sprice=$_POST['sprice'];
    $description=$_POST['description'];
    $eid=$_GET['editid'];
    $query=pg_query($con, "update tblartproduct set title='$title',dimension='$dimension',orientation='$orientation',size='$size',artist='$artist',arttype='$arttype',artmedium='$artmed',sellingpricing='$sprice',description='$description' where id='$eid'");
    if ($query) {
  
    echo "<script>alert('Art product has been updated.');</script>";
  }
  else
    {
      echo "<script>alert('Something Went Wrong. Please try again.');</script>";
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
  <section id="container" class="">
    <!--header start-->
    <?php include_once('includes/header.php');?>
    <!--header end-->

    <!--sidebar start-->
   <?php include_once('includes/sidebar.php');?>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content" style="color:#000">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-file-text-o"></i>Add Art Product Detail</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php">Home</a></li>
              <li><i class="icon_document_alt"></i>Art Product</li>
              <li><i class="fa fa-file-text-o"></i>Art Product Detail</li>
            </ol>
          </div>
        </div>
        <div class="row">      
          <form class="form-horizontal " method="post" action="" enctype="multipart/form-data">
            <?php
 $cid=$_GET['editid'];
$ret=pg_query($con,"select tblarttype.id as atid,tblarttype.arttype as typename,tblartmedium.id as amid,tblartmedium.artmedium as amname,tblartproduct.id as apid,tblartist.id as arid,tblartist.name,tblartproduct.title,tblartproduct.dimension,tblartproduct.orientation,tblartproduct.size,tblartproduct.artist,tblartproduct.arttype,tblartproduct.artmedium,tblartproduct.sellingpricing,tblartproduct.description,tblartproduct.image,tblartproduct.image1,tblartproduct.image2,tblartproduct.image3,tblartproduct.image4,tblartproduct.refnum,tblartproduct.arttype from tblartproduct join tblarttype on tblarttype.id=tblartproduct.arttype join tblartmedium on tblartmedium.id=tblartproduct.artmedium join tblartist on tblartist.id=tblartproduct.artist where tblartproduct.id='$cid'");
$cnt=1;
while ($row=pg_fetch_array($ret,null,PGSQL_ASSOC)) {

?>
          <div class="col-lg-6">
            <section class="panel">
              <header class="panel-heading">
                Update Art Product Detail
              </header>
              <div class="panel-body">
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="title" name="title"  type="text" required="true" value="<?php  echo $row['title'];?>" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Featured Image</label>
                    <div class="col-sm-10">
                     <img src="images/<?php echo $row['image'];?>" width="200" height="150" value="<?php  echo $row['image'];?>"><a href="changeimage.php?editid=<?php echo $row['apid'];?>"> &nbsp; Edit Image</a>
                    </div>
                  </div>

    <div class="form-group">
                    <label class="col-sm-2 control-label">Art Product Image1</label>
                    <div class="col-sm-10">
                      <img src="images/<?php echo $row['image1'];?>" width="200" height="150" value="<?php  echo $row['image1'];?>"><a href="changeimage1.php?editid=<?php echo $row['apid'];?>"> &nbsp; Edit Image</a>
                    </div>
                  </div>

  <div class="form-group">
                    <label class="col-sm-2 control-label">Art Product Image2</label>
                    <div class="col-sm-10">
                       <img src="images/<?php echo $row['image2'];?>" width="200" height="150" value="<?php  echo $row['image2'];?>"><a href="changeimage2.php?editid=<?php echo $row['apid'];?>"> &nbsp; Edit Image</a>
                    </div>
                  </div>

                    <div class="form-group">
                    <label class="col-sm-2 control-label">Art Product Image3</label>
                    <div class="col-sm-10">
                       <img src="images/<?php echo $row['image3'];?>" width="200" height="150" value="<?php  echo $row['image3'];?>"><a href="changeimage3.php?editid=<?php echo $row['apid'];?>"> &nbsp; Edit Image</a>
                    </div>
                  </div>

                    <div class="form-group">
                    <label class="col-sm-2 control-label">Art Product Image4</label>
                    <div class="col-sm-10">
                      <img src="images/<?php echo $row['image4'];?>" width="200" height="150" value="<?php  echo $row['image4'];?>"><a href="changeimage4.php?editid=<?php echo $row['apid'];?>"> &nbsp; Edit Image</a>
                    </div>
                  </div>

<div class="form-group">
                    <label class="col-sm-2 control-label">Dimension</label>
                    <div class="col-sm-10">
                      <input class="form-control" id="dimension" name="dimension"  type="text" required="true" value="<?php  echo $row['dimension'];?>">
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
                      <select class="form-control" id="orientation" name="orientation"  required="true">
                        <option value="<?php  echo $row['orientation'];?>"><?php  echo $row['orientation'];?></option>
                        <option value="Potrait">Potrait</option>
                        <option value="Landscape">Landscape</option>
                        
                      </select>
                    </div>
                  </div>
                   
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Size</label>
                    <div class="col-sm-10">
                      <select class="form-control" id="size" name="size"  required="true">
                        <option value="<?php  echo $row['size'];?>"><?php  echo $row['size'];?></option>
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                      </select>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-sm-2 control-label">Artist</label>
                    <div class="col-sm-10">
                      <select class="form-control m-bot15" name="artist" id="artist">
                                <option value="<?php  echo $row['arid'];?>"><?php  echo $row['name'];?></option>
                                <?php $query1=pg_query($con,"select * from tblartist");
              while($row1=pg_fetch_array($query1,null,PGSQL_ASSOC))
              {
              ?>    
              <option value="<?php echo $row1['id'];?>"><?php echo $row1['name'];?></option>
                  <?php } ?> 
                            </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Art Type</label>
                    <div class="col-sm-10">
                      <select class="form-control m-bot15" name="arttype" id="arttype">
                                <option value="<?php  echo $row['atid'];?>"><?php  echo $row['typename'];?></option>
                                <?php $query2=pg_query($con,"select * from tblarttype");
              while($row2=pg_fetch_array($query2,null,PGSQL_ASSOC))
              {
              ?>    
              <option value="<?php echo $row2['id'];?>"><?php echo $row2['arttype'];?></option>
                  <?php } ?> 
                            </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Art Medium</label>
                    <div class="col-sm-10">
                      <select class="form-control m-bot15" name="artmed" id="artmed">
                                <option value="<?php  echo $row['amid'];?>"><?php  echo $row['amname'];?></option>
                                <?php $query3=pg_query($con,"select * from tblartmedium");
              while($row3=pg_fetch_array($query3,null,PGSQL_ASSOC))
              {
              ?>    
              <option value="<?php echo $row3['id'];?>"><?php echo $row3['artmedium'];?></option>
                  <?php } ?> 
                            </select>
                    </div>
                  </div>
                  
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Selling Price</label>
                    <div class="col-sm-10">
                      <input class="form-control " id="sprice" type="text" name="sprice" required="true" value="<?php  echo $row['sellingpricing'];?>">
                    </div>
                  </div>
                
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Art Product Description</label>
                    <div class="col-sm-10">
                      <textarea class="form-control " id="description" type="text" name="description" rows="12" cols="4" required="true"><?php  echo $row['description'];?></textarea>
                    </div>
                  </div>
              </div>
            </section>
            
          </div>
          <?php } ?>
               <p style="text-align: center;"> <button type="submit" name='submit' class="btn btn-primary">Submit</button></p>
              </form>
        </div>
      
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
<?php  } ?>