//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('entes_tabla');

//validamos campos para los entes
inputmask('#entes_input_nombre', 'alfanumerico', 4, 50, '. ');

$('#entes_form').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let nombre = $('#entes_input_nombre');

    if (!nombre.inputmask('isComplete')){
        procesar = false;
        nombre.addClass('is-invalid');
        $('#error_entes_nombre').text('El nombre es obligatorio y debe tener al menos 4 caracteres.')
    }else {
        nombre.removeClass('is-invalid');
        nombre.addClass('is-valid');
    }

    if (procesar){

        ajaxRequest({ url: '_request/EntesRequest.php', data: $(this).serialize() }, function (data) {
            if (data.result){
                let table = $('#entes_tabla').DataTable();

                if (data.nuevo){
                    //estoy guardando
                    let buttons = '<div class="btn-group btn-group-sm">\n' +
                        '                                <button type="button" class="btn btn-info" onclick="editEnte('+ data.id +')">\n' +
                        '                                    <i class="fas fa-edit"></i>\n' +
                        '                                </button>\n' +
                        '                                <button type="button" class="btn btn-info" onclick="eliminarEnte('+ data.id +')" id="btn_eliminar_ente_'+ data.id +'">\n' +
                        '                                    <i class="far fa-trash-alt"></i>\n' +
                        '                                </button>\n' +
                        '                            </div>';
                    table.row.add([
                        data.item,
                        data.nombre,
                        buttons
                    ]).draw();
                    let nuevo = $('#entes_tabla tr:last')
                    nuevo.attr('id', 'tr_item_ente_' + data.id);
                    nuevo.find("td:eq(0)").addClass('item');
                    nuevo.find("td:eq(1)").addClass('nombre');
                }else {
                    //estoy editando
                    let tr = $('#tr_item_ente_' + data.id);
                    table
                        .cell(tr.find('.item')).data(data.item)
                        .cell(tr.find('.nombre')).data(data.nombre)
                        .draw();
                }
                resetEnte();
            }else {
                //
                if (data.error === 'nombre_duplicado'){
                    nombre.addClass('is-invalid');
                    $('#error_entes_nombre').text('El nombre ya esta registrado.')
                }

            }

            quitarClass();
        });

    }
});

function editEnte(id){

    ajaxRequest({ url: '_request/EntesRequest.php', data: { opcion: 'get_ente', id: id } }, function (data) {
        if (data.result){
            $('#entes_input_nombre').val(data.nombre);
            $('#entes_id').val(data.id);
            $('#entes_opcion').val('editar_ente');
            $('#title_form_ente').text('Editar Ente');
        }
    });

}

function eliminarEnte(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {

            ajaxRequest({ url: '_request/EntesRequest.php', data: { opcion: 'eliminar_ente', id: id } }, function (data) {
                if (data.result) {
                    let table = $('#entes_tabla').DataTable();
                    let item = $('#btn_eliminar_ente_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();
                }
            });

        }

    });
}

function resetEnte() {
    $('#entes_input_nombre')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#entes_id').val('');
    $('#error_entes_nombre').text('');
    $('#entes_opcion').val('guardar_ente');

    getEntes();
}

function quitarClass() {
    $('#entes_input_nombre')
        .removeClass('is-valid');
}

function getEntes() {
    ajaxRequest({ url: '_request/EntesRequest.php', data: { opcion: 'get_entes' }, html: 'si' }, function (data) {
        $('#mostrar_entes').html(data.html);
        datatable('entes_tabla');
    });
}

console.log('entes!');