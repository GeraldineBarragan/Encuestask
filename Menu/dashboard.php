<?php
session_start();

// Si no hay sesión, redirigir al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

echo "<h1>Bienvenido, " . htmlspecialchars($_SESSION['usuario_nombre']) . "</h1>";
echo "<p>Rol: " . htmlspecialchars($_SESSION['usuario_rol']) . "</p>";
echo '<a href="logout.php">Cerrar sesión</a>';
?>  