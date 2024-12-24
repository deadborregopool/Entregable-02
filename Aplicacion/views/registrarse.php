<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Importar Hoja de Estilos -->
    <link rel="stylesheet" href="../css/registro.css">
    <!-- Importar Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <!-- Importar JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Contenedor principal -->
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form id="registroForm" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Registrarse</button>
        </form>

        <div id="resultado"></div>

        <p>¿Ya tienes una cuenta? <a href="index.php">Volver al login</a></p>
    </div>

    <!-- Script para manejar el formulario con AJAX -->
    <script>
        $("#registroForm").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: "../controllers/controller_login.php?action=register",
                method: "POST",
                data: {
                    nombre: $("#nombre").val(),
                    email: $("#email").val(),
                    password: $("#password").val()
                },
                success: function(response) {
                    if (response.trim() === "registro_exitoso") {
                        alert("¡Registro exitoso! Redirigiendo al login...");
                        window.location.href = "index.php";
                    } else if (response.trim() === "email_duplicado") {
                        $("#resultado").html("<p>El email ya está registrado.</p>");
                    } else {
                        $("#resultado").html("<p>Error al registrar el usuario.</p>");
                    }
                },
                error: function() {
                    $("#resultado").html("<p>Error en la solicitud AJAX.</p>");
                }
            });
        });
    </script>
</body>
</html>
