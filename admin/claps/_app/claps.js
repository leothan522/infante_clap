//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('tabla_claps');

inputmask('.clap_input_nombre', 'alfanumerico', 3, 100, ' ');
inputmask('.clap_input_familias', 'numerico', 1, 20, '');
inputmaskTelefono('.jefe_input_telefono');
inputmask('.jefe_input_cedula', 'numerico', 7, 8, '');
inputmask('.jefe_input_nombre', 'alfa', 3, 100);

//funcion para guardar o editar.
$('#form_create_clap').submit(function (e) {
    e.preventDefault();

    let procesar = true;
    let municipio = $('.clap_select_municipio');
    let parroquia = $('.clap_select_parroquia');
    let bloque = $('.clap_select_bloque');
    let estracto = $('.clap_select_estracto');
    let nombre_clap = $('.clap_input_nombre');
    let familias = $('.clap_input_familias');
    let entes = $('.clap_select_entes');
    let cedula = $('.jefe_input_cedula');
    let nombre_jefe = $('.jefe_input_nombre');
    let genero = $('.jefe_select_genero');
    let telefono = $('.jefe_input_telefono');

    if (municipio.val().length <= 0) {
        procesar = false;
        municipio.addClass('is-invalid');
        $('.error_clap_select_municipio').text('El municipio es obligatorio.');
    } else {
        municipio
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (parroquia.val().length <= 0) {
        procesar = false;
        parroquia.addClass('is-invalid');
        $('.error_clap_select_parroquia').text('La parroquia es obligatoria.');
    } else {
        parroquia
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (bloque.val().length <= 0) {
        procesar = false;
        bloque.addClass('is-invalid');
        $('.error_clap_select_bloque').text('El bloque es obligatorio.');
    } else {
        bloque
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (estracto.val().length <= 0) {
        procesar = false;
        estracto.addClass('is-invalid');
        $('.error_clap_select_estracto').text('El estracto es obligatorio.');
    } else {
        estracto
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!nombre_clap.inputmask('isComplete')) {
        procesar = false;
        nombre_clap.addClass('is-invalid');
        $('.error_clap_input_nombre').text('El nombre es obligatorio y debe tener mas de 3 letras.');
    } else {
        nombre_clap
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!familias.inputmask('isComplete')) {
        procesar = false;
        familias.addClass('is-invalid');
        $('.error_clap_input_familias').text('Obligatorio.');
    } else {
        familias
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (entes.val().length <= 0) {
        procesar = false;
        entes.addClass('is-invalid');
        $('.error_clap_select_entes').text('El ente es obligatorio.');
    } else {
        entes
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!cedula.inputmask('isComplete')) {
        procesar = false;
        cedula.addClass('is-invalid');
        $('.error_jefe_input_cedula').text('la cédeula es obrigatoria, y debe tener mínimo 7 digitos.')
    } else {
        cedula
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!nombre_jefe.inputmask('isComplete')) {
        procesar = false;
        nombre_jefe.addClass('is-invalid');
        $('.error_jefe_input_nombre').text('El nombre es obrigatoria, debe tener mínimo 3 letras.')
    } else {
        nombre_jefe
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (genero.val().length <= 0) {
        procesar = false;
        genero.addClass('is-invalid');
        $('.error_jefe_select_genero').text('El género es obligatorio.')
    } else {
        genero
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (!telefono.inputmask('isComplete')) {
        procesar = false;
        telefono.addClass('is-invalid');
        $('.error_jefe_input_telefono').text('El teléfono es obligatorio.')
    } else {
        telefono
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar) {
        ajaxRequest({url: 'procesar_claps.php', data: $(this).serialize()}, function (data) {

        });
    }

});


function resetDatosClap() {
    $('.clap_select_municipio')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('.clap_select_parroquia')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('.clap_select_bloque')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('.clap_select_estracto')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('.clap_input_nombre')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('.clap_input_familias')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('.clap_select_entes')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
}

function resetDatosJefes() {
    $('.jefe_input_cedula')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('.jefe_input_nombre')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('.jefe_select_genero')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');

    $('.jefe_input_telefono')
        .val('')
        .removeClass('is-invalid')
        .removeClass('is-valid');
}

//esta funsion sirve para resetear los datos del modal de clap
function resetClap() {

    resetDatosClap();
    resetDatosJefes();
    verSpinner(true);
    $.ajax({
        type: 'POST',
        url: 'procesar_claps.php',
        data: {
            opcion: 'get_municipios_select'
        },
        success: function (response) {

            let data = JSON.parse(response);

            if (data.result) {
                let select_municipio = $('.clap_select_municipio');
                let municipios = data.municipios.length;
                select_municipio.empty();
                select_municipio.append('<option value="">Seleccione</option>');
                for (let i = 0; i < municipios; i++) {
                    let id = data.municipios[i]['id'];
                    let nombre = data.municipios[i]['nombre'];
                    select_municipio.append('<option value="' + id + '">' + nombre + '</option>');
                }

                let select_ente = $('.clap_select_entes');
                let entes = data.entes.length;
                select_ente.empty();
                select_ente.append('<option value="">Seleccione</option>');
                for (let i = 0; i < entes; i++) {
                    let id = data.entes[i]['id'];
                    let nombre = data.entes[i]['nombre'];
                    select_ente.append('<option value="' + id + '" >' + nombre + '</option>');
                }

            }

            if (data.alerta) {
                Alerta.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.message
                });
            } else {
                /*Toast.fire({
                    icon: data.icon,
                    text: data.title
                });*/
            }
            verSpinner(false);
        }
    });
    /* */
}

function getBloquesParroquias() {
    let municipio = $('.clap_select_municipio');

    verSpinner(true);
    $.ajax({
        type: 'POST',
        url: 'procesar_claps.php',
        data: {
            opcion: 'get_bloque_parroquia',
            id: municipio.val()
        },
        success: function (response) {

            let data = JSON.parse(response);

            if (data.result) {
                let select_bloque = $('.clap_select_bloque');
                let bloques = data.bloques.length;
                select_bloque.empty();
                select_bloque.append('<option value="">Seleccione</option>');
                for (let i = 0; i < bloques; i++) {
                    let id = data.bloques[i]['id'];
                    let nombre = data.bloques[i]['nombre'];
                    select_bloque.append('<option value="' + id + '">' + nombre + '</option>');
                }

                let select_parroquia = $('.clap_select_parroquia');
                let parroquias = data.parroquias.length;
                select_parroquia.empty();
                select_parroquia.append('<option value="">Seleccione</option>');
                for (let i = 0; i < parroquias; i++) {
                    let id = data.parroquias[i]['id'];
                    let nombre = data.parroquias[i]['nombre'];
                    select_parroquia.append('<option value="' + id + '">' + nombre + '</option>');
                }
            }

            if (data.alerta) {
                Alerta.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.message
                });
            } else {
                /*Toast.fire({
                    icon: data.icon,
                    text: data.title
                });*/
            }
            verSpinner(false);
        }
    });
    /* */
}

console.log('clapswwww');