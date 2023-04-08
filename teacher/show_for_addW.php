<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once('../connect.php');
require_once('../response.php');

$response = new Response();

$params = array(
    'tb_id' => $_GET['tb_id'],
);

$sql = "SELECT * FROM time_table INNER JOIN enroll_subject ON time_table.enroll_subject_id = enroll_subject.enroll_subject_id INNER JOIN subject ON enroll_subject.subject_id = subject.subject_id
WHERE time_table.time_table_id = :tb_id ";
$statement = $conn->prepare($sql);
$statement->execute($params);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (count($result)) {
    $response->success($result);
} else {
    $response->error();
}

?>
