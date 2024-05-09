const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
    //icon: data.icon,
    //text: data.message
});

const Cargando = Swal.mixin({
    allowOutsideClick: false,
    didOpen: () => {
        Swal.showLoading()
    },
    showConfirmButton: false,
    /*width: '150',*/
});

const Alerta = Swal.mixin({
    //icon: data.icon,
    //title: data.title,
    //text: data.message
});

const MessageDelete = Swal.mixin({
    title: '¿Estas seguro?',
    text: "¡No podrás revertir esto!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí, bórralo!',
    cancelButtonText: 'Cancelar'
    /*
    Ejemplo Mensaje Eliminar

        MessageDelete.fire().then((result) => {
            if (result.isConfirmed) {
                alert('hola mundo');
            }
        });
*/
});

function verSpinner(opcion = true) {
    if (opcion){
        $('.ver_spinner_cargando').removeClass('d-none');
    }else {
        $('.ver_spinner_cargando').addClass('d-none');
    }
}

