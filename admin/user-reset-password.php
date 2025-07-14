<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (!isset($_SESSION['userid'])) {
    header("Location: forgot-password.php");
    exit();
}

if (isset($_POST['submit'])) {
    $newpassword = trim($_POST['newpassword']);
    $confirmpassword = trim($_POST['confirmpassword']);

    if ($newpassword !== $confirmpassword) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
        $userid = $_SESSION['userid'];

        $query = pg_prepare($con, "update_password", "UPDATE tblusers SET password = $1 WHERE id = $2");
        $result = pg_execute($con, "update_password", array($hashed_password, $userid));

        if ($result) {
            echo "<script>alert('Password updated successfully!'); document.location ='login.php';</script>";
            session_destroy();
        } else {
            echo "<script>alert('Something went wrong. Try again!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password | Art Gallery Management System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        body {
            background:linear-gradient(to right, rgb(0, 0, 0), rgb(0, 191, 255));
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reset-container {
            width: 350px;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        h2 {
            color: white;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
            background:  #00001155;
            color: white;
        }

        button:hover {
            background: #eeeecc55;
            transform: scale(1.1);
        }

        a {
            display: block;
            margin-top: 10px;
            color: white;
            text-decoration: none;
        }

        a:hover {
            color: #ffeb3b;
        }
    </style>
</head>
<body>

    <div class="reset-container">
        <h2>Reset Password</h2>
        <form action="" method="post">
            <input type="password" name="newpassword" placeholder="New Password" required>
            <input type="password" name="confirmpassword" placeholder="Confirm Password" required>
            <button type="submit" name="submit">Change Password</button>
            <a href="login.php">Back to Login</a>
        </form>
    </div>

</body>
</html>
