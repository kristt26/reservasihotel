<?php
class SendSMS
{
    private $conn;
    private $table_name = "outbox";
    public $SendingDateTime;
    public $DestinationNumber;
    public $TextDecoded;
    public $CreatorID;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function createBoking()
    {
        $query = "INSERT INTO ".$this->table_name." SET DestinationNumber=?, TextDecoded=?, CreatorID=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->DestinationNumber);
        $stmt->bindParam(2, $this->TextDecoded);
        $stmt->bindParam(3, $this->CreatorID);
        if($stmt->execute()){
            return true;
        }else {
            return false;
        }
    }
    public function createOut()
    {
        $query = "INSERT INTO ".$this->table_name." SET SendingDateTime=?, DestinationNumber=?, TextDecoded=?, CreatorID=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->SendingDateTime);
        $stmt->bindParam(2, $this->DestinationNumber);
        $stmt->bindParam(3, $this->TextDecoded);
        $stmt->bindParam(4, $this->CreatorID);
        if($stmt->execute()){
            return true;
        }else {
            return false;
        }
    }

}

?>