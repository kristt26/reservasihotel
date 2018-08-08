<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';
include_once '../../../api/objects/Kamar.php';

$database = new Database();
$db = $database->getConnection();
$kamar = new Kamar($db);
$data =json_decode(file_get_contents("php://input"));
$kamar->NomorKamar = $data->NomorKamar;
$kamar->Harga = $data->Harga;
$kamar->Description = $data->Description;
if($kamar->create()){
    $response=array("Message"=>"Success", "IdKamar"=>$kamar->IdKamar);
    echo json_encode($response);
}else {
    $response=array("Message"=>"Gagal");
    echo json_encode($response);
}
?>