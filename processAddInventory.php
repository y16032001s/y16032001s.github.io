<a href="assetdetailsform.php">Back</a>
<?php
$manufacturer_id = $_POST["manufacturer"];
$dop = $_POST["dateofpurchase"];
$doe = $_POST["dateofexpiry"];
$service_tag= $_POST["servicetag"];
$asset_tag= $_POST["assettag"];
$product_type= $_POST["product"];

$servername="localhost";
$username="dbuser";
$password="agrawal@2002";
$dbname="inventoryManagement";
$connection= new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die ("Connection failed: " . $connection->connect_error);
}
$sql= "INSERT INTO assetdetails( dateOfPurchase, dateOfExpiry, serviceTag, assetTag, productType, manufacturer)
VALUES ($dop, $doe, $service_tag, $asset_tag, $product_type, $manufacturer_id)";
if($connection->query($sql) === TRUE) {

     echo "New record created successfully";
 }

$connection->close();

?>

