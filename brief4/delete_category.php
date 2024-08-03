<?php
include 'db_connect.php';


$category_id = $_GET['id'] ?? null;
if ($category_id === null) {
    http_response_code(400);
    echo json_encode(array('status' => http_response_code(), "message" => "category_id is required"));
    exit;
}

$sql = "DELETE FROM categories WHERE category_id='$category_id'";
$result = $conn->query($sql);

if ($result) {
    header("Location: http://localhost/Ecommerce-Website/brief4/dashboard.php");
    exit;
    http_response_code(201);
    echo json_encode(array('status' => http_response_code(), "message" => "category deleted successfully"));
} else {
    http_response_code(400);
    echo json_encode(array('status' => http_response_code(), "message" => "category deletion error"));
}



$conn->close();
