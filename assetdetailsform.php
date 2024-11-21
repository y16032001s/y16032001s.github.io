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

$manufacturer_result = $connection->query("SELECT id, name FROM manufacturer");
$product_result = $connection->query("SELECT id, productType FROM product");

$inputError = array();
$dop = $doe = $service_tag = $asset_tag = $manufacturer_id = $product_type = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $manufacturer_id = $_POST["manufacturer"];
    $dop = $_POST["dateofpurchase"];
    $doe = $_POST["dateofexpiry"];
    $service_tag = $_POST["servicetag"];
    $asset_tag = $_POST["assettag"];
    $product_type = $_POST["product"];

    $purchase_date_timestamp = strtotime($dop);
    $expiry_date_timestamp = strtotime($doe);

    if ($expiry_date_timestamp < $purchase_date_timestamp) {
        $error_message = "Error: Expiry date cannot be before the date of purchase.";
    }

    if (!ctype_alnum($service_tag)) {
        $inputError["sTag"] = "Service tag is invalid";
    }

    if (!is_numeric($asset_tag)) {
        $inputError["aTag"] = "Asset tag is invalid";
    }

    if (empty($inputError) && empty($error_message)) {
        $sql = "INSERT INTO assetdetails (dateOfPurchase, dateOfExpiry, serviceTag, assetTag, productType, manufacturer)
                VALUES ('$dop', '$doe', '$service_tag', '$asset_tag', '$product_type', '$manufacturer_id')";

        if ($connection->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Details Form</title>
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
        input[type="date"],
        input[type="text"],
        select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .select-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php
require "./menu.php";
?>
<div class="container">
    <h2>Asset Details Form</h2>
    <?php
    if (!empty($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>

    <form action="assetdetailsform.php" method="post">
        <label for="dateofpurchase">Date of Purchase:</label>
        <input type="date" id="dateofpurchase" name="dateofpurchase" value="<?php echo htmlspecialchars($dop); ?>" required>

        <label for="dateofexpiry">Date of Expiry:</label>
        <input type="date" id="dateofexpiry" name="dateofexpiry" value="<?php echo htmlspecialchars($doe); ?>" required>

        <label for="serviceTag">Service Tag:</label>
        <?php
        if (isset($inputError["sTag"])) {
            echo "<p style='color: red;'>" . $inputError["sTag"] . "</p>";
        }
        ?>
        <input type="text" id="serviceTag" name="servicetag" value="<?php echo htmlspecialchars($service_tag); ?>" required>

        <label for="assetTag">Asset Tag:</label>
        <?php
        if (isset($inputError["aTag"])) {
            echo "<p style='color: red;'>" . $inputError["aTag"] . "</p>";
        }
        ?>
        <input type="text" id="assetTag" name="assettag" value="<?php echo htmlspecialchars($asset_tag); ?>" required>

        <div class="select-container">
            <label for="manufacturer">Manufacturer</label>
            <select id="manufacturer" name="manufacturer" required>
                <option value="">--Please Select--</option>
                <?php
                if ($manufacturer_result->num_rows > 0) {
                    while ($row = $manufacturer_result->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '" ' . ($manufacturer_id == $row["id"] ? 'selected' : '') . '>' . $row["name"] . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="select-container">
            <label for="product">Product Type</label>
            <select id="product" name="product" required>
                <option value="">--Please Select--</option>
                <?php
                if ($product_result->num_rows > 0) {
                    while ($row = $product_result->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '" ' . ($product_type == $row["id"] ? 'selected' : '') . '>' . $row["productType"] . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>


