<?php
require_once 'conexion.php';

$database = new Database();
$db = $database->getConnection();

$mensaje = '';
$error = '';
$usuario = null;

// Obtener ID del usuario a editar
$id_usuario = isset($_GET['id']) ? intval($_GET['id']) : 0;


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
} ?>
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