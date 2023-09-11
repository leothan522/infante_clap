// *********** Control del Collapse del Sidebar ************************
function collapseSidebar() {
    if (window.localStorage) {
        if (window.localStorage.getItem('Sidebar') !== undefined
            && window.localStorage.getItem('Sidebar')
        ) {
            //alert("Sidebar si existe en localStorage!!");
            //Elimina Sidebar
            localStorage.removeItem('Sidebar');
        }else {
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
        }else {
            //sidebar Cerrado;
            $('body').addClass('sidebar-collapse')
        }
    }
})


