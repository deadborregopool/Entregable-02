<?php
require_once "../models/crud_cuenta_ahorros.php";
require_once "../models/CuentaAhorros.php";

$crud = new CrudCuentaAhorros();

// Crear una nueva cuenta de ahorros
$cuenta = new CuentaAhorros(12, "123456789", 1000.00); // ID usuario: 1, Número de cuenta: "123456789"
if ($crud->crearCuenta($cuenta)) {
    echo "Cuenta creada exitosamente. <br>";
} else {
    echo "Error al crear la cuenta. <br>";
}

// Obtener cuentas del usuario 1
$cuentas = $crud->obtenerCuentasPorUsuario(12);
echo "Cuentas del usuario 1: <br>";
print_r($cuentas);

// Actualizar saldo de la cuenta con ID 1
if ($crud->actualizarSaldo(11, 2000.00)) {
    echo "Saldo actualizado exitosamente. <br>";
} else {
    echo "Error al actualizar el saldo. <br>";
}

// Eliminar la cuenta con ID 1
if ($crud->eliminarCuenta(11)) {
    echo "Cuenta eliminada exitosamente. <br>";
} else {
    echo "Error al eliminar la cuenta. <br>";
}
?>
