<?php if ($controller->listarmunicipios()){ ?>

    <select class="custom-select custom-select-sm rounded-0" id="global_select_id_municipio">
        <option value="">MUNICIPIOS</option>
        <?php
        foreach ($controller->listarmunicipios() as $listarmunicipio)
        {
            if (validarAccesoMunicipio($listarmunicipio['id'])){
                ?>
                <option value="<?php echo $listarmunicipio['id']; ?>"> <?php echo $listarmunicipio['nombre'] ?> </option>
                <?php
            }
        }
        ?>
    </select>

<?php } ?>