//validamos campos para los bloques
$('#bloques_input_nombre').inputmask("*{4,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}[ ]*{0,20}");
$('#bloques_input_numero').inputmask("9{1,3}");

//Inicializamos la Funcion creada para Datatable pasando el ID de la tabla
datatable('bloques_tabla');

//Guardamos y Editamos los bloques
$('#bloques_form').submit(function (e) {
    e.preventDefault();
    let procesar = true;
    let numero = $('#bloques_input_numero');
    let nombre = $('#bloques_input_nombre');
    let municipios = $('#bloques_select_municipios');

    if (numero.val().length <= 0) {
        procesar = false;
        numero.addClass('is-invalid');
        $('#error_bloques_numero').text('El numero del bloque es obligatorio')
    } else {
        numero.removeClass('is-invalid');
        numero.addClass('is-valid');
    }

    if (!nombre.inputmask('isComplete')) {
        procesar = false;
        nombre.addClass('is-invalid');
        $('#error_bloques_nombre').text('El nombre del bloque es obligatorio')
    } else {
        nombre.removeClass('is-invalid');
        nombre.addClass('is-valid');
    }

    if (municipios.val().length <= 0){
        procesar = false;
        municipios.addClass('is-invalid');
        $('#error_bloques_municipio').text('Debe seleccionar un municipio')
    } else {
        municipios.removeClass('is-invalid');
        municipios.removeClass('is-valid');
    }

    if (procesar) {
       verSpinner(true);
       $.ajax({
          type: 'POST',
          url: 'procesar_bloques.php',
          data: $(this).serialize(),
          success: function (response) {
              let data = JSON.parse(response);

              if (data.result){
                  let table = $('#bloques_tabla').DataTable();

                  if (data.nuevo){
                      //estoy guardando
                      let buttons = '<div class="btn-group btn-group-sm">\n' +
                          '                                <button type="button" class="btn btn-info" onclick="editBloque('+ data.id +')">\n' +
                          '                                    <i class="fas fa-edit"></i>\n' +
                          '                                </button>\n' +
                          '                                <button type="button" class="btn btn-info" onclick="eliminarBloque('+ data.id +')" id="btn_eliminar_'+ data.id +'">\n' +
                          '                                    <i class="far fa-trash-alt"></i>\n' +
                          '                                </button>\n' +
                          '                            </div>';

                      table.row.add([
                          data.numero,
                          data.nombre,
                          buttons
                      ]).draw();

                      let nuevo = $('#bloques_tabla tr:last');
                      nuevo.attr('id', 'tr_item_' + data.id);
                      nuevo.find("td:eq(0)").addClass('numero');
                      nuevo.find("td:eq(1)").addClass('nombre');

                  }else{
                      //estoy editando
                      let tr = $('#tr_item_' + data.id);
                      table
                          .cell(tr.find('.numero')).data(data.numero)
                          .cell(tr.find('.nombre')).data(data.nombre)
                          .draw();
                  }
                  limpiarBloques(false);
              }else {
                  if (data.error_numero){
                      numero.addClass('is-invalid');
                  }
                  if (data.error_nombre){
                      nombre.addClass('is-invalid');
                  }
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

function editBloque(id) {
    verSpinner(true);
    $.ajax({
        type: 'POST',
        url: 'procesar_bloques.php',
        data: {
            opcion: 'get_bloque',
            id: id
        },
        success: function (response) {
            let data = JSON.parse(response);

            if (data.result) {
                $('#bloques_input_numero').val(data.numero);
                $('#bloques_input_nombre').val(data.nombre);
                $('#bloques_municipios_id').val($('#bloques_select_municipios').val());
                $('#bloques_id').val(data.id);
                $('#bloques_opcion').val('editar_bloque');
                $('#title_form_bloque').text('Editar Bloque')
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

function cambiarMunicipio() {
    let municipio = $('#bloques_select_municipios');
    municipio.removeClass('is-invalid');
    limpiarBloques(false);
    verSpinner(true);
    $.ajax({
        type: 'POST',
        url: 'procesar_bloques.php',
        data: {
            opcion: 'get_bloques_municipios',
            id: municipio.val()
        },
        success: function (response) {

            let data = response;
            $('#dataContainerBloques')
                .html(data);
            if (municipio.val().length > 0){
                $('#dataContainerBloques').addClass('p-0');
            }else {
                $('#dataContainerBloques').removeClass('p-0');
            }
            datatable('bloques_tabla');
            verSpinner(false);
        }
    });
}

//esta funsion sirve para resetear los datos del modal
function getMunicipios(municipio = true) {
    verSpinner(true);
    limpiarBloques(true);
    let html = '<span>Seleccione un Municipio para empezar</span>';
    $('#dataContainerBloques')
        .html(html)
        .removeClass('p-0');
    $('#bloques_municipios_id').val('');

    $.ajax({
        type: 'POST',
        url: 'procesar_bloques.php',
        data: {
            opcion: 'get_municipios'
        },
        success: function (response) {

            let data = JSON.parse(response);

            if (data.result){
                let select = $('#bloques_select_municipios');
                let municipios = data.municipios.length;
                select.empty();
                select.append('<option value="">Seleccione</option>');
                for (let i = 0; i < municipios; i++) {
                    let id = data.municipios[i]['id'];
                    let nombre = data.municipios[i]['nombre'];
                    select.append('<option value="' + id + '">' + nombre + '</option>');
                }

            }

            if (data.alerta) {
                Alerta.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.message
                });
            } else {
                /*Toast.fire({
                    icon: data.icon,
                    text: data.title
                });*/
            }

            verSpinner(false);
        }
    });
}

function limpiarBloques( municipio = true) {
    $('#bloques_input_numero')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#bloques_input_nombre')
        .val('')
        .removeClass('is-valid')
        .removeClass('is-invalid');
    $('#bloques_id').val('');
    $('#bloques_opcion').val('guardar_bloque');

    if (municipio){
        $('#bloques_select_municipios')
            .val('')
            .removeClass('is-invalid');
    }
}

function eliminarBloque(id) {
    MessageDelete.fire().then((result) => {
        if (result.isConfirmed) {
            verSpinner(true);
            $.ajax({
                type: 'POST',
                url: 'procesar_bloques.php',
                data: {
                    opcion: 'eliminar_bloque',
                    id: id
                },
                success: function (response) {
                    let data = JSON.parse(response);

                    if (data.result) {
                        let table = $('#bloques_tabla').DataTable();
                        let item = $('#btn_eliminar_' + id).closest('tr');
                        table
                            .row(item)
                            .remove()
                            .draw();
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
}

console.log('Hi!');