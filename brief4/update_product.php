<?php
include('db_connect.php');

$product_id = $_GET['id'];
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$description = $_POST['description'];
$sql = "UPDATE products SET product_name='$product_name',price='$price',description='$description' WHERE product_id='$product_id'";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header("Location: http://localhost/Ecommerce-Website/brief4/dashboard.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
