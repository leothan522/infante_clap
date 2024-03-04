//validamos campos para los municpios
inputmask('#municipio_nombre', 'alfa', 5, 100, ' ');
inputmask('#municipio_mini', 'alfa', 5, 50, ' ');
inputmask('#municipio_asignacion', 'numerico', 3, 10, '');

//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('tabla_municipios');

//Aqui se hace la solicitud ajax para registrar un nuevo municipio o editar uno existente
$('#form_territorio_municipio').submit(function (e) {
    e.preventDefault();
    let municipio = $('#municipio_nombre');
    let mini = $('#municipio_mini');
    let asignacion = $('#municipio_asignacion');
    let procesar = true;

    if (!municipio.inputmask('isComplete')){
        procesar = false;
        municipio.addClass('is-invalid');
        $('#error_municipio_nombre').text('El Nombre es obligatorio, debe tener al menos 5 caracteres.');
    } else {
        municipio.removeClass('is-invalid');
        municipio.addClass('is-valid');
    }

    if (!mini.inputmask('isComplete')){
        procesar = false;
        mini.addClass('is-invalid');
        $('#error_municipio_mini').text('La abreviatura es obligatoria, debe tener al menos 5 caracteres.');
    } else {
        mini.removeClass('is-invalid');
        mini.addClass('is-valid');
    }

    if (!asignacion.inputmask('isComplete')){
        procesar = false;
        asignacion.addClass('is-invalid');
        $('#error_municipio_asignacion').text('La asignacion es obligatoria, debe tener al menos 3 digitos.');
    } else {
        asignacion.removeClass('is-invalid');
        asignacion.addClass('is-valid');
    }



    if (procesar){

        ajaxRequest({ url: '_request/MunicipiosRequest.php', data: $(this).serialize() }, function (data) {

            if (data.result){

                let table = $('#tabla_municipios').DataTable();
                let btn_editar = '';
                let btn_eliminar = '';
                let btn_estatus = '';

                if (!data.btn_editar){
                    btn_editar = 'disabled';
                }

                if (!data.btn_eliminar){
                    btn_eliminar = 'disabled';
                }

                if (!data.btn_estatus){
                    btn_estatus = 'disabled';
                }

                if (data.nuevo){
                    //es nuevo registro
                    let button_parroquia = '<div class="text-center"><div class="btn-group btn-group-sm text-center">\n' +
                        '                                <button type="button" class="btn btn-success" onclick="filtrarParroquias('+ data.id +')">\n' +
                        '                                    '+ data.parroquias +'\n' +
                        '                                </button>\n' +
                        '                            </div></div>';

                    let buttons = '<div class="btn-group btn-group-sm">\n' +
                        '<button type="button" class="btn btn-info" onclick="estatusMunicipio('+ data.id +')" id="btn_estatus_'+ data.id +'" '+ btn_estatus +' >\n' +
                        '                                    <i class="fas fa-eye"></i>\n' +
                        '                                </button>' +
                        '                                <button type="button" class="btn btn-info" onclick="editMunicipio('+ data.id +')" data-toggle="modal" data-target="#modal-municipios" '+ btn_editar +' >\n' +
                        '                                    <i class="fas fa-edit"></i>\n' +
                        '                                </button>\n' +
                        '                                <button type="button" class="btn btn-info" onclick="destroyMunicipio('+ data.id +')" id="btn_eliminar_'+ data.id +'" '+ btn_eliminar +' >\n' +
                        '                                    <i class="far fa-trash-alt"></i>\n' +
                        '                                </button>\n' +
                        '                            </div>';
                    table.row.add([
                        data.item,
                        data.nombre,
                        data.mini,
                        data.asignacion,
                        button_parroquia,
                        buttons
                    ]).draw();

                    let nuevo = $('#tabla_municipios tr:last');
                    nuevo.attr('id', 'tr_item_' + data.id);
                    nuevo.find("td:eq(1)").addClass('nombre');
                    nuevo.find("td:eq(2)").addClass('mini');
                    nuevo.find("td:eq(3)").addClass('asignacion');
                    nuevo.find("td:eq(4)").addClass('parroquias');
                }else {
                    //estoy editando
                    let tr = $('#tr_item_' + data.id);
                    table
                        .cell(tr.find('.nombre')).data(data.nombre)
                        .cell(tr.find('.mini')).data(data.mini)
                        .cell(tr.find('.asignacion')).data(data.asignacion)
                        .draw();
                    //modifico el nombre municipio en parroquias vinculadas
                    let table_parroquias = $('#tabla_parroquias').DataTable();
                    let parroquias = data.parroquias.length;
                    let tr_parroquia;
                    for (let i = 0; i < parroquias; i++) {
                        if ($('#tr_item_p_' + data.parroquias[i]['id']).length > 0){
                            tr_parroquia = $('#tr_item_p_' + data.parroquias[i]['id']);
                            table_parroquias
                                .cell(tr_parroquia.find('.municipio')).data(data.mini)
                                .draw()
                        }

                    }

                }

                resetMunicipio();
                $('#municipio_btn_reset').click();
                $('#paginate_leyenda_municipio').text(data.total);


            }else {

                if (data.error_municipio){
                    $('#municipio_nombre').addClass('is-invalid');
                    $('#error_municipio_nombre').text(data.message_municipio);
                }

                if (data.error_mini){
                    $('#municipio_mini').addClass('is-invalid');
                    $('#error_municipio_mini').text(data.message_mini);
                }
            }

        });

    }
});

