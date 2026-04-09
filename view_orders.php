<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

// Database Connection
$connection = new mysqli("localhost", "root", "", "cafe", 3307);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// --- UPDATED QUERY (Joining via o_id) ---
// Humne JOIN use kiya hai taake order_bill ka o_id, order_detail ke o_id se match kare
$sql = "SELECT 
            b.bill_id, 
            b.bill_time, 
            b.bill_amount, 
            od.o_qty, 
            rc.r_name, 
            lc.l_name 
        FROM order_bill b
        LEFT JOIN order_detail od ON b.o_id = od.o_id
        LEFT JOIN registered_customer rc ON od.r_id = rc.r_id
        LEFT JOIN local_customer lc ON od.l_id = lc.l_id
        GROUP BY b.bill_id
        ORDER BY b.bill_time DESC";

$result = $connection->query($sql);

if (!$result) {
    die("❌ SQL Error: " . $connection->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Orders History</title>
    <style>
        /* Aapka Original Design */
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: url('f3.jpg') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
            color: #4d2600;
        }
        .container {
            width: 90%;
            margin: auto;
            background-color: #f9f1e7cc;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(204, 102, 0, 0.3);
        }
        h2 { text-align: center; color: #cc6600; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #cc6600; padding: 12px; text-align: center; }
        th { background-color: #cc6600; color: white; }
        tr:nth-child(even) { background-color: #fff; }
        .btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #cc6600;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn:hover { background: #b35a00; }
    </style>
</head>
<body>

<div class="container">
    <h2>Customer Orders History</h2>
    
    <table>
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Customer Name</th>
                <th>Quantity</th>
                <th>Total Bill</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { 
                    // Customer Name Logic (Registered or Local) - Keeping your logic
                    $c_name = "Guest / Unknown";
                    $c_type = "";
                    
                    if (!empty($row['r_name'])) {
                        $c_name = $row['r_name'];
                        $c_type = "(Reg ID: " . $row['r_id'] . ")";
                    } elseif (!empty($row['l_name'])) {
                        $c_name = $row['l_name'];
                        $c_type = "(Local ID: " . $row['l_id'] . ")";
                    }
            ?>
                <tr>
                    <td>#<?php echo $row['bill_id']; ?></td>
                    <td>
                        <strong><?php echo htmlspecialchars($c_name); ?></strong><br>
                        <small><?php echo $c_type; ?></small>
                    </td>
                    <td><?php echo $row['o_qty']; ?> Items</td>
                    <td>$<?php echo number_format($row['bill_amount'], 2); ?></td>
                    <td><?php echo date("d-M-Y h:i A", strtotime($row['bill_time'])); ?></td>
                </tr>
            <?php 
                } 
            } else {
                echo "<tr><td colspan='5'>No orders found. Naya order place karke check karein.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn">← Back to Dashboard</a>
</div>

</body>
</html>