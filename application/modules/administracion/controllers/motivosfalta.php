<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Motivosfalta extends CI_Controller {
	public $requerimiento;
	
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		
		elseif($this->session->userdata('tipo') != 3){
			redirect('/login/index', 'refresh');
		}*/
		redirect('usuarios/login/index', 'refresh');

		$this->load->model("Requerimiento_model");
		$this->requerimiento['requerimiento_noleidos'] = $this->Requerimiento_model->noleidas();
		$this->requerimiento['requerimiento_eliminacion'] = $this->Requerimiento_model->pet_eliminacion();
		$this->load->model("Mensajes_model");
		$this->load->model("Mensajesresp_model");
		$this->load->model("Evaluacionestipo_model");
		$this->requerimiento['listado_evaluaciones'] = $this->Evaluacionestipo_model->listar(); 
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($this->Mensajes_model->listar_admin($this->session->userdata("id")) as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$this->requerimiento['mensajes_noleidos'] = $suma;
   	}
	
	function ingresar(){
		if(!empty($_POST['nombre_motivo'])){
			$this->load->model("Motivosfalta_model");
			$ingresar = array('nombre' => mb_strtoupper($_POST['nombre_motivo'], 'UTF-8'));
			$this->Motivosfalta_model->ingresar($ingresar);
			redirect('administracion/motivosfalta/listar/exito', 'refresh');
		}
		else{
			redirect('administracion/motivosfalta/listar/error_vacio', 'refresh');
		}
	}
	
	function listar($msg = false){
		$this->load->model("Motivosfalta_model");
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['titulo'] = "Configuracion de Motivos de las faltas en los requerimientos";
		$base['lugar'] = "Configurar motivos";
		
		$pagina['subtitulo'] = "Motivos de las faltas";
		
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nuevo motivo</a>";
		$base['class_subheader'] = "toolbar";
		$lista = array();
		// foreach($this->Motivos_falta_model->listar() as $l){
			// $aux = new stdClass();
			// $aux->id = $lp->id;
			// $aux->nombre = $lp->desc_profesiones;
			// array_push($lista,$aux);
			// unset($aux);
		// }
		if($msg == "error_vacio"){
			$aviso['titulo'] = "El nombre no puede estar vacio";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "Se ha ingresado correctamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "eliminado"){
			$aviso['titulo'] = "Se ha eliminado correctamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		$pagina['listado'] = $this->Motivosfalta_model->listar();
		$base['cuerpo'] = $this->load->view('motivosfaltas/listar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function eliminar($id){
		$this->load->model("Motivosfalta_model");
		$this->Motivosfalta_model->eliminar($id);
		redirect('administracion/motivosfalta/listar/eliminado', 'refresh');
	}
	
}