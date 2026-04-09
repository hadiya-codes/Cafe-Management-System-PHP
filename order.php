<?php
include 'db_connect.php';
// Errors ko screen par dikhane ke liye
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set("Asia/Karachi");
$connection = new mysqli("localhost", "root", "", "cafe", 3307);

if ($connection->connect_error) { die("Connection failed: " . $connection->connect_error); }

$cart = json_decode($_POST['cart_json'] ?? '[]', true);
$name = $_POST['name'] ?? 'Customer';
$contact = $_POST['contact'] ?? '';
$address = $_POST['address'] ?? '';
$customerType = $_POST['customer_type'] ?? 'local';
$time = date("Y-m-d H:i:s");

if (empty($cart)) { die("Error: Cart is empty!"); }

// 1. Customer Insert
$l_id = null; $r_id = null;
if ($customerType === "registered") {
    $q = "INSERT INTO registered_customer (r_name, r_phoneNo, r_address, register_date) VALUES ('$name', '$contact', '$address', NOW())";
    $connection->query($q);
    $r_id = $connection->insert_id;
} else {
    $q = "INSERT INTO local_customer (l_name, l_phoneNo, l_address) VALUES ('$name', '$contact', '$address')";
    $connection->query($q);
    $l_id = $connection->insert_id;
}

// 2. Process Cart Items
$subTotal = 0;
$itemsRows = "";
$last_order_id = 0;

foreach ($cart as $item) {
    $p_name = $item['pizza'];
    $p_size = $item['size'];
    $p_qty  = (int)$item['qty'];

    $res = $connection->query("SELECT f_id, f_price_small, f_price_medium, f_price_large FROM food_item WHERE f_name = '$p_name'");
    $row = $res->fetch_assoc();
    if (!$row) continue;

    $f_id = $row['f_id'];
    $u_price = ($p_size == "Small") ? $row['f_price_small'] : (($p_size == "Large") ? $row['f_price_large'] : $row['f_price_medium']);
    $line_total = $u_price * $p_qty;
    $subTotal += $line_total;

    // Direct Insert (No prepared statements for testing)
    $l_id_val = $l_id ? $l_id : "NULL";
    $r_id_val = $r_id ? $r_id : "NULL";
    
    $sql_od = "INSERT INTO order_detail (o_qty, l_id, r_id, f_id) VALUES ($p_qty, $l_id_val, $r_id_val, $f_id)";
    if (!$connection->query($sql_od)) {
        die("Order Detail Table Update Fail: " . $connection->error);
    }
    $last_order_id = $connection->insert_id;
    $itemsRows .= "<tr><td>$p_name ($p_size)</td><td>$p_qty</td><td>$" . number_format($line_total, 2) . "</td></tr>";
}

$tax = $subTotal * 0.10;
$grandTotal = $subTotal + $tax;

// 3. Final Bill Insert
$sql_bill = "INSERT INTO order_bill (o_id, bill_amount, bill_tax, bill_time) VALUES ($last_order_id, $grandTotal, $tax, '$time')";

if (!$connection->query($sql_bill)) {
    die("Order Bill Table Update Fail: " . $connection->error);
}

// Agar yahan tak code pohancha hai, iska matlab hai database update ho gaya!
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body { background: url('f3.jpg') no-repeat center center fixed; background-size: cover; font-family: 'Segoe UI', sans-serif; margin: 0; padding-top: 100px; }
        .receipt { background: #fff; width: 500px; margin: auto; padding: 35px; border-radius: 15px; border-top: 10px solid #FF7200; box-shadow: 0 10px 40px rgba(0,0,0,0.6); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
        .grand { font-size: 24px; color: #FF7200; font-weight: bold; text-align: right; margin-top: 20px; }
        .btn { display: block; text-align: center; background: #333; color: white; padding: 15px; text-decoration: none; border-radius: 8px; margin-top: 25px; }
    </style>
</head>
<body>
    <div class="receipt">
        <h2 style="text-align:center;">Order History Updated! ✅</h2>
        <p><strong>Customer:</strong> <?php echo htmlspecialchars($name); ?></p>
        <table>
            <tr><th>Item</th><th>Qty</th><th>Total</th></tr>
            <?php echo $itemsRows; ?>
        </table>
        <div class="grand">Grand Total: $<?php echo number_format($grandTotal, 2); ?></div>
        <a href="menu.php" class="btn">Back to Home</a>
    </div>
</body>
</html>