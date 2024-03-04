<?php
use app\controller\RolesController;
$controller = new RolesController();
$controller->index();
?>
<div class="p-3">
    <h5>Roles de Usuarios</h5>
    <hr class="mb-2">
    <h6>Crear nuevo Rol</h6>
    <form id="right_sidebar_from_role">
        <div class="input-group input-group-sm">
            <input type="text" name="nombre" class="form-control" placeholder="nombre" id="right_sidebar_input_rol" required>
            <input type="hidden" name="opcion" value="store">
            <span class="input-group-append">
            <button type="submit" class="btn btn-success btn-flat">
                <i class="fas fa-save"></i>
            </button>
          </span>
        </div>
    </form>
    <hr class="mb-2">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <span class="text-small text-muted float-right">Roles Registrados [ <span id="right_sidebar_span_rows"> <?php echo $controller->totalRows; ?> </span> ]</span>
        </li>
        <li class="dropdown-divider"></li>
    </ul>
    <div class="col-md-12 justify-content-center" id="right_sidebar_div_listar_roles">
        <?php foreach ($controller->rows as $rol){ ?>
            <button type="button" class="btn btn-primary btn-sm btn-block m-1" data-toggle="modal"
                    data-target="#modal_roles_usuarios" onclick="editRol(<?php echo $rol['id']; ?>)"
                    <?php if (!validarPermisos()){ echo 'disabled'; } ?>
                    id="button_role_id_<?php echo $rol['id']; ?>">
                <?php echo ucfirst($rol['nombre']); ?>
            </button>
        <?php } ?>
    </div>
    <?php verCargando(); ?>
</div>