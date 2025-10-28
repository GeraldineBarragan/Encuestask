<?php
require_once 'conexion.php';

$database = new Database();
$db = $database->getConnection();

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->beginTransaction();

        // Insertar encuesta
        $titulo = trim($_POST['titulo']);
        $descripcion = trim($_POST['descripcion']);
        $fecha_limite = !empty($_POST['fecha_limite']) ? $_POST['fecha_limite'] : null;
        $estado = $_POST['estado'];
        $usuario_id = 1; // En un sistema real, tomaría del usuario logueado

        $query = "INSERT INTO encuestas (titulo, descripcion, fecha_limite, estado, usuario_id) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$titulo, $descripcion, $fecha_limite, $estado, $usuario_id]);
        $encuesta_id = $db->lastInsertId();

        // Insertar preguntas
        if (isset($_POST['preguntas'])) {
            foreach ($_POST['preguntas'] as $index => $pregunta_data) {
                $pregunta = trim($pregunta_data['texto']);
                $tipo = $pregunta_data['tipo'];
                $obligatoria = isset($pregunta_data['obligatoria']) ? 1 : 0;

                $query = "INSERT INTO preguntas (encuesta_id, pregunta, tipo, obligatoria, orden) 
                          VALUES (?, ?, ?, ?, ?)";
                $stmt = $db->prepare($query);
                $stmt->execute([$encuesta_id, $pregunta, $tipo, $obligatoria, $index]);
                $pregunta_id = $db->lastInsertId();

                // Insertar opciones si el tipo no es texto_libre
                if ($tipo !== 'texto_libre' && isset($pregunta_data['opciones'])) {
                    foreach ($pregunta_data['opciones'] as $opcion_index => $opcion_texto) {
                        if (!empty(trim($opcion_texto))) {
                            $query = "INSERT INTO opciones (pregunta_id, opcion_texto, orden) 
                                      VALUES (?, ?, ?)";
                            $stmt = $db->prepare($query);
                            $stmt->execute([$pregunta_id, trim($opcion_texto), $opcion_index]);
                        }
                    }
                }
            }
        }

        $db->commit();
        $mensaje = "✅ Encuesta creada exitosamente";
        header("Location: encuestas.php?mensaje=" . urlencode($mensaje));
        exit;
    } catch (Exception $e) {
        $db->rollBack();
        $error = "❌ Error al crear la encuesta: " . $e->getMessage();
    }
}
