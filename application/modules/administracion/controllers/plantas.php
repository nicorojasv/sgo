<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Plantas extends CI_Controller {
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
	function index(){
		
	}
	
	function agregar($msg = FALSE){
		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Plantas";
		$this->load->model("Empresas_model");
		$this->load->model("Region_model");
		
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
		
		$pagina['listado_empresas'] = $this->Empresas_model->listar();
		$pagina['listado_regiones'] = $this->Region_model->listar();
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('plantas/agregar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function buscar(){
		$this->load->library('encrypt');
		$base['titulo'] = "Sistema EST";

		$base = array(
			'head_titulo' => "Sistema EST - Listado de Unidades de Negocio",
			'titulo' => "Unidades de Negocio",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url' => 'administracion/plantas/index', 'txt' => 'Unidad de Negocio'), array('url' => '', 'txt' => 'Listado')),
			'menu' => $this->load->view('layout2.0/menus/menu_admin','',TRUE)
		);
		
		$this->load->model("Planta_model");
		$this->load->model("Empresas_model");
		$pagina['listado'] = $this->Planta_model->listar();
		$base['cuerpo'] = $this->load->view('plantas/buscar',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar($id = false){
		$this->load->model("Planta_model");
		if( empty($_POST['empresa']) || empty($_POST['nombre']) || empty($_POST['fono_cod']) || empty($_POST['fono_num']) || empty($_POST['region']) || empty($_POST['provincia']) || empty($_POST['ciudad']) ){
			if( $id == false )
				redirect( base_url().'administracion/plantas/agregar/obligatorio', 'refresh');
			else
				redirect( base_url().'administracion/plantas/editar/'.$id, 'refresh');
		}
		else{
			if( ($id == false)  and (count($this->Planta_model->get_existe_nombre( mb_strtoupper($_POST['nombre'] , 'UTF-8'), $_POST['empresa'])) > 0 )){
				redirect( base_url().'administracion/plantas/agregar/repetido', 'refresh');
			}
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
			if( $id == false ){
				$this->Planta_model->ingresar($data);
				redirect( base_url().'administracion/plantas/agregar/exito', 'refresh');
			}
			else{
				$this->Planta_model->editar($id,$data);
				redirect( base_url().'administracion/plantas/buscar', 'refresh');
			}
		}
	}

	function plantas_ajax($id){
		$this->load->model("Planta_model");
		foreach($this->Planta_model->get_empresa($id) as $e){
			echo "<li><a href='#' class='item-planta' rel='".$e->id."'>".ucwords(mb_strtolower($e->nombre, 'UTF-8'))."</a></li>";
		}
	}
	
	function eliminar($id,$url){
		$this->load->library('encrypt');
		$this->load->model("Planta_model");
		$this->Planta_model->eliminar($id);
		$url = $this->encrypt->decode( urldecode($url) );
		redirect( $url, 'refresh');
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