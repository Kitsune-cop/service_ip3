<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../connect.php";
require_once "../response.php";

$response = new Response();


$params = array(
    'student_id' => $_GET['student_id'],
);

$sql = "SELECT * FROM student WHERE student_id = :student_id";
$statement = $conn->prepare($sql);
$statement->execute($params);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if(count($result)){
    $response->success($result, "success", 200);    
}else {
    $response->error('error not found!', 404);
}

?>