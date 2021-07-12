$(document).ready(function(){
  $("#example1").dataTable({
    scrollY:        "500px",
    scrollX:        true,
    scrollCollapse: true,
    paging:         false,
    fixedColumns:   {
        leftColumns: 1,
        rightColumns: 1
    }
  });
    $("#example2").DataTable({
        "scrollY":        "500px",
        "scrollCollapse": true,
        "paging":         false
    });
    $("#example3").DataTable({
        "scrollY":        "500px",
        "scrollCollapse": true,
        "paging":         false
    });


});
