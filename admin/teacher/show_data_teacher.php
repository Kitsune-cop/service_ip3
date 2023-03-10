<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../../connect.php";
require_once "../../response.php";

$response = new Response();


$params = array(
    'teacher_id' => $_GET['teacher_id'],
);

$sql = "SELECT * FROM teacher WHERE teacher_id = :teacher_id";
$statement = $conn->prepare($sql);
$statement->execute($params);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if(count($result)){
    $response->success($result, "success", 200);    
}else {
    $response->error('error not found!', 404);
}

?>