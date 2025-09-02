<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirige al login si no hay sesión
    exit();
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
                src="https://source.unsplash.com/QAB-WJcbgJk/60x60"
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
                Cerrar sesión
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
          src="https://source.unsplash.com/QAB-WJcbgJk/60x60"
          width="60"
        />
        <div class="mt-2 text-white">Admin User</div>
        <small class="text-white-50">Administrador</small>
        <h5 class="text-white">Bienvenido, <?php echo $_SESSION['username']; ?> 👋</h5>
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

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div
                        class="text-xs font-weight-bold text-success text-uppercase mb-1"
                      >
                        Usuarios Activos
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        982
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
                        124
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
                        Usuarios Inactivos
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        263
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

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Lista de Usuarios
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
                      <th>Email</th>
                      <th>Rol</th>
                      <th>Estado</th>
                      <th>Último acceso</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Juan Pérez</td>
                      <td>jperez@ejemplo.com</td>
                      <td>Administrador</td>
                      <td><span class="badge badge-success">Activo</span></td>
                      <td>2023-08-27 14:32</td>
                      <td>
                        <button class="btn btn-sm btn-info">Ver</button>
                        <button class="btn btn-sm btn-warning">Editar</button>
                      </td>
                    </tr>
                    <tr>
                      <td>María García</td>
                      <td>mgarcia@ejemplo.com</td>
                      <td>Usuario</td>
                      <td><span class="badge badge-success">Activo</span></td>
                      <td>2023-08-27 10:15</td>
                      <td>
                        <button class="btn btn-sm btn-info">Ver</button>
                        <button class="btn btn-sm btn-warning">Editar</button>
                      </td>
                    </tr>
                    <tr>
                      <td>Carlos López</td>
                      <td>clopez@ejemplo.com</td>
                      <td>Editor</td>
                      <td>
                        <span class="badge badge-secondary">Inactivo</span>
                      </td>
                      <td>2023-08-20 16:45</td>
                      <td>
                        <button class="btn btn-sm btn-info">Ver</button>
                        <button class="btn btn-sm btn-warning">Editar</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
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
