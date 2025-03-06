<?php
/// Parámetros de conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "root";  
$db_name = "negocio";

$con;

// Función para conectar a la base de datos y crear la base de datos y tablas necesarias
function conectar(){
	$con = mysqli_connect($GLOBALS["host"], $GLOBALS["user"], $GLOBALS["password"]);
	if (!$con) {
		// Si hay error, mostrarlo de manera más detallada
		die("Error al conectar con la base de datos: " . mysqli_connect_error());
	}
	crear_bdd($con); // Llama a la función para crear la base de datos si no existe
	mysqli_select_db($con, $GLOBALS["db_name"]); // Selecciona la base de datos
	crear_tabla_usuario($con); // Crea la tabla de usuarios si no existe
	return $con;
}

// Función para crear la base de datos si no existe
function crear_bdd($con){
	mysqli_query($con, "create database if not exists ".$GLOBALS["db_name"].";");
}

// Función para crear la tabla de usuarios si no existe
function crear_tabla_usuario($con){
	mysqli_query($con, "create table if not exists usuario(
	id_usuario int auto_increment primary key,
    nombre varchar(100),
	pass varchar(255),
	tipo int);");
    crear_admin($con); // Llama a la función para crear el usuario administrador
}

// Función para crear un usuario administrador si no existe
function crear_admin($con){
	$resultado = existe_admin($con); // Verifica si el administrador ya existe
	if(obtener_num_filas($resultado) == 0){ // Si no existe, lo crea
		$admin_name = "admin";
		$password = password_hash($admin_name, PASSWORD_DEFAULT); // Cifra la contraseña
		$admin_type = 0;
		$stmt = mysqli_prepare($con, "insert into usuario(nombre, pass, tipo) values(?,?,?);");
		mysqli_stmt_bind_param($stmt, "ssi", $admin_name, $password, $admin_type);
		mysqli_stmt_execute($stmt);
	}
}

// Función para verificar si ya existe un usuario administrador
function existe_admin($con){
	$result = mysqli_query($con, "select * from usuario where tipo=0");
	return $result;
}

// Función para obtener el número de filas en una consulta
function obtener_num_filas($resultado){
	return mysqli_num_rows($resultado);
}

// Función para realizar el login del usuario
function login($con, $username, $password){
	$stmt = mysqli_prepare($con, "select * from usuario where nombre=?;");
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if(obtener_num_filas($result) > 0){ // Si el usuario existe
		$datosUsuario = mysqli_fetch_array($result);
		if(password_verify($password, $datosUsuario['pass'])){ // Verifica la contraseña
			return $datosUsuario; // Retorna los datos del usuario si es correcto
		}
		return false; // Contraseña incorrecta
	}
	return false; // Usuario no encontrado
}

// Función para obtener un único resultado de una consulta
function obtener_resultados($resultado){
	return mysqli_fetch_array($resultado);
}

// Función para cerrar la conexión a la base de datos
function cerrar_conexion($con){
	mysqli_close($con);
}

// Funciones para manejar la tabla de usuarios

// Función para crear un nuevo usuario
function crear_usuario($con, $nombre, $pass, $tipo){
	$password = password_hash($pass, PASSWORD_DEFAULT); // Cifra la contraseña
	$stmt = mysqli_prepare($con, "insert into usuario(nombre, pass, tipo) values(?,?,?);");
	mysqli_stmt_bind_param($stmt, "ssi", $nombre, $password, $tipo);
	mysqli_stmt_execute($stmt);
	return $resultado;
}

// Función para borrar usuarios de la base de datos
function borrar_usuarios($con, $codigos){
	$consulta = "delete from usuario where id_usuario in (";
	foreach($codigos as $codigo){
		$consulta .= "$codigo, "; // Crear la consulta de eliminación para cada código
	}
	$consulta .= "0)"; // Se asegura de que no queden valores incorrectos
	mysqli_query($con, $consulta);
}

// Función para modificar los datos de un usuario
function modificar_usuario($con, $id_usuario, $nombre, $pass, $tipo){
	$password = password_hash($pass, PASSWORD_DEFAULT); // Cifra la nueva contraseña
	$stmt = mysqli_prepare($con, "update usuario set nombre=?, pass=?, tipo=? where id_usuario=?");
	mysqli_stmt_bind_param($stmt, "ssii", $nombre, $password, $tipo, $id_usuario);
	mysqli_stmt_execute($stmt);
}

// Función para obtener todos los usuarios
function obtener_usuarios($con){
	$result = mysqli_query($con, "select * from usuario");
	return $result;
}

// Función para obtener un solo usuario
function obtener_usuario($con, $id){
	$result = mysqli_query($con, "select * from usuario where id_usuario = $id");
	return $result;
}
?>
