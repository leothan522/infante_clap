$('#form_index_dashboard').submit(function (e) {
    e.preventDefault();
    if (existeElemento('#id_index_dashboardt')){
        alert('existe el elemento.');
    }else {
        alert('no existe el elemento');
    }
});

console.log('hola')