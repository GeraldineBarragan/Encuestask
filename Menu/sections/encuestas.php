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