//esta funsion sirve para resetear los datos del modal
function resetMunicipio() {
    $('#municipio_nombre')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#municipio_mini')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#municipio_asignacion')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
    $('#municipio_id').val('');
    $('#municipio_opcion').val('store');
    $('#municipio_title').text('Crear Municipio');
}

//aqui se cambia el modal para editan los municipios segun el id que se pasa
function editMunicipio(id) {

    resetMunicipio();

    ajaxRequest({ url: '_request/MunicipiosRequest.php', data: { opcion: 'edit', id: id } }, function (data) {
        if (data.result){
            $('#municipio_nombre').val(data.nombre);
            $('#municipio_id').val(data.id);
            $('#municipio_opcion').val('editar_municipio');
            $('#municipio_btn_button').text('Guardar Cambios');
            $('#municipio_mini').val(data.mini);
            $('#municipio_asignacion').val(data.asignacion);
        }else{
            $('#municipio_btn_reset').click();
        }
    });

}

//esta es la funcion para eliminar un municipio
function destroyMunicipio(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {

            ajaxRequest({ url: '_request/MunicipiosRequest.php', data: { opcion: 'eliminar_municipio', id: id } }, function (data) {

                if (data.result){

                    let table = $('#tabla_municipios').DataTable();
                    let item = $('#btn_eliminar_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();
                    $('#paginate_leyenda_municipio').text(data.total);

                    //elimno las parroquias
                    let tabla_prroquias = $('#tabla_parroquias').DataTable();
                    let parroquias = data.parroquias.length;
                    let item_parroquia;
                    for (let i = 0; i < parroquias; i++) {
                        if ($('#btn_eliminar_p_' + data.parroquias[i]['id']).length > 0){
                            item_parroquia = $('#btn_eliminar_p_' + data.parroquias[i]['id']).closest('tr');
                            tabla_prroquias
                                .row(item_parroquia)
                                .remove()
                                .draw();
                        }
                    }

                    $('#paginate_leyenda_parroquia').text(data.total_parroquias);

                }
            });
        }
    });
}

function estatusMunicipio(id)
{
    let boton = $('#btn_estatus_' + id);

    ajaxRequest({ url: '_request/MunicipiosRequest.php', data: { opcion: 'estatus_municipio', id: id } }, function (data) {
        if (data.result){
            if (data.estatus === 1){
                boton.html(' <i class="fas fa-eye"></i>');
            }else {
                boton.html('<i class="fas fa-eye-slash"></i>');
            }
        }
    });

}

console.log('Municipio.!');