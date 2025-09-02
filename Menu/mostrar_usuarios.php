<?php
require_once 'conexion.php';

// Crear instancia de la base de datos
$database = new Database();
$db = $database->getConnection();

// Consulta para obtener usuarios
$query = "SELECT id, nombre, usuario, email, rol, estado, fecha_creacion 
          FROM usuarios 
          ORDER BY fecha_creacion DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);



$estadisticas = [];
try {
    // Total de usuarios
    $query_total = "SELECT COUNT(*) as total FROM usuarios";
    $stmt_total = $db->prepare($query_total);
    $stmt_total->execute();
    $estadisticas['total'] = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Usuarios activos
    $query_activos = "SELECT COUNT(*) as activos FROM usuarios WHERE estado = 'activo'";
    $stmt_activos = $db->prepare($query_activos);
    $stmt_activos->execute();
    $estadisticas['activos'] = $stmt_activos->fetch(PDO::FETCH_ASSOC)['activos'];
    
    // Usuarios inactivos
    $query_inactivos = "SELECT COUNT(*) as inactivos FROM usuarios WHERE estado = 'inactivo'";
    $stmt_inactivos = $db->prepare($query_inactivos);
    $stmt_inactivos->execute();
    $estadisticas['inactivos'] = $stmt_inactivos->fetch(PDO::FETCH_ASSOC)['inactivos'];
    
    // Nuevos usuarios este mes
    $query_nuevos = "SELECT COUNT(*) as nuevos FROM usuarios 
                    WHERE MONTH(fecha_creacion) = MONTH(CURRENT_DATE()) 
                    AND YEAR(fecha_creacion) = YEAR(CURRENT_DATE())";
    $stmt_nuevos = $db->prepare($query_nuevos);
    $stmt_nuevos->execute();
    $estadisticas['nuevos'] = $stmt_nuevos->fetch(PDO::FETCH_ASSOC)['nuevos'];
    
    // Porcentajes
    $estadisticas['porcentaje_activos'] = $estadisticas['total'] > 0 ? 
        round(($estadisticas['activos'] / $estadisticas['total']) * 100, 1) : 0;
    $estadisticas['porcentaje_inactivos'] = $estadisticas['total'] > 0 ? 
        round(($estadisticas['inactivos'] / $estadisticas['total']) * 100, 1) : 0;
        
} catch (Exception $e) {
    $estadisticas = [
        'total' => 0,
        'activos' => 0,
        'inactivos' => 0,
        'nuevos' => 0,
        'porcentaje_activos' => 0,
        'porcentaje_inactivos' => 0
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dashboard-card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            border: none;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .card-total { background: linear-gradient(45deg, #667eea, #764ba2); }
        .card-activos { background: linear-gradient(45deg, #11998e, #38ef7d); }
        .card-inactivos { background: linear-gradient(45deg, #ff416c, #ff4b2b); }
        .card-nuevos { background: linear-gradient(45deg, #ff9a9e, #fad0c4); }
        
        .card-text {
            font-size: 2.5rem;
            font-weight: bold;
            color: white;
        }
        .card-title {
            color: white;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .card-icon {
            font-size: 2rem;
            opacity: 0.8;
        }
        .progress {
            height: 8px;
            margin-top: 10px;
        }
        .stats-row {
            margin-bottom: 30px;
        }
        .table-container {
            margin: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
        .estado-activo {
            color: #198754;
            font-weight: bold;
        }
        .estado-inactivo {
            color: #6c757d;
        }
        .estado-bloqueado {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
         <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">
                        <i class="fas fa-users me-2"></i>Dashboard de Usuarios
                    </h1>
                    <a href="agregar_usuario.php" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Agregar Usuario
                    </a>
                </div>
                <p class="text-muted">Resumen general del sistema de usuarios</p>
            </div>
        </div>

        <!-- Estadísticas Dashboard -->
        <div class="row stats-row">
            <!-- Total Usuarios -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card card-total text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">TOTAL USUARIOS</h6>
                                <h2 class="card-text"><?php echo $estadisticas['total']; ?></h2>
                            </div>
                            <div class="card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small>Usuarios registrados en el sistema</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuarios Activos -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card card-activos text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">USUARIOS ACTIVOS</h6>
                                <h2 class="card-text"><?php echo $estadisticas['activos']; ?></h2>
                            </div>
                            <div class="card-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between">
                                <small><?php echo $estadisticas['porcentaje_activos']; ?>% del total</small>
                                <small><?php echo $estadisticas['activos']; ?>/<?php echo $estadisticas['total']; ?></small>
                            </div>
                            <div class="progress bg-white bg-opacity-25">
                                <div class="progress-bar bg-white" 
                                     style="width: <?php echo $estadisticas['porcentaje_activos']; ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuarios Inactivos -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card card-inactivos text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">USUARIOS INACTIVOS</h6>
                                <h2 class="card-text"><?php echo $estadisticas['inactivos']; ?></h2>
                            </div>
                            <div class="card-icon">
                                <i class="fas fa-user-slash"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between">
                                <small><?php echo $estadisticas['porcentaje_inactivos']; ?>% del total</small>
                                <small><?php echo $estadisticas['inactivos']; ?>/<?php echo $estadisticas['total']; ?></small>
                            </div>
                            <div class="progress bg-white bg-opacity-25">
                                <div class="progress-bar bg-white" 
                                     style="width: <?php echo $estadisticas['porcentaje_inactivos']; ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nuevos Usuarios (este mes) -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card card-nuevos text-dark h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-dark">NUEVOS ESTE MES</h6>
                                <h2 class="card-text text-dark"><?php echo $estadisticas['nuevos']; ?></h2>
                            </div>
                            <div class="card-icon text-dark">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small>Registrados en <?php echo date('F'); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de distribución (opcional) -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-chart-pie me-2"></i>Distribución de Usuarios
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <canvas id="userDistributionChart" height="150"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-success">Activos</span>
                                    <span><?php echo $estadisticas['activos']; ?> (<?php echo $estadisticas['porcentaje_activos']; ?>%)</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-danger">Inactivos</span>
                                    <span><?php echo $estadisticas['inactivos']; ?> (<?php echo $estadisticas['porcentaje_inactivos']; ?>%)</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-warning">Otros estados</span>
                                    <span><?php echo $estadisticas['total'] - $estadisticas['activos'] - $estadisticas['inactivos']; ?> 
                                    (<?php echo round(100 - $estadisticas['porcentaje_activos'] - $estadisticas['porcentaje_inactivos'], 1); ?>%)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>










        <div class="table-container">
            <h2 class="text-center mb-4">📋 Lista de Usuarios</h2>
            
            <?php if (count($usuarios) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Fecha Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            switch($usuario['rol']) {
                                                case 'administrador': echo 'danger'; break;
                                                case 'moderador': echo 'warning'; break;
                                                default: echo 'primary';
                                            }
                                        ?>">
                                            <?php echo htmlspecialchars($usuario['rol']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="estado-<?php echo $usuario['estado']; ?>">
                                            <?php echo htmlspecialchars($usuario['estado']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_creacion'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="editarUsuario(<?php echo $usuario['id']; ?>)">
                                            ✏️ Editar
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(<?php echo $usuario['id']; ?>)">
                                            🗑️ Eliminar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="text-muted">
                        Total: <?php echo count($usuarios); ?> usuarios
                    </span>
                    <button class="btn btn-success" onclick="window.location.href='agregar_usuario.php'">
                        ➕ Agregar Usuario
                    </button>
                </div>
                
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <h4>No hay usuarios registrados</h4>
                    <p>Presiona el botón para agregar el primer usuario</p>
                    <button class="btn btn-primary" onclick="agregarUsuario()">
                        Agregar Primer Usuario
                    </button>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-muted">
                            Total: <?php echo count($usuarios); ?> usuarios
                        </span>
                        <a href="agregar_usuario.php" class="btn btn-success">
                            ➕ Agregar Usuario
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editarUsuario(id) {
            alert('Editando usuario ID: ' + id);
            // Aquí iría la lógica para editar
            // window.location.href = 'editar_usuario.php?id=' + id;
        }

        function eliminarUsuario(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                alert('Eliminando usuario ID: ' + id);
                // Aquí iría la lógica para eliminar
                // window.location.href = 'eliminar_usuario.php?id=' + id;
            }
        }

        function agregarUsuario() {
            alert('Agregar nuevo usuario');
            // window.location.href = 'agregar_usuario.php';
        }
    </script>
</body>
</html>