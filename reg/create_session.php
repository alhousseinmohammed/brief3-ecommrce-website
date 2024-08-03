<?php
session_start();
if ($_POST['role'] === "admin") {
    $_SESSION['admin'] = true;
    header("Location: http://localhost/Ecommerce-Website/brief4/dashboard.php");
} else {
    $_SESSION['user_id'] = $_POST['role'];
    header("Location: http://localhost/Ecommerce-Website/client/home.php");
}
