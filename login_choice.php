<!DOCTYPE html>
<html>
<head>
    <title>Login Choice</title>
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
        .container {
            width: 400px;
            padding: 25px;
            background: rgba(94, 9, 9, 0.95);
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(255, 140, 0, 0.5);
            text-align: center;
        }
        h1 {
            color: #ff6600;
            margin-bottom: 10px;
        }
        h3 {
            color: #ffcba4;
            margin-bottom: 20px;
        }
        .btn {
            width: 85%;
            padding: 12px;
            margin: 10px 0;
            background: linear-gradient(90deg, #ff6600, #ff9900);
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Cafe Management System</h1>
        <h3>Select Login Type</h3>

        <a href="menu.php">
            <button class="btn">Local Customer</button>
        </a>

        <a href="customer_login.php">
            <button class="btn">Registered Customer</button>
        </a>

        <a href="manager_login.php">
            <button class="btn">Login as Admin</button>
        </a>

    </div>
</body>
</html>
