<?php
// Iniciar sesión para manejar la autenticación
session_start();

// Conectar a la base de datos
require_once("database.php");
$con = conectar();

// Obtener los datos del formulario y crear el usuario
$nombre = $_POST["nombre"];
$pass = $_POST["pass"];
$tipo = $_POST["tipo"]; // El tipo de usuario es pasado desde el formulario (1 = User, 0 = Admin)

// Crear el nuevo usuario en la base de datos
crear_usuario($con, $nombre, $pass, $tipo);

// Cerrar la conexión a la base de datos
cerrar_conexion($con);

// Redirigir al usuario al inicio
header("Location: index.php");
exit();
?>
