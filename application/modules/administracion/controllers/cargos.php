<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Cargos extends CI_Controller {
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
		$base['lugar'] = "Cargos";
		$this->load->model("Empresas_model");
		$this->load->model("Cargos_model");
		
		if($msg == "obligatorio"){
			$aviso['titulo'] = "Error, algún dato obligatorio esta vacio";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "Se ha guardado correctamente el cargo";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		if($msg == "repetido"){
			$aviso['titulo'] = "Error, este nombre ya existe para la empresa en la base de datos";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('cargos/agregar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function buscar(){
		$this->load->library('encrypt');

		$base = array(
			'head_titulo' => "Sistema EST - Listado de Cargos",
			'titulo' => "Listado de Cargos",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url' => 'administracion/plantas/index', 'txt' => 'Unidad de Negocio'), array('url' => '', 'txt' => 'Listado')),
			'menu' => $this->load->view('layout2.0/menus/menu_admin','',TRUE)
		);
		
		$this->load->model("Cargos_model");

		$pagina['listado'] = $this->Cargos_model->lista();
		$base['cuerpo'] = $this->load->view('cargos/buscar',$pagina,TRUE);
		$this->load->view('layout2.0./layout',$base);
	}

	function guardar($id = false){
		$this->load->model("Cargos_model");
		if( empty($_POST['nombre']) ){
			if($id == false)
				redirect( base_url().'administracion/areas/agregar/obligatorio', 'refresh');
			else
				redirect( base_url().'administracion/areas/editar/'.$id, 'refresh');
		}
		else{
			
			$data = array(
				'desc_cargo' => mb_strtoupper($_POST['nombre'] , 'UTF-8'),
			);
			if( $id == false ){
				$this->Cargos_model->insert($data);
				redirect( base_url().'administracion/cargos/agregar/exito', 'refresh');
			}
			else{
				$this->Cargos_model->r_editar($id,$data);
				redirect( base_url().'administracion/cargos/buscar', 'refresh');
			}	
		}
	}

	
	function editar($id){
		$this->load->library('encrypt');
		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Cargos";

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);

		$this->load->model("Cargos_model");

		$pagina['cargo'] = $this->Cargos_model->r_get($id);

		$base['cuerpo'] = $this->load->view('cargos/editar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function eliminar($id,$url){
		$this->load->library('encrypt');
		$this->load->model("Planta_model");
		$this->Planta_model->eliminar($id);
		$url = $this->encrypt->decode( urldecode($url) );
		redirect( $url, 'refresh');
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