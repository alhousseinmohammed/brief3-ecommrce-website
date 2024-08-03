<?php
include "../brief4/db_connect.php";
$query = $_GET['query'];

// Start building the SQL query
$sql = "SELECT *
        FROM products
        WHERE price <= $query
        ";

// Add category filter if category_id is set


// Add search filter if query is not empty
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    echo json_encode($products);
} else {
    echo "0 results";
}
$conn->close();
