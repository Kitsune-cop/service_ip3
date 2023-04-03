<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../connect.php";
$request = json_decode(file_get_contents("php://input"), true);
$response = array(
    'status' => true,
    'message' => 'success',
    'request' => $request
);
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>