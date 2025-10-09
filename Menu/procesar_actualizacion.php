<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nombre_base_datos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recoger datos del formulario
$user_id = $_POST['id'];
$nombre = $_POST['nombre'];
$usuario = $_POST['username'];
$email = $_POST['email'];
$rol = $_POST['rol'];
$estado = $_POST['es77777777
tado'];

// Si se proporcionó una nueva contraseña, actualizarla
if (!empty($_POST['password'])) {
    $contrasena = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET nombre=?, usuario=?, email=?, contrasena=?, rol=?, estado=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nombre, $usuario, $email, $contrasena, $rol, $estado, $user_id);
} else {
    $sql = "UPDATE usuarios SET nombre=?, usuario=?, email=?, rol=?, estado=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $usuario, $email, $rol, $estado, $user_id);
}

// Ejecutar la actualización
if ($stmt->execute()) {
    header("Location: editar_usuario.php?id=$user_id&status=success");
} else {
    header("Location: editar_usuario.php?id=$user_id&status=error");
}

$conn->close();
