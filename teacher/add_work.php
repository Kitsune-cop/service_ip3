<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../connect.php";
$request = json_decode(file_get_contents("php://input"), true);
try {
$sel = "SELECT enroll.enroll_subject_id FROM enroll JOIN enroll_subject ON enroll.enroll_subject_id = enroll_subject.enroll_subject_id WHERE enroll_subject.subject_id = 'ส22234' ";
$statement = $conn->prepare($sel);
$statement->execute($request);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
// print_r($result[0]['enroll_subject_id']);
$sql = $conn->prepare("INSERT INTO `work`(`work_id`, `work_name`, `work_details`, `deadline`, `enroll_subject_id`) VALUES 
(:work_name,:work_details,$result[0]['enroll_subject_id'])");
print_r($result[0]['enroll_subject_id']);
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