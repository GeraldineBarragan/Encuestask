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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Encuesta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-plus-circle me-2"></i>Crear Nueva Encuesta</h1>
                    <a href="encuestas.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" id="formEncuesta">
                    <!-- Datos de la Encuesta -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Información de la Encuesta</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Título de la Encuesta *</label>
                                        <input type="text" class="form-control" name="titulo" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-select" name="estado">
                                            <option value="activa">Activa</option>
                                            <option value="inactiva">Inactiva</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fecha Límite (opcional)</label>
                                <input type="date" class="form-control" name="fecha_limite" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Preguntas -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Preguntas de la Encuesta</h5>
                            <button type="button" class="btn btn-primary btn-sm" onclick="agregarPregunta()">
                                <i class="fas fa-plus me-1"></i>Agregar Pregunta
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="preguntas-container">
                                <!-- Las preguntas se agregarán aquí dinámicamente -->
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save me-1"></i>Guardar Encuesta
                        </button>
                        <a href="encuestas.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Template para nueva pregunta -->
    <template id="template-pregunta">
        <div class="pregunta-card card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Pregunta <span class="numero-pregunta">1</span></h6>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPregunta(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Texto de la Pregunta *</label>
                            <input type="text" class="form-control" name="preguntas[0][texto]" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tipo de Pregunta</label>
                            <select class="form-select" name="preguntas[0][tipo]" onchange="cambiarTipoPregunta(this)">
                                <option value="opcion_unica">Opción Única</option>
                                <option value="opcion_multiple">Opción Múltiple</option>
                                <option value="texto_libre">Texto Libre</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="preguntas[0][obligatoria]">
                        <label class="form-check-label">Pregunta obligatoria</label>
                    </div>
                </div>
                <div class="opciones-container">
                    <label class="form-label">Opciones de Respuesta</label>
                    <div class="opciones-list">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="preguntas[0][opciones][]" placeholder="Opción 1">
                            <button type="button" class="btn btn-outline-danger" onclick="eliminarOpcion(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarOpcion(this)">
                        <i class="fas fa-plus me-1"></i>Agregar Opción
                    </button>
                </div>
            </div>
        </div>
    </template>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

    </script>
</body>

</html>