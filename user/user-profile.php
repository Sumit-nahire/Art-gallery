<?php
session_start();
include('../includes/dbconnection.php');
if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit();
}

$uid = $_SESSION['userid'];
$query = pg_query($con, "SELECT * FROM tblusers WHERE id='$uid'");
$user = pg_fetch_array($query, null, PGSQL_ASSOC);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    $updateQuery = pg_query($con, "UPDATE tblusers SET name='$name', email='$email', mobile='$phone' WHERE id='$uid'");
    
    if ($updateQuery) {
        $_SESSION['message'] = "Profile updated successfully!";
        header("Location: user-profile.php");
        
        exit();
    } else {
        $_SESSION['message'] = "Failed to update profile.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="container">
        <h2>My Profile</h2>
        <?php if (isset($_SESSION['message'])) { ?>
            <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php } ?>
        <form action="" method="post">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo $user['mobile']; ?>" required>
            
            <button type="submit" name="update">Update Profile</button>
        </form>

        <a href="../userin.php" class="back-button">← Back to Home</a>
    </div>
</body>
</html>
