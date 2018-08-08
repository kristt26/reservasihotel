<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../../api/config/database.php';
include_once '../../../api/objects/Kamar.php';
include_once '../../../api/objects/Customer.php';
include_once '../../../api/objects/Pesanan.php';
include_once '../../../api/objects/DetailPesanan.php';
$database = new Database();
$db = $database->getConnection();
$customer = new Customer($db);
$kamar = new Kamar($db);
$pesanan = new Pesanan($db);
$detail = new DetailPesanan($db);
$Data_Array = array();
$Data_Array["record"]=array();
$stmrPesanan = $pesanan->read();
$num = $stmrPesanan->rowCount();
if($num>0){
    while ($rowPesanan = $stmrPesanan->fetch(PDO::FETCH_ASSOC)) {
        extract($rowPesanan);
        $customer->IdCustomer = $IdCustomer;
        $customer->readOne();
        $ItemPesanan = array(
            'IdPesanan' => $IdPesanan,
            'KodePesanan' => $KodePesanan,
            'IdCustomer' => $IdCustomer,
            'NamaCustomer' => $customer->NamaCustomer,
            'Kontak'=> $customer->Kontak,
            'Alamat' =>$customer->Alamat,
            'Sex'=>$customer->Sex,
            'Email' => $customer->Email,
            'TanggalPesan' => $TanggalPesan,
            'TanggalCheckin' => $TanggalCheckin,
            'TanggalCheckout' => $TanggalCheckout,
            'Status' => $Status,
            'Pembayaran' => $Pembayaran,
            'Kamar' => array() 
        );
        $detail->IdPesanan = $IdPesanan;
        $stmtDetail = $detail->readByPesanan();
        while($rowDetail= $stmtDetail->fetch(PDO::FETCH_ASSOC)){
            extract($rowDetail);
            $kamar->IdKamar = $IdKamar;
            $kamar->readOne();
            $ItemKamar = array(
                'IdKamar' => $kamar->IdKamar,
                'NomorKamar' => $kamar->NomorKamar,
                'Harga' => $kamar->Harga,
                'Description' => $kamar->Description 
            );
            array_push($ItemPesanan["Kamar"], $ItemKamar);
        }
        array_push($Data_Array["record"], $ItemPesanan);
    }
    echo json_encode($Data_Array);
}

?>