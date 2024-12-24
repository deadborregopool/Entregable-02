<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Importar Hoja de Estilos Externa -->
    <link rel="stylesheet" href="../css/index.css">
    <!-- Importar Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <!-- Importar JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
</head>
<body>
    <!-- Contenedor del Login -->
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form id="loginForm" method="POST" action="../controllers/controller_login.php">
            <label for="usuario">Usuario (Email):</label>
            <input type="email" id="usuario" name="usuario" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Ingresar</button>
        </form>

        <div id="resultado"></div>
        <p>¿No tienes una cuenta? <a href="registrarse.php">Regístrate aquí</a></p>
    </div>

    <!-- Script para AJAX -->
    <script>
    $(document).ready(function() {
        // Aplica ajaxForm al formulario
        $("#loginForm").ajaxForm({
            success: function(response) {
                if (response.trim() === "success") {
                    window.location.href = "cuenta.php";
                } else {
                    $("#resultado").html("Usuario o contraseña incorrectos.");
                }
            },
            error: function() {
                $("#resultado").html("Error en la solicitud AJAX.");
            }
        });
    });
    </script>
</body>
</html>
