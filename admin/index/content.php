<div class="row">
    <div class="col-12">
        Bienvenido <?php echo $controller->USER_NAME ?>. <br>
        <a href="_component/export_excel.php">Ejemplo de Export Excel.</a>
        <?php echo verUtf8("Restablecer Contraseña hola"); ?>
        <form id="form_index_dashboard">
            <input type="text" id="id_index_dashboard">
            <button type="submit">enviar</button>
        </form>
    </div>
</div>