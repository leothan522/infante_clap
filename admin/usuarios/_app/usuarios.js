//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('tabla_usuarios');

//Inicializamos el InputMak
inputmask('#name', 'alfa', 3, 50, ' ');
inputmask('#edit_name', 'alfa', 3, 50, ' ');
inputmaskTelefono('#telefono');
inputmaskTelefono('#edit_telefono');


//Generar Clave Aleatoria
function generarClave() {
    
    ajaxRequest({ data: { opcion: 'generar_clave' } }, function (data) {
        if (data.result){
            $('#password').val(data.message);
        }
    });
    
    /*verSpinner(true);
    $.ajax({
        type: 'POST',
        url: 'procesar.php',
        data: {
            opcion: 'generar_clave',
        },
        success: function (response) {
            let data = JSON.parse(response);


            if (data.result){
                $('#password').val(data.message);
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
            verSpinner(false)
        }
    });*/
}

//Crear Usuario
$('#form_create_user').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let name = $('#name');
    let email = $('#email');
    let password = $('#password');
    let telefono = $('#telefono');
    let tipo =  $('#tipo');

    if (!name.inputmask('isComplete')){
        procesar = false;
        name.addClass('is-invalid');
        $('#error_name').text('El Nombre es obligatorio, debe tener al menos 4 caracteres.');
    } else {
        name.removeClass('is-invalid');
        name.addClass('is-valid');
    }

    if (email.val().length <= 0 ){
        procesar = false;
        email.addClass('is-invalid');
        $('#error_email').text('El Email es obligatorio.');
    }else {
        email.removeClass('is-invalid');
        email.addClass('is-valid');
    }

    if (password.val().length <= 7){
        procesar = false;
        password.addClass('is-invalid');
        $('#error_password').text('El contraseña es obligatoria, debe tener al menos 8 caracteres');
    }else {
        password.removeClass('is-invalid');
        password.addClass('is-valid');
    }

    if (!telefono.inputmask("isComplete")) {
        procesar = false;
        telefono.addClass('is-invalid');
        $('#error_telefono').text('El Teléfono es invalido.');
    } else {
        telefono.removeClass('is-invalid');
        telefono.addClass('is-valid');
    }

    if (tipo.val().length <= 0){
        procesar = false;
        tipo.addClass('is-invalid');
        $('#error_tipo').text('El Tipo es obligatorio.');
    }else {
        tipo.removeClass('is-invalid');
        tipo.addClass('is-valid');
    }

    if (procesar){
        
        ajaxRequest({ data: $(this).serialize() }, function (data) {

            if (data.result){

                let table = $('#tabla_usuarios').DataTable();
                let btn_editar = '';
                let btn_eliminar = '';
                let btn_estatus = '';

                if (!data.btn_editar){
                    btn_editar = 'disabled';
                }

                if (!data.btn_eliminar){
                    btn_eliminar = 'disabled';
                }

                if (!data.btn_permisos){
                    btn_estatus = 'disabled';
                }

                let buttons = '<div class="btn-group btn-group-sm">\n' +
                    '                                <button type="button" class="btn btn-info" onclick="getUser('+ data.id +')"\n' +
                    '                                        data-toggle="modal" data-target="#modal_edit_usuarios" '+ btn_editar +'>\n' +
                    '                                    <i class="fas fa-user-edit"></i>\n' +
                    '                                </button>\n' +
                    '                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_permisos" onclick="getPermisos('+ data.id +')" '+ btn_estatus +' >\n' +
                    '                                    <i class="fas fa-user-shield"></i>\n' +
                    '                                </button>\n' +
                    '                                <button type="button" class="btn btn-info" onclick="destroyUser('+ data.id +')" id="btn_eliminar_'+ data.id +'" '+ btn_eliminar +' >\n' +
                    '                                    <i class="far fa-trash-alt"></i>\n' +
                    '                                </button>\n' +
                    '                            </div>';

                table.row.add([
                    data.item,
                    data.name,
                    data.email,
                    data.telefono,
                    data.role,
                    data.estatus,
                    buttons
                ]).draw();

                let nuevo = $('#tabla_usuarios tr:last');
                nuevo.attr('id', 'tr_item_' + data.id)
                nuevo.find("td:eq(1)").addClass('nombre');
                nuevo.find("td:eq(2)").addClass('email');
                nuevo.find("td:eq(3)").addClass('telefono');
                nuevo.find("td:eq(4)").addClass('role');
                nuevo.find("td:eq(5)").addClass('estatus');

                $('#btn_reset_create_user').click();
                $('#paginate_leyenda').text(data.total);

            }else {
                if (data.error === "email_duplicado") {
                    email.addClass('is-invalid');
                    $('#error_email').text("email ya registrado.");
                }
            }
            
        });
    }


});

