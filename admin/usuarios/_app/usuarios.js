//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('tabla_usuarios');

//Inicializamos el InputMak
inputmask('#name', 'alfa', 3, 50, ' ');
inputmask('#edit_name', 'alfa', 3, 50, ' ');
inputmaskTelefono('#telefono');
inputmaskTelefono('#edit_telefono');

$("#navbar_buscar").removeClass('d-none');


//Generar Clave Aleatoria
function generarClave() {

    ajaxRequest({ url: '_request/UsersRequest.php', data: {opcion: 'generar_clave'}}, function (data) {
        if (data.result) {
            $('#password').val(data.message);
        }
    });

}

//Crear Usuario
$('#form_create_user').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let name = $('#name');
    let email = $('#email');
    let password = $('#password');
    let telefono = $('#telefono');
    let tipo = $('#tipo');

    if (!name.inputmask('isComplete')) {
        procesar = false;
        name.addClass('is-invalid');
        $('#error_name').text('El Nombre es obligatorio, debe tener al menos 4 caracteres.');
    } else {
        name.removeClass('is-invalid');
        name.addClass('is-valid');
    }

    if (email.val().length <= 0) {
        procesar = false;
        email.addClass('is-invalid');
        $('#error_email').text('El Email es obligatorio.');
    } else {
        email.removeClass('is-invalid');
        email.addClass('is-valid');
    }

    if (password.val().length <= 7) {
        procesar = false;
        password.addClass('is-invalid');
        $('#error_password').text('El contraseña es obligatoria, debe tener al menos 8 caracteres');
    } else {
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

    if (tipo.val().length <= 0) {
        procesar = false;
        tipo.addClass('is-invalid');
        $('#error_tipo').text('El Tipo es obligatorio.');
    } else {
        tipo.removeClass('is-invalid');
        tipo.addClass('is-valid');
    }

    if (procesar) {

        ajaxRequest({ url: '_request/UsersRequest.php', data: $(this).serialize(), html: 'si' }, function (data) {

            if (data.is_json){
                if (data.error === 'email_duplicado')
                {
                    email.addClass('is-invalid');
                    $('#error_email').text(data.message);
                }
            }else {
                $('#dataContainer').html(data.html);
                datatable('tabla_usuarios');
                $('#btn_reset_create_user').click();
            }

        });
    }


});

//Limpiar o Restablecer Formulario
function resetForm(edit = false) {
    if (!edit) {
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
    } else {
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
    if (data.band !== 1) {
        button.removeClass('btn-danger');
        button.addClass('btn-success');
        button.text('Activar Usuario');
    } else {
        button.addClass('btn-danger');
        button.removeClass('btn-success');
        button.text('Inactivar Usuario');
    }
}

//Solicitando los datos del usuario para el modal
function edit(id = null) {

    //Inicializamos el InputMak
    /*$('#edit_name').inputmask("*{4,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}");
    $('#edit_telefono').inputmask("(9999) 999-99.99");
*/
    let enviar_id;

    if (id) {
        enviar_id = id;
    } else {
        enviar_id = $('#edit_id').val();
    }

    ajaxRequest({ url: '_request/UsersRequest.php',  data: {opcion: 'edit', id: enviar_id}}, function (data) {
        if (data.result) {
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

    ajaxRequest({ url: '_request/UsersRequest.php', data: {opcion: 'set_estatus', id: id}}, function (data) {
        if (data.result) {
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

    ajaxRequest({ url: '_request/UsersRequest.php', data: {opcion: 'set_password', id: id, password: input.val()}}, function (data) {
        if (data.result) {
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
    let tipo = $('#edit_tipo');

    if (!name.inputmask('isComplete')) {
        procesar = false;
        name.addClass('is-invalid');
        $('#error_edit_name').text('El Nombre es obligatorio, debe tener al menos 4 caracteres.');
    } else {
        name.removeClass('is-invalid');
        name.addClass('is-valid');
    }

    if (email.val().length <= 0) {
        procesar = false;
        email.addClass('is-invalid');
        $('#error_edit_email').text('El Email es obligatorio.');
    } else {
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

    if (tipo.val().length <= 0) {
        procesar = false;
        tipo.addClass('is-invalid');
        $('#error_edit_tipo').text('El Tipo es obligatorio.');
    } else {
        tipo.removeClass('is-invalid');
        tipo.addClass('is-valid');
    }

    if (procesar) {

        ajaxRequest({ url: '_request/UsersRequest.php', data: $(this).serialize()}, function (data) {

            if (data.result) {

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

            } else {
                if (data.error === "email_duplicado") {
                    email.addClass('is-invalid');
                    $('#error_edit_email').text("Email ya registrado.");
                }
            }

        });
    }


});

//Eliminar Usuario
function destroy(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            let valor_x = $('#input_hidden_valor_x').val();
            ajaxRequest({ url: '_request/UsersRequest.php', data: {opcion: 'delete', id: id}}, function (data) {

                if (data.result) {

                    let table = $('#tabla_usuarios').DataTable();
                    let item = $('#btn_eliminar_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();

                    $('#paginate_leyenda').text(data.total);
                    valor_x = valor_x - 1;
                    if (valor_x === 0){
                        reconstruirTabla();
                    }else {
                        $('#input_hidden_x').val(valor_x);
                    }
                }

            });
        }
    });
}

//Actualizar datos del usuario en Modal Permisos
function getPermisos(id) {

    ajaxRequest({ url: '_request/UsersRequest.php', data: {opcion: 'get_permisos', id: id}}, function (data) {

        if (data.result) {

            $('#li_permisos_nombre').text(data.name);
            $('#li_permisos_email').text(data.email);
            $('#li_permisos_role').text(data.tipo);
            $('#input_permisos_id').val(data.id);
            $('#html_permisos_usuario').html(data.html_permisos);

            if (data.permisos != null) {
                data.permisos.forEach((key, value) => {
                    key = key.replace('.', '_');
                    $('#' + key).removeAttr('checked');
                    console.log('#' + key)
                });
            }

            if (data.user_permisos != null) {
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

    ajaxRequest({ url: '_request/UsersRequest.php', data: $(this).serialize() }, function (data) {
        //muestro toast
    });
});

function reconstruirTabla() {
    ajaxRequest({ url: '_request/UsersRequest.php', data: { opcion: 'index'}, html: 'si' }, function (data) {
        $('#dataContainer').html(data.html);
        datatable('tabla_usuarios');
    });
}

$('#navbar_form_buscar').submit(function (e) {
    e.preventDefault();
    let keyword = $('#navbar_input_buscar').val();
    ajaxRequest({ url: '_request/UsersRequest.php', data: { opcion: 'search', keyword: keyword}, html: 'si' }, function (data) {
        $('#dataContainer').html(data.html);
        datatable('tabla_usuarios');
    });

});


console.log('Usuarios.!');