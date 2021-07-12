<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Areas extends CI_Controller {
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
		$base = array(
			'head_titulo' => "Sistema EST - Agregar Area",
			'titulo' => "Agregar Area",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url' => 'administracion/areas/index', 'txt' => 'Areas'), array('url' => '', 'txt' => 'Agregar')),
			'menu' => $this->menu
		);
		
		if($msg == "obligatorio"){
			$aviso['titulo'] = "Error, algún dato obligatorio esta vacio";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "Se ha guardado correctamente el area";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		if($msg == "repetido"){
			$aviso['titulo'] = "Error, este nombre ya existe para la empresa en la base de datos";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST'){ //si se envia el post se guarda acá
			$this->load->model("Areas_model");
			if( empty($_POST['nombre']) ){
				redirect( base_url().'est/areas/agregar', 'refresh');
			}
			else{
				$data = array(
					'nombre' => mb_strtoupper($_POST['nombre'] , 'UTF-8'),
				);

				$this->Areas_model->insert($data);
				redirect( base_url().'est/areas/agregar/exito', 'refresh');
			}
		}
		
		$pagina = "";
		$base['cuerpo'] = $this->load->view('areas/agregar',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
	
	function buscar(){
		$this->load->library('encrypt');

		$base = array(
			'head_titulo' => "Sistema EST - Listado de Areas",
			'titulo' => "Listado de Areas",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Listado')),
			'menu' => $this->menu,
			'js' => array('js/confirm.js')
		);

		$this->load->model("Areas_model");

		$pagina['listado'] = $this->Areas_model->lista_orden_nombre();
		$base['cuerpo'] = $this->load->view('areas/buscar',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_editar_area($id_area){
		$this->load->model("areas_model");
		$pagina = array('datos_area' => $this->areas_model->r_get_result($id_area));
		$this->load->view('est/areas/modal_editar_areas', $pagina);
	}

	function guardar_area_nueva(){
		$this->load->model("areas_model");
		$area_post = $_POST['nombre_area']; 
		$data = array(
			"id_empresa" => "2",
			"nombre" => $area_post,
		);
		
		$si_existe = $this->areas_model->validar_area($area_post);
		if($si_existe == 1){
			echo '<script>alert("El nombre ingresado ya se encuentra registrado en nuestras base de datos");</script>';
			redirect('est/areas/buscar', 'refresh');
		}elseif($si_existe == 0){
			$this->areas_model->insert($data);
			echo '<script>alert("Area Registrada Exitosamente");</script>';
			redirect('est/areas/buscar', 'refresh');
		}else{
			echo '<script>alert("Ocurrio un error al ingresar, intente nuevamente");</script>';
			redirect('est/areas/buscar', 'refresh');
		}
		
	}

	function actualizar_datos_area(){
		$this->load->model("areas_model");
		$id_area = $_POST['id_area'];
		$data = array(
			"nombre" => $_POST['nombre_area'],
		);
		$this->areas_model->r_editar($id_area, $data);
		echo '<script>alert("Area Actualizada Correctamente");</script>';
		redirect('est/areas/buscar', 'refresh');
	}

	function guardar($id = false){
		$this->load->model("Areas_model");
		if( empty($_POST['empresa']) || empty($_POST['nombre']) ){
			if ($id == false)
				redirect( base_url().'administracion/areas/agregar/obligatorio', 'refresh');
			else
				redirect( base_url().'administracion/areas/editar/'.$id, 'refresh');
		}
		else{
			
			$data = array(
				'nombre' => mb_strtoupper($_POST['nombre'] , 'UTF-8'),
			);
			if ($id == false){
				$this->Areas_model->insert($data);
				redirect( base_url().'administracion/areas/agregar/exito', 'refresh');
			}
			else{
				$this->Areas_model->r_editar($id,$data);
				redirect( base_url().'administracion/areas/buscar', 'refresh');
			}
		}
	}

	function editar($id){
		$this->load->library('encrypt');
		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Areas";

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);

		$this->load->model("Areas_model");

		$pagina['area'] = $this->Areas_model->r_get($id);

		$base['cuerpo'] = $this->load->view('areas/editar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function eliminar($id){
		//$this->load->library('encrypt');
		$this->load->model("Areas_model");
		$this->Areas_model->r_eliminar($id);
		//$url = $this->encrypt->decode( urldecode($url) );
		//redirect( $url, 'refresh');
		redirect( base_url().'est/areas/buscar', 'refresh');
	}

	function plantas_ajax($id){
		$this->load->model("Planta_model");
		$salida = $this->Planta_model->get_empresa($id);
		echo json_encode($salida);
	}

	function grupos_ajax($id){
		$this->load->model("Grupo_model");
		$salida = $this->Grupo_model->get_planta($id);
		echo json_encode($salida);
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