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

// Fetch current data of item
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price_small = floatval($_POST['price_small']);
    $price_medium = floatval($_POST['price_medium']);
    $price_large = floatval($_POST['price_large']);

    // Handle image upload (optional)
    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES["image"]["name"]);
        $target_path = "first/" . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_path);
    } else {
        $image_name = $item['f_image'];
    }

    $update_sql = "UPDATE food_item SET f_name = ?, f_description = ?, f_price_small = ?, f_price_medium = ?, f_price_large = ?, f_image = ? WHERE f_id = ?";
    $update_stmt = $connection->prepare($update_sql);
    $update_stmt->bind_param("ssdddsi", $name, $description, $price_small, $price_medium, $price_large, $image_name, $id);

    if ($update_stmt->execute()) {
        header("Location: dashboard.php?msg=updated");
        exit();
    } else {
        $error = "Something went wrong. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Food Item</title>
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
            margin-bottom: 20px;
            text-shadow: 1px 1px #ffffff;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 2px solid #cc6600;
            border-radius: 8px;
            outline: none;
        }
        input[type="file"] {
            border: none;
        }
        button {
            background-color: #cc6600;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 15px;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }
        button:hover {
            background-color: #b35900;
        }
        .back-link {
            display: inline-block;
            margin-top: 15px;
            text-align: center;
            color: #cc6600;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        img.preview {
            margin-top: 10px;
            width: 100px;
            height: auto;
            border-radius: 6px;
            border: 1px solid #cc6600;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Edit Food Item</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Food Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($item['f_name']); ?>" required>

        <label>Description</label>
        <textarea name="description" rows="4" required><?php echo htmlspecialchars($item['f_description']); ?></textarea>

        <label>Price - Small ($)</label>
        <input type="number" step="0.01" name="price_small" value="<?php echo htmlspecialchars($item['f_price_small']); ?>" required>

        <label>Price - Medium ($)</label>
        <input type="number" step="0.01" name="price_medium" value="<?php echo htmlspecialchars($item['f_price_medium']); ?>" required>

        <label>Price - Large ($)</label>
        <input type="number" step="0.01" name="price_large" value="<?php echo htmlspecialchars($item['f_price_large']); ?>" required>

        <label>Current Image</label><br>
        <img src="<?php echo htmlspecialchars($item['f_image']); ?>" alt="Current Image" class="preview"><br>

        <label>Change Image (Optional)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Update Item</button>
    </form>

    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
