<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../connect.php');
require_once('../response.php');

$response = new Response();

$params = array(
    'id' => $_GET['id'],
    'date' => date("Y-m-d")
);

$sql = "SELECT * FROM work INNER JOIN enroll_subject ON work.enroll_subject_id = enroll_subject.enroll_subject_id
INNER JOIN enroll ON enroll_subject.enroll_subject_id = enroll.enroll_subject_id
WHERE enroll_subject.teacher_id = :id AND work.enroll_subject_id = enroll_subject.enroll_subject_id AND work.deadline >= :date GROUP BY work.work_id ORDER BY work.deadline ASC";
$statement = $conn->prepare($sql);
$statement->execute($params);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (count($result)) {
    $response->success($result);
} else {
    $response->error();
}

?>
