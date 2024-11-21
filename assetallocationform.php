<?php
//$servername="localhost";
//$username="dbuser";
//$password="agrawal@2002";
//$dbname="inventoryManagement";
//$connection= new mysqli($servername, $username, $password, $dbname);
//if ($connection->connect_error) {
//    die ("Connection failed: " . $connection->connect_error);
//}

require "functions.php";
?>
<?php

$connection=connect();
$sql = "SELECT id, firstname, lastname FROM employee";
$result = $connection->query($sql);

$sql = "SELECT A.id, A.serviceTag, A.assetTag, P.id AS product_id, P.productType, M.id AS manufacturer_id, M.name AS manufacturer_name 
        FROM assetdetails A
        INNER JOIN product P ON A.productType = P.id
        INNER JOIN manufacturer M ON A.manufacturer = M.id
        WHERE A.id NOT IN (SELECT assetID FROM assetallocation)";

$result1 = $connection->query($sql);

$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdowns for Employee Asset Allocation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
        }
        select, input[type="submit"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<?php
require "./menu.php";
?>

<div class="container">
    <h2>Employee Asset Allocation</h2>
    <form action="processAssetAllocation.php" method="post">
        <label for="employee">Select Employee</label>
        <?php
        if ($result->num_rows > 0) {
            echo '<select id="employee" name="employee" required>';
            echo '<option value="">--Please Select--</option>';
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['firstname'] . " " . $row['lastname'] . "</option>";
            }
            echo "</select>";
        }
        ?>

        <label for="assetdetails">Available Assets</label>
        <?php
        if ($result1->num_rows > 0) {
            echo '<select id="assetdetails" name="assetdetails" required>';
            echo '<option value="">--Please Select--</option>';
            while ($row = $result1->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['productType'] . " - " . $row['manufacturer_name'] . "</option>";
            }
            echo "</select>";
        }
        ?>

        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>

