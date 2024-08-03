<?php
include('db_connect.php');

$product_id = $_GET['id'];

$sql = "SELECT * FROM products WHERE product_id=$product_id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    // while ($row = mysqli_fetch_assoc($result)) {
    //     echo $row["product_name"];
    // }
    echo json_encode(mysqli_fetch_assoc($result));
} else {
    echo "0 results";
}
$conn->close();
