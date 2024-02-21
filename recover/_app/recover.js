$('#form_recover').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let password = $('#password_recover');
    let confirmar = $('#confirmar_recover');

    if (password.val().length <= 7){
        procesar = false;
        password.addClass('is-invalid');
        $('#error_password_recover').text('El contraseña es obligatoria, debe tener al menos 8 caracteres');
    }else {
        password.removeClass('is-invalid');
        password.addClass('is-valid');
    }

    if (password.val() !== confirmar.val()){
        procesar = false;
        confirmar.addClass('is-invalid');
        $('#error_confirmar_recover').text('Las contraseñas NO coinciden.');
    }else {
        if (password.val().length > 0){
            confirmar.removeClass('is-invalid');
            confirmar.addClass('is-valid');
        }
    }

    if (procesar){

        ajaxRequest({ data: $(this).serialize() }, function (data) {

            if (data.result){
                Swal.fire({
                    title: data.title,
                    text: data.message,
                    icon: data.icon,
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: '¡Ok!'
                }).then((result) => {
                    window.location.replace ("../login/");
                });
            }

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

                if (data.result){
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: data.icon,
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: '¡Ok!'
                    }).then((result) => {
                        window.location.replace ("../login/");
                    });
                }
                verSpinner(false);
            }
        });*/
    }
});


console.log('recover!');