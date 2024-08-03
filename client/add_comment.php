<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brief4";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;
    $content = $_POST['content'] ?? null;

    if ($product_id === null || $user_id === null || $content === null) {
        http_response_code(400);
        $data = [
            "message" => "All fields are required",
            'status' => http_response_code()
        ];
        echo json_encode($data, true);
        exit;
    }

    $sql = "INSERT INTO comments (product_id, user_id, content, comment_date) VALUES ('$product_id', '$user_id', '$content', CURDATE())";
    $result = $conn->query($sql);

    if ($result) {
        header("Location: product_details.php?id=$product_id");
        exit();
        http_response_code(201);
        $data = [
            "message" => "Comment added successfully",
            'status' => http_response_code(),
            'product_id' => $product_id,
            'user_id' => $user_id,
            'content' => $content
        ];
        echo json_encode($data, true);
    } else {
        http_response_code(400);
        $data = [
            'status' => http_response_code(),
            'message' => "Comment couldn't be added",
            'error' => $conn->error
        ];
        echo json_encode($data, true);
    }
}
$conn->close();
