<?php
// Iniciar la sesión para gestionar la autenticación del usuario
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged_user'])) {
    header("Location: index.php"); // Redirigir al login si no está logueado
    exit();
}

// Mostrar mensaje de bienvenida con el nombre del usuario
echo "<h1>Welcome " . htmlspecialchars($_SESSION['logged_user_name']) . "</h1>"; // Sanitizar el nombre del usuario para evitar XSS

// Formulario para cerrar sesión
echo "<form method='post' action='logout.php'><input type='submit' class='logout' value='Cerrar sesión'/></form>";

// Verificar el tipo de usuario para acceder a ciertas páginas
// Sólo los administradores pueden acceder a estas páginas
if (str_contains($_SERVER['PHP_SELF'], "admin_page.php") || str_contains($_SERVER['PHP_SELF'], "nuevousuario.php") || str_contains($_SERVER['PHP_SELF'], "modificarusuario.php") || str_contains($_SERVER['PHP_SELF'], "borrarusuarios.php")) {
    if ($_SESSION['logged_user_type'] != 0) {
        echo "No puedes acceder a esta página"; // Mostrar mensaje de acceso denegado
        exit();
    }
}

// Sólo los usuarios estándar pueden acceder a esta página
if (str_contains($_SERVER['PHP_SELF'], "user_page.php")) {
    if ($_SESSION['logged_user_type'] != 1) {
        echo "No puedes acceder a esta página"; // Mostrar mensaje de acceso denegado
        exit();
    }
}
?>
