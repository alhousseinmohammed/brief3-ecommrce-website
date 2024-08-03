<?php

include 'db_connect.php';


$user_id = $_GET['id'] ?? null;
if ($user_id !== null) {
    $user_id = mysqli_real_escape_string($conn, $user_id);

    $sql = "SELECT * FROM users WHERE user_id='$user_id'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            echo json_encode($user_data);
        } else {
            echo json_encode([
                "message" => "User not found"
            ]);
        }
    } else {
        echo json_encode([
            "message" => "Query execution failed"
        ]);
    }
} else {
    echo json_encode([
        "message" => "Invalid input"
    ]);
}


$conn->close();
