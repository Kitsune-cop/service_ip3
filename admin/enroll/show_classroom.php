<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type"); 

require_once "../../connect.php";
require_once "../../response.php";
require "../classroom/classroom.php";

$response = new Response();
$show_classroom = show_classroom(array());
if(count($show_classroom)){
    $response->success($show_classroom, "success", 200);    
}else {
    $response->error('error not found!', 404);
}
?>