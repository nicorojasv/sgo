$.lista_gente = function() { 
  $.ajax({
    url: base_url+"chat/listado",
    dataType: 'html',
    async:false,
    success: function(data) {
      $("#users .users-list").html(data);
    } 
  });
} 

$.mostrar_conversacion = function(to_id) {
  $.ajax({
    url: base_url+"chat/conversacion/"+to_id,
    dataType: 'html',
    async:false,
    success: function(data) {
      $("#users .users-list").html(data);
    }
  });
}

$.guardar_conversacion = function() {
  $.post( base_url+"chat/enviar_msj", { to_id: $("#to_id").val(), message: $("#texto_chat").val() });
}

$(document).ready(function(){

  var listado_base = function(){
    
    var entrada = false;

    var listado = "";
    var listado2 = "";
    var listado3 = "";

    $.ajax({
      url: base_url+"chat/listado",
      async:false,
      dataType: 'html',
      success: function(data) {
        listado = data;
      }
    });

    $("#users .users-list").html(listado);

  
  $("#usr_chat .media a").on("click",function(e){
    e.preventDefault();
    to_id = $(this).data("id");
    var conversacion_base = function(){
      entrada = true;
      $.ajax({
        url: base_url+"chat/conversacion/"+to_id,
        async:false,
        dataType: 'html',
        success: function(data) {
          listado3 = $(data).filter('.discussion');
        }
      });
      $("#users .users-list .discussion").html(listado3);
      $("#users .users-list a.sidebar-back").on("click", function(e){
        e.preventDefault();
        entrada = false;
        listado_base();
      });
    }
    var conversacion = function(){
      entrada = true;
      $.ajax({
        url: base_url+"chat/conversacion/"+to_id,
        async:false,
        dataType: 'html',
        success: function(data) {
          listado2 = data
        }
      });
      $("#users .users-list").html(listado2);
      $("#users .users-list a.sidebar-back").on("click", function(e){
        e.preventDefault();
        entrada = false;
        listado_base();
      });
    }
    conversacion();

    $("#envio-chat").on("click",function(e){
        e.preventDefault();
        $.post( base_url+"chat/enviar_msj", { to_id: $("#to_id").val(), message: $("#texto_chat").val() });
        conversacion();

      });
    setInterval(function(){
      if(entrada == true){
        conversacion_base();
      }
    }, 1000);
  });

  }
  
listado_base();
  

  






  /*
  var to_id = "";
  $.lista_gente();
  $("#usr_chat .media a").on("click",function(e){
    e.preventDefault();
    var to_id = $(this).data("id");
    $.mostrar_conversacion(to_id);
  });

  $("#chat-volver").on("click",function(){
    alert("");
    $.lista_gente();
  });*/

/*
$.ajax({
    url: base_url+"chat/listado",
    async:false,
      dataType: 'html',
      success: function(data) {
        $("#users .users-list").html(data);
        $("#usr_chat .media a").on("click",function(e){
          e.preventDefault();
          to_id = $(this).data("id");
          $.ajax({
            url: base_url+"chat/conversacion/"+to_id,
            async:false,
              dataType: 'html',
              success: function(data) {
                $("#users .users-list").html(data);
                $("#chat-volver").on("click",function(){
                  $.ajax({
                    url: base_url+"chat/listado",
                    async:false,
                      dataType: 'html',
                      success: function(data) {
                        $("#users .users-list").html(data);
                      }
                  });
                });
                $("#envio-chat").on("click",function(e){
                  e.preventDefault();
                  $.post( base_url+"chat/enviar_msj", { to_id: $("#to_id").val(), message: $("#texto_chat").val() },function(data){
                      if(data==true){
                        $.ajax({
                          url: base_url+"chat/conversacion/"+to_id,
                          dataType: 'html',
                           success: function(data) {
                            $("#users .users-list").html(data);
                           }
                        });
                      }
                  } );
                });
              }
          });
        });
      }
  });

*/

});