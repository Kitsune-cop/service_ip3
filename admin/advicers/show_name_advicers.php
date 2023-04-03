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
    'room' => $_GET['room']
);
$sql = "SELECT  advicers.*, teacher.first_name, teacher.last_name
FROM advicers 
INNER JOIN teacher ON advicers.teacher_id = teacher.teacher_id
WHERE school_year = :school_year AND grade = :grade AND room = :room";
$statement = $conn->prepare($sql);
$statement->execute($params);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (count($result)) {
    $response->success($result);
} else {
    $response->error();
}
?>
