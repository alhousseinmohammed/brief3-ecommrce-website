<?php
include '../brief4/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_GET['id'] ?? null;
    $email = $_POST['email'] ?? null;

    $sql = "UPDATE users 
    SET email='$email'
    WHERE user_id='$user_id'";
    $result = $conn->query($sql);

    if ($result) {
        header("Location: http://localhost/Ecommerce-Website/client/user.php?id=$user_id");
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
