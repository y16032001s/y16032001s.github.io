<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:./logindecorated.php");
    exit;
}

$servername = "localhost";
$username = "dbuser";
$password = "agrawal@2002";
$dbname = "inventorymanagement";
$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch some key data metrics
$asset_count_result = $connection->query("SELECT COUNT(*) as count FROM assetdetails");
$asset_count = $asset_count_result->fetch_assoc()['count'];

$manufacturer_count_result = $connection->query("SELECT COUNT(*) as count FROM manufacturer");
$manufacturer_count = $manufacturer_count_result->fetch_assoc()['count'];

$product_count_result = $connection->query("SELECT COUNT(*) as count FROM product");
$product_count = $product_count_result->fetch_assoc()['count'];

$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .nav {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background-color: #333;
            color: white;
        }
        .nav .menu {
            display: flex;
        }
        .nav .menu a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
        }
        .nav .menu a:hover {
            background-color: #ddd;
            color: black;
        }
        .nav .logout {
            padding: 14px 20px;
        }
        .nav .logout a {
            color: white;
            text-decoration: none;
        }
        .nav .logout a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .content {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .card {
            flex: 1;
            margin: 0 10px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        .card h3 {
            margin: 0 0 10px;
        }
        .card p {
            font-size: 24px;
            color: #333;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Welcome to the Inventory Management System</h1>
</div>

<div class="nav">
    <div class="menu">
        <a href="homepage.php">Home</a>
        <a href="assetdetailsform.php">Add Asset</a>
        <a href="assetallocationform.php">Allocate Asset</a>
        <a href="inventory.php">View Inventory</a>
    </div>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Overview</h2>
    <div class="content">
        <div class="card">
            <h3>Total Assets</h3>
            <p><?php echo $asset_count; ?></p>
        </div>
        <div class="card">
            <h3>Total Manufacturers</h3>
            <p><?php echo $manufacturer_count; ?></p>
        </div>
        <div class="card">
            <h3>Total Products</h3>
            <p><?php echo $product_count; ?></p>
        </div>
    </div>
</div>

<div class="footer">
    <p>Inventory Management System &copy; 2024</p>
</div>

</body>
</html>
