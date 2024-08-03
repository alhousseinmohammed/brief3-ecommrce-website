<?php
include 'db_connect.php';


$category_id = $_GET['id'] ?? null;
$sql = "SELECT * FROM categories WHERE category_id='$category_id'";
$result = $conn->query($sql);
if ($result) {
    $category = mysqli_fetch_assoc($result);
    if ($category) {
        echo json_encode($category);
    } else {
        echo 'Category not found';
    }
} else {
    echo 'Query error';
}

$conn->close();
