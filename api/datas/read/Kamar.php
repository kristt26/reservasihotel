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
$stmt = $kamar->read();
$num = $stmt->rowCount();
$Data_arr =array();
$Data_arr["record"] = array();
if($num>0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = array(
            'NomorKamar' => $NomorKamar , 
            'Harga' => $Harga,
            'Description' => $Description
        );
        array_push($Data_arr["record"], $item);
    }
    echo json_encode($Data_arr);
}else {
    $response=array("Message"=>"Gagal");
    echo json_encode($response);
}
?>