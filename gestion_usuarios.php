<?php
// Mostrar el título de la página
echo "<h2>Gestión de usuarios</h2>";

// Obtener todos los usuarios desde la base de datos
$resultado = obtener_usuarios($con);
$num_filas = obtener_num_filas($resultado);

// Mostrar la tabla de usuarios solo si existen resultados
if ($num_filas > 0) {
    echo "<div class='table-container'>";
    echo "<table class='user-table'>
        <form method='post' action='borrarusuarios.php'>
        <thead>
            <tr>
                <th>NOMBRE</th>
                <th>TIPO</th>
                <th>Modificar</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>";

    // Recorrer los usuarios y mostrarlos en la tabla
    while ($fila = obtener_resultados($resultado)) {
        extract($fila); // Extraer los datos del usuario
        echo "<tr><td>" . htmlspecialchars($nombre) . "</td><td>"; // Mostrar el nombre y tipo de usuario de forma segura
        if ($tipo == 0) {
            echo "ADMIN";
        } else {
            echo "USER";
        }
        echo "</td>
            <td><a href='modificarusuario.php?id=$id_usuario' class='modify-link'>Modificar</a></td>
            <td><input type='checkbox' name='borrar[]' value='$id_usuario'></td>
        </tr>";
    }

    // Botón para borrar usuarios seleccionados
    echo "<tr><td colspan='4' style='text-align:right'><input type='submit' value='Borrar' class='delete-button'/></td></tr>
        </form></tbody></table>";
    echo "</div>";
} else {
    echo "<p>No hay usuarios registrados.</p>"; // Mensaje si no hay usuarios registrados
}

// Formulario para crear un nuevo usuario
echo "<h3>Crear nuevo usuario</h3>";
echo "<form method='post' action='nuevousuario.php' class='create-user-form'>
        <label for='nombre'>Nombre:</label>
        <input type='text' name='nombre' required><br/>
        <label for='pass'>Password:</label>
        <input type='password' name='pass' required><br/>
        <label for='tipo'>Tipo:</label>
        <select name='tipo' required>
            <option value='0'>Admin</option>
            <option value='1'>User</option>
        </select><br/>
        <input type='submit' value='Crear' class='submit-button'/>
    </form>";

// Línea divisoria para separar secciones
echo "<hr>";
?>