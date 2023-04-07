<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "./connect.php";0
$request = json_decode(file_get_contents("php://input"), true, JSON_UNESCAPED_UNICODE);
$params = array('subject_id'=>$request['subject_id']);
$work_name = $request['work_name'];
$work_details = $request['work_details'];
// $sub = $request['subject_id'];
// print_r($request);
// print_r($request['work_name']);
try {
$sql = "SELECT enroll.enroll_subject_id FROM enroll JOIN enroll_subject ON enroll.enroll_subject_id = enroll_subject.enroll_subject_id WHERE enroll_subject.subject_id = :subject_id";
$statement = $conn->prepare($sql);
$statement->execute($params);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
// print(count($result));
// print_r($params);
// print_r($result);
$res = $result[0]['enroll_subject_id'];
// print_r($res);
$sql = $conn->prepare("INSERT INTO `work`(`work_id`, `work_name`, `work_details`, `deadline`, `enroll_subject_id`) VALUES 
('',$work_name,$work_details,'',$res)");
// print_r($result[0]['enroll_subject_id']);
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
        'request' => $request, 
        'error' => $e
    );
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>