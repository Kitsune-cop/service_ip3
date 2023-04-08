<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../../connect.php";
require_once "../../response.php";

$response = new Response();

$request = json_decode(file_get_contents("php://input"), true, JSON_UNESCAPED_UNICODE);

function    get_enroll_subject_id(){
    global $conn;
    global $params;
    $sql = "SELECT enroll_subject_id 
    FROM `enroll_subject`
    WHERE 1
    ORDER BY enroll_subject_id DESC
    LIMIT 1";
    $statement = $conn->prepare($sql);
    $statement->execute($params);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]["enroll_subject_id"] + 1;
}

function    insert_enroll_subject($params){
    try{
    global $conn;
    $sql = "INSERT INTO `enroll_subject`(`enroll_subject_id`, `teacher_id`, `subject_id`) 
    VALUES (:enroll_subject_id, :teacher_id, :subject_id)";
    $statement = $conn->prepare($sql);
    $statement->execute($params);
    } catch(PDOException $e){
        echo 'insert_eroll_subject' . $e;
    }
};

function    insert_time_table($params){
    try{
        global $conn;
        $sql = "INSERT INTO `time_table`(`time_table_id`, `school_year`, `grade`, `room`, `time`, `term`, `day`, `enroll_subject_id`) VALUES (NULL, :school_year, :grade, :room, :time, :term, :day, :enroll_subject_id)";
        $statement = $conn->prepare($sql);
        $statement->execute($params);
    } catch(PDOException $e){
        echo 'insert_time_table' . $e;
    }
};

if($request['enroll_subject_id'] == ""){
    $request["enroll_subject_id"] = get_enroll_subject_id();
    
    $parrams_insert_enroll_subject = array(
        'enroll_subject_id' => $request["enroll_subject_id"],
        'subject_id' => $request["subject_id"],
        'teacher_id' => $request["teacher_id"],
    );
    insert_enroll_subject($parrams_insert_enroll_subject);
    $parrams_for_time_table = array(
        'school_year' => $request['school_year'],
        'grade' => $request['grade'],
        'room' => $request['room'],
        'time' => $request['time'],
        'term' => $request['term'],
        'day' => $request['day'],
        'enroll_subject_id' => $request['enroll_subject_id'],
    );
    
    insert_time_table($parrams_for_time_table);
}else {
    $parrams_insert_enroll_subject = array(
        'enroll_subject_id' => $request["enroll_subject_id"],
        'subject_id' => $request["subject_id"],
        'teacher_id' => $request["teacher_id"],
    );
    try {
    $sql = "UPDATE `enroll_subject` SET `teacher_id`= :teacher_id ,`subject_id`= :subject_id  WHERE `enroll_subject_id`= :enroll_subject_id ";
        $statement = $conn->prepare($sql);
        $statement->execute($parrams_insert_enroll_subject);
    } catch(PDOException $e){
        echo 'insert_time_table' . $e;  
    }
    
}

?>
