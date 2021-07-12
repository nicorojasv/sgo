$(document).ready(function(){
	var countChecked = function() {
	  var n = $( "input:checked" ).length;
	  //$( "#log" ).text("Usted a Seleccionado: <a>" +  n + (n === 1 ? "</a> " : " </a>") );
	  $( "#log" ).html("Usted ha Seleccionado: " +  n + (n === 1 ? "":"") );
	};
	countChecked();
	$( "input[type=checkbox]" ).on( "click", countChecked );
});
