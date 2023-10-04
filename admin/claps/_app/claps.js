//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('tabla_claps');

inputmask('.clap_input_nombre', 'alfanumerico', 3, 100, ' ');
//$('.clap_input_nombre').inputmask({regex: "[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{4,}"});
//$('.clap_input_nombre').inputmask({regex: "[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,!¿? ]{4,}"});

function prueba() {
    if ($('.clap_input_nombre').inputmask('isComplete')){
        console.log('completo');
    }else {
        console.log('error');
    }
}


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

console.log('clap');