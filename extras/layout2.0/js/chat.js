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

});