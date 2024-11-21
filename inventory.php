<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location:./logindecorated.php");
	exit;
}
	
?>
<!DOCTYPE html>
<html>
<head>
    <style>
body {
    font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        table {
    width: 100%;
    border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
    padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
    background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
background-color: #f9f9f9;
        }
        tr:hover {
    background-color: #f1f1f1;
        }
        .container {
    max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
    text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
<?php
require "./menu.php";
?>

<div class="container">
    <h2>Asset Allocation Table</h2>
<?php

$servername = "localhost";
$username = "dbuser";
$password = "agrawal@2002";
$dbname = "inventorymanagement";
$connection= new mysqli($servername, $username, $password,$dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql= "SELECT 
P.productType AS product_type, 
M.name AS brand,
E.emID AS employee_id,
E.firstname AS employee_first_name,
E.lastname AS employee_last_name,
AD.assetTag AS asset_tag,
AD.serviceTag AS service_tag
FROM `assetallocation` AA 
INNER JOIN `assetdetails` AD ON AA.assetID = AD.id
INNER JOIN `employee` E ON AA.emID =E.id
 INNER JOIN product P ON AD.productType = P.id
 INNER JOIN manufacturer M ON AD.manufacturer = M.id";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>Product Type</th>
            <th>Brand</th>
            <th>Employee ID</th>
            <th>Employee First Name</th>
            <th>Employee Last Name</th>
            <th>Asset Tag</th>
            <th>Service Tag</th>
          </tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["product_type"] . "</td>
                <td>" . $row["brand"] . "</td>
                <td>" . $row["employee_id"] . "</td>
                <td>" . $row["employee_first_name"] . "</td>
                <td>" . $row["employee_last_name"] . "</td>
                <td>" . $row["asset_tag"] . "</td>
                <td>" . $row["service_tag"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$connection->close();

?>