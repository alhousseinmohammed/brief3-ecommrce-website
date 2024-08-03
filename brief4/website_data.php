<?php
include 'db_connect.php';
$sql_products = "SELECT COUNT(*) as product_count FROM products";
$sql_users = "SELECT COUNT(*) as user_count FROM users";
$sql_orders = "SELECT COUNT(*) as order_count FROM orders";
$sql_categories = "SELECT COUNT(*) as category_count FROM categories";


$result_products = $conn->query($sql_products);
$result_users = $conn->query($sql_users);
$result_orders = $conn->query($sql_orders);
$result_categories = $conn->query($sql_categories);

if ($result_products && $result_users && $result_orders && $result_categories) {
    $row_products = $result_products->fetch_assoc();
    $row_users = $result_users->fetch_assoc();
    $row_orders = $result_orders->fetch_assoc();
    $row_categories = $result_categories->fetch_assoc();

    $counts = array_merge($row_products, $row_users, $row_orders, $row_categories);
    echo json_encode($counts);
} else {
    echo json_encode([
        "error" => $conn->error
    ]);
}

$conn->close();
