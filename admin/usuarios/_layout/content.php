

<div class="row justify-content-center">

    <?php if (validarPermisos('usuarios.create')){ ?>
    <div class="col-md-4" id="div_create_user">
        <?php require_once 'card_form.php'; ?>
    </div>
    <?php } ?>

    <div class="col-md-8">
        <div id="dataContainer">
            <?php
            $listarUsuarios = $controller->listarUsuarios();
            $links = $controller->linksPaginate;
            $i = 0;
            require_once 'card_table.php';
            ?>
        </div>
        <?php require_once "modal_edit.php"; ?>
        <?php require_once "modal_permisos.php"; ?>
    </div>
</div>