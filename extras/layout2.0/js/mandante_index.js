$(document).ready(function(){
	$('.tooltipp').tooltipster({
        contentAsHTML: true,
        position: 'bottom-left',
        theme: 'tooltipster-light'
    });
	$('#sample_1').dataTable({
		scrollX:        true,
		scrollCollapse: true,
		"iDisplayLength" : 20,
		"aoColumnDefs" : [{
			"aTargets" : [0]
		}],
		"oLanguage" : {
			"sLengthMenu" : "Show _MENU_ Rows",
			"sSearch" : "",
			"oPaginate" : {
				"sPrevious" : "",
				"sNext" : ""
			}
		},
		"aaSorting" : [[2, 'desc']],
	});
});