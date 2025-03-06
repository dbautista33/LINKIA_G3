<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Usuario - PROYECTO 2025</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo de estilos -->
</head>
<body>
    <div class="container">
        <h1>Crear nuevo usuario</h1>

        <!-- Formulario para crear nuevo usuario -->
        <form method="post" action="nuevousuario.php">
            <input type="text" name="nombre" placeholder="Nombre" required> <!-- Campo de nombre -->
            <input type="password" name="pass" placeholder="Contraseña" required> <!-- Campo de contraseña -->
            
            <!-- Selección del tipo de usuario (Admin o User) -->
            <select name="tipo" required> 
                <option value="1">User</option> 
                <option value="0">Admin</option> <!-- Opción para crear un Administrador -->
            </select>
            
            <input type="submit" value="Crear"> <!-- Botón para enviar el formulario -->
        </form>

        <hr> <!-- Línea divisoria -->
        <div class="back-link">
            <a href="index.php">Volver al inicio</a> <!-- Enlace para volver al inicio -->
        </div>
    </div>
</body>
</html>
