  $(document).ready(function(){
  $.fn.editable.defaults.mode = 'inline';
  
    setInterval(function(){ 
    $.ajax({
      url: base_url+'est/requerimiento/revisar_cambios',
      type: 'GET',
      success: function(data) {
        if (data !== ""){
          $.each(data, function(i, item) {
            salida = "El requerimieto fue modificado por "+data[i].nombres +' '+data[i].paterno
            toastr.info( salida );
          });
        } 
      },
      });
    }, 900);

  $('.dob').editable();
  $('.opcion_jefe_area').editable();
  //$('.opcion_valor_examen').editable();
  //$('.opcion_valor_masso').editable();
  $('.comments').editable({
        showbuttons: 'bottom'
    });
     $('.opcion_referido').editable({
        source: [
            {value: 0, text: 'No'},
            {value: 1, text: 'Si'}
        ]
    });  

     $('.opcion_status').editable({
        source: [
            {value: 0, text: 'No Contactado'},
            //{value: 1, text: 'No Disponible'},
            {value: 2, text: 'En Proceso'},
            {value: 3, text: 'En Servicio'},
            //{value: 4, text: 'Renuncia'},
            {value: 5, text: 'Contrato Firmado'}
        ]
    }); 
    $("#example1").dataTable({
      scrollY:        "400px",
      scrollX:        true,
      scrollCollapse: true,
      paging:         false,
      info:     false,
      fixedColumns:   {
          leftColumns: 1,
          rightColumns: 1
      }
  });
  $(".guardar_modal").submit(function(e){
        e.preventDefault();
        id = $('.comentario').data('id');
        url = base_url+'est/requerimiento/modal_comentario/'+id;
        textarea = $('.comentario').val();
        $.post( url,{comentario : textarea});
        toastr.success("Comentario guardado");
    });

  $(".btn_guardar").on('click',function(e){
    e.preventDefault();
    
    tabla = $(this).closest('tr');

    var celda = new Object();

    celda.id = $(this).attr('rel');
    celda.referido = tabla.find('.referido').val();
    celda.contacto = tabla.find('.contacto').val();
    celda.disponibilidad = tabla.find('.disponibilidad').val();
    celda.contrato = tabla.find('.contrato').val();
    celda.status = tabla.find('.status').val();

    var json = JSON.stringify(celda);
        var posting = $.post( base_url + "est/requerimiento/editar_usuarios_req",{json : json});
 
        // Put the results in a div
        posting.done(function( data ) {
            //alert(data);
            toastr.success("Dato actualizado con exito!")
        });
  });
  $('#example1 tbody').on('click','.sv-callback-list', function (e) {
      e.preventDefault();
      id_usuario = $(this).data('usuario');
      url = $(this).attr('href');
      $('#subview-eval-list').load(url,function(){
        $.subview({
          content: "#subview-eval-list",
          startFrom: "right",
        });
      });
    });
});
  $("#exampleAsistencia").dataTable({
      scrollY:        "400px",
      scrollX:        true,
      scrollCollapse: true,
      paging:         false,
      fixedColumns:   {
          leftColumns: 2,
         // rightColumns: 1
      }
  });

$(document).ready(function () {
  //var empresa = ($('input:hidden[name=empresa]').val());
    $('#datepickerAsistencia').datepicker({
        format: 'yyyy-mm',
        startView: "months", 
        minViewMode: "months",
    }).on('changeDate', function(ev) {
        fecha_seleccionada = $(this).val();
        location.href=base_url+"enjoy/asistencia/index/"+fecha_seleccionada;
    });
});

  $("#exampleListadoAsistencia").dataTable({
      scrollY:        "400px",
      scrollX:        true,
      scrollCollapse: true,
      paging:         false,
      fixedColumns:   {
          //leftColumns: 2,
         // rightColumns: 1
      }
  });

    $(document).ready(function () {
  //var empresa = ($('input:hidden[name=empresa]').val());
  $('#datepickerBono').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
}).on('changeDate', function(ev) {
  fecha_seleccionada = $(this).val();
  location.href=base_url+"enjoy/asistencia/bonos/"+fecha_seleccionada;
  });
});

$(document).ready(function () {
  //var empresa = ($('input:hidden[name=empresa]').val());
    $('#datepickerAsistenciaAramark').datepicker({
        format: 'yyyy-mm',
        startView: "months", 
        minViewMode: "months",
    }).on('changeDate', function(ev) {
        fecha_seleccionada = $(this).val();
        location.href=base_url+"aramark/asistencia/index/"+fecha_seleccionada;
    });
});

$(document).ready(function () {
  //var empresa = ($('input:hidden[name=empresa]').val());
  $('#datepickerBonoAramark').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
  }).on('changeDate', function(ev) {
      fecha_seleccionada = $(this).val();
      location.href=base_url+"aramark/asistencia/bonos/"+fecha_seleccionada;
    });
});


$(document).ready(function () {
  //var empresa = ($('input:hidden[name=empresa]').val());
    $('#datepickerAsistenciaMarina').datepicker({
        format: 'yyyy-mm',
        startView: "months", 
        minViewMode: "months",
    }).on('changeDate', function(ev) {
        fecha_seleccionada = $(this).val();
        location.href=base_url+"marina/asistencia/index/"+fecha_seleccionada;
    });
});

$(document).ready(function () {
  //var empresa = ($('input:hidden[name=empresa]').val());
  $('#datepickerBonoMarina').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
  }).on('changeDate', function(ev) {
      fecha_seleccionada = $(this).val();
      location.href=base_url+"marina/asistencia/bonos/"+fecha_seleccionada;
    });
});