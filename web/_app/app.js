function irDashboard() {
    ajaxRequest({ url: '_request/WebRequest.php', data: {opcion: 'ir_dashboard'}}, function (data) {
        if (data.result) {
            window.location.href = "../admin/";
        }
    });
}

//Inicializamos el InputMak
inputmask('#edit_name', 'alfanumerico', 3, 100, ' ');
inputmaskTelefono('#edit_telefono');

//editar datos personales
$('#form_perfil_datos').submit(function (e){
    e.preventDefault();
    let procesar = true;
    let name = $("#edit_name");
    let email = $("#edit_email");
    let telefono = $("#edit_telefono");
    let password_actual = $("#password_actual_datos");

    if (!name.inputmask('isComplete')){
        procesar = false;
        name.addClass('is-invalid');
        $('#error_edit_name').text('El Nombre es obligatorio, debe tener al menos 3 caracteres.');
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

    if (password_actual.val().length <= 7){
        procesar = false;
        password_actual.addClass('is-invalid');
        $('#error_password_actual').text('El contraseña es obligatoria, debe tener al menos 8 caracteres');
    }else {
        password_actual.removeClass('is-invalid');
        password_actual.addClass('is-valid');
    }

    if (procesar){

        ajaxRequest({ url: '_request/WebRequest.php', data: $(this).serialize() }, function (data) {
            if (data.result){
                $('#profile_name').text(data.nombre);
                $('#profile_email').text(data.email);
                $('#profile_telefono').text(data.telefono);
                $('#ficha_nombre').text(data.nombre);
                $('#ficha_email').text(data.email);
                $('#navbar_header_name').text(data.nombre);

                name
                    .val(data.nombre)
                    .removeClass('is-valid');
                email
                    .val(data.email)
                    .removeClass('is-valid');
                telefono
                    .val(data.telefono)
                    .removeClass('is-valid');
                password_actual
                    .removeClass('is-valid')
                    .val('')
                    .attr('type', 'password');

            }else {
                if (data.error === 'no_password'){
                    password_actual.removeClass('is-valid');
                    password_actual.addClass('is-invalid');
                    $('#error_password_actual').text(data.message);
                }
            }
        });

        /*verSpinner();
        $.ajax({
            type: "POST",
            url: "procesar.php",
            data: $(this).serialize(),
            success: function (response){
                let data = JSON.parse(response);

                if (data.result){
                    $('#profile_name').text(name.val());
                    $('#profile_email').text(email.val());
                    $('#profile_telefono').text(telefono.val());
                    $('#ficha_nombre').text(name.val());
                    $('#ficha_email').text(email.val());
                    $('#navbar_header_name').text(name.val());
                    name.removeClass('is-valid');
                    email.removeClass('is-valid');
                    telefono.removeClass('is-valid');
                    password_actual
                        .removeClass('is-valid')
                        .val('')
                        .attr('type', 'password');

                }else {
                    if (data.error === 'no_password'){
                        password_actual.removeClass('is-valid');
                        password_actual.addClass('is-invalid');
                        $('#error_password_actual').text(data.message);
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
        })*/
    }


});

//editar contraseña
$('#form_perfil_seguridad').submit(function (e){
    e.preventDefault();
    let procesar = true;
    let password_actual = $('#contrasea_actual');
    let password_nueva = $('#contrasea_nueva');
    let confirmar = $('#confirmar');

    if (password_actual.val().length <= 7){
        procesar = false;
        password_actual.addClass('is-invalid');
        $('#error_contrasea_actual').text('El contraseña es obligatoria, debe tener al menos 8 caracteres');
    }else {
        password_actual.removeClass('is-invalid');
        password_actual.addClass('is-valid');
    }

    if (password_nueva.val().length <= 7){
        procesar = false;
        password_nueva.addClass('is-invalid');
        $('#error_contrasea_nueva').text('La contraseña nueva debe tener al menos 8 caracteres');
    }else {
        password_nueva.removeClass('is-invalid');
        password_nueva.addClass('is-valid')
    }

    if (password_nueva.val() !== confirmar.val()){
        procesar = false;
        confirmar.addClass('is-invalid');
        $('#error_confirmar').text('Las contraseñas NO coinciden');
    }else {
        confirmar.removeClass('is-invalid');
        confirmar.addClass('is-valid')
    }

    if (procesar){

        ajaxRequest({ url: '_request/WebRequest.php', data: $(this).serialize() }, function (data) {

            if (data.result){

                password_actual
                    .removeClass('is-valid')
                    .val('')
                    .attr('type', 'password');
                password_nueva
                    .removeClass('is-valid')
                    .val('')
                    .attr('type', 'password');
                confirmar
                    .removeClass('is-valid')
                    .val('')
                    .attr('type', 'password');
                $('#remember').prop("checked", false);

            }else {

                if (data.error === "no_password"){
                    password_actual
                        .removeClass('is-valid')
                        .addClass('is-invalid');
                    $('#error_contrasea_actual').text(data.message);
                }

                if (data.error === "no_password_tamaño"){
                    password_nueva
                        .removeClass('is-valid')
                        .addClass('is-invalid');
                    $('#error_contrasea_nueva').text(data.message);
                }

            }
        });

        /*verSpinner();
        $.ajax({
            type: 'POST',
            url: 'procesar.php',
            data: $(this).serialize(),
            success: function (response) {
                let data = JSON.parse(response)

                if (data.result){

                    password_actual
                        .removeClass('is-valid')
                        .val('')
                        .attr('type', 'password');
                    password_nueva
                        .removeClass('is-valid')
                        .val('')
                        .attr('type', 'password');
                    confirmar
                        .removeClass('is-valid')
                        .val('')
                        .attr('type', 'password');

                    $('#remember').prop("checked", false);
                }else {
                    if (data.error === "no_password"){
                        password_actual
                            .removeClass('is-valid')
                            .addClass('is-invalid');
                        $('#error_contrasea_actual').text(data.message);
                    }

                    if (data.error === "no_password_tamaño"){
                        password_nueva
                            .removeClass('is-valid')
                            .addClass('is-invalid');
                        $('#error_contrasea_nueva').text(data.message);
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
        })*/
    }
});

//mostrar contraseñas en seguridad
$('#remember').click(function () {
    let input_password_actual = $('#contrasea_actual');
    let input_password_nueva = $('#contrasea_nueva');
    let input_confirmar = $('#confirmar');

    if (input_password_actual.attr('type') === 'password' || input_password_nueva.attr('type') === 'password' || input_confirmar.attr('type') === 'password'){
        input_password_actual.attr('type', 'text');
        input_password_nueva.attr('type', 'text');
        input_confirmar.attr('type', 'text');
    }else {
        input_password_actual.attr('type', 'password');
        input_password_nueva.attr('type', 'password');
        input_confirmar.attr('type', 'password');
    }
});

//mostrar contraseñas en datos personales
$('#check_datos').click(function (){
    let passwor_actual_datos = $('#password_actual_datos');

    if (passwor_actual_datos.attr('type') === 'password'){
        passwor_actual_datos.attr('type', 'text');
    }else{
        passwor_actual_datos.attr('type', 'password');
    }
});