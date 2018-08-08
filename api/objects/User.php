<?php
class User
{
    private $conn;
    private $table_name = "user";
    public $IdUser;
    public $Username;
    public $Password;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function read()
    {
        $query = "SELECT * FROM ". $this->table_name." WHERE Username = ?, Password=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->Username);
        $stmt->bindParam(2, $this->Password);
        $stmt->execute();
        return $stmt;
    }
}

?>