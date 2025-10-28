<?php
require_once 'conexion.php';

$database = new Database();
$db = $database->getConnection();

$mensaje = '';
$error = '';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validar y sanitizar datos
        $nombre = trim($_POST['nombre']);
        $usuario = trim($_POST['usuario']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $email = trim($_POST['email']);
        $rol = $_POST['rol'];
        $estado = $_POST['estado'];

        // Validaciones
        if (empty($nombre) || empty($usuario) || empty($password) || empty($email)) {
            throw new Exception("Todos los campos marcados con * son obligatorios");
        }

        if ($password !== $confirm_password) {
            throw new Exception("Las contraseñas no coinciden");
        }

        if (strlen($password) < 6) {
            throw new Exception("La contraseña debe tener al menos 6 caracteres");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del email no es válido");
        }

        // Verificar si el usuario o email ya existen
        $verificar = $db->prepare("SELECT id FROM usuarios WHERE usuario = ? OR email = ?");
        $verificar->execute([$usuario, $email]);

        if ($verificar->rowCount() > 0) {
            throw new Exception("El usuario o email ya existen");
        }

        // Hash de la contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar en la base de datos
        $query = "INSERT INTO usuarios (nombre, usuario, contraseña, email, rol, estado) 
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $db->prepare($query);
        $stmt->execute([$nombre, $usuario, $password_hash, $email, $rol, $estado]);

        $mensaje = "✅ Usuario agregado correctamente";

        // Limpiar el formulario después de éxito
        $_POST = array();
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
    <title>Agregar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 500;
        }

        .required::after {
            content: " *";
            color: red;
        }

        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">👥 Agregar Nuevo Usuario</h2>

        <?php if ($mensaje): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Nombre completo</label>
                        <input type="text" class="form-control" name="nombre"
                            value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>"
                            required maxlength="100">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Nombre de usuario</label>
                        <input type="text" class="form-control" name="usuario"
                            value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>"
                            required maxlength="50" pattern="[a-zA-Z0-9_]+"
                            title="Solo letras, números y guiones bajos">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password"
                                id="password" required minlength="6"
                                oninput="checkPasswordStrength()">
                            <button class="btn btn-outline-secondary" type="button" onclick="generatePassword()">
                                🔑 Generar
                            </button>
                        </div>
                        <div class="password-strength" id="password-strength"></div>
                        <small class="text-muted">Mínimo 6 caracteres</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Confirmar contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm_password"
                                id="confirm_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">
                                👁
                            </button>
                        </div>
                        <div id="password-match"></div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Email</label>
                        <input type="email" class="form-control" name="email"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                            required maxlength="150">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label required">Rol</label>
                        <select class="form-select" name="rol" required>
                            <option value="">Seleccionar rol</option>
                            <option value="usuario" <?php echo (isset($_POST['rol']) && $_POST['rol'] == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                            <option value="candidato" <?php echo (isset($_POST['rol']) && $_POST['rol'] == 'candidato') ? 'selected' : ''; ?>>Candidato</option>
                            <option value="administrador" <?php echo (isset($_POST['rol']) && $_POST['rol'] == 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label required">Estado</label>
                        <select class="form-select" name="estado" required>
                            <option value="">Seleccionar estado</option>
                            <option value="activo" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'activo') ? 'selected' : ''; ?>>Activo</option>
                            <option value="inactivo" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                            <option value="pendiente" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                            <option value="bloqueado" <?php echo (isset($_POST['estado']) && $_POST['estado'] == 'bloqueado') ? 'selected' : ''; ?>>Bloqueado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="mostrar_usuarios.php" class="btn btn-secondary me-md-2">
                    ← Volver a la lista
                </a>
                <button type="submit" class="btn btn-primary">
                    💾 Guardar Usuario
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('password-strength');
            const confirmField = document.getElementById('confirm_password');
            const matchIndicator = document.getElementById('password-match');

            let strength = 0;
            if (password.length >= 6) strength += 1;
            if (password.length >= 8) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;

            // Colores según la fuerza
            const colors = ['#dc3545', '#ffc107', '#ffc107', '#20c997', '#198754'];
            strengthBar.style.width = (strength * 20) + '%';
            strengthBar.style.backgroundColor = colors[strength - 1] || '#dc3545';

            // Verificar coincidencia de contraseñas
            if (confirmField.value !== '') {
                if (password === confirmField.value) {
                    matchIndicator.innerHTML = '✅ Las contraseñas coinciden';
                    matchIndicator.style.color = 'green';
                } else {
                    matchIndicator.innerHTML = '❌ Las contraseñas no coinciden';
                    matchIndicator.style.color = 'red';
                }
            }
        }

        document.getElementById('confirm_password').addEventListener('input', checkPasswordStrength);

        function generatePassword() {
            const length = 12; // longitud de la contraseña
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
            let password = "";
            for (let i = 0; i < length; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            // Colocar en los inputs
            document.getElementById('password').value = password;
            document.getElementById('confirm_password').value = password;

            checkPasswordStrength();
            // Mostrar un pequeño aviso
            alert("🔑 Contraseña generada:\n" + password);
        }

        function togglePasswordVisibility() {
            const passField = document.getElementById('password');
            const confirmField = document.getElementById('confirm_password');

            if (passField.type === "password") {
                passField.type = "text";
                confirmField.type = "text";
            } else {
                passField.type = "password";
                confirmField.type = "password";
            }
        }
    </script>
</body>

</html>