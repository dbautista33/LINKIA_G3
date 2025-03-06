<?php
// Iniciar la sesión para gestionar la desconexión
session_start();

// Destruir la sesión para cerrar la sesión del usuario
session_destroy();

// Redirigir al usuario a la página de inicio
header("Location: index.php");
exit;
?>