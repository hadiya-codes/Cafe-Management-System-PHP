<?php
include 'db_connect.php';
session_start();
$connection = new mysqli("localhost", "root", "", "cafe", 3307);
if ($connection->connect_error) { die("Connection failed: " . $connection->connect_error); }

$foodItems = [];
$result = $connection->query("SELECT f_name FROM food_item");
if ($result) { while ($row = $result->fetch_assoc()) { $foodItems[] = $row['f_name']; } }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Online - CheesePizzaCrust</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
            background: url('f3.jpg') no-repeat center center fixed; 
            background-size: cover; margin: 0; padding-top: 100px; 
        }
        /* Professional Navbar matching your Menu Page */
        .navbar {
            position: fixed; top: 0; width: 100%; background: #000;
            padding: 10px 0; display: flex; justify-content: space-around;
            align-items: center; z-index: 1000; box-shadow: 0 4px 10px rgba(0,0,0,0.5);
        }
        .logo { color: #FF7200; font-size: 24px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .logo span { color: #fff; }
        .nav-links a { color: white; text-decoration: none; font-weight: 500; margin: 0 15px; transition: 0.3s; }
        .nav-links a:hover { color: #FF7200; }
        .logout-btn { 
            background: #FF7200; color: white !important; padding: 8px 20px; 
            border-radius: 5px; font-weight: bold; 
        }
        .logout-btn:hover { background: #e66600; }

        .container { 
            max-width: 900px; margin: 20px auto; background: rgba(255, 255, 255, 0.98); 
            padding: 30px; border-radius: 15px; box-shadow: 0 0 30px rgba(0,0,0,0.6);
        }
        h2 { text-align: center; color: #333; border-bottom: 2px solid #FF7200; padding-bottom: 10px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        label { font-weight: bold; color: #444; }
        input, select, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px; }
        
        .cart-box { background: #fff; border: 2px solid #FF7200; padding: 15px; border-radius: 10px; margin: 20px 0; }
        #cartTable { width: 100%; border-collapse: collapse; }
        #cartTable th { background: #333; color: white; padding: 12px; }
        #cartTable td { border-bottom: 1px solid #eee; padding: 10px; text-align: center; }

        .btn-orange { background: #FF7200; color: white; padding: 12px; border: none; cursor: pointer; width: 100%; font-weight: bold; border-radius: 8px; margin: 10px 0; }
        #map { height: 350px; border: 2px solid #FF7200; border-radius: 10px; margin-top: 10px; }
        .confirm-btn { background: #222; color: white; padding: 18px; width: 100%; font-size: 20px; cursor: pointer; border-radius: 10px; border: none; font-weight: bold; transition: 0.3s; }
        .confirm-btn:hover { background: #FF7200; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">Cheese<span>Pizza</span>Crust</div>
        <div class="nav-links">
            <a href="menu.php">Home</a>
            <a href="menu.php" style="color: #FF7200;">Menu</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h2>🍕 Place Your Variety Order</h2>
        <form action="order.php" method="POST" id="orderForm">
            <div class="form-grid">
                <div>
                    <label>Customer Type:</label>
                    <select name="customer_type" id="c_type" onchange="toggleLate()">
                        <option value="local">Local Customer</option>
                        <option value="registered">Registered Customer</option>
                    </select>
                    <input type="text" name="name" placeholder="Full Name" required style="margin-top:15px;">
                    <input type="tel" name="contact" placeholder="Phone (e.g. 03001234567)" required style="margin-top:15px;">
                </div>
                <div style="background: #fdf2e9; padding: 20px; border-radius: 10px; border: 1px solid #FF7200;">
                    <label>Select Your Food:</label>
                    <select id="t_pizza">
                        <?php foreach($foodItems as $f) echo "<option value='".htmlspecialchars($f)."'>".htmlspecialchars($f)."</option>"; ?>
                    </select>
                    <select id="t_size" style="margin-top:10px;">
                        <option value="Small">Small</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="Large">Large</option>
                    </select>
                    <input type="number" id="t_qty" value="1" min="1" style="margin-top:10px;">
                    <button type="button" class="btn-orange" onclick="addToCart()">➕ Add to Order</button>
                </div>
            </div>

            <div class="cart-box">
                <table id="cartTable">
                    <thead><tr><th>Item Name</th><th>Size</th><th>Qty</th><th>Action</th></tr></thead>
                    <tbody id="cartBody"></tbody>
                </table>
                <input type="hidden" name="cart_json" id="cart_json">
            </div>

            <label>📍 Delivery Address:</label>
            <button type="button" class="btn-orange" onclick="getLocation()" style="background:#333;">🎯 Detect My Current Location</button>
            <div id="map"></div>
            <input type="text" name="address" id="address" placeholder="Type address here if map is slow..." required style="border: 2px solid #FF7200; font-size: 16px;">

            <div id="latePay" style="display:none; margin-top:20px; border-left: 5px solid #FF7200; padding-left: 15px; background: #fff5eb;">
                <label>Request Late Payment Date:</label>
                <input type="date" name="delay_date">
                <textarea name="delay_reason" placeholder="Why do you need a delay?"></textarea>
            </div>

            <div style="margin: 25px 0;">
                <label>Payment Mode: </label>
                <input type="radio" name="payment" value="Cash" checked> Cash on Delivery 
                <input type="radio" name="payment" value="Card" style="margin-left:20px;"> Online Card
            </div>

            <button type="submit" class="confirm-btn">✅ Confirm & Send Order</button>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let cart = [];
        function addToCart() {
            let item = { pizza: document.getElementById('t_pizza').value, size: document.getElementById('t_size').value, qty: document.getElementById('t_qty').value };
            cart.push(item); render();
        }
        function render() {
            let b = document.getElementById('cartBody'); b.innerHTML = "";
            cart.forEach((i, x) => { b.innerHTML += `<tr><td>${i.pizza}</td><td>${i.size}</td><td>${i.qty}</td><td><button type='button' onclick='rem(${x})' style='border:none; background:none; cursor:pointer; font-size:18px;'>❌</button></td></tr>`; });
            document.getElementById('cart_json').value = JSON.stringify(cart);
        }
        function rem(x) { cart.splice(x, 1); render(); }
        function toggleLate() { document.getElementById('latePay').style.display = (document.getElementById('c_type').value === 'registered') ? 'block' : 'none'; }

        var map = L.map('map').setView([32.2036, 74.1930], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        var marker = L.marker([32.2036, 74.1930], {draggable: true}).addTo(map);

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((p) => {
                    let lat = p.coords.latitude, lng = p.coords.longitude;
                    map.flyTo([lat, lng], 17); marker.setLatLng([lat, lng]);
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`).then(r => r.json()).then(d => document.getElementById('address').value = d.display_name);
                });
            }
        }
    </script>
</body>
</html>