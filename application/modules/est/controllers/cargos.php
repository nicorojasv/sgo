<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Cargos extends CI_Controller {
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
			'head_titulo' => "Sistema EST - Listado de Cargos",
			'titulo' => "Listado de Cargos",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'est/cargos/buscar', 'txt' => 'Cargos'), array('url' => '', 'txt' => 'Agregar')),
			'menu' => $this->menu
		);
		
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

		$pagina = "";

		if($_SERVER['REQUEST_METHOD'] == 'POST'){ //si se envia el post se guarda acá
			$this->load->model("Cargos_model");
			if( empty($_POST['nombre']) ){
				redirect( base_url().'est/cargos/agregar', 'refresh');
			}
			else{
				$data = array(
					'nombre' => mb_strtoupper($_POST['nombre'] , 'UTF-8'),
				);

				$this->Cargos_model->insert($data);
				redirect( base_url().'administracion/cargos/agregar/exito', 'refresh');
			}
		}

		$base['cuerpo'] = $this->load->view('cargos/agregar',$pagina,TRUE);
		$this->load->view('layout2.0./layout',$base);
	}
	
	function buscar(){
		$this->load->library('encrypt');
		$this->load->model("Cargos_model");

		$base = array(
			'head_titulo' => "Sistema EST - Listado de Cargos",
			'titulo' => "Listado de Cargos",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Cargos')),
			'menu' => $this->menu,
			'js' => array('js/confirm.js')
		);
		
		$pagina['listado'] = $this->Cargos_model->lista_orden_nombre();
		$base['cuerpo'] = $this->load->view('cargos/buscar',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
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

	function modal_editar_cargo($id_cargo){
		$this->load->model("cargos_model");
		$pagina = array('datos_cargo' => $this->cargos_model->r_get_result($id_cargo));
		$this->load->view('est/cargos/modal_editar_cargo', $pagina);
	}

	function guardar_cargo_nuevo(){
		$this->load->model("cargos_model");
		$cargo_post = $_POST['nombre_cargo']; 
		$data = array(
			"id_empresa" => "2",
			"nombre" => $cargo_post,
		);
		
		$si_existe = $this->cargos_model->validar_cargo($cargo_post);
		if($si_existe == 1){
			echo '<script>alert("El nombre ingresado ya se encuentra registrado en nuestras base de datos");</script>';
			redirect('est/cargos/buscar', 'refresh');
		}elseif($si_existe == 0){
			$this->cargos_model->insert($data);
			echo '<script>alert("Cargo Registrado Exitosamente");</script>';
			redirect('est/cargos/buscar', 'refresh');
		}else{
			echo '<script>alert("Ocurrio un error al ingresar, intente nuevamente");</script>';
			redirect('est/cargos/buscar', 'refresh');
		}
		
	}

	function actualizar_datos_cargo(){
		$this->load->model("cargos_model");
		$id_cargo = $_POST['id_cargo'];
		$data = array(
			"nombre" => $_POST['nombre_cargo'],
		);
		$this->cargos_model->r_editar($id_cargo, $data);
		echo '<script>alert("Cargo Actualizado Correctamente");</script>';
		redirect('est/cargos/buscar', 'refresh');
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

	function eliminar($id){
		//$this->load->library('encrypt');
		//$this->load->model("Cargos_model");
		//$this->Cargos_model->r_eliminar($id);
		//$url = $this->encrypt->decode( urldecode($url) );
		//redirect( $url, 'refresh');
		redirect( base_url().'est/cargos/buscar', 'refresh');
	}

}

?>