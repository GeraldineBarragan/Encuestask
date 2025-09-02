<?php
session_start();

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'sistema_menu';
$username = 'root';
$password = '';

// Conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Procesar formulario de login
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$user]);
    $usuario = $stmt->fetch();
    
    if ($usuario && password_verify($pass, $usuario['password'])) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['username'] = $usuario['username'];
        $_SESSION['nombre'] = $usuario['nombre'];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

// Cerrar sesión
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Obtener elementos del menú desde la base de datos
$menu_items = [];
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM menu_items WHERE activo = TRUE ORDER BY orden");
    $stmt->execute();
    $menu_items = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema con Menú Dinámico</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 1.5rem;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .welcome {
            margin-right: 1rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #ff6b6b;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #ee5253;
        }
        
        .main-content {
            padding: 2rem 0;
        }
        
        .hero {
            text-align: center;
            padding: 3rem 0;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #2d3748;
        }
        
        .hero p {
            font-size: 1.2rem;
            color: #718096;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .login-form {
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .login-form h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #2d3748;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background-color: #4299e1;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-login:hover {
            background-color: #3182ce;
        }
        
        .error-message {
            color: #e53e3e;
            text-align: center;
            margin-bottom: 1rem;
            padding: 0.5rem;
            background-color: #fed7d7;
            border-radius: 4px;
        }
        
        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
        }
        
        .sidebar {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }
        
        .menu-title {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: #2d3748;
            border-bottom: 2px solid #4299e1;
            padding-bottom: 0.5rem;
        }
        
        .menu-items {
            list-style: none;
        }
        
        .menu-items li {
            margin-bottom: 0.75rem;
        }
        
        .menu-items a {
            display: block;
            padding: 0.75rem;
            background-color: #f7fafc;
            color: #4a5568;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .menu-items a:hover {
            background-color: #ebf4ff;
        }
        
        .content {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }
        
        .content h2 {
            color: #2d3748;
            margin-bottom: 1rem;
        }
        
        .content-box {
            background-color: #f7fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        .content-box h3 {
            color: #4299e1;
            margin-bottom: 0.5rem;
        }
        
        footer {
            text-align: center;
            padding: 2rem 0;
            color: #718096;
            border-top: 1px solid #e2e8f0;
            margin-top: 2rem;
        }
        
        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
            
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            nav ul {
                margin-top: 1rem;
                justify-content: center;
            }
            
            .user-info {
                margin-top: 1rem;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">Sistema Dinámico</div>
                <?php if (isset($_SESSION['user_id'])): ?>
                <nav>
                    <ul>
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Acerca de</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </nav>
                <div class="user-info">
                    <span class="welcome">Bienvenido, <?php echo $_SESSION['nombre']; ?></span>
                    <a href="?logout=true" class="btn">Cerrar Sesión</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="hero">
                    <h1>Sistema de Menú Dinámico</h1>
                    <p>Inicie sesión para acceder al panel de control y gestionar su contenido</p>
                </div>
                
                <div class="login-form">
                    <h2>Iniciar Sesión</h2>
                    
                    <?php if ($error): ?>
                        <div class="error-message"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="form-group">
                            <label for="username">Usuario:</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        
                        <button type="submit" name="login" class="btn-login">Ingresar</button>
                    </form>
                    
                    <div style="margin-top: 1.5rem; padding: 1rem; background-color: #ebf8ff; border-radius: 4px;">
                        <p style="text-align: center; margin-bottom: 0.5rem;"><strong>Credenciales de demostración:</strong></p>
                        <p>Usuario: <strong>admin</strong></p>
                        <p>Contraseña: <strong>password123</strong></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="dashboard">
                    <aside class="sidebar">
                        <h3 class="menu-title">Menú Principal</h3>
                        <ul class="menu-items">
                            <?php foreach ($menu_items as $item): ?>
                                <li>
                                    <a href="<?php echo $item['url']; ?>">
                                        <?php echo $item['titulo']; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </aside>
                    
                    <section class="content">
                        <h2>Panel de Control</h2>
                        <p>Bienvenido al sistema de menú dinámico. Desde aquí puedes gestionar tu contenido.</p>
                        
                        <div class="content-box">
                            <h3>Información del Usuario</h3>
                            <p>Usuario: <?php echo $_SESSION['username']; ?></p>
                            <p>Nombre: <?php echo $_SESSION['nombre']; ?></p>
                            <p>ID de sesión: <?php echo session_id(); ?></p>
                        </div>
                        
                        <div class="content-box">
                            <h3>Menú Dinámico</h3>
                            <p>Los elementos del menú lateral se han cargado dinámicamente desde la base de datos MySQL.</p>
                            <p>Puedes agregar, editar o eliminar elementos del menú directamente desde la base de datos.</p>
                        </div>
                    </section>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 Sistema Dinámico con PHP y MySQL. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>