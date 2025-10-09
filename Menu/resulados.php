<?php
require_once 'conexion.php';

$database = new Database();
$db = $database->getConnection();

$encuesta_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener encuesta
$query = "SELECT * FROM encuestas WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$encuesta_id]);
$encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$encuesta) {
    header('Location: encuestas.php?error=Encuesta+no+encontrada');
    exit;
}

// Obtener estadísticas generales
$query = "SELECT COUNT(DISTINCT usuario_id) as total_respondientes FROM respuestas WHERE encuesta_id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$encuesta_id]);
$estadisticas = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener preguntas con resultados
$query = "SELECT p.* FROM preguntas p WHERE p.encuesta_id = ? ORDER BY p.orden";
$stmt = $db->prepare($query);
$stmt->execute([$encuesta_id]);
$preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($preguntas as &$pregunta) {
    if ($pregunta['tipo'] !== 'texto_libre') {
        // Obtener opciones con conteo de respuestas
        $query = "SELECT o.*, 
                 (SELECT COUNT(*) FROM respuestas r WHERE r.opcion_id = o.id) as total_respuestas
                 FROM opciones o 
                 WHERE o.pregunta_id = ? 
                 ORDER BY o.orden";
        $stmt = $db->prepare($query);
        $stmt->execute([$pregunta['id']]);
        $pregunta['opciones'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Total respuestas para esta pregunta
        $query = "SELECT COUNT(*) as total FROM respuestas WHERE pregunta_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$pregunta['id']]);
        $pregunta['total_respuestas'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    } else {
        // Obtener respuestas de texto libre
        $query = "SELECT respuesta_texto FROM respuestas WHERE pregunta_id = ? AND respuesta_texto IS NOT NULL";
        $stmt = $db->prepare($query);
        $stmt->execute([$pregunta['id']]);
        $pregunta['respuestas_texto'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-