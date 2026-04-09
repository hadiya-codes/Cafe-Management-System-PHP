<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

// Database Connection (Port 3307 specify kiya hai jaisa aapne pichle codes mein bheja tha)
$connection = new mysqli("localhost", "root", "", "cafe",3307);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get total food items count
$sql = "SELECT COUNT(*) as total FROM food_item";
$result = $connection->query($sql);
$row = $result->fetch_assoc();
$total_items = $row['total'];

// Fetch all food items in ascending order
$sql_items = "SELECT * FROM food_item ORDER BY f_id ASC";
$result_items = $connection->query($sql_items);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background: url('f3.jpg') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
            color: #4d2600;
        }
        h1 {
            color: #cc6600;
            margin-bottom: 10px;
            text-shadow: 1px 1px 2px #aa5500;
        }
        .logout {
            float: right;
            margin-top: -40px;
        }
        .logout a {
            text-decoration: none;
            color: #cc3300;
            font-weight: bold;
            border: 2px solid #cc3300;
            padding: 6px 12px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .logout a:hover {
            background-color: #cc3300;
            color: white;
        }
        .count-box {
            background-color: #cc6600cc;
            color: white;
            font-weight: bold;
            padding: 15px;
            border-radius: 12px;
            width: 220px;
            text-align: center;
            margin-bottom: 25px;
            font-size: 20px;
            box-shadow: 0 0 8px #cc6600cc;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 1000px;
            margin-bottom: 40px;
            background-color: #f9f1e7cc;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(204, 102, 0, 0.3);
            overflow: hidden;
        }
        th, td {
            border: 1px solid #cc6600;
            padding: 12px 15px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #cc6600;
            color: white;
            font-weight: bold;
        }
        img.food-img {
            width: 80px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #cc6600;
            box-shadow: 0 0 6px #cc6600cc;
        }
        .btn {
            background-color: #cc6600;
            border: none;
            color: white;
            padding: 7px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
            text-decoration: none;
            margin: 0 4px;
            display: inline-block;
        }
        .btn:hover {
            background-color: #b35a00;
            box-shadow: 0 0 8px #b35a00cc;
        }
        .actions {
            white-space: nowrap;
        }
        .add-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1>Welcome, <?php echo htmlspecialchars($_SESSION['manager_name']); ?>!</h1>
<div class="logout">
    <a href="login_choice.php">Logout</a>
</div>

<div class="count-box">
    Total Food Items: <?php echo $total_items; ?>
</div>

<div class="add-btn">
    <a href="add_food.php" class="btn">+ Add New Food Item</a>
    <a href="view_requests.php" class="btn">View Late Payment Requests</a>
    <a href="view_orders.php" class="btn">View Full Orders History</a>
</div>

<table>
    <thead>
        <tr>
            <th>Food ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price (Small)</th>
            <th>Price (Medium)</th>
            <th>Price (Large)</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($food = $result_items->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $food['f_id']; ?></td>
                <td><?php echo htmlspecialchars($food['f_name']); ?></td>
                <td><?php echo htmlspecialchars($food['f_description']); ?></td>
                <td><?php echo number_format($food['f_price_small'], 2); ?></td>
                <td><?php echo number_format($food['f_price_medium'], 2); ?></td>
                <td><?php echo number_format($food['f_price_large'], 2); ?></td>
                <td>
                    <img class="food-img" src="<?php echo htmlspecialchars($food['f_image']); ?>" alt="Food Image">
                </td>
                <td class="actions">
                    <a href="show_food.php?id=<?php echo $food['f_id']; ?>" class="btn">Show</a>
                    <a href="edit_food.php?id=<?php echo $food['f_id']; ?>" class="btn">Edit</a>
                    <a href="del.php?id=<?php echo $food['f_id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn">Delete</a>
                </td>
            </tr>
        <?php } ?> 
    </tbody>
</table>

<div>
    <a href="menu.php" class="btn">View Menu Page</a>
</div>

</body>
</html>