
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
