inputmask('#cuotas_input_precio', 'numerico', 1, 5, '.');
inputmask('#cuotas_input_adicional', 'numerico', 1, 5, '.');

//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('tabla_cuotas');


//cacturo el formulario para guardar la cuota
$('#cuotas_form').submit(function (e) {
   e.preventDefault();
  let procesar = true;
  let mes = $('#cuotas_select_mes');
  let fecha = $('#cuotas_input_fecha');
  let precio = $('#cuotas_input_precio');

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

    if (procesar){
        ajaxRequest({ url: 'procesar_cuotas.php', data: $(this).serialize() }, function (data) {

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
    ajaxRequest({ url: 'procesar_cuotas.php', data: { opcion: 'get_cuotas', id: id } }, function (data) {
       if (data.result){
           $('#cuotas_select_mes').val(data.mes);
           $('#cuotas_input_fecha').val(data.fecha);
           $('#cuotas_input_precio').val(data.precio);
           $('#cuotas_input_adicional').val(data.adicional);
           $('#cuotas_id').val(data.id);
           $('#cuotas_opcion').val('editar_cuotas');
       }
    });
}

//funcion para eliminar la cuota
function destroyCuota(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            ajaxRequest({ url: 'procesar_cuotas.php', data: { opcion: 'eliminar_cuotas', id: id} }, function (data) {
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
        .removeClass('is-valid')
        .val('');
    $('#cuotas_input_fecha')
        .removeClass('is-valid')
        .val('');
    $('#cuotas_id').val('');
    $('#cuotas_opcion').val('guardar_cuotas');
    $('#cuotas_input_precio').val('');
    $('#cuotas_input_adicional').val('');

}
console.log('cuotas');