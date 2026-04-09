<?php
include 'db_connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$connection = new mysqli("localhost", "root", "", "cafe",3307);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_POST['register_btn'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $c_pass = $_POST['c_password'];

    // 1. Pehle check karein ke email unique hai ya nahi
    $checkEmail = $connection->prepare("SELECT r_name FROM registered_customer WHERE r_name = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('❌ This email is already registered!');</script>";
    } 
    elseif ($pass !== $c_pass) {
        echo "<script>alert('❌ Passwords do not match!');</script>";
    } 
    else {
        $hashed = $pass;
// r_name ki jagah email aur r_address ki jagah r_password use hoga
$stmt = $connection->prepare("INSERT INTO registered_customer (r_name, r_email, r_password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $email, $hashed);
        
        if ($stmt->execute()) {
            echo "<script>alert('✅ Registration Successful!'); window.location.href='customer_login.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Customer Signup</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Background image wahi jo login page par hai */
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url("f3.jpg") no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .box {
            width: 380px;
            background: rgba(94, 9, 9, 0.9); /* Dark maroon/brown shade */
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 0 30px rgba(255, 102, 0, 0.4);
            border: 2px solid #ff6600; /* Orange border */
        }

        h2 {
            color: #ff8c00;
            margin-bottom: 25px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input {
            width: 90%;
            padding: 12px;
            margin: 12px 0;
            border: none;
            border-radius: 8px;
            background: #fff;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            box-shadow: 0 0 10px #ff6600;
        }

        button {
            width: 96%;
            padding: 13px;
            margin-top: 20px;
            background: #ff7b00;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
        }

        button:hover {
            background: #e66e00;
            transform: translateY(-2px);
        }

        .links {
            margin-top: 20px;
            color: #ddd;
            font-size: 14px;
        }

        .links a {
            color: #ff8c00;
            text-decoration: none;
            font-weight: bold;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="box">
        <h2>New Customer Signup</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter Your Email" required>
            <input type="password" name="password" placeholder="Create Password" required>
            <input type="password" name="c_password" placeholder="Confirm Password" required>
            <button type="submit" name="register_btn">Sign Up & Save</button>
        </form>

        <div class="links">
            Already have an account? <br>
            <a href="customer_login.php">Wapas Login par jayein</a> <br>
            <a href="login_choice.php" style="font-size: 12px;">⬅ Back</a>
        </div>
    </div>

</body>
</html>