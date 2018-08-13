<?php
class Gammu{
    private $host = "localhost";
    private $db_name = "gammu";
    private $username = "root";
    private $password = "";
    public $conn;

    // private $host = "den1.mysql4.gear.host";
    // private $db_name = "gammu";
    // private $username = "gammu";
    // private $password = "Tl0V1~-k7UhD";
    // public $conn;

    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>