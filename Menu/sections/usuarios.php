<?php
require_once 'editar.php';
?>

<!-- Usuarios Section -->
<div class="content-section" id="users-section">
  <div class="container-fluid">
    <div
      class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Gestión de Usuarios</h1>

      <div class="controls">
        <button class="toggle-btn" id="toggleButtonAB">
          <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Usuario
        </button>
        <button class="toggle-btn" id="toggleButtonC">
          <i class="fas fa-edit fa-sm text-white-50"></i> Editar Usuario
        </button>
      </div>

    </div>
  </div>

  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div
                class="text-xs font-weight-bold text-primary text-uppercase mb-1">
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
                class="text-xs font-weight-bold text-success text-uppercase mb-1">
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
                class="text-xs font-weight-bold text-info text-uppercase mb-1">
                Nuevos (mes)
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?php echo $estadisticas['nuevos']; ?>
                <div class="mt-3">
                  <small>Registrados en <?php
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
                class="text-xs font-weight-bold text-warning text-uppercase mb-1">
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


  <div class="sections-container">
    <div class="card shadow mb-4 section section-a active" id="sectionA">
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
                                            switch ($usuario['rol']) {
                                              case 'administrador':
                                                echo 'danger';
                                                break;
                                              case 'moderador':
                                                echo 'warning';
                                                break;
                                              default:
                                                echo 'primary';
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

    <!-- Aqui va la seccion B -->
    <div class="containerAdd section section-b" id="sectionB">
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



  <!-- seccion C -->
  <div class="containerC section section-c" id="sectionC">
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
</div>