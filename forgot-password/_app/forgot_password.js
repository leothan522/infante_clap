$('#form_forgot_password').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let email = $('#email');

    if (email.val().length <= 0 ){
        procesar = false;
        email.addClass('is-invalid');
        $('#error_email').text('El Email es obligatorio.');
    }else {
        email.removeClass('is-invalid');
        email.addClass('is-valid');
    }

    if (procesar){

        ajaxRequest({ url: '_request/ForgotPasswordRequest.php', data:$(this).serialize() }, function (data) {

            if (data.result){
                const html = '<a href="../login" class="btn btn-primary btn-block">Ir al Login</a>';
                let span = $('#error_email');
                span.removeClass('invalid-feedback');
                span.addClass('valid-feedback');
                span.text(data.message);
                $('#boton_a_login').html(html);
            }else {
                if (data.error === "no_email") {
                    email.addClass('is-invalid');
                    $('#error_email').text(data.message);
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

                    const html = '<a href="../login" class="btn btn-primary btn-block">Ir al Login</a>';
                    let span = $('#error_email');
                    span.removeClass('invalid-feedback');
                    span.addClass('valid-feedback');
                    span.text(data.message);
                    $('#boton_a_login').html(html);

                }else {

                    if (data.error === "no_email") {
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
                }

                verSpinner(false);
            }
        });*/
    }


});

console.log('forgot-password.!');