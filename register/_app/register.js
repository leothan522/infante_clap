inputmask('#name', 'alfa', 3, 100, ' ');
$('#telefono').inputmask("(9999) 999-99.99");

$('#form_registrar_usuario').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let name = $('#name');
    let email = $('#email');
    let password = $('#password');
    let confirmar = $('#confirmar');
    let telefono = $('#telefono');

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

    if (password.val() !== confirmar.val()){
        procesar = false;
        confirmar.addClass('is-invalid');
        $('#error_confirmar').text('Las contraseñas NO coinciden.');
    }else {
        if (password.val().length > 0){
            confirmar.removeClass('is-invalid');
            confirmar.addClass('is-valid');
        }
    }

    if (!telefono.inputmask("isComplete")) {
        procesar = false;
        telefono.addClass('is-invalid');
        $('#error_telefono').text('El Teléfono es invalido.');
    } else {
        telefono.removeClass('is-invalid');
        telefono.addClass('is-valid');
    }


    if (procesar){

        ajaxRequest({ data: $(this).serialize() }, function (data) {

            if (data.result){
                window.location.replace ("../admin/");
            }else {
                if (data.error === "email_duplicado") {
                    email.addClass('is-invalid');
                    $('#error_email').text("email ya registrado.");
                }
            }

        });
        /*verSpinner();
        $.ajax({
           type: 'POST',
           url: 'procesar.php',
           data: $(this).serialize(),
           success: function (response) {

               let data = JSON.parse(response);

               if (data.result){
                   window.location.replace ("../admin/");
               }else {
                   if (data.error === "email_duplicado") {
                       email.addClass('is-invalid');
                       $('#error_email').text("email ya registrado.");
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
           }
        });*/
    }

});

$('#remember').click(function () {
    let input = $('#password');
    let confirmar = $('#confirmar');
    if (input.attr('type') === 'password'){
        input.attr('type', 'text');
        confirmar.attr('type', 'text');
    }else {
        input.attr('type', 'password');
        confirmar.attr('type', 'password');
    }
});

console.log('hi!');