<?php
require_once "../includes/conexion.php"; 
require_once "usuario.php";

     

class CrudUsuario {
    private $db;

    public function __construct() {
        $this->db = (new Conexion())->conn;
    }

    public function insertarUsuario($usuario): mixed {
        $sql = "INSERT INTO usuarios (nombre, email, clave) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare(query: $sql);
        return $stmt->execute([$usuario->nombre, $usuario->email, $usuario->clave]);
    }

    public function buscarUsuarioPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function eliminarUsuario($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    public function actualizarUsuario($id, $nombre, $email, $password = null) {
        try {
            $sql = "UPDATE usuarios SET nombre = :nombre, email = :email";
            if ($password) {
                $sql .= ", clave = :clave";
            }
            $sql .= " WHERE id = :id";
    
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id);
            if ($password) {
                $stmt->bindParam(':clave', $password);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    

}
?>
