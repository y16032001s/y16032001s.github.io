<a href="assetallocationform.php">Back</a>
<?php
$employee_id = $_POST["employee"];
$asset_id= $_POST["assetdetails"];


$servername="localhost";
$username="dbuser";
$password="agrawal@2002";
$dbname="inventoryManagement";
$connection= new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die ("Connection failed: " . $connection->connect_error);
}
$sql= "INSERT INTO assetallocation(emID, assetID)
VALUES($employee_id, $asset_id)";
if($connection->query($sql) === TRUE) {

    echo "New record created successfully";
}

$connection->close();

?>
