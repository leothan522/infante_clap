//validamos campos para los bloques
inputmask('#bloques_input_nombre', 'alfanumerico', 4, 15);
inputmask('#bloques_input_numero', 'numerico', 1, 3, '');
inputmask('#bloques_input_asignacion', 'numerico', 1, 10, '');

//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('bloques_tabla');


//Guardamos y Editamos los bloques
$('#bloques_form').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let numero = $('#bloques_input_numero');
    let nombre = $('#bloques_input_nombre');
    let asignacion = $('#bloques_input_asignacion');
    let municipios = $('#bloques_select_municipios');

    if (numero.val().length <= 0) {
        procesar = false;
        numero.addClass('is-invalid');
        $('#error_bloques_numero').text('El numero del bloque es obligatorio')
    } else {
        numero.removeClass('is-invalid');
        numero.addClass('is-valid');
    }

    /*if (!nombre.inputmask('isComplete')) {
        procesar = false;
        nombre.addClass('is-invalid');
        $('#error_bloques_nombre').text('El nombre del bloque es obligatorio')
    } else {
        nombre.removeClass('is-invalid');
        nombre.addClass('is-valid');
    }*/

    if (municipios.val().length <= 0){
        procesar = false;
        municipios.addClass('is-invalid');
        $('#error_bloques_municipio').text('Debe seleccionar un municipio')
    } else {
        municipios.removeClass('is-invalid');
        municipios.removeClass('is-valid');
    }

    if (!asignacion.inputmask('isComplete')){
        procesar = false;
        asignacion.addClass('is-invalid');
        $('#error_bloques_asignacion').text('La asignacion es obligatoria, debe tener al menos 3 digitos.')
    } else {
        asignacion.removeClass('is-invalid');
        asignacion.addClass('is-valid');
    }

    if (procesar) {
        ajaxRequest({ url: 'procesar_bloques.php', data: $(this).serialize() }, function (data) {
            if (data.result){

                let table = $('#bloques_tabla').DataTable();

                if (data.nuevo){
                    //estoy guardando
                    let buttons = '<div class="btn-group btn-group-sm">\n' +
                        '                                <button type="button" class="btn btn-info" onclick="editBloque('+ data.id +')">\n' +
                        '                                    <i class="fas fa-edit"></i>\n' +
                        '                                </button>\n' +
                        '                                <button type="button" class="btn btn-info" onclick="eliminarBloque('+ data.id +')" id="btn_eliminar_'+ data.id +'">\n' +
                        '                                    <i class="far fa-trash-alt"></i>\n' +
                        '                                </button>\n' +
                        '                            </div>';

                    table.row.add([
                        data.numero,
                        data.nombre,
                        data.asignacion,
                        buttons
                    ]).draw();

                    let nuevo = $('#bloques_tabla tr:last');
                    nuevo.attr('id', 'tr_item_' + data.id);
                    nuevo.find("td:eq(0)").addClass('numero');
                    nuevo.find("td:eq(1)").addClass('nombre');
                    nuevo.find("td:eq(2)").addClass('asignacion');

                }else{
                    //estoy editando
                    let tr = $('#tr_item_' + data.id);
                    table
                        .cell(tr.find('.numero')).data(data.numero)
                        .cell(tr.find('.nombre')).data(data.nombre)
                        .cell(tr.find('.asignacion')).data(data.asignacion)
                        .draw();
                }
                limpiarBloques(false);
            }else {
                if (data.error_numero){
                    $('#bloques_input_numero').addClass('is-invalid');
                    $('#error_bloques_numero').text(data.message);
                }
                if (data.error_nombre){
                    $('#bloques_input_nombre').addClass('is-invalid');
                    $('#error_bloques_nombre').text(data.message);
                }

                if (data.error_asignacion){
                    $('#bloques_input_asignacion').addClass('is-invalid');
                    $('#error_bloques_asignacion').text(data.message_asignacion);
                }


            }
        });
    }

});

function editBloque(id) {
    ajaxRequest({url: 'procesar_bloques.php', data: { opcion: 'get_bloque', id: id }}, function (data) {
        if (data.result) {
            $('#bloques_input_numero').val(data.numero);
            $('#bloques_input_nombre').val(data.nombre);
            $('#bloques_input_asignacion').val(data.asignacion);
            $('#bloques_municipios_id').val($('#bloques_select_municipios').val());
            $('#bloques_id').val(data.id);
            $('#bloques_opcion').val('editar_bloque');
            $('#title_form_bloque').text('Editar Bloque')
        }
    });
}

function cambiarMunicipio() {
    let municipio = $('#bloques_select_municipios');
    municipio.removeClass('is-invalid');
    limpiarBloques(false);
    ajaxRequest({ url: 'procesar_bloques.php', data: { opcion: 'get_bloques_municipios', id: municipio.val() }, html: 'si' }, function (data){

        $('#dataContainerBloques').html(data);
        datatable('bloques_tabla');
        $('#bloques_municipios_id').val($('#bloques_select_municipios').val());

    });
}

//esta funsion sirve para resetear los datos del modal
function getMunicipios(municipio = true) {
    limpiarBloques(true);
    let html = '<span>Seleccione un Municipio para empezar</span>';
    $('#dataContainerBloques')
        .html(html);
    $('#bloques_municipios_id').val('');

    ajaxRequest({url: 'procesar_bloques.php', data: {opcion: 'get_municipios'}}, function (data) {
        if (data.result) {
            let select = $('#bloques_select_municipios');
            let municipios = data.municipios.length;
            select.empty();
            select.append('<option value="">Seleccione</option>');
            for (let i = 0; i < municipios; i++) {
                let id = data.municipios[i]['id'];
                let nombre = data.municipios[i]['nombre'];
                select.append('<option value="' + id + '">' + nombre + '</option>');
            }
        }
    });

}

function limpiarBloques( municipio = true) {
    $('#bloques_input_numero')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#bloques_input_nombre')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#bloques_id').val('');
    $('#bloques_input_asignacion')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#bloques_opcion').val('guardar_bloque');

    if (municipio){
        $('#bloques_select_municipios')
            .val('')
            .removeClass('is-invalid');
    }
}

function eliminarBloque(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {

            ajaxRequest({ url: 'procesar_bloques.php', data: { opcion: 'eliminar_bloque', id: id } }, function (data) {
                if (data.result) {
                    let table = $('#bloques_tabla').DataTable();
                    let item = $('#btn_eliminar_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();
                }
            });

        }

    });
}

console.log('bloques!');