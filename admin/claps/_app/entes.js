//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('entes_tabla');

//validamos campos para los entes
$('#entes_input_nombre').inputmask("*{4,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}");

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
        verSpinner(true);
        $.ajax({
           type: 'POST',
           url: 'procesar_entes.php',
           data: $(this).serialize(),
           success: function (response) {
               let data = JSON.parse(response);

               if (data.result){
                   nombre.removeClass('is-valid');
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

function editEnte(id){
    verSpinner(true);
    $.ajax({
       type: 'POST',
       url: 'procesar_entes.php',
       data: {
           opcion: 'get_ente',
           id: id
       },
        success: function (response) {
            let data = JSON.parse(response);

            if (data.result){
                $('#entes_input_nombre').val(data.nombre);
                $('#entes_id').val(data.id);
                $('#entes_opcion').val('editar_ente');
                $('#title_form_ente').text('Editar Ente')
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

function eliminarEnte(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            verSpinner(true);
            $.ajax({
                type: 'POST',
                url: 'procesar_entes.php',
                data: {
                    opcion: 'eliminar_ente',
                    id: id
                },
                success: function (response) {
                    let data = JSON.parse(response);

                    if (data.result) {
                        let table = $('#entes_tabla').DataTable();
                        let item = $('#btn_eliminar_ente_' + id).closest('tr');
                        table
                            .row(item)
                            .remove()
                            .draw();
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
}

console.log('entes d');