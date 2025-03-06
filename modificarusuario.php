<?php
// Conectar a la base de datos
require_once("header.php");
require_once("database.php");
$con = conectar();

// Verificar si se ha enviado el formulario para modificar un usuario
if (isset($_POST["modificar"])) {
    // Modificar los datos del usuario
    modificar_usuario($con, $_SESSION['id_usuario'], $_POST["nombre"], $_POST["pass"], $_POST["tipo"]);
    unset($_SESSION['id_usuario']); // Eliminar la sesión temporal del usuario modificado
    header('Location: admin_page.php'); // Redirigir al panel de administración
} else {
    // Obtener el ID del usuario desde la URL
    $id_usuario = $_GET["id"];
    $_SESSION['id_usuario'] = $id_usuario; // Guardar el ID del usuario en la sesión

    // Obtener los datos del usuario desde la base de datos
    $resultado = obtener_usuario($con, $id_usuario);
    $num_filas = obtener_num_filas($resultado);

    // Si el usuario no existe, redirigir al panel de administración
    if ($num_filas == 0) {
        header("Location: admin_page.php");
    } else {
        // Obtener los datos del usuario y mostrar el formulario de modificación
        $datos_usuario = obtener_resultados($resultado);
        extract($datos_usuario);

		echo '<link rel="stylesheet" href="styles.css">';

        echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>
            Nombre:<input type='text' name='nombre' value='" . htmlspecialchars($nombre) . "' required><br/> <!-- Sanitización de datos -->
            Password:<input type='password' name='pass' required><br/> <!-- Añadir validación básica -->
            Tipo:<select name='tipo' required>
                <option value='0' " . ($tipo == 0 ? "selected" : "") . ">Admin</option>
                <option value='1' " . ($tipo == 1 ? "selected" : "") . ">User</option>
            </select><br/>
            <input type='submit' name='modificar' value='Modificar'/>
        </form>";
    }
}

// Cerrar la conexión a la base de datos
cerrar_conexion($con);
?>
