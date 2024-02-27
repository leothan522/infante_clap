//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('tabla_claps');

inputmask('#clap_create_input_nombre', 'alfanumerico', 3, 100, ' ');
inputmask('#clap_edit_input_nombre', 'alfanumerico', 3, 100, ' ');
inputmask('#clap_create_input_familias', 'numerico', 1, 20, '');
inputmask('#clap_edit_input_familias', 'numerico', 1, 20, '');
inputmaskTelefono('#jefe_create_input_telefono');
inputmaskTelefono('#jefe_edit_input_telefono');
inputmask('#jefe_create_input_cedula', 'numerico', 7, 8, '');
inputmask('#jefe_edit_input_cedula', 'numerico', 7, 8, '');
inputmask('#jefe_create_input_nombre', 'alfa', 3, 100);
inputmask('#jefe_edit_input_nombre', 'alfa', 3, 100);

//Initialize Select2 Elements
/*$('.select2').select2({
    theme: 'bootstrap4'
});*/

$('#navbar_buscar').removeClass('d-none');

//funcion para guardar
$('#form_create_clap').submit(function (e) {
    e.preventDefault();

    let procesar = true;
    let municipio = $('#clap_create_select_municipio');
    let parroquia = $('#clap_create_select_parroquia');
    let bloque = $('#clap_create_select_bloque');
    let estracto = $('#clap_create_select_estracto');
    let nombre_clap = $('#clap_create_input_nombre');
    let familias = $('#clap_create_input_familias');
    let entes = $('#clap_create_select_entes');
    let cedula = $('#jefe_create_input_cedula');
    let nombre_jefe = $('#jefe_create_input_nombre');
    let genero = $('#jefe_create_select_genero');
    let telefono = $('#jefe_create_input_telefono');

    if (municipio.val().length <= 0) {
        procesar = false;
        municipio.addClass('is-invalid');
        $('.error_clap_create_select_municipio').text('El municipio es obligatorio.');
    } else {
        municipio
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (parroquia.val().length <= 0) {
        procesar = false;
        parroquia.addClass('is-invalid');
        $('.error_clap_create_select_parroquia').text('La parroquia es obligatoria.');
    } else {
        parroquia
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (bloque.val().length <= 0) {
        procesar = false;
        bloque.addClass('is-invalid');
        $('.error_clap_create_select_bloque').text('El bloque es obligatorio.');
    } else {
        bloque
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (estracto.val().length <= 0) {
        procesar = false;
        estracto.addClass('is-invalid');
        $('.error_clap_create_select_estracto').text('El estracto es obligatorio.');
    } else {
        estracto
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!nombre_clap.inputmask('isComplete')) {
        procesar = false;
        nombre_clap.addClass('is-invalid');
        $('.error_clap_create_input_nombre').text('El nombre es obligatorio y debe tener mas de 3 letras.');
    } else {
        nombre_clap
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!familias.inputmask('isComplete') || familias.val() == 0) {

        procesar = false;
        familias.addClass('is-invalid');
        $('.error_clap_create_input_familias').text('Obligatorio.');
    } else {
        familias
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (entes.val().length <= 0) {
        procesar = false;
        entes.addClass('is-invalid');
        $('.error_clap_create_select_entes').text('El ente es obligatorio.');
    } else {
        entes
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!cedula.inputmask('isComplete')) {
        procesar = false;
        cedula.addClass('is-invalid');
        $('.error_jefe_create_input_cedula').text('la cédeula es obrigatoria, y debe tener mínimo 7 digitos.')
    } else {
        cedula
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!nombre_jefe.inputmask('isComplete')) {
        procesar = false;
        nombre_jefe.addClass('is-invalid');
        $('.error_jefe_create_input_nombre').text('El nombre es obrigatoria, debe tener mínimo 3 letras.')
    } else {
        nombre_jefe
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (genero.val().length <= 0) {
        procesar = false;
        genero.addClass('is-invalid');
        $('.error_jefe_create_select_genero').text('El género es obligatorio.')
    } else {
        genero
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!telefono.inputmask('isComplete')) {
        procesar = false;
        telefono.addClass('is-invalid');
        $('.error_jefe_create_input_telefono').text('El teléfono es obligatorio.')
    } else {
        telefono
            .removeClass('is-invalid')
            .addClass('is-valid');
    }


    if (procesar) {
        ajaxRequest({url: '_request/ClapsRequest.php', data: $(this).serialize()}, function (data) {

            if (data.result) {
                cerrarModal('#modal-claps');
                let table = $('#tabla_claps').DataTable();

                if (data.nuevo) {
                    let buttons = '<div class="btn-group btn-group-sm">\n' +
                        '                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-show-claps" onclick="showClapJefe('+ data.id +')" \n' +
                        '                                 id="btn_elimiar_clap_'+ data.id +'">\n' +
                        '                                    <i class="fas fa-eye"></i>\n' +
                        '                                </button>\n' +
                        '                            </div>';


                    let municipio = $('#clap_input_municipio_id').val();

                    if (municipio === ""){
                        table.row.add([
                            data.item,
                            data.nombre_municipio,
                            data.nombre_clap,
                            data.nombre_jefe,
                            data.cedula,
                            data.telefono,
                            data.familias,
                            buttons
                        ]).draw();

                        let nuevo = $('#tabla_claps tr:last');
                        nuevo.attr('id', 'tr_item_claps_' + data.id);
                        nuevo.find("td:eq(0)").addClass('item');
                        nuevo.find("td:eq(1)").addClass('nombre_municipio');
                        nuevo.find("td:eq(2)").addClass('nombre_clap');
                        nuevo.find("td:eq(3)").addClass('nombre_jefe');
                        nuevo.find("td:eq(4)").addClass('cedula');
                        nuevo.find("td:eq(5)").addClass('telefono');
                        nuevo.find("td:eq(6)").addClass('familias');
                    }else {
                        table.row.add([
                            data.item,
                            data.nombre_clap,
                            data.nombre_jefe,
                            data.cedula,
                            data.telefono,
                            data.familias,
                            buttons
                        ]).draw();

                        let nuevo = $('#tabla_claps tr:last');
                        nuevo.attr('id', 'tr_item_claps_' + data.id);
                        nuevo.find("td:eq(0)").addClass('item');
                        nuevo.find("td:eq(1)").addClass('nombre_clap');
                        nuevo.find("td:eq(2)").addClass('nombre_jefe');
                        nuevo.find("td:eq(3)").addClass('cedula');
                        nuevo.find("td:eq(4)").addClass('telefono');
                        nuevo.find("td:eq(5)").addClass('familias');
                    }


                }

                $('#paginate_leyenda').text(data.total);
            } else {
                //errores
                if (data.error_clap == true) {
                    nombre_clap.addClass('is-invalid');
                    $('#error_clap_create_input_nombre').text('Ya existe el clap registrado en este municipio.');
                }

                if (data.error_jefe == true) {
                    cedula.addClass('is-invalid');
                    $('#error_jefe_create_input_cedula').text('La cédula ya se encuentra registrada.')
                }

                if (data.error_asignacion){
                    familias.addClass('is-invalid');
                }

            }

        });
    }

});


function resetDatosClap(opcion = 'create') {
    $('#clap_' + opcion + '_select_municipio')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('#clap_' + opcion + '_select_parroquia')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('#clap_' + opcion + '_select_bloque')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('#clap_' + opcion + '_select_estracto')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('#clap_' + opcion + '_input_nombre')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('#clap_' + opcion + '_input_familias')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('#clap_' + opcion + '_select_entes')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('#clap_' + opcion + '_input_ubch')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

}

function resetDatosJefes(opcion = 'create') {
    $('#jefe_' + opcion + '_input_cedula')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('#jefe_' + opcion + '_input_nombre')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('#jefe_' + opcion + '_select_genero')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('#jefe_' + opcion + '_input_telefono')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('#jefe_' + opcion + '_input_email')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');


}

//esta funsion sirve para resetear los datos del modal de clap
function resetClap(select_municipios, select_entes, opcion = 'create') {

    resetDatosClap(opcion);
    resetDatosJefes(opcion);

    ajaxRequest({url: '_request/ClapsRequest.php', data: {opcion: 'get_municipios_select'}}, function (data) {
        if (data.result) {
            let select_municipio = $('#' + select_municipios);
            let municipios = data.municipios.length;
            select_municipio.empty();
            select_municipio.append('<option value="">Seleccione</option>');
            for (let i = 0; i < municipios; i++) {
                let id = data.municipios[i]['id'];
                let nombre = data.municipios[i]['nombre'];
                select_municipio.append('<option value="' + id + '">' + nombre + '</option>');
            }

            let select_ente = $('#' + select_entes);
            let entes = data.entes.length;
            select_ente.empty();
            //select_ente.append('<option value="">Seleccione</option>');
            for (let i = 0; i < entes; i++) {
                let id = data.entes[i]['id'];
                let nombre = data.entes[i]['nombre'];
                select_ente.append('<option value="' + id + '" >' + nombre + '</option>');
            }

        }
    });
}

function getBloquesParroquias(selectMunicipio, selectBloque, selectParroquia) {

    let idMunicipio = $(selectMunicipio);
    if (idMunicipio.val() !== '') {
        ajaxRequest({
            url: '_request/ClapsRequest.php',
            data: {opcion: 'get_bloque_parroquia', id: idMunicipio.val()}
        }, function (data) {
            if (data.result) {
                let select_bloque = $(selectBloque);
                let bloques = data.bloques.length;
                select_bloque.empty();
                select_bloque.append('<option value="">Seleccione</option>');
                for (let i = 0; i < bloques; i++) {
                    let id = data.bloques[i]['id'];
                    let nombre = data.bloques[i]['nombre'];
                    select_bloque.append('<option value="' + id + '">' + nombre + '</option>');
                }

                let select_parroquia = $(selectParroquia);
                let parroquias = data.parroquias.length;
                select_parroquia.empty();
                select_parroquia.append('<option value="">Seleccione</option>');
                for (let i = 0; i < parroquias; i++) {
                    let id = data.parroquias[i]['id'];
                    let nombre = data.parroquias[i]['nombre'];
                    select_parroquia.append('<option value="' + id + '">' + nombre + '</option>');
                }
            }
        });
    }
}

function editClap(id_clap = 0) {
    let id;
    if (id_clap === 0) {
        id = $('#show_id_clap').val();

    } else {
        id = id_clap;
    }
    cerrarModal('#modal-show-claps');
    resetClap('clap_edit_select_municipio', 'clap_edit_select_entes', 'edit');

    setTimeout(function () {

        ajaxRequest({url: '_request/ClapsRequest.php', data: {opcion: 'get_datos_clap', id: id}}, function (data) {
            if (data.result) {

                $('#clap_edit_select_municipio')
                    .val(data.municipios_id)
                    .trigger('change');

                $('#clap_edit_select_entes')
                    .val(data.entes_id)
                    .trigger('change');

                $('#clap_edit_select_estracto')
                    .val(data.estracto)
                    .trigger('change');

                $('#clap_edit_input_nombre').val(data.nombre);
                $('#clap_edit_input_familias').val(data.familias);
                $('#clap_edit_input_ubch').val(data.ubch);
                $('#clap_edit_id').val(data.id);
                $('#clap_edit_title').text(data.nombre);

                setTimeout(function () {
                    $('#clap_edit_select_parroquia')
                        .val(data.parroquias_id)
                        .trigger('change');
                    $('#clap_edit_select_bloque')
                        .val(data.bloques_id)
                        .trigger('change');
                }, 500);

            }
        });
    }, 150);
}

//capturamos el formulario de editar los datos del clap
$('#form_edit_clap').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let municipio = $('#clap_edit_select_municipio');
    let parroquia = $('#clap_edit_select_parroquia');
    let bloque = $('#clap_edit_select_bloque');
    let estracto = $('#clap_edit_select_estracto');
    let nombre = $('#clap_edit_input_nombre');
    let familias = $('#clap_edit_input_familias');
    let entes = $('#clap_edit_select_entes');

    if (municipio.val().length <= 0) {
        procesar = false;
        municipio.addClass('is-invalid');
        $('#error_clap_edit_select_municipio').text('El municipio es obligatorio');
    } else {
        municipio
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (parroquia.val().length <= 0) {
        procesar = false;
        parroquia.addClass('is-invalid');
        $('#error_clap_edit_select_parroquia').text('La parroquia es obligatoria.');
    } else {
        parroquia
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (bloque.val().length <= 0) {
        procesar = false;
        bloque.addClass('is-invalid');
        $('#error_clap_edit_select_bloque').text('El bloque es obligatorio.');
    } else {
        bloque
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (estracto.val().length <= 0) {
        procesar = false;
        estracto.addClass('is-invalid');
        $('#error_clap_edit_select_estracto').text('El estracto es obligatorio.');
    } else {
        estracto
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!nombre.inputmask('isComplete')) {
        procesar = false;
        nombre.addClass('is-invalid');
        $('#error_clap_edit_input_nombre').text('El nombre es obligatorio, y debe tener al menos 3 letras.');
    } else {
        nombre
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!familias.inputmask('isComplete')) {
        procesar = false;
        familias.addClass('is-invalid');
        $('#error_clap_edit_input_familias').text('La cantidad de familias es obligatoria.');
    } else {
        familias
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (entes.val().length <= 0) {
        procesar = false;
        entes.addClass('is-invalid');
        $('#error_clap_edit_select_entes').text('El ente es obligatorio.');
    } else {
        entes
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar) {
        ajaxRequest({url: '_request/ClapsRequest.php', data: $(this).serialize()}, function (data) {

            if (data.result) {
                cerrarModal('#editar-clap');
                let table = $('#tabla_claps').DataTable();

                if (data.edit_clap) {
                    let tr = $('#tr_item_claps_' + data.id);
                    let municipio = $('#clap_input_municipio_id').val();

                    if (municipio === ""){
                        table
                            .cell(tr.find('.nombre_municipio')).data(data.nombre_municipio)
                            .cell(tr.find('.nombre_clap')).data(data.nombre_clap)
                            .cell(tr.find('.nombre_jefe')).data(data.nombre_jefe)
                            .cell(tr.find('.cedula')).data(data.cedula)
                            .cell(tr.find('.telefono')).data(data.telefono)
                            .cell(tr.find('.familias')).data(data.familias)
                            .draw();
                    }else {
                        table
                            .cell(tr.find('.nombre_clap')).data(data.nombre_clap)
                            .cell(tr.find('.nombre_jefe')).data(data.nombre_jefe)
                            .cell(tr.find('.cedula')).data(data.cedula)
                            .cell(tr.find('.telefono')).data(data.telefono)
                            .cell(tr.find('.familias')).data(data.familias)
                            .draw();
                    }

                }

            }else {
                if (data.error_edit_asignacion) {
                    $('#clap_edit_input_familias').addClass('is-invalid');
                }
            }
        });
    }

});

function editJefe(id_jefe = 0) {
    let id;
    if (id_jefe === 0) {
        id = $('#show_id_jefe').val();

    } else {
        id = id_jefe;
    }
    cerrarModal('#modal-show-claps');
    resetDatosJefes(opcion = 'edit');
    ajaxRequest({url: '_request/ClapsRequest.php', data: {opcion: 'get_datos_jefe', id: id}}, function (data) {

        if (data.result) {
            $('#jefe_edit_input_cedula').val(data.cedula);
            $('#jefe_edit_input_nombre').val(data.nombre);
            $('#jefe_edit_select_genero')
                .val(data.genero)
                .trigger('change');
            $('#jefe_edit_input_telefono').val(data.telefono);
            $('#jefe_edit_input_email').val(data.email);
            $('#jefe_edit_title').text(data.nombre);
            $('#jefe_edit_id').val(data.id);
        }

    });
}

//capturamos el formulario para editar lor jefes
$('#form_edit_jefe').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let cedula = $('#jefe_edit_input_cedula');
    let nombre = $('#jefe_edit_input_nombre');
    let genero = $('#jefe_edit_select_genero');
    let telefono = $('#jefe_edit_input_telefono');
    let email = $('#jefe_edit_input_email');

    if (!cedula.inputmask('isComplete')) {
        procesar = false;
        cedula.addClass('is-invalid');
        $('#error_jefe_edit_input_cedula').text('La cédula es obligatoria.');
    } else {
        cedula
            .removeClass('is-invalid')
            .addClass('is-valid');
    }


    if (!nombre.inputmask('isComplete')) {
        procesar = false;
        nombre.addClass('is-invalid');
        $('#error_jefe_edit_input_nombre').text('El nombre es obligatorio, y debe tener al menos 3 letras.');
    } else {
        nombre
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (genero.val().length <= 0) {
        procesar = false;
        genero.addClass('is-invalid');
        $('#error_jefe_edit_select_genero').text('El género es obligatorio.');
    } else {
        genero
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!telefono.inputmask('isComplete')) {
        procesar = false;
        telefono.addClass('is-invalid');
        $('#error_jefe_edit_input_telefono').text('El teléfono es obligatorio.');
    } else {
        telefono
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar) {
        ajaxRequest({url: '_request/ClapsRequest.php', data: $(this).serialize()}, function (data) {

            if (data.result) {
                cerrarModal('#editar-jefe');

                let table = $('#tabla_claps').DataTable();

                if (data.editar_jefe) {
                    let tr = $('#tr_item_claps_' + data.id_jefe);
                    table
                        .cell(tr.find('.nombre_clap')).data(data.nombre_clap)
                        .cell(tr.find('.nombre_jefe')).data(data.nombre_jefe)
                        .cell(tr.find('.cedula')).data(data.cedula)
                        .cell(tr.find('.telefono')).data(data.telefono)
                        .cell(tr.find('.familias')).data(data.familias)
                        .draw();
                }


            }else {

                if (data.error_cedula){
                    $('#jefe_edit_input_cedula').addClass('is-invalid');
                    $('#error_jefe_edit_input_cedula').text(data.message_cedula);
                }

            }
        });
    }

});


//funcion para cerrar los modals
function cerrarModal(idModal) {
    $(idModal).modal('hide');
}

//eliminar los clap
function destroyClap(id_clap = 0) {
    let id;
    if (id_clap === 0) {
        id = $('#show_id_clap').val();

    } else {
        id = id_clap;
    }
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {

            ajaxRequest({url: '_request/ClapsRequest.php', data: {opcion: 'eliminar_clap', id: id}}, function (data) {
                if (data.result){
                    cerrarModal('#modal-show-claps');
                    let table = $('#tabla_claps').DataTable();
                    let item = $('#btn_elimiar_clap_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();

                    $('#paginate_leyenda').text(data.total);
                }

            });
        }
    });
}


function editarClapJefe() {
    cerrarModal('#modal-show-claps');
}

function showClapJefe(id) {
    ajaxRequest({url: '_request/ClapsRequest.php', data: {opcion: 'show_clap', id: id}}, function (data) {
        if (data.result) {
            $('#show_clap_municipio').text(data.clap_municipio);
            $('#show_clap_parroquia').text(data.clap_parroquia);
            $('#show_clap_bloque').text(data.clap_bloque);
            $('#show_clap_estracto').text(data.clap_estracto);
            $('#show_clap_nombre').text(data.clap_nombre);
            $('#show_clap_familias').text(data.clap_familias);
            $('#show_clap_entes').text(data.clap_entes);
            $('#show_clap_ubch').text(data.clap_ubch);
            $('#show_jefe_cedula').text(data.jefe_cedula);
            $('#show_jefe_nombre').text(data.jefe_nombre);
            $('#show_jefe_genero').text(data.jefe_genero);
            $('#show_jefe_telefono').text(data.jefe_telefono);
            $('#show_jefe_correo').text(data.jefe_email);
            $('#show_id_clap').val(data.clap_id);
            $('#show_id_jefe').val(data.jefe_id);
        }
    });
}

$('#global_select_id_municipio').change(function (e) {
    e.preventDefault();
    let id = $(this).val()
    ajaxRequest({url: '_request/ClapsRequest.php', data: { opcion: 'get_claps_municipio', id: id }, html: 'si'}, function (data) {

        $('#card_listar_claps').html(data);
        datatable('tabla_claps');
        $('#clap_input_municipio_id').val(id);

    });
});

function getClapsMunicipio(id) {
    ajaxRequest({url: '_request/ClapsRequest.php', data: { opcion: 'get_claps_municipio', id: id }, html: 'si'}, function (data) {

    $('#card_listar_claps').html(data);
    datatable('tabla_claps');
    $('#clap_input_municipio_id').val(id);

    });
}

function clickDescargarClaps() {
    $('#form_claps_excel').submit();
}

$('#navbar_form_buscar').submit(function (e) {
    e.preventDefault();
    let id = $('#global_select_id_municipio').val();

    let html = '<input type="hidden" name="opcion" value="nabvar_buscar" id="nabvar_temp_opcion">';
    html += '<input type="hidden" name="id" value="'+ id +'" id="nabvar_temp_municipio">';

    $(this).append(html);

    ajaxRequest({ url: '_request/ClapsRequest.php', data: $(this).serialize(), html:'si' }, function (data) {

        $('#card_listar_claps').html(data);
        datatable('tabla_claps');
        $('#clap_input_municipio_id').val(id);

    });

    $('#nabvar_temp_opcion').remove();
    $('#nabvar_temp_municipio').remove();
    $('#nabvar_x_cerrar').click();
});




console.log('claps.!');