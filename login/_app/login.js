$('#form_login').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let email = $('#email');
    let password = $('#password');

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

    if (procesar){
        verSpinner();
        $.ajax({
            type: 'POST',
            url: 'procesar.php',
            data: $(this).serialize(),
            success: function (response) {

                let data = JSON.parse(response);

                if (data.result){
                    window.location.replace ("../admin/");
                }else {

                    if (data.error === "no_email") {
                        email.addClass('is-invalid');
                        $('#error_email').text(data.message);
                    }

                    if (data.error === "no_password") {
                        password.addClass('is-invalid');
                        $('#error_password').text(data.message);
                    }

                    if (data.error === "no_activo") {
                        email.addClass('is-invalid');
                        $('#error_email').text(data.message);
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
        });
    }

});

//mostrar contraseña
$('#remember').click(function () {
    let input = $('#password');
    if (input.attr('type') === 'password'){
        input.attr('type', 'text');
    }else {
        input.attr('type', 'password');
    }
});
