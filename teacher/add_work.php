<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../connect.php";
$request = json_decode(file_get_contents("php://input"), true, JSON_UNESCAPED_UNICODE);
$params_for_select = array(
    'subject_id' => $request['subject_id'],
    'grade' => $request['grade'],
    'room' => $request['room']
);
$params_for_insert = array(
    'work_name' => $request['work_name'],
    'work_details' => $request['work_details'],
    'date' => $request['date']
);

try {
$sql = "SELECT * FROM enroll JOIN enroll_subject ON enroll.enroll_subject_id = enroll_subject.enroll_subject_id WHERE enroll_subject.subject_id = :subject_id AND enroll.grade = :grade AND enroll.room = :room";
$statement = $conn->prepare($sql);
$statement->execute($params_for_select);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
// if(count($result)){
//     echo json_encode($result, JSON_UNESCAPED_UNICODE);
// }
$sql = $conn->prepare("INSERT INTO work(work_id, work_name, work_details, deadline, enroll_subject_id) VALUES 
('', :work_name, :work_details,:date,". $result[0]['enroll_subject_id']. ")");
if($sql->execute($params_for_insert)){
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