<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <?php
    // Iniciar sesión para manejar la autenticación
    session_start();

    // Verificar si el usuario está logueado
    if (!isset($_SESSION['logged_user'])) {
        header("Location: index.php"); // Redirigir al login si no está logueado
        exit();
    }

    // Conectar a la base de datos
    require_once("database.php");
    $con = conectar();

    // Verificar si el usuario tiene privilegios de administrador
    if ($_SESSION['logged_user_type'] != 0) {
        echo "No puedes acceder a esta página"; // Mensaje de acceso denegado
        exit();
    }

    // Mostrar mensaje de bienvenida al administrador con sanitización para evitar vulnerabilidades XSS
    echo "<h2>Bienvenido, " . htmlspecialchars($_SESSION['logged_user_name']) . "</h2>";
    ?>

    <!-- Gestión de usuarios -->
    <?php
    // Llamar al archivo que maneja la gestión de usuarios
    require_once("gestion_usuarios.php");
    ?>

    <a href="logout.php"><button class="logout">Cerrar sesión</button></a> <!-- Botón para cerrar sesión -->
</body>
</html>
