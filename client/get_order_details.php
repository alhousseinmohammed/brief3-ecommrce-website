<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brief4";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $order_id = $_GET['order_id'];
    $sql = "SELECT products.product_name , products.product_image, products.price, quantity , orders.order_total 
   FROM orders_products 
   JOIN products on orders_products.product_id = products.product_id 
   JOIN orders ON orders_products.order_id = orders.order_id
   WHERE orders.order_id='$order_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {

        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        echo json_encode($products);
    } else {
        echo json_encode(["message" => "Couldn't find result"]);
    }
}
$conn->close();
