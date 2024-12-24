<?php
session_start();
require_once "../includes/conexion.php";
require_once "../models/usuario.php";
require_once "../models/crud_usuario.php";
require_once "../models/CuentaAhorros.php";       
require_once "../models/crud_cuenta_ahorros.php"; 

$crud = new CrudUsuario();
$crudCuenta = new CrudCuentaAhorros();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_GET['action'] ?? '';

 
    if ($accion === 'register') {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $existe = $crud->buscarUsuarioPorEmail($email);
        if ($existe) {
        echo "email_duplicado";
        exit();
        }
    
        $usuario = new Usuario($nombre, $email, $password);

  
        if ($crud->insertarUsuario(usuario: $usuario)) {
            echo "registro_exitoso"; 
        } else {
            echo "error_registro";
        }
        exit(); 
    }
    elseif ($accion === 'eliminar_usuario') {
        ob_clean();
        $id_usuario = $_SESSION['id_usuario'] ?? null;
    
        if ($id_usuario) {
            // Eliminar primero las cuentas del usuario
            if ($crudCuenta->eliminarCuentasPorUsuario($id_usuario)) {
                // Ahora eliminar al usuario
                if ($crud->eliminarUsuario($id_usuario)) {
                    session_destroy(); // Cerrar la sesión del usuario
                    echo "usuario_eliminado";
                } else {
                    echo "error_eliminar_usuario";
                }
            } else {
                echo "error_eliminar_cuentas";
            }
        } else {
            echo "no_autorizado";
        }
        exit();
    }
    
    
    // Login de usuarios
    else {
        $email = $_POST['usuario']?? null;
        $password = $_POST['password']??null;
        
        // Buscar el usuario por email
        $usuario = $crud->buscarUsuarioPorEmail($email);

        if ($usuario && password_verify($password, $usuario['clave'])) {
            // Iniciar sesión
            $_SESSION['usuario'] = $usuario['nombre'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['id_usuario'] = $usuario['id'];
            
            // Respuesta para AJAX
            echo "success";
        } else {
            // Mensaje de error
            echo "error";
        }
        
    }
    
    
    // Crear una cuenta de ahorros
    if ($accion === 'crear_cuenta') {
        ob_clean();
        $id_usuario = $_POST['id_usuario'];
        $numero_cuenta = $_POST['numero_cuenta'];
        $saldo_inicial = $_POST['saldo'];

        $cuenta = new CuentaAhorros($id_usuario, $numero_cuenta, $saldo_inicial);

        if ($crudCuenta->crearCuenta($cuenta)) {
            echo "cuenta_creada";
        } else {
            echo "error_cuenta";
        }
        exit();
    }
     // Eliminar una cuenta de ahorros
     if ($accion === 'eliminar_cuenta') {
        ob_clean();
        $id_cuenta = $_POST['id_cuenta'];
        if ($crudCuenta->eliminarCuenta($id_cuenta)) {
            echo "cuenta_eliminada";
        } else {
            echo "error_eliminar";
        }
        exit();
    }

    // Depositar saldo a una cuenta
    if ($accion === 'depositar') {
        ob_clean();
        $id_cuenta = $_POST['id_cuenta'];
        $monto = $_POST['monto'];

        if ($crudCuenta->depositarSaldo($id_cuenta, $monto)) {
            echo "deposito_exitoso";
        } else {
            echo "error_deposito";
        }
        exit();
    }

    // Retirar saldo de una cuenta
    if ($accion === 'retirar') {
        ob_clean();
        $id_cuenta = $_POST['id_cuenta'];
        $monto = $_POST['monto'];

        if ($crudCuenta->retirarSaldo($id_cuenta, $monto)) {
            echo "retiro_exitoso";
        } else {
            echo "error_retiro";
        }
        exit();
    }

    elseif ($accion === 'actualizar_usuario') {
        ob_clean();
        $id_usuario = $_SESSION['id_usuario'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

    if ($id_usuario && $nombre && $email) {
        $passwordHashed = $password ? password_hash($password, PASSWORD_DEFAULT) : null;
        if ($crud->actualizarUsuario($id_usuario, $nombre, $email, $passwordHashed)) {
            // Actualizar la sesión con los nuevos datos
            $_SESSION['usuario'] = $nombre;
            $_SESSION['email'] = $email;

            echo "usuario_actualizado";
        } else {
            echo "error_actualizar";
        }
    } else {
        echo "datos_incompletos";
    }
    exit();
    }
    

}
?>
