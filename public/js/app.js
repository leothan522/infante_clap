// *********** Control del Collapse del Sidebar ************************
function collapseSidebar() {
    if (window.localStorage) {
        if (window.localStorage.getItem('Sidebar') !== undefined
            && window.localStorage.getItem('Sidebar')
        ) {
            //alert("Sidebar si existe en localStorage!!");
            //Elimina Sidebar
            localStorage.removeItem('Sidebar');
        } else {
            //alert('NO Existe Sidebar');
            //Crear Sidebar
            localStorage.setItem('Sidebar', true);
        }
    }
}

$(document).ready(function () {
    if (window.localStorage) {
        if (window.localStorage.getItem('Sidebar') !== undefined
            && window.localStorage.getItem('Sidebar')
        ) {
            //sidebar Abierto;
            $('body').removeClass('sidebar-collapse')
        } else {
            //sidebar Cerrado;
            $('body').addClass('sidebar-collapse')
        }
    }
})

// **************************** Solicitudes AJAX ****************************************

function ajaxRequest(solicitud, callback) {

    verSpinner(true);

    //valores por defecto
    let type = 'POST';
    let url = 'procesar.php';
    let html = 'no';

    //comprobamos si recibimos valores personalizados
    //para reemplazar los valores por defecto
    if (solicitud.type) {
        type = solicitud.type;
    }
    if (solicitud.url) {
        url = solicitud.url;
    }
    if (solicitud.html) {
        html = solicitud.html;
    }

    //realizamos la peticion AJAX
    $.ajax({

        // especifica si será una petición POST o GET
        type: type,
        // la URL para la petición
        url: url,
        // la información a enviar
        // (también es posible utilizar una cadena de datos)
        data: solicitud.data,
        // código a ejecutar si la petición es satisfactoria;
        // la respuesta es pasada como argumento a la función
        success: function (response) {
            let respuesta;
            if (html === 'no') {
                respuesta = JSON.parse(response);
            } else {
                respuesta = response;
            }

            if (respuesta.alerta) {
                Alerta.fire({
                    icon: respuesta.icon,
                    title: respuesta.title,
                    text: respuesta.message
                });
            } else {
                if (html === 'no' && !respuesta.toast) {
                    Toast.fire({
                        icon: respuesta.icon,
                        text: respuesta.title
                    });
                }
            }
            callback(respuesta);
        },
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto de la petición en crudo y código de estatus de la petición
        error: function (xhr, status) {
            //alert('Disculpe, existió un problema');
            Alerta.fire({
                icon: 'error',
                title: 'Error en la Solicitud',
                text: 'Disculpe, existió un problema'
            });
        },

        // código a ejecutar sin importar si la petición falló o no
        complete: function (xhr, status) {
            //alert('Petición realizada');
            verSpinner(false);
        }

    });
}

/*
* Elemplo Soliciutud Ajax (login.js)

ajaxRequest({ data: $(this).serialize() },
            function (data) {

                if (data.result){
                    window.location.replace ("../admin/");
                }else {

                    if (data.error === "no_email") {
                        email.addClass('is-invalid');
                        $('#error_email').text(data.message);
                        password.removeClass('is-valid');
                        password.removeClass('is-invalid');
                    }

                    if (data.error === "no_password") {
                        password.addClass('is-invalid');
                        $('#error_password').text(data.message);
                    }

                    if (data.error === "no_activo") {
                        email.addClass('is-invalid');
                        $('#error_email').text(data.message);
                    }
                }

        });

* */


