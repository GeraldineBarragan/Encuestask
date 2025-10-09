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

// Obtener ID del usuario a editar
$user_id = $_GET['id'] ?? 0;

// Consulta SQL para obtener los datos del usuario
$sql = "SELECT id, nombre, usuario, contrasena, email, rol, estado, fecha_creacion 
        FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    die("Usuario no encontrado");
}

$conn->close();
?>

<!-- Aquí iría el formulario HTML con los valores de $usuario -->