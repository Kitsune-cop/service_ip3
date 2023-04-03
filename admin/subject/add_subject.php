<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../../connect.php";
$request = json_decode(file_get_contents("php://input"), true, JSON_UNESCAPED_UNICODE);
try {
$sql = $conn->prepare("INSERT INTO `subject`(`subject_id`, `subject_name`, `course_description_th`, `course_description_en`) VALUES (:subject_id,:subject_name, :course_description_th,:course_description_en)");
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
        'sql' => $sql,
        'data' => $data,
        'request' => gettype($request), 
        'error' => $e
    );
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>