<?php
include 'db_connect.php';

$user_id = $_GET['id'] ?? null;

if ($user_id === null) {
    http_response_code(400);
    echo json_encode(array('status' => http_response_code(), "message" => "user_id is required"));
    exit;
}
$sql = "DELETE FROM users WHERE user_id='$user_id'";
$result = $conn->query($sql);

if ($result) {
    header("Location: http://localhost/Ecommerce-Website/brief4/dashboard.php");
    exit;
    http_response_code(201);
    echo json_encode(array('status' => http_response_code(), "message" => "user deleted successfully"));
} else {
    http_response_code(400);
    echo json_encode(array('status' => http_response_code(), "message" => "user deletion error"));
}

$conn->close();
