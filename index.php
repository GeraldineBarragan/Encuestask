<?php
session_start();

// Configuración de la base de datos
$host = "localhost";
$db_username = "root";
$db_password = "";
$database = "basedepruebas";

$error_message = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($host, $db_username, $db_password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // CONSULTA CORREGIDA (usa los nombres exactos de tus columnas)
    $stmt = $conn->prepare("SELECT Usuario, Contraseña FROM Login WHERE Usuario = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // COMPARACIÓN DIRECTA (ya que tus contraseñas están en texto plano)
        if ($password === $user['Contraseña']) {
            // Login exitoso (quitamos el user_id ya que no lo estás seleccionando)
            $_SESSION['username'] = $user['Usuario'];
            header("Location:main.php");
            exit();
        } else {
            $error_message = "Contraseña incorrecta";
        }
    } else {
        $error_message = "Usuario no encontrado";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    
     <style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #ffffffff, #6ccffdff);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }

  .login-container {
    background: #00aeffff;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow:
      10px 10px 25px rgba(90, 0, 130, 0.3),
      -10px -10px 25px rgba(255, 255, 255, 0.1);
    width: 320px;
    transition: 0.3s ease;
  }

  h2 {
    text-align: center;
    color: white;
    margin-bottom: 30px;
    font-weight: 700;
  }

  .form-group {
    margin-bottom: 20px;
  }

  label {
    font-size: 14px;
    margin-bottom: 8px;
    display: block;
    color: #f9f9f9;
  }

  input[type="text"], input[type="password"] {
    width: 90%;
    padding: 12px;
    border: none;
    border-radius: 12px;
    background: #c3f3ffff;
    color: #333;
    box-shadow: inset 4px 4px 8px rgba(90, 0, 130, 0.3),
                inset -4px -4px 8px rgba(255, 255, 255, 0.1);
    outline: none;
    transition: 0.2s ease-in-out;
  }

  input::placeholder {
    color: #f0d8ff;
  }

  input[type="text"]:focus, input[type="password"]:focus {
    box-shadow: inset 2px 2px 5px rgba(90, 0, 130, 0.4),
                inset -2px -2px 5px rgba(255, 255, 255, 0.1);
  }

  button {
    width: 100%;
    padding: 12px;
    background: #41c3ffff;
    border: none;
    border-radius: 12px;
    box-shadow: 6px 6px 10px rgba(90, 0, 130, 0.4),
                -6px -6px 10px rgba(255, 255, 255, 0.05);
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  button:hover {
    background: #41c3ffff;
    box-shadow: inset 4px 4px 6px rgba(90, 0, 130, 0.4),
                inset -4px -4px 6px rgba(255, 255, 255, 0.05);
  }

  .error {
    color: #0400ffff;
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
  }
</style>

</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (!empty($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>