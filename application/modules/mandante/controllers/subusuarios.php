<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Subusuarios extends CI_Controller{
	public $noticias;
	
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		/*elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		*/
		elseif($this->session->userdata('tipo') != 1){
			redirect('/login/index', 'refresh');
		}
		$this->load->model("Noticias_model");
		$this->noticias['noticias_noleidas'] = $this->Noticias_model->cont_noticias_noleidas($this->session->userdata('id'));
		$this->load->model("Mensajes_model");
		$this->load->model("Mensajesresp_model");
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($this->Mensajes_model->listar_admin($this->session->userdata("id")) as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$this->noticias['mensajes_noleidos'] = $suma;
   	}

	function crear($msg = FALSE){
		$base['titulo'] = "Creacion de Sub Usuarios";
		$base['lugar'] = "Sub Usuarios";
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimiento_model");
		
		if($msg == "exito"){
			$aviso['titulo'] = "Se ha guardado el subusuario exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_vacio"){
			$aviso['titulo'] = "Error al guardar subusuario, algunos datos estan vacios";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_pass"){
			$aviso['titulo'] = "Error al guardar subusuario, las contraseñas no coinciden";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_rut"){
			$aviso['titulo'] = "Error al guardar subusuario, el rut ya existe en el sistema";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		$usr = $this->Usuarios_model->get($this->session->userdata('id'));
		$codigo_usr = $usr->codigo_ingreso;
		$total_sub = $this->Usuarios_model->total_planta_sub($usr->id_planta);
		
		if((int)$total_sub < 1000) $total = (int)$total_sub;
		if((int)$total_sub < 100) $total = '0'.(int)$total_sub;
		if((int)$total_sub < 10) $total = '00'.(int)$total_sub;
		
		$pagina['codigo_ingreso'] = $codigo_usr.'-'.$total;
		
		$pagina['listado_requerimientos'] = $this->Requerimiento_model->listar();
		$pagina['planta'] = $this->Usuarios_model->get($this->session->userdata("id"))->id_planta;
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$base['cuerpo'] = $this->load->view('subusuarios/crear',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function guardar(){
		$data = array(
			'nombres' => $_POST['nombres_m'],
			'paterno' => $_POST['paterno'],
			'materno' => $_POST['materno'],
			'rut_usuario' => $_POST['rut'],
			'fono3' => $_POST['fono1'],
			'fono4' => $_POST['fono2'],
			'email_m' => $_POST['email_mandante'],
			'cargo_mandante' => $_POST['cargo'],
		);
		$this->session->set_flashdata('ingreso_subusuario',$data);
		
		if(empty($_POST['nombres_m']) || empty($_POST['paterno']) || empty($_POST['materno'])  
		|| empty($_POST['rut']) || empty($_POST['fono1']) || empty($_POST['fono2']) 
		|| empty($_POST['cargo']) || empty($_POST['pass1']) || empty($_POST['pass2']) ){
			redirect('mandantes/subusuarios/crear/error_vacio', 'refresh');
		}
		else{
			
			if($_POST['pass1'] != $_POST['pass2'] )
				redirect('mandantes/subusuarios/crear/error_pass', 'refresh');
			else{
				$this->load->model('Usuarios_model');
				if($this->Usuarios_model->get_rut($_POST['rut'])){
					redirect('mandantes/subusuarios/crear/error_rut', 'refresh');
				}
				else{
					$this->load->model("Subusuarios_model");
					$data_mandante = array(
						'id_tipo_usuarios' => 6,
						'nombres' => mb_strtoupper($_POST['nombres_m'], 'UTF-8'),
						'paterno' => mb_strtoupper($_POST['paterno'], 'UTF-8'),
						'materno' => mb_strtoupper($_POST['materno'], 'UTF-8'),
						'rut_usuario' => trim($_POST['rut']),
						'fono' => $_POST['fono1'].'-'.$_POST['fono2'],
						'email' => $_POST['email_mandante'],
						'cargo_mandante' => mb_strtoupper($_POST['cargo'] ,'UTF-8'),
						'clave' => hash('sha512',$_POST['pass1']),
						'id_planta' => $_POST['planta']
					);
					$id_usr = $this->Usuarios_model->ingresar($data_mandante);
					// $data_subusr = array(
						// 'id_requerimiento' => $_POST['requerimiento'],
						// 'id_usuarios' => $id_usr 
					// );
					// $this->Subusuarios_model->ingresar($data_subusr);
					redirect('mandantes/subusuarios/crear/exito', 'refresh');
				}
			}
		}
	}

	function listado(){
		$base['titulo'] = "Listado de Sub Usuarios";
		$base['lugar'] = "Sub Usuarios";
		
		$this->load->model("Subusuarios_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimiento_model");
		
		$mi_planta = $this->Usuarios_model->get( $this->session->userdata("id") )->id_planta;
		$listado = array();
		foreach($this->Usuarios_model->get_planta_subusr($mi_planta) as $l){
			$usr = $this->Usuarios_model->get($l->id);
			$aux = new stdClass();
			$aux->id = $usr->id;
			$aux->nombre = $usr->nombres;
			$aux->paterno = $usr->paterno;
			$aux->materno = $usr->materno;
			$aux->rut = $usr->rut_usuario;
			$requerimiento = $this->Subusuarios_model->get($l->id);
			if($requerimiento)
				$aux->requerimiento = $this->Requerimiento_model->get($l->id_requerimiento)->nombre;
			else
				$aux->requerimiento = FALSE;
			array_push($listado,$aux);
			unset($aux);
		}
		
		
		$pagina['listado'] = $listado;
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$base['cuerpo'] = $this->load->view('subusuarios/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function asignar($id){
		$base['titulo'] = "Asignacion de Sub Usuarios";
		$base['lugar'] = "Sub Usuarios";
		
		$this->load->model("Subusuarios_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimiento_model");
		
		$pagina['usuario'] = $this->Usuarios_model->get($id);
		
		$mi_planta = $this->Usuarios_model->get( $this->session->userdata("id") )->id_planta;
		$pagina['req'] = $this->Requerimiento_model->get_planta($mi_planta);
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$base['cuerpo'] = $this->load->view('subusuarios/asignar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function ajax_lista_subreq($id_req){
		$this->load->model("Requerimiento_model");
		$this->load->model("Requerimiento_trabajador_model");
		
		foreach($this->Requerimiento_trabajador_model->get_requerimiento($id_req) as $r){
			echo "<input type='checkbox' name='subreq' value='". $r->trabajador_id."' >";
		}
		
	}
}
?>