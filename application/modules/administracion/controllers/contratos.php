<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Contratos extends CI_Controller {
	
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
	
	function index(){
		
	}
	
	public function agregar_variable()
	{
		$base['titulo'] = "Listado de variables para contratos";
		$base['lugar'] = "Listado de variables";
		$this->load->model('Tags_contratos_model');
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$pagina['listado'] = $this->Tags_contratos_model->listar();
		$base['cuerpo'] = $this->load->view('contratos/agregar_variable',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	public function ae_variable($id = false){ //agregar y editar variable
		$this->load->model('Tags_contratos_model');
		
		if($id){
			$var = $this->Tags_contratos_model->get($id);
			$base['titulo'] = "Editar Variable"; 
			$base['nb_var'] = ucwords( mb_strtolower($var->nombre, 'UTF-8'));
			$base['val_var'] = $var->variable;
			$base['action'] = 'administracion/contratos/editar_variable/'.$id;
		}
		else{
			$base['titulo'] = "Crear Variable";
			$base['action'] = 'administracion/contratos/crear_variable'; 
		}
		$this->load->view('contratos/modal_variable',$base);
	}
	
	public function crear_variable(){
		$this->load->model('Tags_contratos_model');
		$data = array(
			'nombre' => mb_strtoupper($_POST['nb_var'], 'UTF-8'),
			'variable' => mb_strtoupper($_POST['val_var'], 'UTF-8')
		);
		$this->Tags_contratos_model->ingresar($data);
		redirect('/administracion/contratos/agregar_variable', 'refresh');
	}
	
	public function editar_variable($id){
		$this->load->model('Tags_contratos_model');
		$data = array(
			'nombre' => mb_strtoupper($_POST['nb_var'], 'UTF-8'),
			'variable' => mb_strtoupper($_POST['val_var'], 'UTF-8')
		);
		$this->Tags_contratos_model->editar($id,$data);
		redirect('/administracion/contratos/agregar_variable', 'refresh');
	}
	public function eliminar_variable($id){
		$this->load->model('Tags_contratos_model');
		$this->Tags_contratos_model->eliminar($id);
	}
	
	public function texto(){
		$base['titulo'] = "Creación de texto y formato para contratos";
		$base['lugar'] = "Creación de contratos";
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$this->load->library('encrypt');
		$this->load->model('Tags_contratos_model');
		
		$pagina['listado_tags'] = $this->Tags_contratos_model->listar();
		$base['cuerpo'] = $this->load->view('contratos/texto',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function guardar_contrato(){
		$this->load->model('Contratos_model');
		if( empty($_POST['nb_contrato']) || empty($_POST['txt_contrato']) || empty($_POST['planta']) ){
			redirect('/administracion/contratos/listado', 'refresh');
		}
		else{
			$data = array(
				'id_empresa_planta' => $_POST['planta'],
				'nombre' => mb_strtoupper($_POST['nb_contrato'], 'UTF-8'),
				'texto' => $_POST['txt_contrato']
			);
			if(!empty($_POST['id_contrato']))
				$this->Contratos_model->editar($_POST['id_contrato'],$data);
			else
				$this->Contratos_model->ingresar($data);
			redirect('/administracion/contratos/listado', 'refresh');
		}
	}
	
	function listado(){
		$base['titulo'] = "Listado de contratos ingresados";
		$base['lugar'] = "Listado de contratos";
		$this->load->model('Contratos_model');
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$pagina['listado'] = $this->Contratos_model->listar();
		$base['cuerpo'] = $this->load->view('contratos/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function listar_contratos(){
		header('Content-Type: text/html; charset=utf-8');
		$this->load->model('Contratos_model');
		$_nombre = 'PAPAS PEPE';
		$_rut = '15.089.595-2';
		foreach($this->Contratos_model->listar() as $l){
			echo 'nombre = '. $l->nombre. '<br/>';
			$txt_salida = str_replace('{NOMBRE}', $_nombre, $l->texto);
			$txt_salida = str_replace('{RUT}', $_rut, $txt_salida);
			echo 'texto = ' . $txt_salida ."<br/>";
		}
	}
	
	function editor_contratos($id = false){
		$base['titulo'] = "Creación de texto y formato para contratos";
		$base['lugar'] = "Creación de contratos";
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$this->load->model('Planta_model');
		$pagina['lista_planta'] = $this->Planta_model->listar();
		if($id){
			$this->load->model('Contratos_model');
			$pagina['texto'] = $this->Contratos_model->get($id);
			$pagina['id_contrato'] = $id;
		}
		$base['cuerpo'] = $this->load->view('contratos/editor2',$pagina,TRUE);
		$this->load->view('layout',$base);
		// $this -> load -> view('contratos/editor2');
	}
	
	function asignar($id_subreq = false, $id_contrato = false){
		//echo $id_subreq;
		$this->load->model('Contratos_model');
		$this->load->model('Tags_contratos_model');
		$this->load->model('Requerimiento_trabajador_model');
		$base['titulo'] = "Asignación de contratos a trabajadores de requerimiento";
		$base['lugar'] = "Asignación de contratos";
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$pagina['id_contrato'] = $id_contrato;
		if($id_contrato){
			$contrato = $this->Contratos_model->get($id_contrato);
			$lista = array();
			$lista_nombre = array();
			$patron1 = "/\{BONO\_(.*)\}/";
			$patron2 = "/{ASIGNACION_(.*)}/";
			preg_match_all($patron1, $contrato->texto,$coincidencias1);
			preg_match_all($patron2, $contrato->texto,$coincidencias2);
			//print_r($coincidencias2[0]);
			foreach($coincidencias1[0] as $c1){
				$lista[] = $c1;
			}
			foreach($coincidencias2[0] as $c2){
				$lista[] = $c2;
			}
			//$lista --> listado de las variables de bonos y asignaciones, se buscan en la base de datos
			$aux = new stdClass();
			foreach($lista as $l){
				$nb = $this->Tags_contratos_model->get_var($l);
				//$lista_nombre[] = ucwords( mb_strtolower($nb->nombre, 'UTF-8')); //guardados los nombres principales de las variables
				$aux->nombre = ucwords( mb_strtolower($nb->nombre, 'UTF-8'));
				$aux->id = $nb->id;
				array_push($lista_nombre,$aux);
				unset($aux);
			}
			$pagina['lista_bonos'] = $lista_nombre;
		}
		$pagina['lista_contratos'] = $this->Contratos_model->listar();
		$pagina['lista_trabajadores'] = $this->Requerimiento_trabajador_model->get_trabajador_subreq($id_subreq);
		$pagina['id_subreq'] = $id_subreq;
		$base['cuerpo'] = $this->load->view('contratos/asignar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function listado_variables(){
		$this->load->model('Tags_contratos_model');
		foreach($this->Tags_contratos_model->listar() as $l){
			echo ucwords( mb_strtolower( $l->nombre, 'UTF-8')).'-'.$l->variable.';';
		}
	}
	
	
	public function guardar_sueldo()
	{
		$this->load->model('Contratos_model');
		$this->load->model('Tags_contratos_model');
		$this->load->model('Sueldos_model');
		$this->load->model('Sueldos_bonos_model');
		$this->load->helper('to_dompdf');
		
		$sueldo_id = array();
		
		foreach($_GET['check'] as $chk => $chv){
			//echo "valor -->".$chv. " indice -->".$chk."<br/>";
			//echo "sueldo -->".$_GET['sueldo'][$chk]."<br/>";
			//echo "cantidad de bonos -->".$_GET['cantidad_bonos']."<br/>";
			$datos = array(
				'id_usuarios' => $chv,
				'id_requerimiento_trabajador' => $_GET['id_subreq'],
				'valor' => $_GET['sueldo'][$chk]
			);
			$id_sueldo = $this->Sueldos_model->ingresar($datos);
			$sueldo_id[] = $id_sueldo;
			for($i=0;$i<$_GET['cantidad_bonos'];$i++){
				//echo "bono ".$i."-->".$_GET['bono_'.$i][$chk]." id bono -->".$_GET['contrato_'.$i][$chk]."<br/>";
				$data = array(
					'id_sueldos' => $id_sueldo,
					'id_tags_contratos' => $_GET['contrato_'.$i][$chk],
					'valor' => $_GET['bono_'.$i][$chk]
				);
				$this->Sueldos_bonos_model->ingresar($data);
			}
		}
		foreach($sueldo_id as $sid){
			$sueldo = $this->Sueldos_bonos_model->get($sid);
			
		}
	}
	
	public function test(){
		$this->load->view('contratos/imprimir');
	}
	
	
	public function obtener_bono($id)
	{
		$this->load->model('Contratos_model');
		$this->load->model('Tags_contratos_model');
		
		$contrato = $this->Contratos_model->get($id);
		$lista = array();
		$lista_nombre = array();
		$patron1 = "/\{BONO\_(.*)\}/";
		$patron2 = "/{ASIGNACION_(.*)}/";
		preg_match_all($patron1, $contrato->texto,$coincidencias1);
		preg_match_all($patron2, $contrato->texto,$coincidencias2);
		//print_r($coincidencias2[0]);
		foreach($coincidencias1[0] as $c1){
			$lista[] = $c1;
		}
		foreach($coincidencias2[0] as $c2){
			$lista[] = $c2;
		}
		//$lista --> listado de las variables de bonos y asignaciones, se buscan en la base de datos
		foreach($lista as $l){
			$nb = $this->Tags_contratos_model->get_var($l);
			$lista_nombre[] = ucwords( mb_strtolower($nb->nombre, 'UTF-8')); //guardados los nombres principales de las variables
		}
		echo json_encode($lista_nombre);
	}
}
?>