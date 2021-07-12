<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Experiencia extends CI_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo') != 2){
			redirect('/login/index', 'refresh');
		}*/
		redirect('usuarios/login/index', 'refresh');

		$this->load->model("Noticias_model");
		$this->load->model("Ofertas_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Evaluacionestipo_model");
		$this->noticias['noticias_noleidas'] = $this->Noticias_model->cont_noticias_noleidas($this->session->userdata('id'));
		$this->noticias['capacitaciones_noleidas'] = $this->Noticias_model->cont_capacitacion_noleidas($this->session->userdata('id'));
		$this->noticias['ofertas_noleidas'] = $this->Ofertas_model->cont_ofertas_noleidas($this->session->userdata('id'));
		$this->noticias['requerimiento_nuevo'] = $this->Asignarequerimiento_model->cant_asignados($this->session->userdata('id'));
		$this->noticias['listado_tipoeval'] = $this->Evaluacionestipo_model->listar();
		$this->load->model("Mensajes_model");
		$this->load->model("Mensajesresp_model");
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($this->Mensajes_model->listar_trabajador($this->session->userdata("id")) as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$this->noticias['mensajes_noleidos'] = $suma;
   	}
	function index($msg = FALSE) {
		$this->load->model("Experiencia_model");
		$base['titulo'] = "Listado de mis experiencias";
		$base['lugar'] = "Experiencia";
		
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nueva experiencia</a>";
		$base['class_subheader'] = "toolbar";
		/**** AVISOS Y MENSAJES ****/
		if($msg == "vacio"){
			$aviso['titulo'] = "No olvide que todos los datos con asterisco son obligatorios";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "fecha"){
			$aviso['titulo'] = "La fecha 'hasta' no puede ser menor que 'desde'";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "Su experiencia a sido añadida exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "borrado_exito"){
			$aviso['titulo'] = "Se a borrado la experiencia exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		$pagina['menu'] = $this->load->view('menus/menu_trabajador',$this->noticias,TRUE);
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pagina['experiencia'] = $this->Experiencia_model->get_usuario($this->session->userdata('id'));
		$base['cuerpo'] = $this->load->view('experiencia',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function agregar() {
		if( empty( $_POST['select_dia_desde'] ) || empty( $_POST['select_mes_desde'] ) || empty( $_POST['select_ano_desde'] ) || 
		empty( $_POST['select_dia_hasta'] ) || empty( $_POST['select_mes_hasta'] ) || empty( $_POST['select_ano_hasta'] ) ||
		empty( $_POST['cargo'] ) || empty( $_POST['area'] ) || empty( $_POST['contratista'] ) || empty( $_POST['funciones'] ) ){
			redirect('trabajador/experiencia/index/vacio', 'refresh');
		}
		else{
			$fecha1 = $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-'.$_POST['select_dia_desde'];
			$fecha2 = $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-'.$_POST['select_dia_hasta'];
			
			if( (strtotime($fecha2) - strtotime($fecha1)) < 0 )
				redirect('trabajador/experiencia/index/fecha', 'refresh');
			else{
				$this->load->model("Experiencia_model");
				$data = array(
					'id_usuarios' => $this->session->userdata('id'),
					'desde' => $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-'.$_POST['select_dia_desde'],
					'hasta' => $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-'.$_POST['select_dia_hasta'],
					'cargo' => $_POST['cargo'],
					'area' => $_POST['area'],
					'empresa_c' => $_POST['contratista'],
					'empresa_m' => $_POST['mandante'],
					'funciones' => $_POST['funciones'],
					'referencias' => $_POST['referencias']
				);
				$this->Experiencia_model->ingresar($data);
				redirect('trabajador/experiencia/index/exito', 'refresh');
			}
		}
	}
	function eliminar($id){
		$this->load->model("Experiencia_model");
		$this->Experiencia_model->borrar($id);
		redirect('trabajador/experiencia/index/borrado_exito', 'refresh');
	}
	
	function tooltip($tipo){ //informacion dinamica de un usuario
		if($tipo == 1){
			echo "<div class='democontent'>
				Para separar las <b>funciones principales</b> usted debe presionar enter, de esa manera puede ingresar de forma individual las funciones que estime convenientes.
			</div>";
		}
		if($tipo == 2){
			echo "<div class='democontent'>
				Para separar las <b>referencias</b> usted debe presionar enter, de esa manera puede ingresar de forma individual las referencias que estime convenientes.
			</div>";
		}
	}

}
?>