//Limpiar o Restablecer Formulario
function resetForm(edit = false) {
    if (!edit){
        $('#name')
            .removeClass('is-valid')
            .removeClass('is-invalid');
        $('#email')
            .removeClass('is-valid')
            .removeClass('is-invalid');
        $('#password')
            .removeClass('is-valid')
            .removeClass('is-invalid');
        $('#telefono')
            .removeClass('is-valid')
            .removeClass('is-invalid');
        $('#tipo')
            .removeClass('is-valid')
            .removeClass('is-invalid');
    }else {
        $('#edit_name')
            .removeClass('is-valid')
            .removeClass('is-invalid');
        $('#edit_email')
            .removeClass('is-valid')
            .removeClass('is-invalid');
        $('#edit_telefono')
            .removeClass('is-valid')
            .removeClass('is-invalid');
        $('#edit_tipo')
            .removeClass('is-valid')
            .removeClass('is-invalid');
    }
}

//quitar DIV contenedor del formulario
function cerrarDiv() {
    verSpinner(true);
    setTimeout(function () {
        $('#div_create_user').addClass('d-none');
        verSpinner(false);
    }, 500);
}

//Actualizando los datos del usuario en modal edit
function setUser(data) {
    $('#profile_name').text(data.name);
    $('#profile_tipo').text(data.tipo);
    $('#profile_email').text(data.email);
    $('#profile_telefono').text(data.telefono);
    $('#profile_estatus').html(data.estatus);
    $('#profile_fecha').text(data.fecha);
    $('#edit_id').val(data.id);
    $('#edit_name').val(data.name);
    $('#edit_email').val(data.email);
    $('#edit_telefono').val(data.telefono);
    $('#edit_tipo')
        .val(data.role)
        .trigger('change');

    let button = $('#btn_profile_band_user');
    if (data.band !== 1){
        button.removeClass('btn-danger');
        button.addClass('btn-success');
        button.text('Activar Usuario');
    }else {
        button.addClass('btn-danger');
        button.removeClass('btn-success');
        button.text('Inactivar Usuario');
    }
}

//Solicitando los datos del usuario para el modal
function getUser(id = null) {

    //Inicializamos el InputMak
    /*$('#edit_name').inputmask("*{4,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}");
    $('#edit_telefono').inputmask("(9999) 999-99.99");
*/
    let enviar_id;

    if (id){
        enviar_id = id;
    }else {
        enviar_id = $('#edit_id').val();
    }
    
    ajaxRequest({ data:{ opcion: 'get_user', id: enviar_id } }, function (data) {
        if (data.result){
            setUser(data);
            $('#ver_new_password').addClass('d-none');
            $('#profile_new_password').val('');
            resetForm(true);
        }
    });
}

//cambiar estatus del usuario
function cambiarEstatus() {
    let id = $('#edit_id').val();
    
    ajaxRequest({ data: { opcion: 'cambiar_estatus', id: id } }, function (data) {
        if (data.result){
            setUser(data);
            let table = $('#tabla_usuarios').DataTable();
            let tr = $('#tr_item_' + data.id);
            table
                .cell(tr.find('.estatus')).data(data.table_estatus)
                .draw();
        }
    });
}

//restablecer contraseña
function resetPassword() {
    let id = $('#edit_id').val();
    let ver = $('#ver_new_password');
    let input = $('#profile_new_password');
    
    ajaxRequest({ data: { opcion: 'reset_password', id: id, password: input.val() }}, function (data) {
        if (data.result){
            ver.removeClass('d-none');
            input.val(data.message);
            setUser(data);
        }
    });
}

