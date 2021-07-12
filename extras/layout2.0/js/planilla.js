$(document).ready(function () {

    var href = window.location.href;
    var id = href.substr(href.lastIndexOf('/') + 1);

  var categoryattributelist = "";
  $.ajax({
        async: false,
        url: base_url+"est/requerimiento/planilla_json/"+id,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (msg) { categoryattributelist = msg; },
        //error: function (msg) { categoryattributelist = msg; }
    });
    //return categoryattributelist;

    $("#example1").dataTable({
        scrollY:        "500px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            leftColumns: 1
        }
    });
});