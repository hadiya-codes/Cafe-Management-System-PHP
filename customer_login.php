<?php
include 'db_connect.php';
session_start();
$connection = new mysqli("localhost", "root", "", "cafe",3307);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']); 
    
    $sql = "SELECT * FROM local_customer WHERE l_name = ? AND l_address = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $name, $address);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['customer_name'] = $row['l_name'];
        $_SESSION['customer_type'] = "local";
        header("Location: menu.php");
        exit();
    }

// r_name ki jagah r_email se search karein
$sql2 = "SELECT * FROM registered_customer WHERE r_email = ?";
$stmt2 = $connection->prepare($sql2);
$stmt2->bind_param("s", $name);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($result2->num_rows === 1) {
        $row = $result2->fetch_assoc();
  
        if ($address === $row['r_password']) {
            $_SESSION['customer_name'] = $row['r_name'];
            $_SESSION['customer_type'] = "registered";
            header("Location: menu.php");
            exit();
        } else {
            $message = "❌ please correct the password.";
        }
    } else {
        $message = "first register.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Login</title>
    <style>
       
        body {
            font-family: 'Segoe UI', sans-serif;
            background: url("f3.jpg") no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            width: 350px;
            padding: 25px;
            background: rgba(94, 9, 9, 0.95);
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(255, 140, 0, 0.5);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .login-box h2 {
            margin-bottom: 20px;
            color: #ff6600;
            text-shadow: 1px 1px 2px #ffcba4;
        }
        input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #ff6600;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }
        button {
            width: 95%;
            padding: 12px;
            margin-top: 15px;
            background: linear-gradient(90deg, #ff6600, #ff9900);
            border: none;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 8px;
            cursor: pointer;
        }
        .error {
            color: #ffeb3b;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .signup-link {
            margin-top: 15px;
            color: white;
            font-size: 0.9em;
        }
        a {
            color: #ff6600;
            text-decoration: none;
            font-weight: bold;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Customer Login</h2>
    <?php if (!empty($message)) echo "<p class='error'>$message</p>"; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Enter Email / Name" required>
        <input type="password" name="address" placeholder="Enter Password" required>
        <button type="submit">Login</button>
    </form>
    
    <div class="signup-link">
        Don't have an account? <br>
        <a href="customer_register.php">Do you want to login? (Register)</a>
    </div>
    
    <a href="login_choice.php">⬅ Back</a>
</div>
</body>
</html>