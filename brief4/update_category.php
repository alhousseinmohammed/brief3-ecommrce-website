<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'] ?? null;
    $category_id = $_GET['id'] ?? null;

    if ($category_name === null || $category_id === null) {
        http_response_code(400);
        $data = [
            'status' => http_response_code(),
            "message" => "Both category_name and category_id are required"
        ];
        echo json_encode($data, true);
        exit;
    }
    $sql = "UPDATE categories 
    SET category_name='$category_name'
    WHERE category_id='$category_id'";
    $result = $conn->query($sql);

    if ($result) {
        header("Location: http://localhost/Ecommerce-Website/brief4/dashboard.php");
        exit;
        http_response_code(201);
        $data = [
            'status' => http_response_code(),
            "message" => "Category updated successfully",
            'category_id' => $category_id,
            'category_name' => $category_name
        ];
        echo json_encode($data, true);
    } else {
        http_response_code(400);
        $data = [
            'status' => http_response_code(),
            "message" => "Category couldn't be updated",
            'error' => $conn->error
        ];
        echo json_encode($data, true);
    }
}
$conn->close();
