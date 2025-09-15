<?php
require_once 'conexion.php';

// Crear instancia de la base de datos
$database = new Database();
$db = $database->getConnection();

// Consulta para obtener usuarios
$query = "SELECT id, nombre, usuario, email, rol, estado, fecha_creacion, fecha_actualizacion
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