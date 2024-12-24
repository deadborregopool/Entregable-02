<?php
require_once "../includes/conexion.php";
require_once "CuentaAhorros.php";

class CrudCuentaAhorros {
    private $db;

    public function __construct() {
        $this->db = (new Conexion())->conn;
    }

    // 1. Crear una nueva cuenta de ahorros
    public function crearCuenta($cuenta) {
        $sql = "INSERT INTO cuentas_ahorros (id_usuario, numero_cuenta, saldo) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cuenta->id_usuario, $cuenta->numero_cuenta, $cuenta->saldo]);
    }

    // 2. Obtener cuentas de un usuario por ID
    public function obtenerCuentasPorUsuario($id_usuario) {
        $sql = "SELECT * FROM cuentas_ahorros WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Actualizar saldo de una cuenta
    public function actualizarSaldo($id_cuenta, $nuevo_saldo) {
        $sql = "UPDATE cuentas_ahorros SET saldo = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nuevo_saldo, $id_cuenta]);
    }

    // 4. Eliminar una cuenta de ahorros
    public function eliminarCuenta($id_cuenta) {
        $sql = "DELETE FROM cuentas_ahorros WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_cuenta]);
    }

    public function depositarSaldo($id_cuenta, $monto) {
        try {
            $sql = "UPDATE cuentas_ahorros SET saldo = saldo + :monto WHERE id = :id_cuenta";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':monto', $monto);
            $stmt->bindParam(':id_cuenta', $id_cuenta);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function retirarSaldo($id_cuenta, $monto) {
        try {
            // Verificar que el saldo sea suficiente
            $sql = "SELECT saldo FROM cuentas_ahorros WHERE id = :id_cuenta";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_cuenta', $id_cuenta);
            $stmt->execute();
            $saldoActual = $stmt->fetchColumn();
    
            if ($saldoActual >= $monto) {
                // Actualizar el saldo
                $sql = "UPDATE cuentas_ahorros SET saldo = saldo - :monto WHERE id = :id_cuenta";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':monto', $monto);
                $stmt->bindParam(':id_cuenta', $id_cuenta);
                return $stmt->execute();
            } else {
                return false; // Saldo insuficiente
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function eliminarCuentasPorUsuario($id_usuario) {
        try {
            $sql = "DELETE FROM cuentas_ahorros WHERE id_usuario = :id_usuario";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
   
    

}
?>
