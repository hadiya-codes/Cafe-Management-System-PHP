<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    // ID nahi mil rahi toh dashboard pe wapas bhej do
    header("Location: dashboard.php");
    exit();
}

$connection = new mysqli("localhost", "root", "", "cafe", 3307);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$id = intval($_GET['id']);

// Pehle item ki image file delete karni hai agar aap image bhi delete karna chahte ho:
$sql_img = "SELECT f_image FROM food_item WHERE f_id = ?";
$stmt_img = $connection->prepare($sql_img);
$stmt_img->bind_param("i", $id);
$stmt_img->execute();
$result_img = $stmt_img->get_result();

if ($result_img->num_rows > 0) {
    $row = $result_img->fetch_assoc();
    $image_path = "first/" . $row['f_image'];
    if (file_exists($image_path)) {
        unlink($image_path); // image file delete karo
    }
}

$stmt_img->close();

// Ab item database se delete karo
$sql_delete = "DELETE FROM food_item WHERE f_id = ?";
$stmt_delete = $connection->prepare($sql_delete);
$stmt_delete->bind_param("i", $id);

if ($stmt_delete->execute()) {
    // Success: dashboard pe redirect karo
    header("Location: dashboard.php?msg=deleted");
} else {
    // Fail: error message ke sath wapas
    header("Location: dashboard.php?msg=error");
}

$stmt_delete->close();
$connection->close();
exit();
?>
