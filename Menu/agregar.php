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