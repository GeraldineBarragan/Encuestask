<?php
require_once 'conexion.php';

$database = new Database();
$db = $database->getConnection();

$mensaje = '';
$error = '';
$usuario = null;

// Obtener ID del usuario a editar
$id_usuario = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_usuario <= 0) {
    header('Location: mostrar_usuarios.php');
    exit;
}

// Obtener datos del usuario
try {
    $query = "SELECT id, nombre, usuario, email, rol, estado, fecha_creacion 
              FROM usuarios WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        throw new Exception("Usuario no encontrado");
    }
} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validar y sanitizar datos
        $nombre = trim($_POST['nombre']);
        $usuario_nuevo = trim($_POST['usuario']);
        $email = trim($_POST['email']);
        $rol = $_POST['rol'];
        $estado = $_POST['estado'];
        $cambiar_password = isset($_POST['cambiar_password']) && $_POST['cambiar_password'] == '1';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Validaciones básicas
        if (empty($nombre) || empty($usuario_nuevo) || empty($email)) {
            throw new Exception("Todos los campos marcados con * son obligatorios");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del email no es válido");
        }

        // Verificar si el usuario o email ya existen (excluyendo el actual)
        $verificar = $db->prepare("SELECT id FROM usuarios WHERE (usuario = ? OR email = ?) AND id != ?");
        $verificar->execute([$usuario_nuevo, $email, $id_usuario]);

        if ($verificar->rowCount() > 0) {
            throw new Exception("El usuario o email ya están en uso por otro usuario");
        }

        // Si se cambia la contraseña
        if ($cambiar_password) {
            if (empty($password) || empty($confirm_password)) {
                throw new Exception("Debe completar ambos campos de contraseña");
            }

            if ($password !== $confirm_password) {
                throw new Exception("Las contraseñas no coinciden");
            }

            if (strlen($password) < 6) {
                throw new Exception("La contraseña debe tener al menos 6 caracteres");
            }

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Actualizar con contraseña
            $query = "UPDATE usuarios SET nombre = ?, usuario = ?, email = ?, rol = ?, estado = ?, contraseña = ? WHERE id = ?";
            $stmt = $db->prepare($query);
            $stmt->execute([$nombre, $usuario_nuevo, $email, $rol, $estado, $password_hash, $id_usuario]);
        } else {
            // Actualizar sin cambiar contraseña
            $query = "UPDATE usuarios SET nombre = ?, usuario = ?, email = ?, rol = ?, estado = ? WHERE id = ?";
            $stmt = $db->prepare($query);
            $stmt->execute([$nombre, $usuario_nuevo, $email, $rol, $estado, $id_usuario]);
        }

        $mensaje = "✅ Usuario actualizado correctamente";

        // Recargar datos actualizados
        $query = "SELECT id, nombre, usuario, email, rol, estado, fecha_creacion 
                  FROM usuarios WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id_usuario]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = "❌ Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .containerC {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .header-card {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 500;
        }

        .required::after {
            content: " *";
            color: red;
        }

        .password-section {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .toggle-password {
            cursor: pointer;
            color: #6c757d;
        }

        .toggle-password:hover {
            color: #495057;
        }
    </style>
</head>

<body>
    <div class="containerC">
        <!-- Header -->
        <div class="header-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-user-edit me-2"></i>Editar Usuario</h2>
                    <p class="mb-0">ID: <?php echo $usuario['id']; ?> | Creado: <?php echo date('d/m/Y', strtotime($usuario['fecha_creacion'])); ?></p>
                </div>
                <a href="mostrar_usuarios.php" class="btn btn-light">
                    <i class="fas fa-arrow-left me-1"></i>Volver
                </a>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($mensaje): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($usuario): ?>
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required">Nombre completo</label>
                            <input type="text" class="form-control" name="nombre"
                                value="<?php echo htmlspecialchars($usuario['nombre']); ?>"
                                required maxlength="100">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required">Nombre de usuario</label>
                            <input type="text" class="form-control" name="usuario"
                                value="<?php echo htmlspecialchars($usuario['usuario']); ?>"
                                required maxlength="50" pattern="[a-zA-Z0-9_]+"
                                title="Solo letras, números y guiones bajos">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="<?php echo htmlspecialchars($usuario['email']); ?>"
                                required maxlength="150">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label required">Rol</label>
                            <select class="form-select" name="rol" required>
                                <option value="usuario" <?php echo $usuario['rol'] == 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                                <option value="moderador" <?php echo $usuario['rol'] == 'moderador' ? 'selected' : ''; ?>>Moderador</option>
                                <option value="administrador" <?php echo $usuario['rol'] == 'administrador' ? 'selected' : ''; ?>>Administrador</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label required">Estado</label>
                            <select class="form-select" name="estado" required>
                                <option value="activo" <?php echo $usuario['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                                <option value="inactivo" <?php echo $usuario['estado'] == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                <option value="pendiente" <?php echo $usuario['estado'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="bloqueado" <?php echo $usuario['estado'] == 'bloqueado' ? 'selected' : ''; ?>>Bloqueado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Sección de contraseña -->
                <div class="password-section">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="cambiarPassword" name="cambiar_password" value="1">
                        <label class="form-check-label" for="cambiarPassword">
                            <strong>¿Cambiar contraseña?</strong>
                        </label>
                    </div>

                    <div id="passwordFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nueva contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password"
                                            id="password" minlength="6">
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                            onclick="togglePassword('password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Mínimo 6 caracteres</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Confirmar contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="confirm_password"
                                            id="confirm_password">
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                            onclick="togglePassword('confirm_password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div id="password-match" class="mt-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="mostrar_usuarios.php" class="btn btn-secondary me-md-2">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-danger text-center">
                <h4><i class="fas fa-exclamation-triangle me-2"></i>Usuario no encontrado</h4>
                <p>El usuario que intentas editar no existe o no tienes permisos para acceder.</p>
                <a href="mostrar_usuarios.php" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-1"></i>Volver al listado
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle para mostrar/ocultar campos de contraseña
        document.getElementById('cambiarPassword').addEventListener('change', function() {
            const passwordFields = document.getElementById('passwordFields');
            passwordFields.style.display = this.checked ? 'block' : 'none';

            // Hacer campos obligatorios si se activa el cambio
            document.getElementById('password').required = this.checked;
            document.getElementById('confirm_password').required = this.checked;
        });

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Validación de coincidencia de contraseñas
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const matchIndicator = document.getElementById('password-match');

            if (password && confirmPassword) {
                if (password === confirmPassword) {
                    matchIndicator.innerHTML = '✅ Las contraseñas coinciden';
                    matchIndicator.style.color = 'green';
                } else {
                    matchIndicator.innerHTML = '❌ Las contraseñas no coinciden';
                    matchIndicator.style.color = 'red';
                }
            } else {
                matchIndicator.innerHTML = '';
            }
        }

        document.getElementById('password').addEventListener('input', checkPasswordMatch);
        document.getElementById('confirm_password').addEventListener('input', checkPasswordMatch);

        // Prevenir envío del formulario si las contraseñas no coinciden
        document.querySelector('form').addEventListener('submit', function(e) {
            const cambiarPassword = document.getElementById('cambiarPassword').checked;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (cambiarPassword && password !== confirmPassword) {
                e.preventDefault();
                alert('Las contraseñas no coinciden. Por favor, verifique.');
            }
        });
    </script>
</body>

</html>