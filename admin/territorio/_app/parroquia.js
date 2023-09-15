//inicializo datatable
datatable('tabla_parroquias');

//inicializamos el inputmask
$('#parroquia_nombre').inputmask("*{4,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}");

//Aqui se hace la solicitud ajax para registrar una nueva parroquia o editar una existente
$('#form_parroquias').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let municipio = $('#parroquia_municipio');
    let parroquia = $('#parroquia_nombre');

    if (municipio.val().length <= 0){
        procesar = false;
        municipio.addClass('is-invalid');
        $('#error_parroquia_municipio').text('El municipio es obligatorio');
    }else {
        municipio.removeClass('is-invalid');
        municipio.addClass('is-valid');
    }

    if (!parroquia.inputmask('isComplete')){
        procesar = false;
        parroquia.addClass('is-invalid');
        $('#error_parroquia_nombre').text('El nombre de la parroquia es obligatorio');
    }else {
        parroquia
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar){
        verSpinner(true);
        $.ajax({
            type: 'POST',
            url: 'procesar_parroquia.php',
            data: $(this).serialize(),
            success: function (response) {
                let data = JSON.parse(response);

                if (data.result){

                    let table = $('#tabla_parroquias').DataTable();

                    if (data.nuevo){
                        //nuevo
                        let buttons = '<div class="btn-group btn-group-sm">\n' +
                            '                                <button type="button" class="btn btn-info" onclick="editParroquia('+ data.id +')" data-toggle="modal"\n' +
                            '                                        data-target="#modal-parroquias">\n' +
                            '                                    <i class="fas fa-edit"></i>\n' +
                            '                                </button>\n' +
                            '                                <button type="button" class="btn btn-info" onclick="elimParroquia('+ data.id +')">\n' +
                            '                                    <i class="far fa-trash-alt"></i>\n' +
                            '                                </button>\n' +
                            '                            </div>';

                        table.row.add([
                            data.item,
                            data.parroquia,
                            data.municipio,
                            buttons
                        ]).draw();

                        let nuevo = $('#tabla_parroquias tr:last');
                        nuevo.attr('id', 'tr_item_p_' + data.id);
                        nuevo.find("td:eq(1)").addClass('parroquia');
                        nuevo.find("td:eq(2)").addClass('municipio');

                    }else {
                        //estoy editando
                        let tr = $('#tr_item_p_' + data.id);
                        table
                            .cell(tr.find('.parroquia')).data(data.parroquia)
                            .cell(tr.find('.municipio')).data(data.municipio)
                            .draw();
                    }


                    resetParroquia();
                    $('#parroquia_btn_cancelar').click();
                }else {

                    if (data.error === 'nombre_duplicado'){
                        $('#parroquia_nombre').addClass('is-invalid');
                        $('#error_parroquia_nombre').text(data.message);
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

//aqui se cambia el modal para editar las parroquias segun el id que se pasa
function editParroquia(id) {
    verSpinner(true);
    resetParroquia();
    $('#title_parroquia').text('Editar Parroquia');
    $.ajax({
        type: 'POST',
        url: 'procesar_parroquia.php',
        data:{
            opcion: 'get_parroquia',
            id: id
        },
        success: function (response) {
            let data = JSON.parse(response)

            if (data.result){
                $('#parroquia_municipio').val(data.municipios);
                $('#parroquia_nombre').val(data.parroquia);
                $('#parroquia_opcion').val('editar_parroquia');
                $('#parroquia_id').val(data.id);
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

function elimParroquia(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed){
            verSpinner(true);
            $.ajax({
                type: 'POST',
                url: 'procesar_parroquia.php',
                data: {
                    opcion: 'eliminar_parroquia',
                    id:id
                },
                success: function (response) {
                    let data = JSON.parse(response);

                    if (data.result){
                        let table = $('#tabla_parroquias').DataTable();
                        let item = $('#btn_eliminar_p_' + id).closest('tr');
                        table
                            .row(item)
                            .remove()
                            .draw();

                        $('#paginate_leyenda').text(data.total);
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

//esta funsion sirve para resetear los datos del modal de parroquia
function resetParroquia(){
    $('#parroquia_municipio')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-valid');
    $('#parroquia_nombre')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#parroquia_id').val('');
    $('#parroquia_opcion').val('guardar_parroquia');
    $('#title_parroquia').text('Crear Parroquia')
}

console.log('hi!');
