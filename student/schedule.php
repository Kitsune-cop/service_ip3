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

$sql = "SELECT * FROM student_has_class INNER JOIN time_table ON student_has_class.school_year = time_table.school_year INNER JOIN enroll_subject ON time_table.enroll_subject_id = enroll_subject.enroll_subject_id WHERE student_has_class.student_id = :id AND student_has_class.school_year = '2019' ";
$statement = $conn->prepare($sql);
$statement->execute($params);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (count($result)) {
    $response->success($result);
} else {
    $response->error();
}

?>
