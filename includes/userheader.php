<?php
session_start();
include('includes/dbconnection.php');

if (isset($_SESSION['userid'])) {
    $uid = $_SESSION['userid'];
    $query = pg_query($con, "SELECT * FROM tblusers WHERE id='$uid'");
    $user = pg_fetch_array($query, null, PGSQL_ASSOC);
}
?>

<div class="header-bar">
    <div class="info-top-grid">
        <div class="info-contact-agile">
            <?php
            $ret = pg_query($con, "SELECT * FROM tblpage WHERE pagetype = 'contactus'");
            while ($row = pg_fetch_array($ret, null, PGSQL_ASSOC)) {
            ?>
                <ul>
                    <li>
                        <span class="fas fa-phone-volume"></span>
                        <p><?php echo $row['mobilenumber']; ?></p>
                    </li>
                    <li>
                        <span class="fas fa-envelope"></span>
                        <p><?php echo $row['email']; ?></p>
                    </li>
                </ul>
            <?php } ?>
        </div>
    </div>
    <div class="container-fluid">
        <div class="hedder-up row">
            <div class="col-lg-3 col-md-3 logo-head">
                <h1><a class="navbar-brand" href="userin.php">Art Gallery</a></h1>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="userin.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a href="userabout.php" class="nav-link">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Art Type</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        $ret = pg_query($con, "SELECT * FROM tblarttype");
                        while ($row = pg_fetch_array($ret, null, PGSQL_ASSOC)) {
                        ?>
                            <a class="nav-link" href="userproduct.php?cid=<?php echo $row['id']; ?>&&artname=<?php echo $row['arttype']; ?>">
                                <?php echo $row['arttype']; ?>
                            </a>
                        <?php } ?>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="usercontact.php" class="nav-link">Contact</a>
                </li>
                <?php if (isset($_SESSION['userid'])) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- <img src="user-icon.png" width="25" height="25" class="mr-2"> User icon -->
                            <img src="includes/man.png" width="25" height="25" class="rounded-circle mr-2"> <!-- User profile image -->
                            <?php echo $user['username']; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="user/user-profile.php">View Profile</a>
                            <a class="dropdown-item" href="user/orders.php">My Orders</a>
                            <a class="dropdown-item" href="user/view.php">Check Status</a>
                            <a class="dropdown-item" href="index.php">Logout</a>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link">Login</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</div>
