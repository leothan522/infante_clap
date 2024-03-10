inputmask('#cuotas_input_precio', 'numerico', 1, 5, '.');
inputmask('#cuotas_input_adicional', 'numerico', 1, 5, '.');

//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('tabla_cuotas');

//esta funsion sirve para resetear los datos del modal
function getMunicipios(municipio = true) {
    let html = '<div class="card-body"><span>Seleccione un Municipio para empezar</span></div>';
    $('#card_body_cuotas')
        .html(html);
    $('#cuotas_select_municipios').val('');
    ajaxRequest({url: '_request/CuotasRequest.php', data: {opcion: 'get_municipios'}}, function (data) {
        if (data.result) {
            verSpinner(true);
            let select = $('#cuotas_select_municipios');
            let municipios = data.municipios.length;
            select.empty();
            select.append('<option value="">Seleccione</option>');
            for (let i = 0; i < municipios; i++) {
                let id = data.municipios[i]['id'];
                let nombre = data.municipios[i]['nombre'];
                select.append('<option value="' + id + '">' + nombre + '</option>');
            }

            let idMunicipio = $('#pagos_input_municipio_id').val();
            if (idMunicipio.length > 0){
                setTimeout(function () {
                    select.val(idMunicipio).trigger('change');
                }, 150);
            }
        }
        verSpinner(false);
    });

}

function cambiarMunicipio() {
    resetCuota();
    getCuotas();
    getPrecio();
}

function getPrecio() {
    let id = $('#cuotas_select_municipios').val();
    ajaxRequest({ url: '_request/CuotasRequest.php', data: { opcion: 'get_precio', id: id } }, function (data) {
        if (data.result){
            $('#cuotas_input_precio').val(data.precio_modulo);
        }
    });
}

function getCuotas() {
    let id = $('#cuotas_select_municipios').val();
    ajaxRequest({ url: '_request/CuotasRequest.php', data: { opcion: 'index', id: id }, html: 'si' }, function (data) {

        $('#card_body_cuotas').html(data.html);
        datatable('tabla_cuotas');
        $('#input_hidde_municipios_id').val(id);

    });
}

//cacturo el formulario para guardar la cuota
$('#cuotas_form').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let mes = $('#cuotas_select_mes');
    let fecha = $('#cuotas_input_fecha');
    let precio = $('#cuotas_input_precio');
    let id = $('#input_hidde_municipios_id');

    if (mes.val().length <= 0){
        procesar = false;
        mes.addClass('is-invalid');
        $('#error_cuotas_select_mes').text('El mes es obligatorio.');
    }else {
        mes
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (fecha.val() === ""){
        procesar = false;
        fecha.addClass('is-invalid');
        $('#error_cuotas_input_fecha').text('La fecha es obligatoria.');
    }else {
        fecha
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (precio.val().length <= 0){
        procesar = false;
        precio.addClass('is-invalid');
        $('#error_cuotas_input_precio').text('El precio es obligatorio.');
    }else {
        precio
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (id.val().length <= 0){
        procesar = false;
        $('#cuotas_select_municipios').addClass('is-invalid');
        $('#error_cuotas_municipio').text('Seleccione un Municipio.');
    }else {
        $('#cuotas_select_municipios')
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    if (procesar){
        ajaxRequest({ url: '_request/CuotasRequest.php', data: $(this).serialize() }, function (data) {

            if (data.result){

                let table = $('#tabla_cuotas').DataTable();

                if (data.nuevo){

                    let button = '<div class="btn-group btn-group-sm">\n' +
                        '                                <button type="button" class="btn btn-info" onclick="editCuota('+ data.id +')">\n' +
                        '                                    <i class="fas fa-edit"></i>\n' +
                        '                                </button>\n' +
                        '                                <button type="button" class="btn btn-info" onclick="destroyCuota('+ data.id +')" id="btn_eliminar_cuota_'+ data.id +'">\n' +
                        '                                    <i class="far fa-trash-alt"></i>\n' +
                        '                                </button>\n' +
                        '                            </div>';

                    table.row.add([
                        data.item,
                        data.mes,
                        data.fecha,
                        button
                    ]).draw();

                    let nuevo = $('#tabla_cuotas tr:last');
                    nuevo.attr('id', 'tr_item_cuota_' + data.id);
                    nuevo.find("td:eq(0)").addClass('item');
                    nuevo.find("td:eq(1)").addClass('mes');
                    nuevo.find("td:eq(2)").addClass('fecha');

                    $('#paginate_leyenda').text(data.total);
                }else{

                    let tr = $('#tr_item_cuota_' + data.id);
                    table
                        .cell(tr.find('.mes')).data(data.mes)
                        .cell(tr.find('.fecha')).data(data.fecha)
                        .draw();

                }

                resetCuota();

            } else {

                if (data.error_mes){
                    mes.addClass('is-invalid');
                    $('#error_cuotas_select_mes').text('El mes ya ha sido registrado este año.');
                }

                if (data.error_fecha){
                    fecha.addClass('is-invalid');
                    $('#error_cuotas_input_fecha').text('La fecha debe ser mayor a la ultima cuota establecida.');
                }

            }



        });
    }

});

//me traigo los datos de las cuotas para editar
function editCuota(id) {
    ajaxRequest({ url: '_request/CuotasRequest.php', data: { opcion: 'edit', id: id } }, function (data) {
        if (data.result){
            $('#cuotas_select_mes').val(data.mes);
            $('#cuotas_input_fecha').val(data.fecha);
            $('#cuotas_input_precio').val(data.precio);
            $('#cuotas_input_adicional').val(data.adicional);
            $('#cuotas_id').val(data.id);
            $('#cuotas_opcion').val('update');
        }
    });
}

//funcion para eliminar la cuota
function destroyCuota(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            ajaxRequest({ url: '_request/CuotasRequest.php', data: { opcion: 'delete', id: id} }, function (data) {
                if (data.result){
                    let table = $('#tabla_cuotas').DataTable();
                    let item = $('#btn_eliminar_cuota_' + id).closest('tr');
                    table
                        .row(item)
                        .remove()
                        .draw();
                }
                $('#paginate_leyenda').text(data.total);
            });
        }
    });
}

function resetCuota() {
    $('#cuotas_select_mes')
        .removeClass('is-invalid')
        .removeClass('is-valid')
        .val('');
    $('#cuotas_input_fecha')
        .removeClass('is-invalid')
        .removeClass('is-valid')
        .val('');
    $('#cuotas_id').val('');
    $('#cuotas_opcion').val('store');
    $('#cuotas_input_precio')
        .removeClass('is-valid');
    $('#cuotas_input_adicional').val('');
    $('#cuotas_select_municipios').removeClass('is-valid');

}

console.log('cuotas.!');