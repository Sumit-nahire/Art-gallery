<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit'])) {
    $contactno = trim($_POST['contactno']);
    $email = trim($_POST['email']);

    // Securely check if email and mobile match
    $query = pg_prepare($con, "check_user", "SELECT id FROM tblusers WHERE email = $1 AND mobile = $2");
    $result = pg_execute($con, "check_user", array($email, $contactno));

    if ($row = pg_fetch_assoc($result)) {
        $_SESSION['userid'] = $row['id'];  
        $_SESSION['email'] = $email;
        $_SESSION['contactno'] = $contactno;
        
        // Redirect to reset password page
        header("Location: user-reset-password.php");
        exit();
    } else {
        echo "<script>alert('Invalid details. Please try again!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password | Art Gallery Management System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, rgb(0, 0, 0), rgb(0, 191, 255));
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .forgot-container {
            width: 400px;
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
            width: 93%;
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
            background: #00001155;
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

    <div class="forgot-container">
        <h2>Forgot Password</h2>
        <form action="" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="contactno" placeholder="Mobile Number" required>
            <button type="submit" name="submit">Verify</button>
            <a href="login.php">Back to Login</a>
        </form>
    </div>

</body>
</html>
