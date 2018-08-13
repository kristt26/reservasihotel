<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';
include_once '../../../api/config/gammu.php';
include_once '../../../api/objects/Kamar.php';
include_once '../../../api/objects/Pesanan.php';
include_once '../../../api/objects/Customer.php';
include_once '../../../api/objects/DetailPesanan.php';
include_once '../../../api/objects/SendSMS.php';
include_once '../../../api/objects/Fungsi.php';
date_default_timezone_set('Asia/Seoul');
$data =json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$gammu = new Gammu();
$dbgammu = $gammu->getConnection();
$pesananwithgammu = new Pesanan($dbgammu);
$pesanan = new Pesanan($db);
$customer = new Customer($db);
$detail = new DetailPesanan($db);
$sendsms = new SendSMS($dbgammu);
$fungsi = new Fungsi();
$customer->NamaCustomer = $data->NamaCustomer;
$customer->Kontak = $data->Kontak;
$customer->Alamat = $data->Alamat;
$customer->Sex = $data->Sex;
$customer->Email = $data->Email;
if($customer->create()){
    $a = new DateTime($data->TanggalCheckin);
    $aa=str_replace('-', '/', $a->format('Y-m-d'));
    $aaa = date('Y-m-d',strtotime($aa . "+1 days"));
    $b = new DateTime($data->TanggalCheckout);
    $bb=str_replace('-', '/', $b->format('Y-m-d'));
    $bbb = date('Y-m-d',strtotime($bb . "+1 days"));
    $c = new DateTime();
    $cc=str_replace('-', '/', $c->format('Y-m-d'));
    $ccc = date('Y-m-d',strtotime($cc . "+1 days"));
    $pesanan->KodePesanan= $fungsi->acak();
    $pesanan->IdCustomer=$customer->IdCustomer;
    $pesanan->TanggalPesan=$ccc;
    $pesanan->TanggalCheckin= $aaa;
    $pesanan->TanggalCheckout= $bbb;
    $pesanan->Status="Waiting";
    $nomorkamar = "";
    if($pesanan->create()){
        foreach ($data->Kamar as $value) {
            $nomor = $nomorkamar.$value->NomorKamar.", ";
            $nomorkamar = $nomor;
            $testing =$value;
            $detail->IdPesanan=$pesanan->IdPesanan;
            $detail->IdKamar=$value->IdKamar;
            if($detail->create()){
                
            }
            // $pesanan->IdKamar=$value->IdKamar;
        }
        $sendsms->SendingDateTime = $pesanan->TanggalCheckout . " 00:00:00";
        $sendsms->DestinationNumber = $data->Kontak;
        $sendsms->TextDecoded = "Hotel Permata: \r\n Anda berhasil melakukan Reservasi dengan Kode Boking: " . "'" . $pesanan->KodePesanan . "'" . "Nomor Kamar: " . $nomorkamar;
        $sendsms->CreatorID = "Hotel Permata";
        if($sendsms->createBoking())
        {
            $response=array("status"=>1,"message"=>"Success");
            echo json_encode($response);
           
        }
        
    }
}



?>