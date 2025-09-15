<?php
session_start();
require_once 'usuarios.php';
require_once 'agregar.php';
// Si no hay sesión, redirigir al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel de Administración - Sistema de Encuestas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="../estilos.css"/>
   
  </head>
  <body>
    <!-- Top Navigation Bar -->
   
    <nav class="navbar navbar-expand topbar mb-4 static-top shadow"
      style="background-color: white">
      <div class="container-fluid">
        <!-- Toggle Sidebar Button (Mobile) -->
        <button
          class="btn btn-link d-md-none rounded-circle mr-3"
          id="sidebarToggle"
        >
          <i class="fa fa-bars"></i>
        </button>

        <!-- Search Bar -->
        <form
          class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
        >
          <div class="input-group">
            <input
              type="text"
              class="form-control bg-light border-0 small"
              placeholder="Buscar..."
              aria-label="Search"
            />
            <div class="input-group-append">
              <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Notifications Dropdown -->
          <li class="nav-item dropdown no-arrow mx-1">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="alertsDropdown"
              role="button"
              data-bs-toggle="dropdown"
            >
              <i class="fas fa-bell fa-fw"></i>
              <span class="badge badge-danger badge-counter">3+</span>
            </a>
          </li>

          <!-- Messages Dropdown -->
          <li class="nav-item dropdown no-arrow mx-1">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="messagesDropdown"
              role="button"
              data-bs-toggle="dropdown"
            >
              <i class="fas fa-envelope fa-fw"></i>
              <span class="badge badge-danger badge-counter">7</span>
            </a>
          </li>

          <!-- User Dropdown -->
          <li class="nav-item dropdown no-arrow">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="userDropdown"
              role="button"
              data-bs-toggle="dropdown"
            >
              <img
                class="img-profile rounded-circle"
                src="https://images.vexels.com/media/users/3/137047/isolated/preview/5831a17a290077c646a48c4db78a81bb-icono-de-perfil-de-usuario-azul.png"
                width="32"
              />
              
              <span class="ml-2 d-none d-lg-inline text-gray-600 small"
                >Admin User</span
              >
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow">
              <a class="dropdown-item" href="#">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Perfil
              </a>
              <a class="dropdown-item" href="#">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                Configuración
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <i
                  class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                ></i>
                cerrar sesion
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar position-fixed" id="sidebar" style="width: 250px">
      <div
        class="sidebar-brand d-flex align-items-center justify-content-center p-4"
      >
        <div class="sidebar-brand-icon">
          <i class="fas fa-poll"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Sistema de Encuestas</div>
      </div>

      <hr class="sidebar-divider my-0" />

      <div class="nav-item text-center p-3">
        <img
          class="img-profile rounded-circle"
          src="https://cdn-icons-png.flaticon.com/512/6073/6073874.png"
          width="60"
        />
        
        <h5 class="text-white">Bienvenido, <?php echo  htmlspecialchars($_SESSION['usuario_nombre']) ;
        echo "<p>Rol: " . htmlspecialchars($_SESSION['usuario_rol']) . "</p>"; ?></h5>
      </div>

      <hr class="sidebar-divider" />

      <div class="sidebar-heading p-3">
        <span class="sidebar-text">Administración</span>
      </div>

      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#" data-section="dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span class="sidebar-text">Dashboard</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#" data-section="surveys">
            <i class="fas fa-fw fa-poll"></i>
            <span class="sidebar-text">Encuestas</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#" data-section="exams">
            <i class="fas fa-fw fa-question-circle"></i>
            <span class="sidebar-text">Exámenes</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#" data-section="users">
            <i class="fas fa-fw fa-users"></i>
            <span class="sidebar-text">Usuarios</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#" data-section="reports">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span class="sidebar-text">Reportes</span>
          </a>
        </li>
      </ul>

      <hr class="sidebar-divider" />

      <div class="sidebar-heading p-3">
        <span class="sidebar-text">Configuración</span>
      </div>

      <ul class="nav flex-column mb-4">
        <li class="nav-item">
          <a class="nav-link" href="#" data-section="settings">
            <i class="fas fa-fw fa-cog"></i>
            <span class="sidebar-text">Ajustes</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-section="permissions">
            <i class="fas fa-fw fa-key"></i>
            <span class="sidebar-text">Permisos</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="content-container" id="content">
      <!-- Dashboard Section -->
      <div class="content-section active" id="dashboard-section">
        <div class="container-fluid">
          <!-- Page Heading -->
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4"
          >
            <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
            <a
              href="#"
              class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
            >
              <i class="fas fa-download fa-sm text-white-50"></i> Generar
              Reporte
            </a>
          </div>

          <!-- Content Row -->
          <div class="row">
            <!-- Encuestas Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div
                        class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                      >
                        Encuestas Activas
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        12
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-poll fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Usuarios Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div
                        class="text-xs font-weight-bold text-success text-uppercase mb-1"
                      >
                        Usuarios Registrados
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        1,245
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Respuestas Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div
                        class="text-xs font-weight-bold text-info text-uppercase mb-1"
                      >
                        Respuestas Hoy
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        356
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pendientes Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div
                        class="text-xs font-weight-bold text-warning text-uppercase mb-1"
                      >
                        Tareas Pendientes
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        5
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-tasks fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">
            <!-- Gráfico de Encuestas -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div
                  class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                >
                  <h6 class="m-0 font-weight-bold text-primary">
                    Actividad de Encuestas
                  </h6>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="surveyChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Últimas Respuestas -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <div
                  class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                >
                  <h6 class="m-0 font-weight-bold text-primary">
                    Últimas Respuestas
                  </h6>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <div class="small text-gray-500">
                      Encuesta: Satisfacción del cliente
                      <span class="float-right">Hace 15 min</span>
                    </div>
                    <div>Usuario: jperez@ejemplo.com</div>
                  </div>
                  <hr />
                  <div class="mb-3">
                    <div class="small text-gray-500">
                      Encuesta: Hábitos de compra
                      <span class="float-right">Hace 32 min</span>
                    </div>
                    <div>Usuario: mgarcia@ejemplo.com</div>
                  </div>
                  <hr />
                  <div class="mb-3">
                    <div class="small text-gray-500">
                      Encuesta: Preferencias de producto
                      <span class="float-right">Hace 1 hora</span>
                    </div>
                    <div>Usuario: lrodriguez@ejemplo.com</div>
                  </div>
                  <a href="#" class="btn btn-primary btn-block mt-3"
                    >Ver todas</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Encuestas Section -->
      <div class="content-section" id="surveys-section">
        <div class="container-fluid">
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4"
          >
            <h1 class="h3 mb-0 text-gray-800">Gestión de Encuestas</h1>
            <button class="btn btn-primary">
              <i class="fas fa-plus fa-sm text-white-50"></i> Nueva Encuesta
            </button>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Lista de Encuestas
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table
                  class="table table-bordered"
                  width="100%"
                  cellspacing="0"
                >
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Estado</th>
                      <th>Respuestas</th>
                      <th>Fecha Creación</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Satisfacción del Cliente</td>
                      <td><span class="badge badge-success">Activa</span></td>
                      <td>245</td>
                      <td>2023-05-15</td>
                      <td>
                        <button class="btn btn-sm btn-info">Ver</button>
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                      </td>
                    </tr>
                    <tr>
                      <td>Hábitos de Compra</td>
                      <td><span class="badge badge-success">Activa</span></td>
                      <td>178</td>
                      <td>2023-06-22</td>
                      <td>
                        <button class="btn btn-sm btn-info">Ver</button>
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                      </td>
                    </tr>
                    <tr>
                      <td>Preferencias de Producto</td>
                      <td>
                        <span class="badge badge-secondary">Inactiva</span>
                      </td>
                      <td>89</td>
                      <td>2023-04-10</td>
                      <td>
                        <button class="btn btn-sm btn-info">Ver</button>
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Exámenes Section -->
      <div class="content-section" id="exams-section">
        <div class="container-fluid">
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4"
          >
            <h1 class="h3 mb-0 text-gray-800">Gestión de Exámenes</h1>
            <button class="btn btn-primary">
              <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Examen
            </button>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Exámenes Activos
                  </h6>
                </div>
                <div class="card-body">
                  <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Examen de Matemáticas Básicas</h5>
                        <small>30 preguntas</small>
                      </div>
                      <p class="mb-1">
                        Evaluación de conceptos matemáticos fundamentales
                      </p>
                      <small>25 estudiantes completados</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Examen de Historia Universal</h5>
                        <small>40 preguntas</small>
                      </div>
                      <p class="mb-1">
                        Prueba sobre eventos históricos relevantes
                      </p>
                      <small>18 estudiantes completados</small>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Estadísticas de Exámenes
                  </h6>
                </div>
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="examStatsChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Aprobados
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Reprobados
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-warning"></i> En progreso
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Usuarios Section -->
      <div class="content-section" id="users-section">
        <div class="container-fluid">
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4"
          >
            <h1 class="h3 mb-0 text-gray-800">Gestión de Usuarios</h1>
            <button class="btn btn-primary">
              <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Usuario
            </button>
                    <div class="controls">
            <button class="toggle-btn" id="toggleButton1">
                <span>Mostrar Sección B</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
          </div>

          <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div
                        class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                      >
                        Total Usuarios
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $estadisticas['total']; ?>
                        <div class="mt-3">
                            <small>Usuarios registrados en el sistema</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div
                        class="text-xs font-weight-bold text-success text-uppercase mb-1"
                      >
                        USUARIOS ACTIVOS
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $estadisticas['activos']; ?>
                          <div class="mt-3">
                            <div class="d-flex justify-content-between">
                                <small><?php echo $estadisticas['porcentaje_activos']; ?>% del total</small>
                                <small><?php echo $estadisticas['activos']; ?>/<?php echo $estadisticas['total']; ?></small>
                            </div>
                            <div class="progress bg-black bg-opacity-25">
                                <div class="progress-bar bg-black" 
                                     style="width: <?php echo $estadisticas['porcentaje_activos']; ?>%"></div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div
                        class="text-xs font-weight-bold text-info text-uppercase mb-1"
                      >
                        Nuevos (mes)
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $estadisticas['nuevos']; ?>
                        <div class="mt-3">
                            <small>Registrados en  <?php
                                    // Array con nombres de meses en español
                                    $meses = [
                                        'January' => 'Enero',
                                        'February' => 'Febrero',
                                        'March' => 'Marzo',
                                        'April' => 'Abril',
                                        'May' => 'Mayo',
                                        'June' => 'Junio',
                                        'July' => 'Julio',
                                        'August' => 'Agosto',
                                        'September' => 'Septiembre',
                                        'October' => 'Octubre',
                                        'November' => 'Noviembre',
                                        'December' => 'Diciembre'
                                    ];
                                    
                                    // Obtener mes actual en inglés y traducir
                                    $mes_ingles = date('F');
                                    $mes_espanol = $meses[$mes_ingles];
                                    
                                    echo $mes_espanol;
                                    ?></small>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div
                        class="text-xs font-weight-bold text-warning text-uppercase mb-1"
                      >
                        USUARIOS INACTIVOS
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $estadisticas['inactivos']; ?>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between">
                                <small><?php echo $estadisticas['porcentaje_inactivos']; ?>% del total</small>
                                <small><?php echo $estadisticas['inactivos']; ?>/<?php echo $estadisticas['total']; ?></small>
                            </div>
                            <div class="progress bg-black bg-opacity-25">
                                <div class="progress-bar bg-black" 
                                     style="width: <?php echo $estadisticas['porcentaje_inactivos']; ?>%"></div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-times fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card shadow mb-4  section-a active" id="sectionA">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Lista de Usuarios
              </h6>
            </div>
            <div class="card-body">

              <?php if (count($usuarios) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Fecha Creación</th>
                                <th>Fecha Última Modificación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            switch($usuario['rol']) {
                                                case 'administrador': echo 'danger'; break;
                                                case 'moderador': echo 'warning'; break;
                                                default: echo 'primary';
                                            }
                                        ?>">
                                            <?php echo htmlspecialchars($usuario['rol']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="estado-<?php echo $usuario['estado']; ?>">
                                            <?php echo htmlspecialchars($usuario['estado']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_creacion'])); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_actualizacion'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="editarUsuario(<?php echo $usuario['id']; ?>)">
                                            ✏️ Editar
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(<?php echo $usuario['id']; ?>)">
                                            🗑️ Eliminar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="text-muted">
                        Total: <?php echo count($usuarios); ?> usuarios
                    </span>
                    <button class="btn btn-success" onclick="window.location.href='agregar_usuario.php'">
                        ➕ Agregar Usuario
                    </button>
                </div>
                
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <h4>No hay usuarios registrados</h4>
                    <p>Presiona el botón para agregar el primer usuario</p>
                    <button class="btn btn-primary" onclick="agregarUsuario()">
                        Agregar Primer Usuario
                    </button>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-muted">
                            Total: <?php echo count($usuarios); ?> usuarios
                        </span>
                        <a href="agregar_usuario.php" class="btn btn-success">
                            ➕ Agregar Usuario
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            </div>
          </div>
          

            <div class="containerAdd section-b" id="sectionB">
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
                            <option value="moderador" <?php echo (isset($_POST['rol']) && $_POST['rol'] == 'moderador') ? 'selected' : ''; ?>>Moderador</option>
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

         





        </div>
      </div>

      <!-- Reportes Section -->
      <div class="content-section" id="reports-section">
        <div class="container-fluid">
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4"
          >
            <h1 class="h3 mb-0 text-gray-800">Reportes y Estadísticas</h1>
            <div>
              <button class="btn btn-success mr-2">
                <i class="fas fa-download fa-sm text-white-50"></i> Exportar PDF
              </button>
              <button class="btn btn-info">
                <i class="fas fa-download fa-sm text-white-50"></i> Exportar
                Excel
              </button>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-8">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Respuestas por Mes
                  </h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                    <canvas id="monthlyResponsesChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Distribución por Tipo
                  </h6>
                </div>
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="surveyTypeChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Encuestas
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Exámenes
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Formularios
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Reportes Disponibles
              </h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-4 mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div
                            class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                          >
                            Reporte de Encuestas
                          </div>
                          <div class="h6 mb-0 text-gray-800">
                            Resumen completo de todas las encuestas
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-poll fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 mb-4">
                  <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div
                            class="text-xs font-weight-bold text-success text-uppercase mb-1"
                          >
                            Reporte de Exámenes
                          </div>
                          <div class="h6 mb-0 text-gray-800">
                            Resultados y estadísticas de exámenes
                          </div>
                        </div>
                        <div class="col-auto">
                          <i
                            class="fas fa-question-circle fa-2x text-gray-300"
                          ></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 mb-4">
                  <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div
                            class="text-xs font-weight-bold text-info text-uppercase mb-1"
                          >
                            Reporte de Usuarios
                          </div>
                          <div class="h6 mb-0 text-gray-800">
                            Actividad y participación de usuarios
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Ajustes Section -->
      <div class="content-section" id="settings-section">
        <div class="container-fluid">
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4"
          >
            <h1 class="h3 mb-0 text-gray-800">Configuración del Sistema</h1>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Configuración General
                  </h6>
                </div>
                <div class="card-body">
                  <form>
                    <div class="form-group">
                      <label for="siteName">Nombre del Sitio</label>
                      <input
                        type="text"
                        class="form-control"
                        id="siteName"
                        value="Sistema de Encuestas"
                      />
                    </div>
                    <div class="form-group">
                      <label for="adminEmail">Email del Administrador</label>
                      <input
                        type="email"
                        class="form-control"
                        id="adminEmail"
                        value="admin@ejemplo.com"
                      />
                    </div>
                    <div class="form-group">
                      <label for="timezone">Zona Horaria</label>
                      <select class="form-control" id="timezone">
                        <option selected>America/Mexico_City</option>
                        <option>America/New_York</option>
                        <option>America/Los_Angeles</option>
                        <option>Europe/Madrid</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="itemsPerPage">Elementos por Página</label>
                      <input
                        type="number"
                        class="form-control"
                        id="itemsPerPage"
                        value="25"
                      />
                    </div>
                    <button type="submit" class="btn btn-primary">
                      Guardar Cambios
                    </button>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Apariencia</h6>
                </div>
                <div class="card-body">
                  <form>
                    <div class="form-group">
                      <label for="theme">Tema</label>
                      <select class="form-control" id="theme">
                        <option selected>Claro</option>
                        <option>Oscuro</option>
                        <option>Automático</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="primaryColor">Color Primario</label>
                      <input
                        type="color"
                        class="form-control"
                        id="primaryColor"
                        value="#4e73df"
                      />
                    </div>
                    <div class="form-group">
                      <label for="logo">Logo</label>
                      <div class="custom-file">
                        <input
                          type="file"
                          class="custom-file-input"
                          id="logo"
                        />
                        <label class="custom-file-label" for="logo"
                          >Seleccionar archivo</label
                        >
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          id="sidebarCollapse"
                          checked
                        />
                        <label class="form-check-label" for="sidebarCollapse">
                          Barra lateral colapsable
                        </label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                      Guardar Cambios
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Permisos Section -->
      <div class="content-section" id="permissions-section">
        <div class="container-fluid">
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4"
          >
            <h1 class="h3 mb-0 text-gray-800">Gestión de Permisos</h1>
            <button class="btn btn-primary">
              <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Rol
            </button>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Roles del Sistema
                  </h6>
                </div>
                <div class="card-body">
                  <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Administrador</h5>
                        <span class="badge badge-primary badge-pill"
                          >12 usuarios</span
                        >
                      </div>
                      <p class="mb-1">
                        Acceso completo a todas las funcionalidades del sistema.
                      </p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Editor</h5>
                        <span class="badge badge-primary badge-pill"
                          >25 usuarios</span
                        >
                      </div>
                      <p class="mb-1">
                        Puede crear y editar encuestas y exámenes, pero no
                        gestionar usuarios.
                      </p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Usuario</h5>
                        <span class="badge badge-primary badge-pill"
                          >1,208 usuarios</span
                        >
                      </div>
                      <p class="mb-1">
                        Solo puede responder encuestas y exámenes asignados.
                      </p>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Permisos por Rol
                  </h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table
                      class="table table-bordered"
                      width="100%"
                      cellspacing="0"
                    >
                      <thead>
                        <tr>
                          <th>Módulo</th>
                          <th>Administrador</th>
                          <th>Editor</th>
                          <th>Usuario</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Gestión de Encuestas</td>
                          <td><i class="fas fa-check text-success"></i></td>
                          <td><i class="fas fa-check text-success"></i></td>
                          <td><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                          <td>Gestión de Exámenes</td>
                          <td><i class="fas fa-check text-success"></i></td>
                          <td><i class="fas fa-check text-success"></i></td>
                          <td><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                          <td>Gestión de Usuarios</td>
                          <td><i class="fas fa-check text-success"></i></td>
                          <td><i class="fas fa-times text-danger"></i></td>
                          <td><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                          <td>Ver Reportes</td>
                          <td><i class="fas fa-check text-success"></i></td>
                          <td><i class="fas fa-check text-success"></i></td>
                          <td><i class="fas fa-times text-danger"></i></td>
                        </tr>
                        <tr>
                          <td>Configuración</td>
                          <td><i class="fas fa-check text-success"></i></td>
                          <td><i class="fas fa-times text-danger"></i></td>
                          <td><i class="fas fa-times text-danger"></i></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
  </body>
</html>
