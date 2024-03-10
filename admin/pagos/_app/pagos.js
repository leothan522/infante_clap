$('#global_select_id_municipio').change(function (e) {
    e.preventDefault();
    let id = $(this).val()
    $('#pagos_input_municipio_id').val(id);
});

console.log('pagos.!');