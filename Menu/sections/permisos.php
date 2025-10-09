
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
