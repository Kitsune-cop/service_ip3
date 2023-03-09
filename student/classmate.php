<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../connect.php');
require_once('../response.php');

$response = new Response();

$params = array(
    'class' => $_GET['class'],
    'room' => $_GET['room'],
);

$sql = "SELECT * FROM student 
INNER JOIN student_has_class ON student.student_id = student_has_class.student_id  
WHERE student_has_class.grade = :class AND student_has_class.room = :room ";
$statement = $conn->prepare($sql);
$statement->execute($params);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (count($result)) {
    $response->success($result);
} else {
    $response->error();
}

?>
