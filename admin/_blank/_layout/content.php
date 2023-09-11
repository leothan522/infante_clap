<div class="row">
    <div class="col-12">
        content <br><br><br><br>
        <?php
        if (!isset($controller)){
            echo "<p><h3 class='text-danger'>NOTA IMPORTANTE:</h3>Hace Falta Definir el Controlador. <br> Por ello no se muestran las opciones del <strong class='text-danger'>Sidebar</strong>. <br> Tampoco los datos de Usuario Activo en el <strong class='text-danger'>NavBar</strong>.</p>";
        }
        ?>
    </div>
</div>