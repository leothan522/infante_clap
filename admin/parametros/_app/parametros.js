datatable('table_parametros');
inputmask('#tabla_id', 'numerico', 0, 12);
inputmask('#name', 'alfanumerico', 4, 100, '_');

$("#navbar_buscar").removeClass('d-none');

//procesamos el formulario tanto para guardar como editar
$('#form_parametros').submit(function (e){
    e.preventDefault();
    let condicion = true;
    let name = $('#name');
    let tabla_id = $('#tabla_id');
    let valor = $('#valor');

    if (!name.inputmask('isComplete')){
        condicion = false;
        name.addClass('is-invalid');
        $('#error_name').text('El Nombre es obligatorio, debe terner al menos 4 caracteres.');
    }else {
        name.removeClass('is-invalid');

    }

    if (tabla_id.val().length <= 0 && valor.val().length <= 0){
        condicion = false;
        tabla_id.addClass('is-invalid');
        valor.addClass('is-invalid')
        $('#error_tabla_id').text('La tabla_id es obligatoria.');
        $('#error_valor').text('El valor es obligatorio.');
    }else {
        tabla_id.removeClass('is-invalid');
        valor.removeClass('is-invalid');

    }

    if (condicion){
        let opcion = $('#opcion').val();
        if (opcion === 'editar'){
            editParametros();
        }else {
            guardarParametro();
        }
    }
});

function editParametros() {

    ajaxRequest({ data: $('#form_parametros'). serialize() }, function (data) {

        if (data.result) {

            let table = $('#table_parametros').DataTable();

                let tr = $('#tr_item_' + data.id);
                table
                    .cell(tr.find('.nombre')).data(data.nombre)
                    .cell(tr.find('.tabla_id')).data(data.tabla_id)
                    .cell(tr.find('.valor')).data(data.valor)
                    .draw();
            }
            $('#btn_cancelar').click();

    });
}

function guardarParametro() {

    ajaxRequest({ data: $('#form_parametros'). serialize(), html: 'si' }, function (data) {

        $('#dataContainerParametros').html(data);
        datatable('table_parametros');
        $('#btn_cancelar').click();

    });
}

//cambiamos los datos en formulariopara editar
function edit(id) {

    ajaxRequest({ data:{ id: id, opcion: 'get_parametro'} }, function (data) {
        if (data.result){
            $('#name').val(data.nombre);
            $('#tabla_id').val(data.tabla_id);
            $('#valor').val(data.valor);
            $('#opcion').val("editar");
            $('#id').val(data.id);
        }
    });

}

//eliminamos parametros
function borrar(id) {
    MessageDelete.fire().then((result_parametros) => {
        if (result_parametros.isConfirmed){
            let valor_x = $('#input_hidden_x').val();
            ajaxRequest({ data: { id: id, opcion: 'eliminar' } }, function (data) {

                if (data.result){

                    let table = $('#table_parametros').DataTable();
                    let item = $('#btn_eliminar_' + id).closest('tr');

                    table
                        .row(item)
                        .remove()
                        .draw();

                    $('#paginate_leyenda').text(data.total);
                    $('#btn_cancelar').click();
                    valor_x = valor_x - 1;
                    if (valor_x === 0){
                        reconstruirTabla();
                    }else {
                        $('#input_hidden_x').val(valor_x);
                    }
                }

            });
        }

    });
}

function reset() {
    $('#nombre').removeClass('is-invalid');
    $('#tabla_id').removeClass('is-invalid');
    $('#valor').removeClass('is-invalid');
    $('#opcion').val("guardar");
    $('#id').val("");
}

$('#btn_cancelar').click(function () {
    reset();
});

function ocultarForm() {
    verSpinner(true);
    setTimeout(function () {
        $('#col_form').addClass('d-none');
        verSpinner(false);
    }, 500);
}

$('#navbar_form_buscar').submit(function (e) {
    e.preventDefault();
    let keyword = $('#navbar_input_buscar').val();
    ajaxRequest({ url: 'procesar.php', data: {opcion: 'navbar_buscar', keyword: keyword}, html: 'si' }, function (data) {
        $('#dataContainerParametros').html(data);
    });

});

function reconstruirTabla() {
    ajaxRequest({ url: 'procesar.php', data: { opcion: 'index'}, html: 'si' }, function (data) {
        $('#dataContainerParametros').html(data);
    });
}

console.log('hi!');


