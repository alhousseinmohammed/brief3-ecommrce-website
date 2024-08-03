<?php
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);

    if ($result) {
        $categories = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
        http_response_code(200);
        echo json_encode($categories); 
    } else {
        http_response_code(400);
        echo json_encode(array('message' => 'Failed to retrieve data'));
    }
}
$conn->close();
?>
