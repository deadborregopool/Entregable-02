<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

require_once "../models/crud_cuenta_ahorros.php";
require_once "../models/CuentaAhorros.php";

$crudCuenta = new CrudCuentaAhorros();
$id_usuario = $_SESSION['id_usuario']; // ID del usuario logueado
$nombre = htmlspecialchars($_SESSION['usuario']);

// Obtener las cuentas existentes del usuario
$cuentas = $crudCuenta->obtenerCuentasPorUsuario($id_usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Cuentas de Ahorro</title>
    <link rel="stylesheet" href="../css/cuenta.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
        <h2>¡Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</h2>
        
        <!-- Actualizar Datos Personales -->
        <div class="seccion-centrada">
        <h3 >Actualizar Datos Personales</h3>
        <button id="toggleActualizar" class="boton-centrado">Mostrar/Ocultar</button>
        <form id="formActualizarUsuario">
            <label>Nombre:</label>
            <input type="text" id="nombre" value="<?php echo htmlspecialchars($_SESSION['usuario']); ?>" required>
            
            <label>Email:</label>
            <input type="email" id="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>

            <label>Nueva Contraseña (opcional):</label>
            <input type="password" id="password">
            <button type="submit">Actualizar</button>
        </form>
        <div id="resultadoActualizar"></div>
        </div>
        <!-- Crear Nueva Cuenta -->
        <div class="seccion-centrada">
        <h3>Crear una Nueva Cuenta de Ahorro</h3>
        <button id="toggleCrearCuenta" class="boton-centrado">Mostrar/Ocultar</button>
        <form id="crearCuentaForm">
            <label>Número de Cuenta:</label>
            <input type="text" id="numero_cuenta" required>
            <label>Saldo Inicial:</label>
            <input type="number" id="saldo" step="0.01" required>
            <button type="submit">Crear Cuenta</button>
        </form>
        <div id="resultado"></div>
        </div>
        <!-- Tabla de Cuentas Existentes -->
        <h3>Tus Cuentas de Ahorro</h3>
        <div class="table-container">
    <?php if (count($cuentas) > 0): ?>
        <table>
            <tr>
                <th>Número de Cuenta</th>
                <th>Saldo</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($cuentas as $cuenta): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cuenta['numero_cuenta']); ?></td>
                    <td><?php echo number_format($cuenta['saldo'], 2); ?></td>
                    <td class="acciones-container">
                        <!-- Botón de Depositar -->
                        <form class="accion depositar" data-id="<?php echo $cuenta['id']; ?>" data-accion="depositar">
                            <input type="number" placeholder="Monto a depositar" step="0.01" required>
                            <button type="submit">Depositar</button>
                        </form>

                        <!-- Botón de Retirar -->
                        <form class="accion retirar" data-id="<?php echo $cuenta['id']; ?>" data-accion="retirar">
                            <input type="number" placeholder="Monto a retirar" step="0.01" required>
                            <button type="submit">Retirar</button>
                        </form>

                        <!-- Botón de Eliminar -->
                        <button class="eliminar" data-id="<?php echo $cuenta['id']; ?>">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <!-- Mostrar mensaje si no hay cuentas -->
        <div class="no-accounts">Usted aún no tiene ninguna cuenta abierta.</div>
    <?php endif; ?>
    </div>
        <br>        
        <!-- Botón de Eliminar Cuenta -->
        <div class="seccion-centrada">
        <button id="eliminarCuenta" class="boton-centrado" >Eliminar Mi Cuenta</button>
        <a href="../controllers/logout.php">Cerrar sesión</a>
        </div>
    </div>
        
    <script>
         // Mostrar/Ocultar formularios
         $("#toggleCrearCuenta").click(function() {
            $("#crearCuentaForm").slideToggle();
        });
        $("#toggleActualizar").click(function() {
            $("#formActualizarUsuario").slideToggle();
        });


        // Crear una nueva cuenta
        $("#crearCuentaForm").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: "../controllers/controller_login.php?action=crear_cuenta",
                method: "POST",
                data: {
                    id_usuario: <?php echo $id_usuario; ?>,
                    numero_cuenta: $("#numero_cuenta").val(),
                    saldo: $("#saldo").val()
                },
                success: function(response) {
                    if (response.trim() === "cuenta_creada") {
                        alert("¡Cuenta creada exitosamente!");
                        location.reload(); // Recargar la página
                    } else {
                        $("#resultado").html("<p style='color:red;'>Error al crear la cuenta.</p>");
                    }
                },
                error: function() {
                    $("#resultado").html("<p style='color:red;'>Error en la solicitud AJAX.</p>");
                }
            });
        });

        // Eliminar una cuenta
        $(".eliminar").click(function() {
            if (!confirm("¿Seguro que deseas eliminar esta cuenta?")) return;

            const id_cuenta = $(this).data("id");

            $.ajax({
                url: "../controllers/controller_login.php?action=eliminar_cuenta",
                method: "POST",
                data: { id_cuenta: id_cuenta },
                success: function(response) {
                    if (response.trim() === "cuenta_eliminada") {
                        alert("Cuenta eliminada exitosamente.");
                        location.reload(); // Recargar la página
                    } else {
                        alert("Error al eliminar la cuenta.");
                    }
                },
                error: function() {
                    alert("Error en la solicitud AJAX.");
                }
            });
        });
        $("#eliminarCuenta").click(function() {
        if (confirm("¿Seguro que deseas eliminar tu cuenta? Esta acción no se puede deshacer.")) {
            $.ajax({
                url: "../controllers/controller_login.php?action=eliminar_usuario",
                method: "POST",
                success: function(response) {
                    if (response.trim() === "usuario_eliminado") {
                        alert("Cuenta eliminada exitosamente. Serás redirigido al inicio.");
                        window.location.href = "index.php"; // Redirigir al login
                    } else {
                        alert("Error al eliminar la cuenta.");
                    }
                },
                error: function() {
                    alert("Error en la solicitud AJAX.");
                }
            });
        }
    });
    $("#formActualizarUsuario").submit(function(event) {
        event.preventDefault();

        $.ajax({
            url: "../controllers/controller_login.php?action=actualizar_usuario",
            method: "POST",
            data: {
                nombre: $("#nombre").val(),
                email: $("#email").val(),
                password: $("#password").val()
            },
            success: function(response) {
                if (response.trim() === "usuario_actualizado") {
                    alert("Datos actualizados exitosamente.");
                    location.reload();
                } else {
                    $("#resultadoActualizar").html("<p style='color:red;'>Error al actualizar los datos.</p>");
                }
            },
            error: function() {
                $("#resultadoActualizar").html("<p style='color:red;'>Error en la solicitud AJAX.</p>");
            }
        });
    });

    </script>
    <script src="../js/cuenta.js"></script>
</body>
</html>
    