<?php
include('db_connect.php');

$category_id = $_GET['id'];

$sql = "SELECT products.product_id as product_id, products.product_name as product_name , products.price as price, products.description as description, products.product_image as product_image , products.onsale as onsale FROM categories_products JOIN products ON products.product_id = categories_products.product_id WHERE category_id = {$category_id};
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    // while ($row = mysqli_fetch_assoc($result)) {
    //     echo $row["product_name"];
    // }
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    echo json_encode($products);
} else {
    echo "0 results";
}
$conn->close();
