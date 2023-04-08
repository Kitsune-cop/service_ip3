<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../connect.php');
require_once('../response.php');

$response = new Response();

$params = array(
    'id' => $_GET['id'],
    'sc_yr' => $GET['school_year'],
    'date' => date("Y-m-d")
);

$sql = "SELECT * FROM time_table
INNER JOIN enroll_subject on time_table.enroll_subject_id = enroll_subject.enroll_subject_id
INNER JOIN work ON enroll_subject.enroll_subject_id = work.enroll_subject_id
WHERE school_year = :sc_yr AND teacher_id = :id AND work.deadline >= :date ORDER BY work.deadline ASC";
$statement = $conn->prepare($sql);
$statement->execute($params);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (count($result)) {
    $response->success($result);
} else {
    $response->error();
}

?>
