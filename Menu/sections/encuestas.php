<style>
  .estado-activa {
    background-color: #d4edda;
    color: #155724;
  }

  .estado-inactiva {
    background-color: #f8d7da;
    color: #721c24;
  }

  .estado-finalizada {
    background-color: #e2e3e5;
    color: #383d41;
  }
</style>
<?php

include 'encuestas/crear.php';
?>

<!-- Encuestas Section -->
<div class="content-section" id="surveys-section">
  <div class="sections-container">
    <!-- Sección A: Lista de Encuestas -->
    <div class="section section-a active" id="sectionE">
      <!-- El contenido se cargará aquí vía fetch -->
    </div>

    <!-- Sección B: Nueva Encuesta -->
    <div class="section section-b" id="sectionF">
      <!-- El formulario de nueva encuesta se cargará aquí -->
    </div>

    <!-- Sección C: Editar Encuesta -->
    <div class="section section-c" id="sectionG">
      <!-- El formulario de edición se cargará aquí -->
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const sectionE = document.getElementById('sectionE');
    const sectionF = document.getElementById('sectionF');
    const sectionG = document.getElementById('sectionG');

    function mostrarSeccion(seccion) {
      [sectionE, sectionF, sectionG].forEach(s => {
        if (s) s.classList.remove('active');
      });
      if (seccion) seccion.classList.add('active');
    }

    function cargarEncuestas() {
      fetch('encuesta.php')
        .then(response => response.text())
        .then(html => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');

          // Extraer el contenido relevante (contenido específico de encuestas)
          const contenido = doc.querySelector('#surveys-content, .surveys-content, .container-fluid');
          if (contenido && sectionE) {
            sectionE.innerHTML = '';
            sectionE.appendChild(document.importNode(contenido, true));

            // Reasignar evento al botón de nueva encuesta (sólo dentro de sectionE)
            const btnNueva = sectionE.querySelector('a[href="crear_encuesta.php"]');
            if (btnNueva) {
              btnNueva.addEventListener('click', (e) => {
                e.preventDefault();
                fetch('crear_encuesta.php')
                  .then(res => res.text())
                  .then(html => {
                    if (sectionF) {
                      sectionF.innerHTML = html;
                      mostrarSeccion(sectionF);
                    }
                  })
                  .catch(err => console.error('Error cargando crear_encuesta:', err));
              });
            }

            // Asignar eventos a los botones de acción dentro de sectionE
            sectionE.querySelectorAll('.btn-warning').forEach(btn => {
              btn.addEventListener('click', (e) => {
                e.preventDefault();
                const id = btn.dataset.id;
                fetch(`editar_encuesta.php?id=${id}`)
                  .then(res => res.text())
                  .then(html => {
                    if (sectionG) {
                      sectionG.innerHTML = html;
                      mostrarSeccion(sectionG);
                    }
                  })
                  .catch(err => console.error('Error cargando editar_encuesta:', err));
              });
            });
          }
        })
        .catch(error => {
          console.error('Error cargando encuestas:', error);
          if (sectionE) sectionE.innerHTML = '<div class="alert alert-danger">Error al cargar las encuestas</div>';
        });
    }

    // Cargar encuestas al iniciar (solo si existe la sección)
    if (sectionE) cargarEncuestas();
  });
</script>

<!-- Exámenes Section -->
<div class="content-section" id="exams-section">
  <div class="container-fluid">
    <div
      class="d-sm-flex align-items-center justify-content-between mb-4">
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