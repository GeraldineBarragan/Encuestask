<?php
session_start();
include 'database.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Obtener elementos del menú desde la base de datos
$stmt = $pdo->prepare("SELECT * FROM menu_items WHERE activo = TRUE ORDER BY orden");
$stmt->execute();
$menu_items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
        </header>
        
        <div class="dashboard-content">
            <nav class="sidebar">
                <ul class="menu">
                    <?php foreach ($menu_items as $item): ?>
                        <li class="menu-item">
                            <a href="<?php echo $item['url']; ?>">
                                <?php if ($item['icono']): ?>
                                    <span class="icon"><?php echo $item['icono']; ?></span>
                                <?php endif; ?>
                                <span class="title"><?php echo $item['titulo']; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            
            <main class="main-content">
                <h2>Panel Principal</h2>
                <p>Este es el contenido principal de tu aplicación.</p>
                <p>El menú lateral se ha cargado dinámicamente desde la base de datos.</p>
                
                <div class="content-box">
                    <h3>Información del Sistema</h3>
                    <p>Usuario: <?php echo $_SESSION['username']; ?></p>
                    <p>ID de sesión: <?php echo session_id(); ?></p>
                </div>
            </main>
        </div>
    </div>
</body>
</html>