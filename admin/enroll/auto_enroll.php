<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../../connect.php";
require_once "../../response.php";
require "../classroom/classroom.php";

$response = new Response();

$request = json_decode(file_get_contents("php://input"), true, JSON_UNESCAPED_UNICODE);


function    get_student_id($params){
    global  $conn;
    // $sql = "SELECT student_id FROM `student_has_class` WHERE school_year = '2019' AND grade = '1' AND room = '1'";
    $sql = "SELECT student_id FROM `student_has_class` WHERE school_year = :school_year AND grade = :grade  AND room = :room";
    $statement = $conn->prepare($sql);
    $statement->execute($params);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
};

$params_for_student_has_class = array(
    "school_year" => $request['school_year'],
    "grade" => $request['grade'],
    "room" => $request['room'],
);
$student_id_array = get_student_id($params_for_student_has_class);
foreach ($student_id_array as $student_id){
    $params_for_enroll = array(
        "student_id" => $student_id['student_id'],
        "school_year" => $request['school_year'],
        "grade" => $request['grade'],
        "room" => $request['room'],
        "enroll_subject_id" => $request['enroll_subject_id'],
    );
    try{
    $sql = "SELECT * FROM `enroll` WHERE student_id = :student_id AND school_year = :school_year AND grade = :room AND room = :grade AND enroll_subject_id = :enroll_subject_id";
    $statement = $conn->prepare($sql);
    $statement->execute($params_for_enroll);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if(!count($result)){
        $sql_insert_enror = "INSERT INTO `enroll`(`student_id`, `school_year`, `grade`, `room`, `enroll_subject_id`) VALUES ( :student_id, :school_year, :grade, :room, :enroll_subject_id)";
        $statement = $conn->prepare($sql_insert_enror);
        $statement->execute($params_for_enroll);
    }
    } catch(PDOException $e) {
        $response = array(
            'status' => false,
            'message' => 'error',
            'error' => $e
        );
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}





?>