 
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