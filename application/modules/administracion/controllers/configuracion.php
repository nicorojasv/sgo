<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Configuracion extends CI_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			 redirect('usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo') != 3){
			redirect('usuarios/login/index', 'refresh');
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
	function index() {
		
	}
	
	function profesiones(){
		$this->load->model("Profesiones_model");
		$base['titulo'] = "Configuracion de profesiones";
		$base['lugar'] = "Configurar profesiones";
		
		$pagina['subtitulo'] = "profesiones creadas";
		$pagina['modal_subtitulo'] = "nueva profesión";
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nueva profesión</a>";
		$base['class_subheader'] = "toolbar";
		$lista = array();
		foreach($this->Profesiones_model->listar() as $lp){
			$aux = new stdClass();
			$aux->id = $lp->id;
			$aux->nombre = $lp->desc_profesiones;
			array_push($lista,$aux);
			unset($aux);
		}
		
		$pagina['listados'] = $lista;
		$pagina['url_guardar'] = 'guardar_profesiones';
		$pagina['url_editar_modal'] = base_url().'administracion/configuracion/modal_profesiones';
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('configuraciones',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function guardar_profesiones(){
		$this->load->model("Profesiones_model");
		if(isset($_POST['nombre'])){
			$data = array( 'desc_profesiones' => mb_strtoupper($_POST['nombre'], 'UTF-8') );
			$this->Profesiones_model->ingresar($data);
		}
		redirect('administracion/configuracion/profesiones', 'refresh');
	}
	
	function modal_profesiones($id){
		$this->load->model("Profesiones_model");
		$base['modal_subtitulo'] = "profesión";
		$base['url_editar'] = 'editar_profesiones';
		$base['nb'] = ucwords( mb_strtolower($this->Profesiones_model->get($id)->desc_profesiones, 'UTF-8'));
		$base['id'] = $id;
		$this->load->view('editar_modal',$base);
	}
	
	function editar_profesiones(){
		$this->load->model("Profesiones_model");
		$data = array( 'desc_profesiones' => $_POST['nombre'] );
		$this->Profesiones_model->actualizar($data,$_POST['id']);
		redirect('administracion/configuracion/profesiones', 'refresh');
	}
	
	function especialidades(){
		$this->load->model("Especialidadtrabajador_model");
		$base['titulo'] = "Configuracion de especialidad";
		$base['lugar'] = "Configurar especialidades";
		
		$pagina['subtitulo'] = "especialidades creadas";
		$pagina['modal_subtitulo'] = "nueva especialidad";
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nueva especialidad</a>";
		$base['class_subheader'] = "toolbar";
		
		$lista = array();
		foreach($this->Especialidadtrabajador_model->listar() as $lp){
			$aux = new stdClass();
			$aux->id = $lp->id;
			$aux->nombre = $lp->desc_especialidad;
			array_push($lista,$aux);
			unset($aux);
		}
		
		$pagina['listados'] = $lista;
		$pagina['url_guardar'] = 'guardar_especialidades';
		$pagina['url_editar_modal'] = base_url().'administracion/configuracion/modal_especialidades';
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('configuraciones',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function guardar_especialidades(){
		$this->load->model("Especialidadtrabajador_model");
		if(isset($_POST['nombre'])){
			$data = array( 'desc_especialidad' => mb_strtoupper($_POST['nombre'], 'UTF-8') );
			$this->Especialidadtrabajador_model->ingresar($data);
		}
		redirect('administracion/configuracion/especialidades', 'refresh');
	}
	
	function modal_especialidades($id){
		$this->load->model("Especialidadtrabajador_model");
		$base['modal_subtitulo'] = "especialidad";
		$base['url_editar'] = 'editar_especialidades';
		$base['nb'] = ucwords( mb_strtolower($this->Especialidadtrabajador_model->get($id)->desc_especialidad, 'UTF-8'));
		$base['id'] = $id;
		$this->load->view('editar_modal',$base);
	}

	function editar_especialidades(){
		$this->load->model("Especialidadtrabajador_model");
		$data = array( 'desc_especialidad' => $_POST['nombre'] );
		$this->Especialidadtrabajador_model->actualizar($data,$_POST['id']);
		redirect('administracion/configuracion/especialidades', 'refresh');
	}
	
	function bancos(){
		$this->load->model("Bancos_model");
		$base['titulo'] = "Configuracion de bancos";
		$base['lugar'] = "Configurar bancos";
		
		$pagina['subtitulo'] = "bancos creados";
		$pagina['modal_subtitulo'] = "nuevo banco";
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nuevo banco</a>";
		$base['class_subheader'] = "toolbar";
		
		$lista = array();
		foreach($this->Bancos_model->listar() as $lp){
			$aux = new stdClass();
			$aux->id = $lp->id;
			$aux->nombre = $lp->desc_bancos;
			array_push($lista,$aux);
			unset($aux);
		}
		
		$pagina['listados'] = $lista;
		$pagina['url_guardar'] = 'guardar_bancos';
		$pagina['url_editar_modal'] = base_url().'administracion/configuracion/modal_bancos';
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('configuraciones',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function guardar_bancos(){
		$this->load->model("Bancos_model");
		if(isset($_POST['nombre'])){
			$data = array( 'desc_bancos' => mb_strtoupper($_POST['nombre'], 'UTF-8') );
			$this->Bancos_model->ingresar($data);
		}
		redirect('administracion/configuracion/bancos', 'refresh');
	}	
	
	function modal_bancos($id){
		$this->load->model("Bancos_model");
		$base['modal_subtitulo'] = "banco";
		$base['url_editar'] = 'editar_bancos';
		$base['nb'] = ucwords( mb_strtolower($this->Bancos_model->get($id)->desc_bancos, 'UTF-8'));
		$base['id'] = $id;
		$this->load->view('editar_modal',$base);
	}
	
	function editar_bancos(){
		$this->load->model("Bancos_model");
		$data = array( 'desc_especialidad' => $_POST['nombre'] );
		$this->Bancos_model->actualizar($data,$_POST['id']);
		redirect('administracion/configuracion/bancos', 'refresh');
	}
	
	function tipos_de_archivos(){
		$this->load->model("Tipoarchivos_model");
		$base['titulo'] = "Configuracion de tipos de archivos";
		$base['lugar'] = "Configurar tipos de archivo";
		
		$pagina['subtitulo'] = "tipos de archivos creados";
		$pagina['modal_subtitulo'] = "nuevo tipo de archivo";
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nuevo tipo de archivo</a>";
		$base['class_subheader'] = "toolbar";
		
		$lista = array();
		foreach($this->Tipoarchivos_model->listar() as $lp){
			$aux = new stdClass();
			$aux->id = $lp->id;
			$aux->nombre = $lp->desc_tipoarchivo;
			array_push($lista,$aux);
			unset($aux);
		}
		
		$pagina['listados'] = $lista;
		$pagina['url_guardar'] = 'guardar_archivos';
		$pagina['url_editar_modal'] = base_url().'administracion/configuracion/modal_archivos';
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('configuraciones',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function guardar_archivos(){
		$this->load->model("Tipoarchivos_model");
		if(isset($_POST['nombre'])){
			$data = array( 'desc_tipoarchivo' => mb_strtoupper($_POST['nombre'], 'UTF-8') );
			$this->Tipoarchivos_model->ingresar($data);
		}
		redirect('administracion/configuracion/tipos_de_archivos', 'refresh');
	}
	
	function modal_archivos($id){
		$this->load->model("Tipoarchivos_model");
		$base['modal_subtitulo'] = "archivo ";
		$base['url_editar'] = 'editar_archivos';
		$base['nb'] = ucwords( mb_strtolower($this->Bancos_model->get($id)->desc_tipoarchivo, 'UTF-8'));
		$base['id'] = $id;
		$this->load->view('editar_modal',$base);
	}
	
	function editar_archivos(){
		$this->load->model("Tipoarchivos_model");
		$data = array( 'desc_tipoarchivo' => $_POST['nombre'] );
		$this->Tipoarchivos_model->actualizar($data,$_POST['id']);
		redirect('administracion/configuracion/tipos_de_archivos', 'refresh');
	}

	function salud(){
		$this->load->model("Salud_model");
		$base['titulo'] = "Configuracion de sistema de salud";
		$base['lugar'] = "Configurar sistema de salud";
		
		$pagina['subtitulo'] = "salud creadas";
		$pagina['modal_subtitulo'] = "nuevo sistema de salud";
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nueva salud</a>";
		$base['class_subheader'] = "toolbar";
		
		$lista = array();
		foreach($this->Salud_model->listar() as $lp){
			$aux = new stdClass();
			$aux->id = $lp->id;
			$aux->nombre = $lp->desc_salud;
			array_push($lista,$aux);
			unset($aux);
		}
		
		$pagina['listados'] = $lista;
		$pagina['url_guardar'] = 'guardar_salud';
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('configuraciones',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function guardar_salud(){
		$this->load->model("Salud_model");
		if(isset($_POST['nombre'])){
			$data = array( 'desc_salud' => mb_strtoupper($_POST['nombre'], 'UTF-8') );
			$this->Salud_model->ingresar($data);
		}
		redirect('administracion/configuracion/salud', 'refresh');
	}
	
	function modal_salud($id){
		$this->load->model("Salud_model");
		$base['modal_subtitulo'] = "archivo ";
		$base['url_editar'] = 'editar_salud';
		$base['nb'] = ucwords( mb_strtolower($this->Salud_model->get($id)->desc_salud, 'UTF-8'));
		$base['id'] = $id;
		$this->load->view('editar_modal',$base);
	}
	
	function editar_salud(){
		$this->load->model("Salud_model");
		$data = array( 'desc_salud' => $_POST['nombre'] );
		$this->Salud_model->actualizar($data,$_POST['id']);
		redirect('administracion/configuracion/tipos_de_archivos', 'refresh');
	}
	
	function afp(){
		$this->load->model("Afp_model");
		$base['titulo'] = "Configuracion de afp";
		$base['lugar'] = "Configurar afp";
		
		$pagina['subtitulo'] = "afp creadas";
		$pagina['modal_subtitulo'] = "nueva afp";
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nueva afp</a>";
		$base['class_subheader'] = "toolbar";
		
		$lista = array();
		foreach($this->Afp_model->listar() as $lp){
			$aux = new stdClass();
			$aux->id = $lp->id;
			$aux->nombre = $lp->desc_afp;
			array_push($lista,$aux);
			unset($aux);
		}
		
		
		$pagina['listados'] = $lista;
		$pagina['url_guardar'] = 'guardar_afp';
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('configuraciones',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function guardar_afp(){
		$this->load->model("Afp_model");
		if(isset($_POST['nombre'])){
			$data = array( 'desc_afp' => mb_strtoupper($_POST['nombre'], 'UTF-8') );
			$this->Afp_model->ingresar($data);
		}
		redirect('administracion/configuracion/afp', 'refresh');
	}
	
	function modal_afp($id){
		$this->load->model("Afp_model");
		$base['modal_subtitulo'] = "archivo ";
		$base['url_editar'] = 'editar_afp';
		$base['nb'] = ucwords( mb_strtolower($this->Afp_model->get($id)->desc_afp, 'UTF-8'));
		$base['id'] = $id;
		$this->load->view('editar_modal',$base);
	}
	
	function editar_afp(){
		$this->load->model("Afp_model");
		$data = array( 'desc_afp' => $_POST['nombre'] );
		$this->Afp_model->actualizar($data,$_POST['id']);
		redirect('administracion/configuracion/afp', 'refresh');
	}
	
	function regiones(){
		$this->load->model('Region_model');
		$base['titulo'] = "Configuracion de regiones";
		$base['lugar'] = "Configurar regiones";
		
		$pagina['subtitulo'] = "regiones creadas";
		$pagina['modal_subtitulo'] = "nueva region";
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nueva region</a>";
		$base['class_subheader'] = "toolbar";
		
		$lista = array();
		foreach($this->Region_model->listar() as $lp){
			$aux = new stdClass();
			$aux->id = $lp->id;
			$aux->nombre = $lp->desc_regiones;
			array_push($lista,$aux);
			unset($aux);
		}
		
		$pagina['listados'] = $lista;
		$pagina['url_guardar'] = 'guardar_regiones';
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('configuraciones',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function provincias(){
		$this->load->model('Region_model');
		$this->load->model('Provincia_model');
		$base['titulo'] = "Configuracion de provincias";
		$base['lugar'] = "Configurar provincias";
		
		$pagina['subtitulo'] = "provincias creadas";
		$pagina['modal_subtitulo'] = "nueva provincia";
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nueva provincia</a>";
		$base['class_subheader'] = "toolbar";
		
		$lista = array();
		foreach($this->Provincia_model->listar() as $lp){
			$aux = new stdClass();
			$aux->id = $lp->id;
			$aux->nombre = $lp->desc_provincias;
			array_push($lista,$aux);
			unset($aux);
		}
		
		$pagina['aux_regiones'] = TRUE;	
		$pagina['listados'] = $lista;
		$pagina['url_guardar'] = 'guardar_provincias';
		$pagina['regiones'] = $this->Region_model->listar();
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('configuraciones',$pagina,TRUE);
		$this->load->view('layout',$base);
		
	}
	function ciudades(){
		$this->load->model('Region_model');
		$this->load->model('Ciudad_model');
		$base['titulo'] = "Configuracion de Ciudades";
		$base['lugar'] = "Configurar ciudades";
		
		$pagina['subtitulo'] = "ciudades creadas";
		$pagina['modal_subtitulo'] = "nueva ciudad";
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nueva ciudad</a>";
		$base['class_subheader'] = "toolbar";
		
		$lista = array();
		foreach($this->Ciudad_model->listar() as $lp){
			$aux = new stdClass();
			$aux->id = $lp->id;
			$aux->nombre = $lp->desc_ciudades;
			array_push($lista,$aux);
			unset($aux);
		}
		
		$pagina['aux_regiones'] = TRUE;	
		$pagina['listados'] = $lista;
		$pagina['regiones'] = $this->Region_model->listar();
		$pagina['url_guardar'] = 'guardar_ciudades';
		$pagina['url_editar_modal'] = "";
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('configuraciones',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function guardar_ciudades(){
		$this->load->model("Ciudad_model");
		$this->load->helper('url');
		if(isset($_POST['nombre']) && isset($_POST['select_region'])){
			$data = array( 
				'desc_ciudades' => mb_strtoupper($_POST['nombre'], 'UTF-8'),
				'id_regiones' => $_POST['select_region']
			);
			$this->Ciudad_model->ingresar($data);
		}

		redirect('administracion/configuracion/ciudades', 'refresh');
	}

	function nivel_estudios(){
		
	}
	
	function estados_civiles(){
		
	}
}
?>