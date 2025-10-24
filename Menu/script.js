document.addEventListener('DOMContentLoaded', () => {
  const sectionA = document.getElementById('sectionA');
  const sectionB = document.getElementById('sectionB');
  const sectionC = document.getElementById('sectionC');
  const btnAB = document.getElementById('toggleButtonAB');

  function mostrarSeccion(seccion) {
    [sectionA, sectionB, sectionC].forEach(s => s.classList.remove('active'));
    seccion.classList.add('active');
  }

  // Alternar entre lista y agregar
  btnAB.addEventListener('click', () => {
    if (sectionA.classList.contains('active')) {
      mostrarSeccion(sectionB);
    } else {
      mostrarSeccion(sectionA);
    }
  });

  // --- Múltiples botones Editar ---
  const botonesEditar = document.querySelectorAll('.btn-editar');
  botonesEditar.forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;
      editarUsuario(id);
    });
  });

// --- Función para cargar datos del usuario ---
function editarUsuario(id) {
  fetch(`editar.php?id=${id}`)
    .then(res => res.text())
    .then(html => {
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const contenido = doc.querySelector('#contenido-editar');

      const sectionC = document.getElementById('sectionC');
      sectionC.innerHTML = ''; // Limpia el contenido anterior

      if (contenido) {
        sectionC.appendChild(contenido);
      } else {
        sectionC.innerHTML = '<p style="color:red;">Error: No se encontró el contenido del formulario.</p>';
      }

      // Asegura visibilidad después de insertar
      requestAnimationFrame(() => {
        sectionA.classList.remove('active');
        sectionB.classList.remove('active');
        sectionC.classList.add('active');
      });

      // Listener del formulario
      const form = sectionC.querySelector('#formEditarUsuario');
      if (form) {
        form.addEventListener('submit', e => {
          e.preventDefault();
          const formData = new FormData(form);

          fetch('actualizar_usuario.php', {
            method: 'POST',
            body: formData
          })
            .then(res => res.json())
            .then(data => {
              alert(data.message);
              if (data.status === 'success') {
                // Ocultar sección C y mostrar A
                sectionC.classList.remove('active');
                sectionA.classList.add('active');
                
                // Recargar la tabla de usuarios
                fetch('mostrar_usuarios.php')
                  .then(res => res.text())
                  .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const nuevaTabla = doc.querySelector('.table-responsive');
                    if (nuevaTabla) {
                      const tablaActual = sectionA.querySelector('.table-responsive');
                      if (tablaActual) {
                        tablaActual.innerHTML = nuevaTabla.innerHTML;
                      }
                    }
                    // Reinicializar los botones de editar
                    const botonesEditar = sectionA.querySelectorAll('.btn-editar');
                    botonesEditar.forEach(btn => {
                      btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        editarUsuario(id);
                      });
                    });
                  })
                  .catch(err => console.error('Error recargando la tabla:', err));
              }
            })
            .catch(err => console.error('Error al actualizar:', err));
        });
      }
    })
    .catch(err => console.error('Error cargando usuario:', err));
}


});





    // Toggle sidebar
      document
        .getElementById("sidebarToggle")
        .addEventListener("click", function () {
          document.getElementById("sidebar").classList.toggle("sidebar-show");
        });

      // Chart initialization
      const ctx = document.getElementById("surveyChart").getContext("2d");
      const surveyChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul"],
          datasets: [
            {
              label: "Encuestas completadas",
              data: [153, 189, 215, 281, 324, 378, 412],
              backgroundColor: "rgba(78, 115, 223, 0.05)",
              borderColor: "rgba(78, 115, 223, 1)",
              pointBackgroundColor: "rgba(78, 115, 223, 1)",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "rgba(78, 115, 223, 1)",
              borderWidth: 2,
              tension: 0.3,
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });

      // Exam Stats Chart
      const examStatsCtx = document
        .getElementById("examStatsChart")
        .getContext("2d");
      const examStatsChart = new Chart(examStatsCtx, {
        type: "doughnut",
        data: {
          labels: ["Aprobados", "Reprobados", "En progreso"],
          datasets: [
            {
              data: [65, 20, 15],
              backgroundColor: ["#4e73df", "#36b9cc", "#f6c23e"],
              hoverBackgroundColor: ["#2e59d9", "#2c9faf", "#dda20a"],
              hoverBorderColor: "rgba(234, 236, 244, 1)",
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          cutout: "70%",
          plugins: {
            legend: {
              display: false,
            },
          },
        },
      });

      // Monthly Responses Chart
      const monthlyResponsesCtx = document
        .getElementById("monthlyResponsesChart")
        .getContext("2d");
      const monthlyResponsesChart = new Chart(monthlyResponsesCtx, {
        type: "bar",
        data: {
          labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun"],
          datasets: [
            {
              label: "Encuestas",
              backgroundColor: "#4e73df",
              hoverBackgroundColor: "#2e59d9",
              borderColor: "#4e73df",
              data: [421, 532, 461, 784, 625, 817],
            },
            {
              label: "Exámenes",
              backgroundColor: "#1cc88a",
              hoverBackgroundColor: "#17a673",
              borderColor: "#1cc88a",
              data: [230, 342, 272, 488, 390, 535],
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          scales: {
            x: {
              stacked: false,
            },
            y: {
              stacked: false,
            },
          },
        },
      });

      // Survey Type Chart
      const surveyTypeCtx = document
        .getElementById("surveyTypeChart")
        .getContext("2d");
      const surveyTypeChart = new Chart(surveyTypeCtx, {
        type: "doughnut",
        data: {
          labels: ["Encuestas", "Exámenes", "Formularios"],
          datasets: [
            {
              data: [60, 25, 15],
              backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"],
              hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf"],
              hoverBorderColor: "rgba(234, 236, 244, 1)",
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          cutout: "70%",
          plugins: {
            legend: {
              display: false,
            },
          },
        },
      });

      // Menu navigation functionality
      document.querySelectorAll(".nav-link").forEach((link) => {
        link.addEventListener("click", function (e) {
          e.preventDefault();

          // Remove active class from all links
          document.querySelectorAll(".nav-link").forEach((l) => {
            l.classList.remove("active");
          });

          // Add active class to clicked link
          this.classList.add("active");

          // Hide all content sections
          document.querySelectorAll(".content-section").forEach((section) => {
            section.classList.remove("active");
          });

          // Show the selected content section
          const sectionId = this.getAttribute("data-section") + "-section";
          document.getElementById(sectionId).classList.add("active");
        });
      });


