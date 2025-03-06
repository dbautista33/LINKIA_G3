<?php
// Iniciar sesión para manejar la autenticación
session_start();

// Conectar a la base de datos
require_once("database.php");
$con = conectar();

// Validación de los datos recibidos (asegurándonos de que son códigos válidos)
if (isset($_POST['borrar']) && is_array($_POST['borrar'])) {
    // Sanitizar los datos para asegurarnos de que solo recibimos valores enteros
    $codigos = array_map('intval', $_POST['borrar']);
} else {
    // Si los datos no son válidos, mostramos un error y terminamos la ejecución
    die('Datos inválidos');
}

// Llamar a la función para eliminar los usuarios seleccionados
borrar_usuarios($con, $codigos);

// Cerrar la conexión a la base de datos de manera segura
cerrar_conexion($con);

// Redirigir al panel de administración después de la eliminación
header('Location: admin_page.php');
exit;
?>
