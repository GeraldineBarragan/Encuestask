<?php
require_once 'conexion.php';

$database = new Database();
$db = $database->getConnection();

try {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];

    if (empty($nombre) || empty($usuario) || empty($email)) {
        throw new Exception("Todos los campos son obligatorios");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("El correo no es válido");
    }

    $stmt = $db->prepare("UPDATE usuarios SET nombre=?, usuario=?, email=?, rol=?, estado=? WHERE id=?");
    $stmt->execute([$nombre, $usuario, $email, $rol, $estado, $id]);

    echo json_encode(["status" => "success", "message" => "✅ Usuario actualizado correctamente"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "❌ " . $e->getMessage()]);
}
