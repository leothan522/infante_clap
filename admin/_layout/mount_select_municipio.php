<?php
if ($controller->MUNICIPIOS){
    $listarmunicipios = $controller->MUNICIPIOS;
?>

    <select class="custom-select custom-select-sm rounded-0" id="global_select_id_municipio">
        <option value="">MUNICIPIOS</option>
        <?php
        foreach ($listarmunicipios as $municipio)
        {
            if (validarAccesoMunicipio($municipio['id'])){
                ?>
                <option value="<?php echo $municipio['id']; ?>"> <?php echo $municipio['nombre'] ?> </option>
                <?php
            }
        }
        ?>
    </select>

<?php } ?>