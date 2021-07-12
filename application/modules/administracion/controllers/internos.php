<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Internos extends CI_Controller {
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
		redirect('administracion/internos/agregar', 'refresh');
	}
	function agregar($msg = false) {
		
		$base['titulo'] = "Agregar Usuario Interno";
		$base['lugar'] = "Agregar Usuario Interno";
		$this->load->model('Tipousuarios_model');
		
		if($msg == "error_vacio"){
			$aviso['titulo'] = "Tiene que agregar los datos obligatorios";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_rut"){
			$aviso['titulo'] = "El rut existe en nuestros sistemas";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_pass"){
			$aviso['titulo'] = "No se ha guardado usuario. Favor revisar la contraseña";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "Se ha ingresado el usuario correctamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}

		$pagina['texto_anterior'] = $this->session->flashdata('ingreso_interno');
		$pagina['listado_tipo'] = $this->Tipousuarios_model->get_internos();
		$pagina['pass_generada'] = $prefijo = substr(md5(uniqid(rand())),0,10);
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('internos/agregar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function guardar(){
		$sess = array(
			'id_tipo_usuarios' => trim($_POST['cargo']),
			'rut_usuario' =>trim($_POST['rut']),
			'nombres' => trim($_POST['nombres']),
			'paterno' => trim($_POST['paterno']),
			'materno' => trim($_POST['materno']),
			'fono1' => trim($_POST['fono_cod']),
			'fono2' => trim($_POST['fono_num']),
			'email' => trim($_POST['email']),
			'direccion' => trim($_POST['dir'])
		);
		$this->session->set_flashdata('ingreso_interno',$sess);
		if(empty($_POST['cargo']) || empty($_POST['nombres']) || empty($_POST['paterno']) || empty($_POST['materno']) || empty($_POST['rut']) || 
		 empty($_POST['fono_cod']) || empty($_POST['fono_num']) ){
			redirect('administracion/internos/agregar/error_vacio', 'refresh');
		}
		else{
			$this->load->model('Usuarios_model');
			if($this->Usuarios_model->get_rut($_POST['rut']))
				redirect('administracion/internos/agregar/error_rut', 'refresh');
			else{
				if(empty($_POST['contra']))
					redirect('administracion/internos/agregar/error_pass', 'refresh');
				else{
					if($_POST['contra'] == "pass"){
						if( (empty($_POST['pass1'])) || (empty($_POST['pass2'])) ){
							redirect('administracion/internos/agregar/error_pass', 'refresh');
						}
						else{
							if(trim($_POST['pass1']) != trim($_POST['pass2']))
								redirect('administracion/internos/agregar/error_pass', 'refresh');
							else $pass = trim($_POST['pass1']);
						}
					}
					elseif($_POST['contra'] == "pass2"){
						if(empty($_POST['pass3']))
							redirect('administracion/internos/agregar/error_pass', 'refresh');
						else $pass = trim($_POST['pass3']);
					}
					$data = array(
						'id_tipo_usuarios' => trim($_POST['cargo']),
						'rut_usuario' => mb_strtoupper(trim($_POST['rut']), 'UTF-8'),
						'nombres' => mb_strtoupper(trim($_POST['nombres']), 'UTF-8'),
						'paterno' => mb_strtoupper(trim($_POST['paterno']), 'UTF-8'),
						'materno' => mb_strtoupper(trim($_POST['materno']), 'UTF-8'),
						'fono' => trim($_POST['fono_cod']).'-'.trim($_POST['fono_num']),
						'email' => trim($_POST['email']),
						'direccion' => mb_strtoupper(trim($_POST['dir']), 'UTF-8'),
						'clave' => hash('sha512', $pass)
					);
					$this->Usuarios_model->ingresar($data);
					redirect('administracion/internos/agregar/exito', 'refresh');
				}
			}
		}
	}
	function buscar() {
		$base['titulo'] = "Listado de Usuarios internos";
		$base['lugar'] = "Listado de Usuarios Internos";
		
		$this->load->model('Usuarios_model');
		$this->load->model('Tipousuarios_model');
		$pagina['listado_interno'] = $this->Usuarios_model->listar_internos();
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('internos/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function categorias($msg = FALSE){
		$base['titulo'] = "Categorias de Usuarios";
		$base['lugar'] = "Categorias de Usuarios";
		
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nueva categoria</a>";
		$base['class_subheader'] = "toolbar";
		
		if($msg == "exito_ingreso"){
			$aviso['titulo'] = "Se ha ingresado la categoria correctamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		$this->load->model('Tipousuarios_model');
		$pagina['categorias'] = $this->Tipousuarios_model->listar();
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('internos/categorias',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function ingresar_categoria(){
		if(empty($_POST['cat'])){
			redirect('administracion/internos/categorias', 'refresh');
		}
		else{
			$this->load->model('Tipousuarios_model');
			$data = array( 'desc_tipo_usuarios' => mb_strtoupper($_POST['cat'],'UTF-8') );
			$this->Tipousuarios_model->ingresar($data);
			redirect('administracion/internos/categorias/exito_ingreso', 'refresh');
		}
	}

}
?>