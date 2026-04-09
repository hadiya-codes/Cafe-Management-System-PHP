<?php
include 'db_connect.php';
date_default_timezone_set("Asia/Karachi");

$connection = new mysqli("localhost", "root", "", "cafe",3307);
if ($connection->connect_error) {
  die("Connection failed: " . $connection->connect_error);
}

// STEP 1: Get form data
$name     = $_POST['rname'];
$contact  = $_POST['rcontact'];
$address  = $_POST['raddress'];
$pizza    = $_POST['pizza-type'];
$size     = $_POST['size'];
$quantity = $_POST['quantity'];
$payment  = $_POST['payment'];
$time     = date("Y-m-d H:i:s");

// STEP 2: Insert into registered_customer
$stmt = $connection->prepare("INSERT INTO registered_customer (r_name, r_phoneNo, r_address, register_date) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sss", $name, $contact, $address);
$stmt->execute();
$registeredCustomerId = $connection->insert_id;
$stmt->close();

// STEP 3: Get price from DB according to size
$query = "SELECT f_id, f_price_small, f_price_medium, f_price_large FROM food_item WHERE f_name = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $pizza);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $foodId = $row['f_id'];

    if ($size == "Small") {
        $unit_price = floatval($row['f_price_small']);
    } elseif ($size == "Medium") {
        $unit_price = floatval($row['f_price_medium']);
    } elseif ($size == "Large") {
        $unit_price = floatval($row['f_price_large']);
    } else {
        // Default to Medium if size not matched
        $unit_price = floatval($row['f_price_medium']);
    }
} else {
    $foodId = null;
    $unit_price = 0;
}
$stmt->close();

$price = $unit_price * $quantity;
$tax = $price * 0.10;
$total = $price + $tax;

// STEP 4: Insert into order_detail
$stmt = $connection->prepare("INSERT INTO order_detail (o_qty, r_id) VALUES (?, ?)");
$stmt->bind_param("ii", $quantity, $registeredCustomerId);
$stmt->execute();
$orderId = $connection->insert_id;
$stmt->close();

// STEP 5: Insert into order_bill
$stmt = $connection->prepare("INSERT INTO order_bill (bill_amount, bill_tax, bill_time, o_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ddsi", $price, $tax, $time, $orderId);
$stmt->execute();
$billId = $connection->insert_id;
$stmt->close();

// STEP 6: Insert into payment
$stmt = $connection->prepare("INSERT INTO payment (amount_paid, p_method, p_time, bill_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("dssi", $total, $payment, $time, $billId);
$stmt->execute();
$stmt->close();

// STEP 7: Insert into request table (if needed)
$stmt = $connection->prepare("INSERT INTO request (r_amount, r_time, registered_id) VALUES (?, ?, ?)");
$stmt->bind_param("dsi", $total, $time, $registeredCustomerId);
$stmt->execute();
$stmt->close();

// SUCCESS MESSAGE
echo "
<link rel='stylesheet' href='order.css'>
<div class='container'>
  <h2 style='color:green;'>Order Placed Successfully!</h2>
  <h3>Here are your order details:</h3>
  <div class='group'>
    <label>Name:</label> " . htmlspecialchars($name) . "<br>
    <label>Contact:</label> " . htmlspecialchars($contact) . "<br>
    <label>Address:</label> " . htmlspecialchars($address) . "<br>
    <label>Pizza:</label> " . htmlspecialchars($pizza) . "<br>
    <label>Size:</label> " . htmlspecialchars($size) . "<br>
    <label>Quantity:</label> " . htmlspecialchars($quantity) . "<br>
    <label>Payment:</label> " . htmlspecialchars($payment) . "<br>
    <label>Unit Price:</label> $" . number_format($unit_price, 2) . "<br>
    <label>Total Price:</label> $" . number_format($price, 2) . "<br>
    <label>Tax (10%):</label> $" . number_format($tax, 2) . "<br>
    <label>Final Total:</label> $" . number_format($total, 2) . "<br>
  </div>
  <a href='Cafe.html' style='color:blue;'>Back to Home</a>
</div>
";

$connection->close();
?>
