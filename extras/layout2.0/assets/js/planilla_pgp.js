$(document).ready(function(){
	$('.tooltipp').tooltipster({
        contentAsHTML: true,
        position: 'bottom-left',
        theme: 'tooltipster-light'
    });
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