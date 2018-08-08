<?php
class Customer
{
    private $conn;
    private $table_name = "customer";
    public $IdCustomer;
    public $NamaCustomer;
    public $Kontak;
    public $Alamat;
    public $Sex;
    public $Email;
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
    public function readOne()
    {
        $query = "SELECT * FROM ". $this->table_name." WHERE IdCustomer=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->IdCustomer);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->NamaCustomer = $row["NamaCustomer"];
        $this->Kontak = $row["Kontak"];
        $this->Alamat = $row["Alamat"];
        $this->Sex = $row["Sex"];
        $this->Email = $row["Email"];
    }
    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET NamaCustomer=?, Kontak=?, Alamat=?, Sex=?, Email=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->NamaCustomer);
        $stmt->bindParam(2, $this->Kontak);
        $stmt->bindParam(3, $this->Alamat);
        $stmt->bindParam(4, $this->Sex);
        $stmt->bindParam(5, $this->Email);
        if($stmt->execute()){
            $this->IdCustomer = $this->conn->lastInsertId();
            return true;
        }else {
            return false;
        }
    }
    public function update()
    {
        $query = "UPDATE ".$this->table_name." SET NamaCustomer=?, Kontak=?, Alamat=?, Sex=?, Email=? WHERE IdCustomer=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->NamaCustomer);
        $stmt->bindParam(2, $this->Kontak);
        $stmt->bindParam(3, $this->Alamat);
        $stmt->bindParam(4, $this->Sex);
        $stmt->bindParam(5, $this->Email);
        if($stmt->execute())
        {
            return true;
        }else
            return false;
    }
}

?>