<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Plantas extends CI_Controller{
	public $requerimiento;
	
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador_general','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		
	}
	
	function agregar($msg = FALSE){
		$this->load->model("Empresas_model");
		$this->load->model("Region_model");
		$this->load->model("Provincia_model");
		$this->load->model("Ciudad_model");

		$base = array(
			'head_titulo' => "Sistema EST - Listado de Unidades de Negocio",
			'titulo' => "Unidades de Negocio",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'est/plantas/buscar', 'txt' => 'Unidad de Negocio'), array('url' => '', 'txt' => 'Agregar')),
			'menu' => $this->menu,
		);
		
		if($msg == "obligatorio"){
			$aviso['titulo'] = "Error, algún dato obligatorio esta vacio";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "Se ha guardado correctamente la planta";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		if($msg == "repetido"){
			$aviso['titulo'] = "Error, este nombre ya existe para la empresa en la base de datos";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST'){ //si se envia el post se guarda acá
			$this->load->model("Planta_model");

			if( empty($_POST['empresa']) || empty($_POST['nombre']) || empty($_POST['fono_cod']) || empty($_POST['fono_num']) || empty($_POST['region']) || empty($_POST['provincia']) || empty($_POST['ciudad']) ){
				redirect( base_url().'est/plantas/agregar', 'refresh');
			}
			else{
				$data = array(
					'id_empresa' => $_POST['empresa'],
					'nombre' => mb_strtoupper($_POST['nombre'] , 'UTF-8'),
					'fono' => $_POST['fono_cod'].'-'.$_POST['fono_num'],
					'email' => mb_strtoupper($_POST['email'] , 'UTF-8'),
					'id_regiones' => $_POST['region'],
					'id_ciudades' => $_POST['ciudad'],
					'id_provincias' => $_POST['provincia'],
					'direccion' => mb_strtoupper($_POST['direccion'] , 'UTF-8'),
				);
				$this->Planta_model->ingresar($data);
				redirect( base_url().'est/plantas/agregar/exito', 'refresh');
			}
		}
		
		$pagina['listado_empresas'] = $this->Empresas_model->listar();
		$pagina['listado_regiones'] = $this->Region_model->listar();
		$pagina['listado_provincias'] = $this->Provincia_model->listar();
		$pagina['listado_ciudades'] = $this->Ciudad_model->listar();
		
		$base['cuerpo'] = $this->load->view('plantas/agregar',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
	
	function buscar(){
		$this->load->library('encrypt');

		$base = array(
			'head_titulo' => "Sistema EST - Listado de Unidades de Negocio",
			'titulo' => "Unidades de Negocio",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'est/plantas/buscar', 'txt' => 'Unidad de Negocio'), array('url' => '', 'txt' => 'Listado')),
			'menu' => $this->menu,
			'js' => array('js/confirm.js')
		);
		
		$this->load->model("Planta_model");
		$pagina['listado'] = $this->Planta_model->listar();
		$base['cuerpo'] = $this->load->view('plantas/buscar',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar($id = false){
		$this->load->model("Planta_model");
		if( empty($_POST['empresa']) || empty($_POST['nombre']) || empty($_POST['fono_cod']) || empty($_POST['fono_num']) || empty($_POST['region']) || empty($_POST['provincia']) || empty($_POST['ciudad']) ){
			if( $id == false )
				redirect( base_url().'est/plantas/agregar/obligatorio', 'refresh');
			else
				redirect( base_url().'est/plantas/editar/'.$id, 'refresh');
		}
		else{
			if( ($id == false)  and (count($this->Planta_model->get_existe_nombre( mb_strtoupper($_POST['nombre'] , 'UTF-8'), $_POST['empresa'])) > 0 )){
				redirect( base_url().'est/plantas/agregar/repetido', 'refresh');
			}
			$data = array(
				'nombre' => mb_strtoupper($_POST['nombre'] , 'UTF-8'),
				'fono' => $_POST['fono_cod'].'-'.$_POST['fono_num'],
				'email' => mb_strtoupper($_POST['email'] , 'UTF-8'),
				'id_regiones' => $_POST['region'],
				'id_ciudades' => $_POST['ciudad'],
				'id_provincias' => $_POST['provincia'],
				'direccion' => mb_strtoupper($_POST['direccion'] , 'UTF-8'),
			);
			if( $id == false ){
				$this->Planta_model->ingresar($data);
				redirect( base_url().'est/plantas/agregar/exito', 'refresh');
			}
			else{
				$this->Planta_model->editar($id,$data);
				redirect( base_url().'est/plantas/buscar', 'refresh');
			}
		}
	}

	function plantas_ajax($id){
		$this->load->model("Planta_model");
		foreach($this->Planta_model->get_empresa($id) as $e){
			echo "<li><a href='#' class='item-planta' rel='".$e->id."'>".ucwords(mb_strtolower($e->nombre, 'UTF-8'))."</a></li>";
		}
	}
	
	function eliminar($id){
		//$this->load->library('encrypt');
		$this->load->model("Planta_model");
		$this->Planta_model->eliminar($id);
		//$url = $this->encrypt->decode( urldecode($url) );
		//redirect( $url, 'refresh');
		redirect( base_url().'est/plantas/buscar', 'refresh');
	}

	function editar($id){
		$this->load->library('encrypt');
		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Plantas";

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);

		$this->load->model("Planta_model");
		$this->load->model("Empresas_model");
		$this->load->model("Region_model");

		$pagina['planta'] = $this->Planta_model->get($id);
		$pagina['listado_empresas'] = $this->Empresas_model->listar();
		$pagina['listado_regiones'] = $this->Region_model->listar();

		$base['cuerpo'] = $this->load->view('plantas/editar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function ajax_validar_eliminar($id){
		$this->load->model("Planta_model");
		$this->load->model("Requerimiento_model");
		$this->load->model("Usuarios_model");
		$listado = array();
		$l_planta = $this->Usuarios_model->get_planta($id);
		if( count($l_planta) > 0 ){
			foreach($l_planta as $p){
				$listado['usuarios'][] = $p->nombres.' '.$p->paterno.' '.$p->materno;
			}
		}
		else
			$listado['usuarios'] = false;
		
		$l_req = $this->Requerimiento_model->get_planta($id);
		
		if( count($l_req) > 0 ){
			foreach($l_req as $r){
				$listado['requerimientos'][] = $r->nombre;
			}
		}
		else
			$listado['requerimientos'] = false;
		
		echo json_encode($listado);
	}
}

?>