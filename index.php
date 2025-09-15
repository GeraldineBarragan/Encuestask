<?php
session_start();
require_once 'Menu/conexion.php';

$database = new Database();
$db = $database->getConnection();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    try {
        if (empty($usuario) || empty($password)) {
            throw new Exception("Por favor ingresa usuario y contraseña.");
        }

        // Buscar al usuario por usuario o email
        $stmt = $db->prepare("SELECT id, nombre, usuario, email, contraseña, rol, estado 
                              FROM usuarios 
                              WHERE usuario = ? OR email = ? LIMIT 1");
        $stmt->execute([$usuario, $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception("Usuario o contraseña incorrectos.");
        }

        // Verificar estado (ejemplo: no dejar loguear bloqueados)
        if ($user['estado'] !== 'activo') {
            throw new Exception("Tu cuenta está en estado: " . $user['estado']);
        }

        // Verificar contraseña
        if (!password_verify($password, $user['contraseña'])) {
            throw new Exception("Usuario o contraseña incorrectos.");
        }

        // Guardar datos en la sesión
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nombre'] = $user['nombre'];
        $_SESSION['usuario_rol'] = $user['rol'];

        // Redirigir al panel o dashboard
        header("Location: Menu/menu.php");
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .login-container {
        max-width: 400px;
        margin: 80px auto;
        padding: 30px;
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h3 class="text-center mb-4">🔑 Iniciar Sesión</h3>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">Usuario o Email</label>
        <input type="text" class="form-control" name="usuario" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Ingresar</button>
      </div>
    </form>
  </div>
</body>
</html>