//Editar usuario
$('#form_editar_user').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let name = $('#edit_name');
    let email = $('#edit_email');
    let telefono = $('#edit_telefono');
    let tipo =  $('#edit_tipo');

    if (!name.inputmask('isComplete')){
        procesar = false;
        name.addClass('is-invalid');
        $('#error_edit_name').text('El Nombre es obligatorio, debe tener al menos 4 caracteres.');
    } else {
        name.removeClass('is-invalid');
        name.addClass('is-valid');
    }

    if (email.val().length <= 0 ){
        procesar = false;
        email.addClass('is-invalid');
        $('#error_edit_email').text('El Email es obligatorio.');
    }else {
        email.removeClass('is-invalid');
        email.addClass('is-valid');
    }

    if (!telefono.inputmask("isComplete")) {
        procesar = false;
        telefono.addClass('is-invalid');
        $('#error_edit_telefono').text('El Teléfono es invalido.');
    } else {
        telefono.removeClass('is-invalid');
        telefono.addClass('is-valid');
    }

    if (tipo.val().length <= 0){
        procesar = false;
        tipo.addClass('is-invalid');
        $('#error_edit_tipo').text('El Tipo es obligatorio.');
    }else {
        tipo.removeClass('is-invalid');
        tipo.addClass('is-valid');
    }

    if (procesar){
        
        ajaxRequest({ data: $(this).serialize() }, function (data) {
            
            if (data.result){

                setUser(data);

                let table = $('#tabla_usuarios').DataTable();
                let tr = $('#tr_item_' + data.id);
                table
                    .cell(tr.find('.nombre')).data(data.name)
                    .cell(tr.find('.email')).data(data.email)
                    .cell(tr.find('.telefono')).data(data.table_telefono)
                    .cell(tr.find('.role')).data(data.table_role)
                    .draw();
                resetForm(true);

            }else {
                if (data.error === "email_duplicado") {
                    email.addClass('is-invalid');
                    $('#error_edit_email').text("Email ya registrado.");
                }
            }
            
        });
    }


});

//Eliminar Usuario
function destroyUser(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            
            ajaxRequest({ data: { opcion: 'eliminar', id: id } }, function (data) {

                if (data.result){

                    let table = $('#tabla_usuarios').DataTable();
                    let item = $('#btn_eliminar_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();

                    $('#paginate_leyenda').text(data.total);
                }

            });

            /*verSpinner(true);
            $.ajax({
                type: 'POST',
                url: 'procesar.php',
                data: {
                    opcion: 'eliminar',
                    id: id
                },
                success: function (response) {

                    let data = JSON.parse(response);

                    if (data.result){

                        let table = $('#tabla_usuarios').DataTable();
                        let item = $('#btn_eliminar_' + id).closest('tr');
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
            });*/

        }
    });
}

//Actualizar datos del usuario en Modal Permisos
function getPermisos(id) {

    ajaxRequest({ data: { opcion: 'get_permisos', id: id } }, function (data) {

        if (data.result){

            $('#li_permisos_nombre').text(data.name);
            $('#li_permisos_email').text(data.email);
            $('#li_permisos_role').text(data.tipo);
            $('#input_permisos_id').val(data.id);

            if (data.permisos != null){
                data.permisos.forEach((key, value) => {
                    key = key.replace('.', '_');
                    $('#' + key).removeAttr('checked');
                });
            }

            if (data.user_permisos != null){
                Object.entries(data.user_permisos).forEach(([key, value]) => {
                    key = key.replace('.', '_');
                    $('#' + key).attr('checked', 'checked');
                });
            }

        }

    });
}

//Guardar los Permisos del usuario
$('#form_permisos_usuario').submit(function (e) {
    e.preventDefault();

    ajaxRequest({ data: $(this).serialize() }, function (data) {
        //muestro toast
    });

    /*verSpinner(true);
    $.ajax({
        type: 'POST',
        url: 'procesar.php',
        data: $(this).serialize(),
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
    });*/
});

function getUsuariosMunicipios() {

    ajaxRequest({ url: 'procesar.php', data:{ opcion:'get_usuarios_municipios' } }, function (data) {

    });
}

function getAccesosMunicipio() {
    ajaxRequest({ url: 'procesar.php', data:{ opcion: 'get_acceso_municipios' }, html: 'si' }, function (data) {
        $('#usuario_card_table').html(data);
        datatable('usuario_table');
    });
}

console.log('hidd!');