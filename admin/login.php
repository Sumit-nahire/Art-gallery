<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $adminuser = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Secure prepared statement to prevent SQL injection
    $query = pg_prepare($con, "admin_login", "SELECT id, password FROM tbladmin WHERE username = $1");
    $result = pg_execute($con, "admin_login", array($adminuser));

    if ($row = pg_fetch_assoc($result)) {
        // Verify password against hashed password in database
        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['agmsaid'] = $row['id'];

            echo "<script>document.location = 'dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid Username or Password!');</script>";
        }
    } else {
        echo "<script>alert('Invalid Username or Password!');</script>";
    }
}

// session_start();
// error_reporting(0);
// include('includes/dbconnection.php');

// if(isset($_POST['login']))
//   {
//     $adminuser=$_POST['username'];
//     $password=md5($_POST['password']);
//     $query=pg_query($con,"select id from tbladmin where  username='$adminuser' and password='$password' ");
//     $ret=pg_fetch_array($query,null,PGSQL_ASSOC);
//     if($ret>0){
//       $_SESSION['agmsaid']=$ret['id'];
//       echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
//     }
//     else{
//     echo "<script>alert('Invalid Details');</script>";
//     }
//   }
  ?>
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login1'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password']; // Raw password (not hashed yet)

    // Prepare query to fetch hashed password
    $query = pg_prepare($con, "user_login", "SELECT id, password FROM tblusers WHERE username = $1");
    $result = pg_execute($con, "user_login", array($username));

    if ($row = pg_fetch_assoc($result)) {
        $hashed_password = $row['password'];

        // Verify the entered password with the hashed password in DB
        if (password_verify($password, $hashed_password)) {
            session_regenerate_id(true);
            $_SESSION['userid'] = $row['id']; // Store user ID in session
            echo "<script>document.location = '../userin.php';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid Username or Password. Please try again!'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid Username or Password. Please try again!'); window.location.href='login.php';</script>";
    }
}
?>
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login1'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password']; // Raw password input

    if (empty($username) || empty($password)) {
        echo json_encode(["error" => "Username and password are required!"]);
        exit();
    }

    // Prepare and execute the query safely
    $query = "SELECT id, password FROM tblusers WHERE username = $1";
    $result = pg_query_params($con, $query, [$username]);

    if ($row = pg_fetch_assoc($result)) {
        $hashed_password = $row['password']; // Password stored in DB

        // Verify the entered password against the hashed password in DB
        if (password_verify($password, $hashed_password)) {
            session_regenerate_id(true);
            $_SESSION['userid'] = $row['id']; // Store user ID in session

            echo json_encode(["success" => "Login successful", "user_id" => $row['id'], "redirect" => "../userin.php"]);
            echo "<script>document.location = '../userin.php';</script>";
            exit();
        } else {
            echo json_encode(["error" => "Invalid Username or Password. Please try again!"]);
        }
    } else {
        echo json_encode(["error" => "User not found!"]);
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Art Gallery Management System</title>
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

        /* Login Container */
        .login-container {
            display: flex;
            gap: 80px; /* Adds space between both login boxes */
        }

        /* Glassmorphism Effect */
        .login-box {
            width: 320px;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease-in-out;
        }

        .login-box h2 {
            font-weight: bold;
            margin-bottom: 20px;
            color: white;
            text-transform: uppercase;
        }

        .login-box input {
            width: 100%;
            margin: 10px 0;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .login-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        /* User Login Box */
        .login-box1 {
            background: linear-gradient(to right, #ee, #ff5e62);
        }

        .login-box1 button {
            background: #00000055;
            color: white;
        }

        .login-box1 button:hover {
            background: #eeeeee55;
            transform: scale(1.1);
        }

        /* Admin Login Box */
        .login-box2 {
            background: linear-gradient(to right, #00c6 f, #0072ff);
        }

        .login-box2 button {
            background: #00001155;
            color: white;
        }

        .login-box2 button:hover {
            background: #eeeecc55;
            transform: scale(1.1);
        }

        .login-box a {
            display: block;
            margin-top: 10px;
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .login-box a:hover {
            color: #ffeb3b;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- User Login -->
        <div class="login-box login-box1">
            <h2><i class="fas fa-user"></i> User Login</h2>
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login1">Login</button>
                <a href="user-forgot-password.php">Forgot Password?</a>
                <a href="register.php">New Register?</a>
            </form>
        </div>
        
        <!-- Admin Login -->
        <div class="login-box login-box2">
            <h2><i class="fas fa-user-shield"></i> Admin Login</h2>
            <form action="login.php" method="post"> <!-- Admin login remains the same -->
                <input type="text" name="username" placeholder="Admin Username" required>
                <input type="password" name="password" placeholder="Admin Password" required>
                <button type="submit" name="login">Login</button>
                <a href="admin-forget-password.php">Forgot Password?</a>
            </form>
        </div>
    </div>

</body>
</html>
