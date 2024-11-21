
<?php

$servername = "localhost";
$username = "dbuser";
$password = "agrawal@2002";
$dbname = "inventorymanagement";
$connection= new mysqli($servername, $username, $password,$dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
echo"Connected successfully";

$sql= "SELECT id, productType FROM product";
$result=$connection->query($sql);


if($result->num_rows>0){
    echo '<select name="productType">';
    while($row= $result->fetch_assoc()){
        ?>
        <option value="<?php echo $row["id"]?>"><?php echo $row["productType"]?></option>
<?php
    }
    echo '</select>';

}else{
    echo "No results";
}
$connection->close();

//creating form for asset details:










?>
