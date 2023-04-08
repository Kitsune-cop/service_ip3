<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../connect.php');
require_once('../response.php');

$response = new Response();
$params = array(
    'id' => $_GET['id'],
    'sc_yr' => $_GET['school_year'],
    'date' => date("Y-m-d")
);

$sql = "SELECT * FROM time_table
INNER JOIN enroll_subject ON time_table.enroll_subject_id = enroll_subject.enroll_subject_id
INNER JOIN work ON enroll_subject.enroll_subject_id = work.enroll_subject_id
WHERE school_year = :sc_yr AND teacher_id = :id AND work.enroll_subject_id = enroll_subject.enroll_subject_id AND work.deadline >= :date GROUP BY work.work_id ORDER BY work.deadline ASC";
$statement = $conn->prepare($sql);
$statement->execute($params);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (count($result)) {
    $response->success($result);
} else {
    $response->error();
}

?>
