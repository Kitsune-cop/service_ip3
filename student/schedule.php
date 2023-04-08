<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../connect.php";
require_once "../response.php";

$response = new Response();

$params = array(
    'id' => $_GET['id'],
);

try{
$sql = "SELECT *
FROM `time_table` 
INNER JOIN enroll_subject 
ON time_table.enroll_subject_id = enroll_subject.enroll_subject_id 
INNER JOIN subject
ON enroll_subject.subject_id = subject.subject_id
INNER JOIN enroll
ON enroll.enroll_subject_id = enroll_subject.enroll_subject_id
WHERE enroll.student_id = :id";


$statement = $conn->prepare($sql);
$statement->execute($params);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);


if(count($result)){
    $response->success($result, "success", 200);    
}else {
    // $response->error('error not found!', 404);
    echo json_encode($params, JSON_UNESCAPED_UNICODE);
}
} catch(PDOException $e) {
    $response = array(
        'status' => false,
        'message' => 'error',
        'params' => $params,
        'error' => $e
    );
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

?>