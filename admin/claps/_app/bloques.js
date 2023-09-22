//validamos campos para los bloques
$('#bloques_input_nombre').inputmask("*{4,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}");
$('#bloques_input_numero').inputmask("9{1,3}");

//Guardamos y Editamos los bloques
$('#bloques_form').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let numero = $('#bloques_input_numero');
    let nombre = $('#bloques_input_nombre');

    if (numero.val().length <= 0){
        procesar = false;
        numero.addClass('is-invalid');
        $('#error_bloques_numero').text('El numero del bloque es obligatorio')
    }else {
        numero.removeClass('is-invalid');
        numero.addClass('is-valid');
    }

    if (!nombre.inputmask('isComplete')){
        procesar = false;
        nombre.addClass('is-invalid');
        $('#error_bloques_nombre').text('El nombre del bloque es obligatorio')
    }else {
        nombre.removeClass('is-invalid');
        nombre.addClass('is-valid');
    }

    if (procesar){
        verSpinner(true);
        $.ajax({
            type: 'POST',
            url: 'procesar_bloques.php',
            data: $(this).serialize(),
            success: function (response) {
                let data = JSON.parse(response);

                if (data.result){
                    numero.removeClass('is-valid');
                    nombre.removeClass('is-valid')
                }

                if (data.alerta) {
                    Alerta.fire({
                        icon: data.icon,
                        title: data.title,
                        text: data.message
                    });
                } else {
                    Toast.fire({
                        icon: data.icon,
                        text: data.title
                    });
                }
                verSpinner(false);
            }
        });
    }

});

function editBloque(id) {
    verSpinner(true);
    $.ajax({
        type: 'POST',
        url: 'procesar_bloques.php',
        data: {
            opcion: 'get_bloque',
            id: id
        },
        success: function (response) {
            let data = JSON.parse(response);

            if (data.result){
                $('#bloques_input_numero').val(data.numero);
                $('#bloques_input_nombre').val(data.nombre);
                $('#bloques_municipios_id').val(data.municipios_id);
                $('#id').val(data.id);
                $('#opcion_id').val('editar_bloque');
                $('#title_form_bloque').text('Editar Bloque')

            }

            if (data.alerta) {
                Alerta.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.message
                });
            } else {
                Toast.fire({
                    icon: data.icon,
                    text: data.title
                });
            }
            verSpinner(false);
        }
    });
}

function cambiarMunicipio() {
    verSpinner(true);
    let municipio = $('#bloques_select_municipios');
    $('#bloques_municipios_id').val(municipio.val());
}

//esta funsion sirve para resetear los datos del modal
function resetBloque() {
    $('#bloques_input_numero').val('');
    $('#bloques_input_nombre').val('');
    $('#bloques_municipios_id').val('');
    $('#id').val('');
    $('#opcion_id').val('guardar_bloque');
}


console.log('hola');