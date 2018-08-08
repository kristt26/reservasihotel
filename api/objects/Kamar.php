<?php
class Kamar
{
    private $conn;
    private $table_name = "kamar";
    public $IdKamar;
    public $NomorKamar;
    public $Harga;
    public $Description;
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
        $query = "SELECT * FROM ". $this->table_name." WHERE IdKamar=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->IdKamar);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->NomorKamar = $row["NomorKamar"];
        $this->Harga = $row["Harga"];
        $this->Description = $row["Description"];
    }
    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET NomorKamar=?, Harga=?, Description=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->NomorKamar);
        $stmt->bindParam(2, $this->Harga);
        $stmt->bindParam(3, $this->Description);
        if($stmt->execute()){
            return true;
        }else {
            return false;
        }
    }
    public function update()
    {
        $query = "UPDATE ".$this->table_name." SET NomorKamar=?, Harga=?, Description=? WHERE IdKamar=?";
        $stmt->bindParam(1, $this->NomorKamar);
        $stmt->bindParam(2, $this->Harga);
        $stmt->bindParam(3, $this->Description);
        if($stmt->execute())
        {
            return true;
        }else
            return false;
    }
}

?>