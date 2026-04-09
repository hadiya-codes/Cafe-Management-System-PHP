<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

$connection = new mysqli("localhost", "root", "", "cafe",3307);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['f_name']);
    $description = trim($_POST['f_description']);
    $price_small = floatval($_POST['f_price_small']);
    $price_medium = floatval($_POST['f_price_medium']);
    $price_large = floatval($_POST['f_price_large']);
    $image = trim($_POST['f_image']); // image path

    if (!empty($name) && !empty($description) && !empty($image) &&
        $price_small > 0 && $price_medium > 0 && $price_large > 0) {

        $stmt = $connection->prepare("INSERT INTO food_item (f_name, f_description, f_price_small, f_price_medium, f_price_large, f_image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddds", $name, $description, $price_small, $price_medium, $price_large, $image);

        if ($stmt->execute()) {
            $message = "✅ Food item added successfully!";
        } else {
            $message = "❌ Error adding item.";
        }
    } else {
        $message = "❌ All fields are required and prices must be greater than 0.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Food Item</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: url('f3.jpg') no-repeat center center fixed;
            background-size: cover;
            padding: 50px;
            color: #4d2600;
        }
        .form-box {
            max-width: 500px;
            background: #fff5e6cc;
            margin: auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(204, 102, 0, 0.4);
        }
        h2 {
            text-align: center;
            color: #cc6600;
            margin-bottom: 25px;
            text-shadow: 1px 1px #ffffff;
        }
        label {
            font-weight: bold;
            color: #cc6600;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #cc6600;
            background-color: #fff;
        }
        button {
            background-color: #cc6600;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
        }
        button:hover {
            background-color: #b35900;
        }
        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
            color: #b30000;
        }
        .success {
            color: green;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #cc6600;
            font-weight: bold;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Add New Food Item</h2>

    <?php if (!empty($message)) { ?>
        <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : ''; ?>">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <form method="POST">
        <label>Food Name:</label>
        <input type="text" name="f_name" required>

        <label>Description:</label>
        <textarea name="f_description" rows="3" required></textarea>

        <label>Price (Small) $:</label>
        <input type="number" name="f_price_small" min="0.01" step="0.01" required>

        <label>Price (Medium) $:</label>
        <input type="number" name="f_price_medium" min="0.01" step="0.01" required>

        <label>Price (Large) $:</label>
        <input type="number" name="f_price_large" min="0.01" step="0.01" required>

        <label>Image File Name (with extension):</label>
        <input type="text" name="f_image" placeholder="e.g., burger.jpg" required>

        <button type="submit">Add Item</button>
    </form>

    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
