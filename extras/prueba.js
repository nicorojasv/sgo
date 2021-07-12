
	//alert('Hola')
	document.getElementById('botonP').disabled = true;
	console.log(document.getElementById('nombre').value);


	console.log('hola')
	function prueba(){
		if (document.getElementById('nombre').value != 0) {
			document.getElementById("botonP").className = "btn btn-success";
			document.getElementById('botonP').disabled = false;
		}else{
			document.getElementById("alerta").style.visibility  = "visible";
			document.getElementById("botonP").className = "btn btn-danger";
		}
	}
