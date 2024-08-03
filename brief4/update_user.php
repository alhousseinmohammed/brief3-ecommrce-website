<?php
include 'db_connect.php';


$user_id = $_GET['id'] ?? null;
$user_name = $_POST['user_name'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$role_id = $_POST['role_id'] ?? null;

$sql = "UPDATE users
    SET
    user_name='$user_name',
    email='$email',
    password='$password',
    role_id='$role_id'
    WHERE user_id='$user_id'
    ";
$result = $conn->query($sql);
if ($result) {
    header("Location: http://localhost/Ecommerce-Website/brief4/dashboard.php");
    exit;
    http_response_code(201);
    $data = [
        'status' => http_response_code(),
        "message" => "User updated successfully",
        'user_name' => $user_name,
        'email' => $email,
        'password' => $password,
        'role_id' => $role_id
    ];
    echo json_encode($data, true);
} else {
    http_response_code(400);
    $data = [
        'status' => http_response_code(),
        "message" => "User couldn't be updated",
        'error' => $conn->error
    ];
    echo json_encode($data, true);
}
$conn->close();
