<?php
require_once 'conexion.php';

$database = new Database();
$db = $database->getConnection();

// Obtener estadísticas
$estadisticas = [];
try {
    // Total encuestas
    $query = "SELECT COUNT(*) as total FROM encuestas";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $estadisticas['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Encuestas activas
    $query = "SELECT COUNT(*) as activas FROM encuestas WHERE estado = 'activa' AND (fecha_limite IS NULL OR fecha_limite >= CURDATE())";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $estadisticas['activas'] = $stmt->fetch(PDO::FETCH_ASSOC)['activas'];

    // Encuestas finalizadas
    $query = "SELECT COUNT(*) as finalizadas FROM encuestas WHERE estado = 'finalizada' OR (fecha_limite < CURDATE())";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $estadisticas['finalizadas'] = $stmt->fetch(PDO::FETCH_ASSOC)['finalizadas'];
} catch (Exception $e) {
    $estadisticas = ['total' => 0, 'activas' => 0, 'finalizadas' => 0];
}

// Obtener listado de encuestas
$query = "SELECT e.*, COUNT(r.id) as total_respuestas 
          FROM encuestas e 
          LEFT JOIN respuestas r ON e.id = r.encuesta_id 
          GROUP BY e.id 
          ORDER BY e.fecha_creacion DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$encuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Encuestas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dashboard-card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            border: none;
            color: white;
        }

        .card-total {
            background: linear-gradient(45deg, #667eea, #764ba2);
        }

        .card-activas {
            background: linear-gradient(45deg, #11998e, #38ef7d);
        }

        .card-finalizadas {
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
        }

        .estado-activa {
            background-color: #d4edda;
            color: #155724;
        }

        .estado-inactiva {
            background-color: #f8d7da;
            color: #721c24;
        }

        .estado-finalizada {
            background-color: #e2e3e5;
            color: #383d41;
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0"><i class="fas fa-poll me-2"></i>Sistema de Encuestas</h1>
                    <a href="crear_encuesta.php" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Nueva Encuesta
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card dashboard-card card-total">
                    <div class="card-body text-center">
                        <i class="fas fa-poll fa-3x mb-3"></i>
                        <h3><?php echo $estadisticas['total']; ?></h3>
                        <p class="mb-0">Total Encuestas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card card-activas">
                    <div class="card-body text-center">
                        <i class="fas fa-play-circle fa-3x mb-3"></i>
                        <h3><?php echo $estadisticas['activas']; ?></h3>
                        <p class="mb-0">Encuestas Activas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card card-finalizadas">
                    <div class="card-body text-center">
                        <i class="fas fa-flag-checkered fa-3x mb-3"></i>
                        <h3><?php echo $estadisticas['finalizadas']; ?></h3>
                        <p class="mb-0">Encuestas Finalizadas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Encuestas -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-list me-2"></i>Lista de Encuestas</h5>
            </div>
            <div class="card-body">
                <?php if (count($encuestas) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Respuestas</th>
                                    <th>Fecha Límite</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($encuestas as $encuesta): ?>
                                    <tr>
                                        <td><?php echo $encuesta['id']; ?></td>
                                        <td><?php echo htmlspecialchars($encuesta['titulo']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($encuesta['descripcion'], 0, 50)) . '...'; ?></td>
                                        <td>
                                            <?php
                                            $estado_class = 'estado-' . $encuesta['estado'];
                                            $icono = $encuesta['estado'] == 'activa' ? 'fa-play' : ($encuesta['estado'] == 'finalizada' ? 'fa-flag-checkered' : 'fa-pause');
                                            ?>
                                            <span class="badge <?php echo $estado_class; ?>">
                                                <i class="fas <?php echo $icono; ?> me-1"></i>
                                                <?php echo ucfirst($encuesta['estado']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                <?php echo $encuesta['total_respuestas']; ?> respuestas
                                            </span>
                                        </td>
                                        <td>
                                            <?php echo $encuesta['fecha_limite'] ? date('d/m/Y', strtotime($encuesta['fecha_limite'])) : 'Sin límite'; ?>
                                        </td>
                                        <td>
                                            <a href="responder_encuesta.php?id=<?php echo $encuesta['id']; ?>" class="btn btn-sm btn-success">
                                                <i class="fas fa-edit"></i> Responder
                                            </a>
                                            <a href="resultados_encuesta.php?id=<?php echo $encuesta['id']; ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-chart-bar"></i> Resultados
                                            </a>
                                            <a href="editar_encuesta.php?id=<?php echo $encuesta['id']; ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-cog"></i> Editar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-poll fa-4x text-muted mb-3"></i>
                        <h4>No hay encuestas creadas</h4>
                        <p>Crea tu primera encuesta para comenzar</p>
                        <a href="crear_encuesta.php" class="btn btn-primary">Crear Primera Encuesta</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>