<div class="form-group">
    <label for="exampleInputFile">File input</label>
    <div class="input-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFileLangHTML">
            <label class="custom-file-label" for="customFileLangHTML" data-browse="Elegir">Seleccionar Archivo</label>
        </div>
    </div>
</div>

<!-- bs-custom-file-input -->
<script src="<?php asset('app/resources/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>

<script !src="">
    $(function () {
        bsCustomFileInput.init();
    });
</script>