<?php
require_once "../includes/conexion.php";

$conexion = new Conexion();
if ($conexion->conn) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Fallo en la conexión.";
}
?>
