<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a PROYECTO 2025</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <!-- Título -->
        <h1>Bienvenido a PROYECTO 2025</h1>
        <h2>Inicia sesión</h2>

        <!-- Formulario de Login -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="text" name="username" placeholder="Usuario" required> <!-- Campo de texto para el nombre de usuario -->
            <input type="password" name="password" placeholder="Contraseña" required> <!-- Campo de contraseña -->
            <input type="submit" name="login" value="Login"> <!-- Botón de envío para login -->
        </form>

        <!-- Mensaje de error si las credenciales no son correctas -->
        <?php
        if (isset($_POST['login'])) { // Si el formulario de login fue enviado
            session_start(); // Iniciar sesión para manejar el acceso
            require("database.php");
            $con = conectar(); // Conectar a la base de datos

            $usuario = login($con, $_POST['username'], $_POST['password']); // Verificar las credenciales
            if (empty($usuario)) { // Si el usuario no es encontrado o las credenciales son incorrectas
                echo '<div class="message error">Las credenciales introducidas no son correctas.</div>';
            } else { // Si las credenciales son correctas
                $_SESSION['logged_user'] = $usuario['id_usuario']; // Almacenar el ID de usuario en la sesión
                $_SESSION['logged_user_name'] = $usuario['nombre']; // Almacenar el nombre del usuario en la sesión
                $_SESSION['logged_user_type'] = $usuario['tipo']; // Almacenar el tipo de usuario (admin o user)

                // Redirigir a la página correspondiente según el tipo de usuario
                if ($usuario['tipo'] == 0) {
                    header("Location: admin_page.php"); // Si es administrador, redirigir a la página de administración
                } else {
                    header("Location: user_page.php"); // Si es usuario, redirigir a la página de usuario
                }
                exit(); // Terminar el script para evitar la ejecución posterior
            }
        }
        ?>

        <!-- Enlace para registrarse -->
        <div class="register-link">
            <p>¿No tienes una cuenta? <a href="registrousuario.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>