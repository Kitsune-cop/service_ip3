<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../connect.php');
require_once('../response.php');

$response = new Response();

$params = array(
    'id' => $_GET['id']
);

$sql = "SELECT * FROM student_has_class 
INNER JOIN advicers ON student_has_class.school_year = advicers.school_year 
INNER JOIN teacher ON advicers.teacher_id = teacher.teacher_id 
WHERE student_has_class.student_id = :id AND student_has_class.school_year = '2019' ";
$statement = $conn->prepare($sql);
$statement->execute($params);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (count($result)) {
    $response->success($result);
} else {
    $response->error();
}

?>
