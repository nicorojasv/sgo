$(document).ready(function(){
  $("#example1").dataTable({
    scrollY:        "400px",
    scrollX:        true,
    scrollCollapse: true,
    paging:         false,
    fixedColumns:   {
        leftColumns: 1,
        rightColumns: 1
    }
  });
});