<?php
session_start();
include('includes/dbconnection.php'); // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);

    // Basic validation
    if (empty($name) || empty($username) || empty($password) || empty($mobile) || empty($email)) {
        echo "<script>alert('All fields are required!'); window.location.href='register.php';</script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if username or email already exists
    $check_query = pg_query($con, "SELECT * FROM tblusers WHERE username='$username' OR email='$email'");
    if (pg_num_rows($check_query) > 0) {
        echo "<script>alert('Username or Email already exists!'); window.location.href='register.php';</script>";
        exit();
    }

    // Insert user into database
    $query = "INSERT INTO tblusers (name, username, password, mobile, email) VALUES ('$name', '$username', '$hashed_password', '$mobile', '$email')";
    $result = pg_query($con, $query);

    if ($result) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Something went wrong! Please try again.'); window.location.href='register.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Art Gallery Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Stylish Background */
        body {
            background: linear-gradient(to right, rgb(0, 0, 0), rgb(0, 191, 255));
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Glassmorphism Form */
        .register-container {
            width: 400px;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .register-container h2 {
            color: white;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .register-container input {
            width: 100%;
            margin: 10px 0;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            outline: none;
        }

        .register-container input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .register-container button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            background: #00001155;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        .register-container button:hover {
            background: #eeeecc55;
            transform: scale(1.05);
        }

        .register-container a {
            display: block;
            margin-top: 10px;
            color: #ffeb3b;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .register-container a:hover {
            color: white;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2><i class="fas fa-user-plus"></i> Register</h2>
        <form action="" method="post">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="mobile" placeholder="Mobile Number" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <button type="submit" name="register">Register</button>
            <a href="login.php">Already have an account? Login</a>
        </form>
    </div>

</body>
</html>
