<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Mandantes extends CI_Controller {
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
		redirect('administracion/mandantes/agregar', 'refresh');
	}
	function agregar($msg = FALSE) {
		$this->load->model('Region_model');
		$this->load->model('Empresas_model');
		$this->load->model("Planta_model");
		
		$base['titulo'] = "Agregar Mandante";
		$base['lugar'] = "Agregar Mandante";
		
		if($msg == "error_vacio"){
			$aviso['titulo'] = "Ocurrio un error, todos los datos son obligatorios";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_pass"){
			$aviso['titulo'] = "Las contraseñas no coinciden,favor corregir";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_rut"){
			$aviso['titulo'] = "El rut existe en nuestros sistemas";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "El mandante a sido guardado exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		$pagina['texto_anterior'] = $this->session->flashdata('ingreso_mandante');
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$pagina['listado_regiones'] = $this->Region_model->listar();
		$pagina['listado_empresas'] = $this->Empresas_model->listar();
		$pagina['listado_plantas'] = $this->Planta_model->listar();
		$base['cuerpo'] = $this->load->view('mandantes/agregar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function provincia($id_region){
		$this->load->model('Provincia_model');
		if(isset($id_region)){
			foreach ($this->Provincia_model->listar_region($id_region) as $prov ){
				echo "<option value=".$prov->id.">".$prov->desc_provincias."</option>";
			}
		}
	}
	function ciudad($id_region){
		$this->load->model('Ciudad_model');
		if(isset($id_region)){
			foreach ($this->Ciudad_model->listar_region($id_region) as $ciu ){
				echo "<option value=".$ciu->id.">".$ciu->desc_ciudades."</option>";
			}
		}
	}
	function buscar() {
		$base['titulo'] = "Listado de mandantes agregados";
		$base['lugar'] = "Listado de Mandantes";
		
		$this->load->model("Usuarios_model");
		$this->load->model("Planta_model");
		
		$pagina['listar'] = $this->Usuarios_model->listar_mandantes();
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('mandantes/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function guardar(){
		$data = array(
			'id_empresa' => $_POST['empresa_select'],
			'id_planta' => $_POST['planta_select'],
			'nombres' => $_POST['nombres_m'],
			'paterno' => $_POST['paterno'],
			'materno' => $_POST['materno'],
			'codigo_ingreso' => $_POST['codigo_ingreso'],
			'fono3' => $_POST['fono1'],
			'fono4' => $_POST['fono2'],
			'email_m' => $_POST['email_mandante'],
			'cargo_mandante' => $_POST['cargo'],
		);
		$this->session->set_flashdata('ingreso_mandante',$data);
		
		if( empty($_POST['empresa_select']) || empty($_POST['planta_select']) || empty($_POST['nombres_m']) || 
		empty($_POST['paterno']) || empty($_POST['materno']) || empty($_POST['codigo_ingreso']) || empty($_POST['fono1']) || 
		empty($_POST['fono2']) || empty($_POST['cargo']) || empty($_POST['pass1']) || empty($_POST['pass2']) ){
			redirect('administracion/mandantes/agregar/error_vacio', 'refresh');
		}
		else{
			
			if($_POST['pass1'] != $_POST['pass2'] )
				redirect('administracion/mandantes/agregar/error_pass', 'refresh');
			else{
				$this->load->model('Usuarios_model');
				if($this->Usuarios_model->get_rut($_POST['rut'])){
					redirect('administracion/mandantes/agregar/error_rut', 'refresh');
				}
				else{
					$data_mandante = array(
						'id_tipo_usuarios' => 1,
						'nombres' => mb_strtoupper($_POST['nombres_m'], 'UTF-8'),
						'paterno' => mb_strtoupper($_POST['paterno'], 'UTF-8'),
						'materno' => mb_strtoupper($_POST['materno'], 'UTF-8'),
						'rut_usuario' => '',
						'codigo_ingreso' => $_POST['codigo_ingreso'],
						'fono' => $_POST['fono1'].'-'.$_POST['fono2'],
						'email' => $_POST['email_mandante'],
						'cargo_mandante' => $_POST['cargo'],
						'clave' => hash('sha512',$_POST['pass1']),
						'id_planta' => $_POST['planta_select']
					);
					$this->Usuarios_model->ingresar($data_mandante);
					redirect('administracion/mandantes/agregar/exito', 'refresh');
				}
			}
		}
	}
	
	function plantas_ajax($id){
		$this->load->model("Planta_model");
		echo "<option value=''>Seleccione</option>";
		foreach($this->Planta_model->get_empresa($id) as $e){
			echo "<option value='".$e->id."'>".ucwords(mb_strtolower($e->nombre, 'UTF-8'))."</option>";
		}
	}
	
	function ajax_datos_planta($id){
		$this->load->model("Planta_model");
		$salida = $this->Planta_model->get($id);
		echo json_encode($salida,JSON_FORCE_OBJECT);
	}
	
	function ajax_revisar_codigo($id_planta){
		$this->load->model("Usuarios_model");
		$salida = $this->Usuarios_model->total_planta($id_planta);
		echo $salida;
	}

}
?>