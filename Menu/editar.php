<?php
require_once 'conexion.php';

$database = new Database();
$db = $database->getConnection();

$error = '';
$mensaje = '';

if (!isset($_GET['id']) || intval($_GET['id']) <= 0) {
    echo '<div class="alert alert-warning">⚠️ ID no válido.</div>';
    return;
}

$id = intval($_GET['id']);
$stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo '<div class="alert alert-danger">❌ Usuario no encontrado.</div>';
    return;
}
?>

<div class="containerC" id="contenido-editar">
    <!-- Header -->
    <div class="header-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-user-edit me-2"></i>Editar Usuario</h2>
                <p class="mb-0">
                    ID: <?php echo htmlspecialchars($usuario['id']); ?> |
                    Creado: <?php echo date('d/m/Y', strtotime($usuario['fecha_creacion'])); ?>
                </p>
            </div>
            <button type="button" class="btn btn-light" id="btnVolverLista">
                <i class="fas fa-arrow-left me-1"></i>Volver
            </button>
        </div>
    </div>

    <form id="formEditarUsuario">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

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

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label required">Rol</label>
                    <select class="form-select" name="rol" required>
                        <option value="usuario" <?php echo $usuario['rol'] == 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                        <option value="candidato" <?php echo $usuario['rol'] == 'candidato' ? 'selected' : ''; ?>>Candidato </option>
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
                                <input type="password" class="form-control" name="password" id="password" minlength="6">
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
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password">
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
            <button type="button" class="btn btn-secondary me-md-2" id="btnCancelarEdicion">
                <i class="fas fa-times me-1"></i>Cancelar
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>Guardar Cambios
            </button>
        </div>
    </form>
</div>