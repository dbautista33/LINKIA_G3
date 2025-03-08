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

// Verificar si el usuario tiene privilegios de usuario estándar
if ($_SESSION['logged_user_type'] != 1) {
    echo "<h2>No puedes acceder a esta página. Solo los usuarios estándar tienen acceso.</h2>"; // Mensaje para usuarios sin permisos
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Mostrar mensaje de bienvenida al usuario -->
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['logged_user_name']); ?>!</h1>

        <!-- Opciones para el usuario -->
        <div class="user-options">
            <p>Bienvenido a tu página de usuario.</p>
        </div>

        <!-- Enlace para cerrar sesión -->
        <form method="post" action="logout.php">
            <input  type="submit"  value="Cerrar sesión" class="logout">
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
cerrar_conexion($con);
?>
