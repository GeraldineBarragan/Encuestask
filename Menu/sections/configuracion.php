
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