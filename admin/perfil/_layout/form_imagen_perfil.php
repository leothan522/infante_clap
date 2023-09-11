<form id="form_perfil_imagen">


    <label for="edit_name">Subir Imagen</label>
    <div class="input-group mb-3">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFileLangHTML">
            <label class="custom-file-label" for="customFileLangHTML" data-browse="Elegir">Seleccionar Archivo</label>
        </div>
        <div class="invalid-feedback" id="error_edit_name"></div>
    </div>



    <input type="hidden" name="opcion" value="editar" id="edit_opcion">
    <input type="hidden" name="id" id="edit_id">
    <button type="submit" class="btn bg-lightblue">Guardar Cambios</button>
    <button type="reset" class="btn btn-default float-right" onclick="getUser()" id="btn_edit_cancelar">Restablecer</button>



</form>