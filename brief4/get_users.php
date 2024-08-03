<?php
include 'db_connect.php';
if($_SERVER['REQUEST_METHOD']=='GET'){
$sql="SELECT * FROM users";
$result=$conn->query($sql);
if($result){
    $users=array();
    while($row=mysqli_fetch_assoc($result)){
        $users[]=$row;
    }http_response_code(201);
    echo json_encode(array('status' => http_response_code(), 'data' => $users));
}else{
    http_response_code(400);
    echo json_encode(array('status' => http_response_code(), 'message' => 'failed to retreive data'));
}
}
$conn->close();
?>