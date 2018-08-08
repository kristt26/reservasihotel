<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';
include_once '../../../api/objects/User.php';
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$data =json_decode(file_get_contents("php://input"));
$user->Username = $data->Username;
$user->Password = md5($data->Password);
$cek = $user->read();
$num = $cek->rowCount();
if($num>0){
    session_star();
    $_SESSION["Username"]= $data->Username;
    echo json_decode($_SESSION);
}else {
    $response=array("Message"=>"Success");
    echo json_encode($response);
}
?>