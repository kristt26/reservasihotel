<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';
include_once '../../../api/objects/Kamar.php';
include_once '../../../api/objects/Pesanan.php';
date_default_timezone_set('Asia/Seoul');

$database = new Database();
$db = $database->getConnection();
$kamar = new Kamar($db);
$pesanan = new Pesanan($db);
$data =json_decode(file_get_contents("php://input"));
$a = new DateTime($data->TanggalCheckin);
$aa=str_replace('-', '/', $a->format('Y-m-d'));
$aaa = date('Y-m-d',strtotime($aa . "+1 days"));
$b = new DateTime($data->TanggalCheckout);
$bb=str_replace('-', '/', $b->format('Y-m-d'));
$bbb = date('Y-m-d',strtotime($bb . "+1 days"));
$pesanan->TanggalCheckin= $aaa;
$pesanan->TanggalCheckout= $bbb;
$stmt = $kamar->read();
$num = $stmt->rowCount();
if($num>0)
{
    $Datas = array();
    $Datas["record"]=array();
    while ($rowKamar = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($rowKamar);
        $numpesanan;
        $pesanan->IdKamar = $IdKamar;
        $stmtpesanan = $pesanan->readByStatus();
        $numpesanan = $stmtpesanan->rowCount();
        if($numpesanan==0){
            $ItemKamar = array(
                'IdKamar' => $IdKamar,
                'NomorKamar' => $NomorKamar,
                'Description' => $Description,
                'Status' => 'true',
                'Color' => 'aqua', 
            );
        }else {
            $ItemKamar = array(
                'IdKamar' => $IdKamar,
                'NomorKamar' => $NomorKamar,
                'Description' => $Description,
                'Status' => 'false',
                'Color' => 'red'  
            );
        }
        
        array_push($Datas["record"], $ItemKamar);
    }
    echo json_encode($Datas);
}
?>