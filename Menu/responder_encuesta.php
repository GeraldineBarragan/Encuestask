<?php
require_once 'conexion.php';

$database = new Database();
$db = $database->getConnection();

$encuesta_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener encuesta
$query = "SELECT * FROM encuestas WHERE id = ? AND estado = 'activa' 
          AND (fecha_limite IS NULL OR fecha_limite >= CURDATE())";
$stmt = $db->prepare($query);
$stmt->execute([$encuesta_id]);
$encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$encuesta) {
    header('Location: encuestas.php?error=Encuesta+no+encontrada+o+no+disponible');
    exit;
}

// Obtener preguntas con opciones
$query = "SELECT p.*, 
          (SELECT COUNT(*) FROM opciones o WHERE o.pregunta_id = p.id) as total_opciones
          FROM preguntas p 
          WHERE p.encuesta_id = ? 
          ORDER BY p.orden";
$stmt = $db->prepare($query);
$stmt->execute([$encuesta_id]);
$preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($preguntas as &$pregunta) {
    if ($pregunta['tipo'] !== 'texto_libre') {
        $query = "SELECT * FROM opciones WHERE pregunta_id = ? ORDER BY orden";
        $stmt = $db->prepare($query);
        $stmt->execute([$pregunta['id']]);
        $pregunta['opciones'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Procesar respuesta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->beginTransaction();
        $usuario_id = 1; // En sistema real, sería el usuario logueado

        foreach ($_POST['respuestas'] as $pregunta_id => $respuesta) {
            // Validar preguntas obligatorias
            $pregunta_actual = array_filter($preguntas, function ($p) use ($pregunta_id) {
                return $p['id'] == $pregunta_id;
            });
            $pregunta_actual = reset($pregunta_actual);

            if ($pregunta_actual['obligatoria'] && empty($respuesta)) {
                throw new Exception("La pregunta '{$pregunta_actual['pregunta']}' es obligatoria");
            }

            if (!empty($respuesta)) {
                if ($pregunta_actual['tipo'] === 'texto_libre') {
                    $query = "INSERT INTO respuestas (encuesta_id, pregunta_id, usuario_id, respuesta_texto) 
                              VALUES (?, ?, ?, ?)";
                    $stmt = $db->prepare($query);
                    $stmt->execute([$encuesta_id, $pregunta_id, $usuario_id, $respuesta]);
                } else {
                    // Para opciones múltiples
                    if (is_array($respuesta)) {
                        foreach ($respuesta as $opcion_id) {
                            $query = "INSERT INTO respuestas (encuesta_id, pregunta_id, usuario_id, opcion_id) 
                                      VALUES (?, ?, ?, ?)";
                            $stmt = $db->prepare($query);
                            $stmt->execute([$encuesta_id, $pregunta_id, $usuario_id, $opcion_id]);
                        }
                    } else {
                        // Para opción única
                        $query = "INSERT INTO respuestas (encuesta_id, pregunta_id, usuario_id, opcion_id) 
                                  VALUES (?, ?, ?, ?)";
                        $stmt = $db->prepare($query);
                        $stmt->execute([$encuesta_id, $pregunta_id, $usuario_id, $respuesta]);
                    }
                }
            }
        }

        $db->commit();
        header('Location: encuestas.php?mensaje=Encuesta+respondida+exitosamente');
        exit;
    } catch (Exception $e) {
        $db->rollBack();
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responder Encuesta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><?php echo htmlspecialchars($encuesta['titulo']); ?></h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <p class="text-muted"><?php echo htmlspecialchars($encuesta['descripcion']); ?></p>

                        <form method="POST">
                            <?php foreach ($preguntas as $pregunta): ?>
                                <div class="mb-4">
                                    <h6>
                                        <?php echo htmlspecialchars($pregunta['pregunta']); ?>
                                        <?php if ($pregunta['obligatoria']): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </h6>

                                    <?php if ($pregunta['tipo'] === 'texto_libre'): ?>
                                        <textarea class="form-control" name="respuestas[<?php echo $pregunta['id']; ?>]"
                                            rows="3" <?php echo $pregunta['obligatoria'] ? 'required' : ''; ?>></textarea>
                                    <?php elseif ($pregunta['tipo'] === 'opcion_unica'): ?>
                                        <?php foreach ($pregunta['opciones'] as $opcion): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="respuestas[<?php echo $pregunta['id']; ?>]"
                                                    value="<?php echo $opcion['id']; ?>"
                                                    <?php echo $pregunta['obligatoria'] ? 'required' : ''; ?>>
                                                <label class="form-check-label">
                                                    <?php echo htmlspecialchars($opcion['opcion_texto']); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <?php foreach ($pregunta['opciones'] as $opcion): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="respuestas[<?php echo $pregunta['id']; ?>][]"
                                                    value="<?php echo $opcion['id']; ?>">
                                                <label class="form-check-label">
                                                    <?php echo htmlspecialchars($opcion['opcion_texto']); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">Enviar Respuestas</button>
                                <a href="encuestas.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>