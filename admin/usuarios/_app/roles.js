//crear rol
$('#right_sidebar_from_role').submit(function (e) {
    e.preventDefault();
    ajaxRequest({ url: '_request/RolesRequest.php', data: $(this).serialize() }, function (data) {
        if (data.result){
            let boton = '';
            boton += '<button type="button" class="btn btn-primary btn-sm btn-block m-1" data-toggle="modal"';
            boton += 'data-target="#modal_roles_usuarios" onclick="editRol('+ data.id +')" id="button_role_id_'+ data.id +'">';
            boton += data.nombre;
            boton += '</button>';
            $('#right_sidebar_input_rol')
                .val('')
                .blur();
            $('#right_sidebar_span_rows').text(data.rows);
            $('#right_sidebar_div_listar_roles').append(boton);
            setSelect(data);
        }
    });
});

function editRol(id) {
    ajaxRequest({url: '_request/RolesRequest.php', data: { id: id, opcion: 'edit' } }, function (data) {
        if (data.result){
            show(data);
        }
    } );
}

//editar rol
$('#modal_form_roles_usuario').submit(function (e) {
    e.preventDefault();
    ajaxRequest({ url: '_request/RolesRequest.php', data: $(this).serialize() }, function (data) {
        if (data.result){
            show(data);
            $('#button_role_id_' + data.id).text(data.nombre);
            setSelect(data);
        }
    });
});

function show(data) {
    $('#modal_input_nombre').val(data.nombre);
    $('#modal_li_rol_nombre').text(data.nombre);
    $('#modal_input_roles_id').val(data.id);
    $('#html_roles_usuario').html(data.html_permisos);

    if (data.permisos != null) {
        data.permisos.forEach((key, value) => {
            key = key.replace('.', '_');
            $('#' + key + '_role').removeAttr('checked');
        });
    }

    if (data.user_permisos != null) {
        Object.entries(data.user_permisos).forEach(([key, value]) => {
            key = key.replace('.', '_');
            $('#' + key + '_role').attr('checked', 'checked');
        });
    }
}

function destroyRol() {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {

            let id = $('#modal_input_roles_id').val();

            ajaxRequest({ url: '_request/RolesRequest.php', data: { opcion: 'delete', id: id }}, function (data) {

                if (data.result) {
                    $('#modal_role_btn_cerrar').click();
                    $('#right_sidebar_span_rows').text(data.rows);
                    $('#button_role_id_' + data.id).remove();
                    setSelect(data);
                }

            });
        }
    });
}
//volvemos a renderizar el select del formulario crear usuarios
function setSelect(data) {
    let select = $('.select_roles_usuarios');
    let roles = data.roles.length;
    select.empty();
    select.append('<option value="">Seleccione</option><option value="0">Público</option><option value="1">Estandar</option>');
    for (let i = 0; i < roles; i++) {
        let id = data.roles[i]['id'];
        let nombre = data.roles[i]['nombre'];
        select.append('<option value="' + id + '">' + nombre + '</option>');
    }
    select.append('<option value="99">Administrador</option>');
}