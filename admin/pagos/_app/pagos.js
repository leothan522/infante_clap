//cacturo el formulario para guardar la cuota
$('#cuotas_form').submit(function (e) {
   e.preventDefault();
  let procesar = true;
  let mes = $('#cuotas_select_mes');
  let fecha = $('#cuotas_input_fecha');

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

    if (procesar){
        ajaxRequest({ url: 'procesar_cuotas.php', data: $(this).serialize() }, function (data) {
            if (data.result){
                mes
                    .removeClass('is-valid')
                    .val('');
                fecha
                    .removeClass('is-valid')
                    .val('');
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
           $('#cuotas_id').val(data.id);
           $('#cuotas_opcion').val('editar_cuotas');
       }
    });
}

//funcion para eliminar la cuota
function destroyCuota(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            ajaxRequest({ url: 'procesar_cuotas.php', data: {opcion: 'eliminar_cuotas', id: id} }, function (data) {

            });
        }
    });
}
console.log('cuotas');