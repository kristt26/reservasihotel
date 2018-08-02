<?php
class Kamar
{
    private $conn;
    private $table_name = "kamar";
    public $IdKamar;
    public $NomorKamar;
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
        $stmt->bindParam(1, $this->$IdKamar);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->NomorKamar = $row["NomorKamar"];
        $this->Description = $row["Description"];
    }
    public function create()
    {
        $query = "INSERT INTO ".$this->table_name." SET NomorKamar=?, Description=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->NomorKamar);
        $stmt->bindParam(2, $this->Description);
        if($stmt->execute()){
            return true;
        }else {
            return false;
        }
    }
    public function update()
    {
        $query = "UPDATE ".$this->table_name." SET NomorKamar=?, Description=? WHERE IdKamar=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->NomorKamar);
        $stmt->bindParam(2, $this->Description);
        $stmt->bindParam(3, $this->Status);
        if($stmt->execute())
        {
            return true;
        }else
            return false;
    }
}

?>