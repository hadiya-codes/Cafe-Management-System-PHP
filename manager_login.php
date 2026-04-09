<?php
include 'db_connect.php';
session_start();
$connection = new mysqli("localhost", "root", "", "cafe",3307);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM manager WHERE m_email = ? AND m_password = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['manager_id'] = $row['m_id'];
        $_SESSION['manager_name'] = $row['m_name'];
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "❌ Invalid Email or Password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin / Manager Login</title>
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
        input:focus {
            border-color: #ff3300;
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.6);
        }
        button {
            width: 95%;
            padding: 12px;
            margin-top: 15px;
            background: linear-gradient(90deg, #ff6600, #ff9900);
            border: none;
            color: white;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(255, 102, 0, 0.4);
        }
        button:hover {
            background: linear-gradient(90deg, #ff5500, #ff8800);
            box-shadow: 0 8px 20px rgba(255, 85, 0, 0.6);
            transform: translateY(-2px);
        }
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
        a {
            display: inline-block;
            margin-top: 15px;
            color: #ff6600;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Admin / Manager Login</h2>
    <?php if (!empty($message)) echo "<p class='error'>$message</p>"; ?>
    <form action="" method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Login</button>
    </form>
    <a href="login_choice.php">⬅ Back</a>
</div>
</body>
</html>
