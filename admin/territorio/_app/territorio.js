//validamos campos para los municpios
$('#municipio_nombre').inputmask("*{4,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}");

//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('tabla_municipios');

$('#form_territorio_municipio').submit(function (e) {
    e.preventDefault();
    let municipio = $('#municipio_nombre');
    let procesar = true;

    if (!municipio.inputmask('isComplete')){
        procesar = false;
        municipio.addClass('is-invalid');
        $('#error_municipio_nombre').text('El Nombre es obligatorio, debe tener al menos 4 caracteres.');
    } else {
        municipio.removeClass('is-invalid');
        municipio.addClass('is-valid');
    }

    if (procesar){
        verSpinner(true);
        $.ajax({
            type: 'POST',
            url: 'procesar.php',
            data: $(this).serialize(),
            success: function (response) {
                let data = JSON.parse(response);

                if (data.result){
                    resetMunicipio();
                    $('#municipio_btn_reset').click();
                }else{
                    if (data.error === 'nombre_duplicado'){
                        municipio.addClass('is-invalid');
                        $('#error_municipio_nombre').text(data.message);
                    }
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

function resetMunicipio() {
    $('#municipio_nombre').val('');
    $('#municipio_nombre').removeClass('is-valid');
    $('#municipio_nombre').removeClass('is-invalid');
    $('#municipio_id').val('');
    $('#municipio_opcion').val('guardar_municipio');
    $('#municipio_title').text('Crear Municipio');
}

function editMunicipio(id) {
    verSpinner(true);
    resetMunicipio();
    $('#municipio_title').text('Editar Municipio');
    $.ajax({
        type: 'POST',
        url: 'procesar.php',
        data: {
            opcion: 'get_municipio',
            id: id
        },
        success: function (response) {
            let data = JSON.parse(response);


            if (data.result){
                $('#municipio_nombre').val(data.nombre);
                $('#municipio_id').val(data.id);
                $('#municipio_opcion').val('editar_municipio');
                $('#municipio_btn_button').text('Guardar Cambios');
            }else{
                $('#municipio_btn_reset').click();
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
}


function destroyMunicipio(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            verSpinner(true);
            $.ajax({
                type: 'POST',
                url: 'procesar.php',
                data: {
                    opcion: 'eliminar_municipio',
                    id: id
                },
                success: function (response) {
                    let data = JSON.parse(response);


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
}
console.log('hi!');