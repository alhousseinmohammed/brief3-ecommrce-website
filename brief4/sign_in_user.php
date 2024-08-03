<?php

include 'db_connect.php';
$email = $_POST['email'];
$password = $_POST['password'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "SELECT * FROM users WHERE email='$email' and password='$password';";
    $result = $conn->query($sql);
    if ($result) {
        $User = mysqli_fetch_assoc($result);
        if ($User) {
            echo $User['user_name'];
        } else {
            echo 'User not found';
        }
    } else {
        echo 'Query error';
    }
}
$conn->close();
