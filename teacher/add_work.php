<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../connect.php";
$request = json_decode(file_get_contents("php://input"), true, JSON_UNESCAPED_UNICODE);


try {

$sql = $conn->prepare("INSERT INTO work(work_id, work_name, work_details, deadline, enroll_subject_id) VALUES 
('', :work_name, :work_details,:date,:enroll_subject_id)");
if($sql->execute($request)){
    $response = array(
        'status' => true,
        'message' => 'success'
    );
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
} catch(PDOException $e) {
    $response = array(
        'status' => false,
        'message' => 'error',
        'error' => $e
    );
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>