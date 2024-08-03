<?php
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['user_name'] ?? null;
    $role_id = $_POST['role_id'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($user_name === null || $role_id === null || $email === null || $password === null) {
        http_response_code(400);
        $data = [
            "message" => "All fields are required",
            'status' => http_response_code()
        ];
        echo json_encode($data, true);
        exit;
    }
    $sql = "INSERT INTO users (user_name, role_id, email, password) VALUES ('$user_name', '$role_id', '$email', '$password')";
    $result = $conn->query($sql);
    if ($result) {
        header("Location: http://localhost/Ecommerce-Website/brief4/dashboard.php");
        exit;
        http_response_code(201);
        $data = [
            "message" => "User created successfully",
            'status' => http_response_code(),
            'user_name' => $user_name,
            'role_id' => $role_id,
            'email' => $email,
            'password' => $password
        ];
        echo json_encode($data, true);
    } else {
        http_response_code(400);
        $data = [
            'status' => http_response_code(),
            'message' => "User couldn't be created",
            'error' => $conn->error
        ];
        echo json_encode($data, true);
    }
}
$conn->close();
?>
