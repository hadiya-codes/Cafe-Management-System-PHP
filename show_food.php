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

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch item by ID
$sql = "SELECT * FROM food_item WHERE f_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: dashboard.php");
    exit();
}

$item = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Food Item</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: url('f3.jpg') no-repeat center center fixed;
            background-size: cover;
            padding: 50px;
            color: #4d2600;
        }
        .details-box {
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
        .info {
            margin-bottom: 15px;
        }
        .info label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #cc6600;
        }
        .info span {
            display: block;
            background: #fff;
            padding: 10px;
            border: 1px solid #cc6600;
            border-radius: 8px;
        }
        img.preview {
            margin-top: 10px;
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            border-radius: 6px;
            border: 1px solid #cc6600;
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

<div class="details-box">
    <h2>Food Item Details</h2>

    <div class="info">
        <label>Name:</label>
        <span><?php echo htmlspecialchars($item['f_name']); ?></span>
    </div>

    <div class="info">
        <label>Description:</label>
        <span><?php echo htmlspecialchars($item['f_description']); ?></span>
    </div>

    <div class="info">
        <label>Price (Small) $:</label>
        <span><?php echo number_format($item['f_price_small'], 2); ?></span>
    </div>

    <div class="info">
        <label>Price (Medium) $:</label>
        <span><?php echo number_format($item['f_price_medium'], 2); ?></span>
    </div>

    <div class="info">
        <label>Price (Large) $:</label>
        <span><?php echo number_format($item['f_price_large'], 2); ?></span>
    </div>

    <div class="info">
        <label>Image:</label>
        <img src="<?php echo htmlspecialchars($item['f_image']); ?>" alt="Food Image" class="preview">
    </div>

    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
