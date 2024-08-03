<?php
include('db_connect.php');
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$description = $_POST['description'];
$category_ids = $_POST['category_ids'];
$filename = $_FILES["image"]["name"];
$tempname = $_FILES["image"]["tmp_name"];

$folder = "./product_images/" . $filename;


$sql = "INSERT INTO products(product_name, price, description, product_image)
VALUES ('$product_name', '$price', '$description', '$filename')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    $last_id = $conn->insert_id;
    move_uploaded_file($tempname, $folder);

    if (is_array($category_ids)) {
        foreach ($category_ids as $category_id) {
            $category_id = $conn->real_escape_string($category_id);
            $sql = "INSERT INTO categories_products(category_id, product_id) VALUES ('$category_id', '$last_id')";
            $conn->query($sql);
        }
    }
    header("Location: http://127.0.0.1/Ecommerce-Website/brief4/dashboard.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
