<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../connect.php";
$request = json_decode(file_get_contents("php://input"), true);
$params_for_select = array(
    'subject_id' => $request['subject_id'],
    'grade' => $request['grade'],
    'room' => $request['room']
);
$params_for_insert = array(
    'work_id' => $request['work_id'],
    'work_name' => $request['work_name'],
    'work_details' => $request['work_details'],
    'date' => $request['date']

);
print_r($request);
try {
$sql = "SELECT * FROM enroll JOIN enroll_subject ON enroll.enroll_subject_id = enroll_subject.enroll_subject_id WHERE enroll_subject.subject_id = :subject_id AND enroll.grade = :grade AND enroll.room = :room";
$statement = $conn->prepare($sql);
$statement->execute($params_for_select);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$for_up = array(
    'work_id' => $request['work_id'],
    'work_name' => $request['work_name'],
    'work_details' => $request['work_details'],
    'date' => $request['date'],
    'enroll_subject_id' => $result[0]['enroll_subject_id']
);

$sql = $conn->prepare("UPDATE `work` SET `work_name`=:work_name,`work_details`=:work_details,`deadline`=:date,`enroll_subject_id`=:enroll_subject_id WHERE work_id = :work_id");
// $sql = $conn->prepare("UPDATE `student` SET `password`=':password',`first_name`=':first_name',`last_name`=':last_name',`gender`=':gender',`social_id`=':social_id',`bathday`=':bathday',`nationality`=':nationality',`phone_number`=':phone_number',`first_name_father`=':first_name_father',`last_name_father`=':last_name_father',`first_name_mother`=':first_name_mother',`last_name_mother`=':last_name_mother',`first_name_parent`=':first_name_parent',`last_name_parent`=':last_name_parent',`phone_number_of_parent`=':phone_number_of_parent',`status_id`=':status_id' WHERE `student_id`=':student_id'");
if($sql->execute($for_up)){
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