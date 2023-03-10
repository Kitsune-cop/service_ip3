<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../connect.php');
require_once('../response.php');

$response = new Response();

$params = array(
    'id' => $_GET['id'],
);

$sql = "SELECT * FROM advicers
INNER JOIN student_has_class ON advicers.school_year = student_has_class.school_year 
INNER JOIN student ON student_has_class.student_id = student.student_id
WHERE advicers.teacher_id = :id AND advicers.grade = student_has_class.grade AND advicers.room = student_has_class.room";
$statement = $conn->prepare($sql);
$statement->execute($params);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (count($result)) {
    $response->success($result);
} else {
    $response->error();
}

?>
