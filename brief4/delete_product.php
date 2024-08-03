<?php
include('db_connect.php');

$product_id = $_GET['id'];

$sql = "DELETE FROM products WHERE product_id=$product_id";

$result = mysqli_query($conn, $sql);

header("Location: http://localhost/Ecommerce-Website/brief4/dashboard.php");

$conn->close();
