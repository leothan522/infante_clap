<div class="card-body">
    <button type="button" class="btn btn-primary btn-block btn-sm"
            onclick="modalBloques()" data-toggle="modal" data-target="#modal-bloques"
            <?php if (!validarPermisos('bloques.index')){ echo 'disabled ' ; } ?> >
        BLOQUES
    </button>
    <button type="button" class="btn btn-primary btn-block btn-sm"
            onclick="resetEnte()" data-toggle="modal" data-target="#modal-entes"
            <?php if (!validarPermisos("entes.index")){ echo 'disabled'; } ?>   >
        ENTES
    </button>
</div>