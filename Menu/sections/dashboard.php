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