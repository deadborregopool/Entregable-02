<?php
class Conexion {
    private $host = "localhost"; 
    private $dbname = "mi_base";  
    private $username = "root";   
    private $password = "";       
    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}
?>