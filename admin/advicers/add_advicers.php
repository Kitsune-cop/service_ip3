<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require "../../connect.php";
require_once "../classroom/classroom.php";
try{
$request = json_decode(file_get_contents("php://input"), true);
$class = array(
    'school_year' => $request['school_year'],
    'grade' => $request['grade'],
    'room' => $request['room'],
);
print_r($request);
print_r($class);
check_classroom_and_add($class);
$sql = $conn->prepare("INSERT INTO `advicers`(`school_year`, `grade`, `room`, `teacher_id`) 
VALUES (:school_year, :grade, :room, :teacher_id)");
if($sql->execute($request)){
    $response = array(
        'status' => true,
        'message' => 'insert advicers success'
    );
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
} 
}catch(PDOException $e) {
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