<?php
class DetailPesanan
{
    private $conn;
    private $table_name = "detailpesanan";
    public $IdDetailPesanan;
    public $IdPesanan;
    public $IdKamar;
    public $DataDetail = array('record' => array());
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
    public function readByPesanan()
    {
        $query = "SELECT * FROM ". $this->table_name." WHERE IdPesanan =? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->IdPesanan);
        $stmt->execute();
        return $stmt;
    }
    public function readById()
    {
        $query = "SELECT * FROM ". $this->table_name." WHERE IdPesanan =? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->IdPesanan);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET IdPesanan=?, IdKamar=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->IdPesanan);
        $stmt->bindParam(2, $this->IdKamar);
        if($stmt->execute()){
            $this->IdDetailPesanan = $this->conn->lastInsertId();
            return true;
        }else {
            return false;
        }
    }
}



?>