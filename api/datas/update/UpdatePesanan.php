<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';
include_once '../../../api/config/gammu.php';
include_once '../../../api/objects/Pesanan.php';
include_once '../../../api/objects/SendSMS.php';
session_start();
date_default_timezone_set('Asia/Seoul');
$database = new Database();
$db = $database->getConnection();
$gammu = new Gammu();
$dbgammu = $gammu->getConnection();
$pesanan = new Pesanan($db);
$sendsms = new SendSMS($dbgammu);
$data =json_decode(file_get_contents("php://input"));
if($data->StatusBayar=="Bayar"){
    if($data->Status=="Waiting"){
        $pesanan->IdPesanan = $data->IdPesanan;
        $pesanan->Status="Checkin";
        $pesanan->Pembayaran="true";
        if($pesanan->update()){
            $sendsms->SendingDateTime = $pesanan->TanggalCheckout . " 12:00:00";
            $sendsms->DestinationNumber = $data->Kontak;
            $sendsms->TextDecoded = "Hotel Permata: \r\n Batas menginap anda berakhir pada: " . $pesanan->TanggalCheckout . "Jam " . "12:00 WIT, " . "\r\n TERIMA KASIH";
            $sendsms->CreatorID = "Hotel Permata";
            if($sendsms->createOut())
            {
                $_SESSION["Data"] = $data;
                $response=array("Message"=>"Success", "Status" => $pesanan->Status);
                echo json_encode($response);
            }
        }else {
            $response=array("Message"=>"Gagal");
            echo json_encode($response);
        }
    }elseif ($data->Status=="Checkin") {
        $pesanan->IdPesanan = $data->IdPesanan;
        $pesanan->Status="Checkout";
        $pesanan->Pembayaran="true";
        if($pesanan->update()){
            $_SESSION["Data"] = $data;
            $response=array("Message"=>"Success", "Status" => $pesanan->Status);
            echo json_encode($response);
        }else {
            $response=array("Message"=>"Gagal");
            echo json_encode($response);
        }
    }else {
        $response=array("Message"=>"Gagal");
            echo json_encode($response);
    }
}else {
    if($data->Status=="Waiting"){
        $pesanan->IdPesanan = $data->IdPesanan;
        $pesanan->Status="Checkin";
        $pesanan->Pembayaran="false";
        if($pesanan->update()){
            $sendsms->SendingDateTime = $pesanan->TanggalCheckout . " 12:00:00";
            $sendsms->DestinationNumber = $data->Kontak;
            $sendsms->TextDecoded = "Hotel Permata: \r\n Batas menginap anda berakhir pada: " . $pesanan->TanggalCheckout . "Jam " . "12:00 WIT, " . "\r\n TERIMA KASIH";
            $sendsms->CreatorID = "Hotel Permata";
            if($sendsms->createOut())
            {
                $_SESSION["Data"] = $data;
                $response=array("Message"=>"Success", "Status" => $pesanan->Status);
                echo json_encode($response);
            }
        }else {
            $response=array("Message"=>"Gagal");
            echo json_encode($response);
        }
    }elseif ($data->Status=="Checkin") {
        $pesanan->IdPesanan = $data->IdPesanan;
        $pesanan->Status="Checkout";
        $pesanan->Pembayaran="true";
        if($pesanan->update()){
            $_SESSION["Data"] = $data;
            $response=array("Message"=>"Success", "Status" => $pesanan->Status);
            echo json_encode($response);
        }else {
            $response=array("Message"=>"Gagal");
            echo json_encode($response);
        }
    }else {
        $response=array("Message"=>"Gagal");
            echo json_encode($response);
    }
}

?>