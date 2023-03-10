<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once ".../connect.php";
$request = json_decode(file_get_contents("php://input"), true);
try {

$sql = $conn->prepare("UPDATE `teacher` SET `password`=:password,`first_name`=:first_name,`last_name`=:last_name,`gender`=:gender,`social_id`=:social_id,`bathday`=:bathday,`nationality`=:nationality,`phone_number`=:phone_number,`first_name_father`=:first_name_father,`last_name_father`=:last_name_father,`first_name_mother`=:first_name_mother,`last_name_mother`=:last_name_mother,`first_name_parent`=:first_name_parent,`last_name_parent`=:last_name_parent,`phone_number_of_parent`=:phone_number_of_parent,`status_id`=:status_id WHERE `teacher_id`=:teacher_id");
// $sql = $conn->prepare("UPDATE `student` SET `password`=':password',`first_name`=':first_name',`last_name`=':last_name',`gender`=':gender',`social_id`=':social_id',`bathday`=':bathday',`nationality`=':nationality',`phone_number`=':phone_number',`first_name_father`=':first_name_father',`last_name_father`=':last_name_father',`first_name_mother`=':first_name_mother',`last_name_mother`=':last_name_mother',`first_name_parent`=':first_name_parent',`last_name_parent`=':last_name_parent',`phone_number_of_parent`=':phone_number_of_parent',`status_id`=':status_id' WHERE `student_id`=':student_id'");
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
        'request' => ($request), 
        'error' => $e
    );
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>