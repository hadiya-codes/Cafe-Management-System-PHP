<?php
include 'db_connect.php';
session_start(); // Session start karna achi practice hai

// Database connection (Port 3307)
$connection = new mysqli("localhost", "root", "", "cafe",3307);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch all food items
$sql = "SELECT * FROM food_item";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menu Bar</title>
  <link rel="stylesheet" href="Nav.css">
  <link rel="stylesheet" href="Menu.css">
  <style>
    .logout-btn {
      float: right;
      margin-right: 30px;
      margin-top: -45px;
    }
    .logout-btn a {
      background-color: #FF7200;
      color: white;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: 0.3s;
    }
    .logout-btn a:hover {
      background-color: #e56200;
    }
  </style>
</head>
<body>

<nav>
  <label class="logo"><sup>Cheese</sup>Pizza<sub>Crust</sub></label>
  <ul>
    <li><a href="Cafe.html">Home</a></li>
    <li><a class="active" href="menu.php">Menu</a></li>
    <li><a href="About.html">About</a></li>
    <li><a href="contact.html">Contact</a></li>
    <li><a href="orders.php" id="order">Order Online</a></li>
  </ul>
</nav>

<div class="logout-btn">
  <a href="login_choice.php">Logout</a>
</div>

<h1 class="h1">Menu Page</h1>

<section>
  <div class="row">
    <?php
    $count = 0;
    while ($row = $result->fetch_assoc()) {
      if ($count % 3 == 0 && $count != 0) {
          echo '</div><div class="row">';
      }
      ?>
      <div class="column">
        <div class="card">
          <img id="img" src="<?php echo htmlspecialchars($row['f_image']); ?>" style="width:100%;">
          <div class="container">
            <h2 style="margin-top: 10px;"><?php echo htmlspecialchars($row['f_name']); ?></h2>
            <p class="p1" style="margin: 10px;"><?php echo htmlspecialchars($row['f_description']); ?></p>

            <h2>Price:</h2>
            <p>Small: $<?php echo number_format($row['f_price_small'], 2); ?></p>
            <p>Medium: $<?php echo number_format($row['f_price_medium'], 2); ?></p>
            <p>Large: $<?php echo number_format($row['f_price_large'], 2); ?></p>

          </div>
        </div>
      </div>
      <?php
      $count++;
    }
    ?>
  </div>
</section>

<div>
  <center>
    <a href="orders.php" style="text-decoration: none;">
        <button style="color: white; background-color: #FF7200; padding: 10px 20px; border-radius: 20px; margin-top: 10px; border: none; outline: none; opacity: 0.9; cursor: pointer; font-size: 16px;">
            Order Online
        </button>
    </a>
  </center>
</div>

</body>
</html>