<?php
$listarUsuarios = $controller->rows;
$links = $controller->links;
$userRole = $controller->USER_ROLE;
$i = $controller->offset;
$x = 0;
?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <?php if (empty($controller->keyword)){ ?>
                Usuarios Registrados
                <?php }else{ ?>
                Resultados para la busqueda [ <strong class="text-danger"><?php echo $controller->keyword; ?></strong> ]
                <button type="button" class="btn btn-tool" onclick="reconstruirTabla()">
                    <i class="fas fa-times-circle"></i>
                </button>
            <?php } ?>
        </h3>

        <div class="card-tools">
            <!--<button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                <i class="fas fa-sync-alt"></i>
            </button>-->
            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
            </button>
            <!--<button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>-->
            <!--<button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>-->
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table table-responsive mt-3">
            <table class="table table-sm" id="tabla_usuarios">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Estatus</th>
                    <th style="width: 5%">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listarUsuarios as $user) {
                    $i++;
                    $x++;
                    ?>
                    <tr id="tr_item_<?php echo $user['id']; ?>">
                        <td class="text-center"><?php echo $i ?></td>
                        <td class="nombre"><?php echo $user['name'] ?></td>
                        <td class="email"><?php echo $user['email'] ?></td>
                        <td class="telefono text-center"><?php echo $user['telefono'] ?></td>
                        <td class="role text-center"><?php echo $controller->getRol($user['role'], $user['role_id']) ?></td>
                        <td class="estatus text-center"><?php echo $controller->verEstatusUsuario($user['estatus']) ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info" onclick="edit(<?php echo $user['id'] ?>)"
                                        data-toggle="modal" data-target="#modal_edit_usuarios"
                                    <?php if (($_SESSION['id'] == $user['id']) || ($user['role'] == 100) || (!validarPermisos('usuarios.edit')) || ($user['role'] > $userRole && $userRole != 100)) { echo 'disabled'; } ?> >
                                    <i class="fas fa-user-edit"></i>
                                </button>
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                        data-target="#modal_permisos" onclick="getPermisos(<?php echo $user['id'] ?>)"
                                    <?php if (($_SESSION['id'] == $user['id']) || ($user['role'] == 100) || (!validarPermisos())) {
                                        echo 'disabled';
                                    } ?>>
                                    <i class="fas fa-user-shield"></i>
                                </button>
                                <button type="button" class="btn btn-info"
                                        onclick="destroy(<?php echo $user['id']; ?>)"
                                        id="btn_eliminar_<?php echo $user['id'] ?>"
                                    <?php if (($_SESSION['id'] == $user['id']) || ($user['role'] == 100) || (!validarPermisos('usuarios.destroy')) || ($user['role'] > $userRole && $userRole != 100)) { echo 'disabled'; } ?> >
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <?php
        if (empty($controller->keyword)){
            echo $links;
        }else{
            echo "Mostrando ".$x;
        }

        ?>
        <input type="hidden" value="<?php echo $x ?>" placeholder="valor_x" name="valor_x" id="input_hidden_valor_x">
        <!--<ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>-->
    </div>

    <?php verCargando(); ?>

</div>