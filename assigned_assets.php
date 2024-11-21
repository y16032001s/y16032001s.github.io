
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

// Fetch assets assigned to "Dibyansha"
$sql = "SELECT assetdetails.id, assetdetails.dateOfPurchase, assetdetails.dateOfExpiry, assetdetails.serviceTag, assetdetails.assetTag, product.productType, manufacturer.name
        FROM assetdetails
        INNER JOIN allocation ON assetdetails.id = allocation.assetId
        INNER JOIN users ON allocation.userId = users.id
        INNER JOIN product ON assetdetails.productType = product.id
        INNER JOIN manufacturer ON assetdetails.manufacturer = manufacturer.id
        WHERE users.name = 'Dibyansha'";
$result = $connection->query($sql);

$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Assets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php require "./menu.php"; ?>
<div class="container">
    <h2>Assets Assigned to Dibyansha</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date of Purchase</th>
                <th>Date of Expiry</th>
                <th>Service Tag</th>
                <th>Asset Tag</th>
                <th>Product Type</th>
                <th>Manufacturer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["dateOfPurchase"] . "</td>";
                    echo "<td>" . $row["dateOfExpiry"] . "</td>";
                    echo "<td>" . $row["serviceTag"] . "</td>";
                    echo "<td>" . $row["assetTag"] . "</td>";
                    echo "<td>" . $row["productType"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No assets assigned to Dibyansha.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
