<?php
include 'db_connect.php';
// Database connection variables
$servername = "localhost";
$username = "root";
$password = "root"; // Aap ke system ka password
$dbname = "cafe";

// Connection banana
$conn = new mysqli($servername, $username, $password, $dbname);

// Connection check karna
if ($conn->connect_error) {
    // Agar connection fail ho jaye to error show kare
    die("Database Connection Failed: " . $conn->connect_error);
}

// Global variable set karna taake har jagah use ho sakay
// echo "Connected successfully"; // Is line ko sirf check karne ke liye un-comment karein
?>