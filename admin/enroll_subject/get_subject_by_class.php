<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../../connect.php";
require_once "../../response.php";

$response = new Response();

$params = array(
    'school_year' => $_GET['school_year'],
    'grade' => $_GET['grade'],
    'room' => $_GET['room'],
);
try{
$sql = "SELECT time_table.*, enroll_subject.teacher_id, enroll_subject.subject_id , subject.subject_name, teacher.first_name, teacher.last_name
FROM `time_table` 
INNER JOIN enroll_subject 
ON time_table.enroll_subject_id = enroll_subject.enroll_subject_id 
INNER JOIN subject
ON enroll_subject.subject_id = subject.subject_id
INNER JOIN teacher
ON enroll_subject.teacher_id = teacher.teacher_id 
WHERE school_year = :school_year AND room = :room AND grade = :grade";


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