<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'] ?? null;

    if (empty($category_name)) {
        http_response_code(400);
        $data = [
            "message" => "Category name is required",
            'status' => http_response_code()
        ];
        echo json_encode($data, true);
        exit;
    }

    $sql = "INSERT INTO categories (category_name) VALUES ('$category_name')";
    $result = $conn->query($sql);

    if ($result) {
        header("Location: http://127.0.0.1/Ecommerce-Website/brief4/dashboard.php");
        exit;
        http_response_code(201);
        $data = [
            "message" => "Category created successfully",
            'status' => http_response_code(),
            'category_name' => $category_name
        ];
        echo json_encode($data, true);
    } else {
        http_response_code(400);
        $data = [
            "message" => "Error in creating category",
            'status' => http_response_code(),
            'error' => $conn->error
        ];
        echo json_encode($data, true);
    }
}

$conn->close();
