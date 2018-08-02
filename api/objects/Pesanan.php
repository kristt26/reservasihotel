<?php
class Pesanan
{
    private $conn;
    private $table_name = "pesanan";
    public $IdPesanan;
    public $KodePesanan;
    public $IdCustomer;
    public $IdKamar;
    public $TanggalPesan;
    public $TanggalCheckin;
    public $TanggalCheckout;
    public $Status;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function read()
    {
        $query = "SELECT * FROM ". $this->table_name."";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function readByStatus()
    {
        $query = "SELECT * FROM ". $this->table_name." WHERE IdKamar=:IdKamar and ((TanggalCheckin>=:TanggalCheckin and TanggalCheckin<=:TanggalCheckout) or (TanggalCheckout>=:TanggalCheckin and TanggalCheckout<=:TanggalCheckout))";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":IdKamar", $this->IdKamar);
        $stmt->bindParam(":TanggalCheckin", $this->TanggalCheckin);
        $stmt->bindParam(":TanggalCheckout", $this->TanggalCheckout);
        $stmt->execute();
        return $stmt;
    }
    public function readOne()
    {
        $query = "SELECT * FROM ". $this->table_name." WHERE IdPesanan=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->IdPesanan);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->KodePesanan = $row["KodePesanan"];
        $this->IdCustomer = $row["IdCustomer"];
        $this->IdKamar = $row["IdKamar"];
        $this->TanggalPesan = $row["TanggalPesan"];
        $this->TanggalCheckin = $row["TanggalCheckin"];
        $this->TanggalCheckout = $row["TanggalCheckout"];
        $this->Status = $row["Status"];
    }
    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET KodePesanan=?, IdCustomer=?, IdKamar=?, TanggalPesan=?, TanggalCheckin=?, TanggalCheckout=?, Status=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->KodePesanan);
        $stmt->bindParam(2, $this->IdCustomer);
        $stmt->bindParam(3, $this->IdKamar);
        $stmt->bindParam(4, $this->TanggalPesan);
        $stmt->bindParam(5, $this->TanggalCheckin);
        $stmt->bindParam(6, $this->TanggalCheckout);
        $stmt->bindParam(7, $this->Status);
        if($stmt->execute()){
            return true;
        }else {
            return false;
        }
    }
    public function update()
    {
        $query = "UPDATE ".$this->table_name." SET IdCustomer=?, IdKamar=?, TanggalPesan=?, TanggalCheckin=?, TanggalCheckout=?, Status=? WHERE IdPesanan=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->Kontak);
        $stmt->bindParam(2, $this->Alamat);
        $stmt->bindParam(3, $this->Sex);
        $stmt->bindParam(4, $this->Email);
        $stmt->bindParam(5, $this->IdPesanan);
        if($stmt->execute())
        {
            return true;
        }else
            return false;
    }
}

?>