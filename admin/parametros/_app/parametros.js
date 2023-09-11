datatable('table_parametros');
$('#tabla_id').inputmask("[-]9{0,20}");
$('#name').inputmask("*{4,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}");

//procesamos el formulario tanto para guardar como editar
$('#form_parametros').submit(function (e){
    e.preventDefault();
    let condicion = true;
    let name = $('#name');
    let tabla_id = $('#tabla_id');
    let valor = $('#valor');

    if (name.val().length <= 0 ){
        condicion = false;
        name.addClass('is-invalid');
        $('#error_name').text('El Nombre es obligatorio.');
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
        verSpinner(true)
        $.ajax({
           type: 'POST',
           url: "procesar.php",
           data: $(this). serialize(),
           success: function (response){
               let data = JSON.parse(response)
               if (data.result){


                   let table = $('#table_parametros').DataTable();
                   let buttons = '<div class="btn-group btn-group-sm">\n' +
                       '                            <button type="button" class="btn btn-info" onclick="edit('+ data.id +')">\n' +
                       '                                <i class="fas fa-edit"></i>\n' +
                       '                            </button>\n' +
                       '                            <button type="button" class="btn btn-info" onclick="borrar('+ data.id +')" id="btn_eliminar_'+ data.id +'"  >\n' +
                       '                                <i class="far fa-trash-alt"></i>\n' +
                       '                            </button>\n' +
                       '                        </div>';

                   if (data.add){
                       //nueva row

                       table.row.add([
                           '<span class="text-bold">'+ data.item +'</span>',
                           data.nombre,
                           data.tabla_id,
                           data.valor,
                           buttons
                       ]).draw();

                       $('#paginate_leyenda').text(data.total);

                       let nuevo = $('#table_parametros tr:last');
                       nuevo.attr('id', 'tr_item_' + data.id);
                       nuevo.find("td:eq(1)").addClass('nombre');
                       nuevo.find("td:eq(2)").addClass('tabla_id');
                       nuevo.find("td:eq(3)").addClass('valor');

                   }else {
                       //editando

                       let tr = $('#tr_item_' + data.id);
                       table
                           .cell(tr.find('.nombre')).data(data.nombre)
                           .cell(tr.find('.tabla_id')).data(data.tabla_id)
                           .cell(tr.find('.valor')).data(data.valor)
                           .draw();
                   }


                   $('#btn_cancelar').click();
                   reset();
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

               verSpinner(false);
           }

        });
    }
});


//cambiamos los datos en formulariopara editar
function edit(id) {
    verSpinner();
    $.ajax({
        type: 'POST',
        url: 'procesar.php',
        data: {
            id: id,
            opcion: 'get_parametro'
        },
        success: function (response) {
            let data = JSON.parse(response);

            if (data.result){
                $('#name').val(data.nombre);
                $('#tabla_id').val(data.tabla_id);
                $('#valor').val(data.valor);
                $('#opcion').val("editar");
                $('#id').val(data.id);
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
            verSpinner(false);
        }
    });
}

//eliminamos parametros
function borrar(id) {
    MessageDelete.fire().then((result_parametros) => {
        if (result_parametros.isConfirmed){
            $.ajax({
                type: 'POST',
                url: 'procesar.php',
                data: {
                    id: id,
                    opcion: 'eliminar'
                },
                success: function (response) {
                    let data = JSON.parse(response);

                    if (data.result){

                        let table = $('#table_parametros').DataTable();
                        let item = $('#btn_eliminar_' + id).closest('tr');

                        table
                            .row(item)
                            .remove()
                            .draw();

                        $('#paginate_leyenda').text(data.total);

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
    $('#col_form').addClass('d-none');
}

console.log('hi! mundo');


