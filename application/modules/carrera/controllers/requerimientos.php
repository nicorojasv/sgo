<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

$archivo_numero_letras = "extras/contratos/numero_letras.php";
$autoloader = "extras/contratos/PHPWord-master/src/PhpWord/Autoloader.php";
require_once (BASE_URL2.$autoloader);
require_once (BASE_URL2.$archivo_numero_letras);
\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\TemplateProcessor;

class Requerimientos extends CI_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 12)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_logistica_servicios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 14)
			$this->menu = $this->load->view('layout2.0/menus/carrera_menu_admin','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 15)
			$this->menu = $this->load->view('layout2.0/menus/carrera_menu_admin_supervisor','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 11)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_rrhh','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 16)
			$this->menu = $this->load->view('layout2.0/menus/menu_marina_supervisor','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 4)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_externo','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif( $this->session->userdata('id') == 120)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_psicologo','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
			elseif($this->session->userdata('tipo_usuario') == 18)
			$this->menu = $this->load->view('layout2.0/menus/menu_carrera','',TRUE);
		
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		redirect('carrera/requerimientos/listado', 'refresh');
	}

	function agregar(){
		$base = array(
			'head_titulo' => "Agregar Requerimiento - Sistema EST",
			'titulo' => "Publicacion de requerimiento",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/requerimientos/listado','txt' => 'Listado Requerimientos'), array('url'=>'','txt'=>'Crear Requerimiento' )),
			'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
				'js/form-wizard.js','plugins/select2/select2.min.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/requerimiento.js'),
			'css' => array('plugins/datepicker/css/datepicker.css','plugins/select2/select2.css','plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'menu' => $this->menu
		);
		$pagina['soloParaHoraFecha']= true;
		$this->load->model("Areas_model");
		$this->load->model("carrera/Cargos_model");
		$this->load->model('carrera/Empresas_model');
		$this->load->model('carrera/Centrocostos_model');
		$this->load->model("carrera/Empresa_planta_model");
		//$this->load->model("carrera/Relacion_usuario_planta_model");
		$this->load->model('carrera/Requerimientos_model');
		$pagina['listado_areas'] = $this->Areas_model->lista_orden_nombre();
		$pagina['listado_cargos'] = $this->Cargos_model->lista_orden_nombre();
		$pagina['listado_empresa'] = $this->Empresas_model->listar();
		$pagina['listado_centro_costo'] = $this->Centrocostos_model->listar();
		$pagina['unidad_negocio'] = $this->Empresa_planta_model->listar();
		$base['cuerpo'] = $this->load->view('requerimientos/crear_requerimiento',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function asignacion($id){
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$this->load->model('carrera/Requerimientos_model');
		$this->load->model('carrera/Empresa_planta_model');
		$this->load->model('carrera/Areas_model');
		$this->load->model('carrera/Cargos_model');
		$this->load->model('carrera/Requerimiento_asc_trabajadores_model');

		$datos_req = $this->Requerimientos_model->get_req_planta($id);
		$planta_id = (isset($datos_req->planta_id)?$datos_req->planta_id:"");

		$base = array(
			'head_titulo' => "Agregar Area/Cargos al Requerimiento - Sistema EST",
			'titulo' => "Asignacion area/cargo de requerimientos",
			'subtitulo' => '',
			'side_bar' => true,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/requerimientos/listado','txt' => 'Listado Requerimientos'), array('url'=>'','txt'=>'Asignar Areas - Cargos Requerimiento' )),
			'menu' => $this->menu
		);

		$lista = array();
		foreach ($this->Requerimientos_model->get_result($id) as $l){
			$aux = new stdClass();
			$get_empresa = $this->Empresa_planta_model->get($l->planta_id);
			$aux->id = $l->id;
			$aux->nombre = (isset($l->nombre))?$l->nombre:'';
			$aux->nombre_empresa = (isset($get_empresa->nombre))?$get_empresa->nombre:'';
			$aux->f_solicitud = (isset($l->f_solicitud))?$l->f_solicitud:'';
			$aux->regimen = (isset($l->regimen))?$l->regimen:'';
			$aux->f_inicio = (isset($l->f_inicio))?$l->f_inicio:'';
			$aux->f_fin = (isset($l->f_fin))?$l->f_fin:'';
			$aux->causal = (isset($l->causal))?$l->causal:'';
			$aux->motivo = (isset($l->motivo))?$l->motivo:'';
			array_push($lista,$aux);
			unset($aux);
		}

		$lista_aux = array();
		foreach ($this->Requerimiento_area_cargo_model->get_requerimiento($id) as $r){
			$aux1 = new stdClass();
			$aux1->id = $r->id;
			$get_area = $this->Areas_model->r_get($r->areas_id);
			$get_cargo = $this->Cargos_model->r_get($r->cargos_id);
			$aux1->nombre_area = (isset($get_area->nombre))?$get_area->nombre:'';
			$aux1->nombre_cargo = (isset($get_cargo->nombre))?$get_cargo->nombre:'';
			$aux1->cantidad = (isset($r->cantidad))?$r->cantidad:'';
			$aux1->valor_aprox = (isset($r->valor_aprox))?$r->valor_aprox:'';
			$p_asignadas = count($this->Requerimiento_asc_trabajadores_model->get_cargo_area($r->id));
			$aux1->asignadas = $p_asignadas;
			array_push($lista_aux,$aux1);
			unset($aux1);
		}

		$pagina['requerimiento'] = $lista;
		$pagina['area_cargos_requerimiento'] = $lista_aux;
		$pagina['id_req'] = $id;
		$pagina['areas'] = $this->Areas_model->lista_orden_nombre();
		$pagina['cargos'] = $this->Cargos_model->lista_orden_nombre();
		$base['cuerpo'] = $this->load->view('carrera/requerimientos/asignar_area_cargo_requerimiento',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_area_cargo_req(){
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$id_req = $_POST['id_req'];
		$datos = array(
			"requerimiento_id" => $id_req,
			"areas_id" => $_POST['area'],
			"cargos_id" => $_POST['cargo'],
			"cantidad" => $_POST['cantidad'],
			"valor_aprox" => $_POST['valor'],
		);
		$this->Requerimiento_area_cargo_model->ingresar($datos);
		echo '<script>alert("Area/Cargo del Requerimiento Ingresado Exitosamente");</script>';
		redirect('carrera/requerimientos/asignacion/'.$id_req.'', 'refresh');
	}

	function eliminar_area_cargo_req($id_area_cargo, $id_req){
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$this->Requerimiento_area_cargo_model->eliminar($id_area_cargo);
		redirect('carrera/requerimientos/asignacion/'.$id_req, 'refresh');
	}

	function listado($fecha = false){
		$base = array(
			'head_titulo' => "Lista de Requerimientos - Sistema EST",
			'titulo' => "Listado de requerimientos",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Requerimientos' )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js','js/exportarExcelcarrera.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$this->load->model("carrera/Requerimientos_model");
		$this->load->model('carrera/Empresas_model');
		$this->load->model('carrera/Empresa_planta_model');

		if ($fecha =='historico') {
			$requerimientos = $this->Requerimientos_model->r_listar_order_estado();
			$pagina['mes'] = 'historico';
		}elseif($fecha){
			$fechaI = new DateTime($fecha);
			$fechaI->modify('first day of this month');
			$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
			$fechaT = new DateTime($fecha);
			$fechaT->modify('last day of this month');
			$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31
			//$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas($fechaInicio, $fechaTermino);
			$requerimientos = $this->Requerimientos_model->r_listar_order_estado_fecha($fechaInicio, $fechaTermino);
			$f= explode("-", $fecha);
				$mes =$f[1];
			setlocale(LC_TIME, 'spanish');// para que los meses sean escritos en español
			$monthNum  = $mes;
			$dateObj   = DateTime::createFromFormat('!m', $monthNum);
			$nombreDelMes = strftime('%B', $dateObj->getTimestamp());
			$pagina['mes']= $nombreDelMes;
		}else{
			$fecha = date('Y-m-d');
			$fechaI = new DateTime($fecha);
				$fechaI->modify('first day of this month');
				$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
			$fechaT = new DateTime($fecha);
				$fechaT->modify('last day of this month');
				$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31
				$requerimientos = $this->Requerimientos_model->r_listar_order_estado_fecha($fechaInicio, $fechaTermino);
			setlocale(LC_TIME, 'spanish');
			$monthNum  = date('m');
			$dateObj   = DateTime::createFromFormat('!m', $monthNum);
			$nombreDelMes = strftime('%B', $dateObj->getTimestamp());
			$pagina['mes']= $nombreDelMes;
		}
		$lista = array();
		foreach ($requerimientos as $l){
			$dotacion = 0;

			$id_requerimiento = (isset($l->id))?$l->id:'0';
			$e = $this->Empresas_model->get($l->empresa_id);
			$p = $this->Empresa_planta_model->get($l->planta_id);
			$ac = $this->Requerimiento_area_cargo_model->get_requerimiento($id_requerimiento);
			$aux = new stdClass();
			$aux->id = $id_requerimiento;
			$aux->nombre = (isset($l->nombre))?$l->nombre:'';
			$aux->empresa = (isset($e->razon_social))?$e->razon_social:'';
			$aux->planta = (isset($p->nombre))?$p->nombre:'';
			$aux->regimen = (isset($l->regimen))?$l->regimen:'';
			$aux->f_solicitud = (isset($l->f_solicitud))?$l->f_solicitud:'';
			$aux->f_inicio = (isset($l->f_inicio))?$l->f_inicio:'';
			$aux->f_fin = (isset($l->f_fin))?$l->f_fin:'';
			$aux->causal = (isset($l->causal))?$l->causal:'';
			$aux->motivo = (isset($l->motivo))?$l->motivo:'';
			$aux->comentario = (isset($l->comentario))?$l->comentario:'';
			$aux->version = (isset($l->version))?$l->version:'';
			$aux->estado = (isset($l->estado))?$l->estado:'';
			foreach ($ac as $ac) {
				$dotacion += $ac->cantidad;
			}
			$aux->dotacion = $dotacion;
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['listado'] = $lista;
		$base['cuerpo'] = $this->load->view('carrera/requerimientos/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function cambiar_estados_requerimientos(){
		$this->load->model("carrera/Requerimientos_model");

		if (!empty($_POST['requerimientos'])?$_POST['requerimientos']:false){
			foreach($_POST['requerimientos'] as $c){
				$data = array(
					"estado" => '0',
				);
				$this->Requerimientos_model->actualizar($c, $data);
			}
		}

		if (!empty($_POST['check_estado'])?$_POST['check_estado']:false){
			foreach($_POST['check_estado'] as $c){
				$data = array(
					"estado" => '1',
				);
				$this->Requerimientos_model->actualizar($c, $data);
			}
		}
		echo "<script>alert('Requerimientos Actualizados Exitosamente')</script>";
		redirect('carrera/requerimientos/listado', 'refresh');
	}

	function editar_area_cargo_requerimiento($id_area_cargo, $id_req){
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$this->load->model('carrera/Areas_model');
		$this->load->model('carrera/Cargos_model');
		$listado = array();
		foreach($this->Requerimiento_area_cargo_model->get_result($id_area_cargo) as $r){
			$get_area = $this->Areas_model->r_get($r->areas_id);
			$get_cargo = $this->Cargos_model->r_get($r->cargos_id);
			$aux = new stdClass();
			$aux->id = $r->id;
			$aux->requerimiento_id = $r->requerimiento_id;
			$aux->areas_id = $r->areas_id;
			$aux->nombre_area = (isset($get_area->nombre)?$get_area->nombre:"");
			$aux->cargos_id = $r->cargos_id;
			$aux->nombre_cargo = (isset($get_cargo->nombre)?$get_cargo->nombre:"");
			$aux->cantidad = $r->cantidad;
			$aux->valor = $r->valor_aprox;
			array_push($listado,$aux);
		}
		$pagina['datos_area_cargo_req'] = $listado;
		$pagina['areas'] = $this->Areas_model->lista_orden_nombre();
		$pagina['cargos'] = $this->Cargos_model->lista_orden_nombre();
		$this->load->view('requerimientos/modal_editar_datos_area_cargo_requerimiento', $pagina);
	}

	function editar_requerimiento($id){
		$this->load->model("carrera/Requerimientos_model");
		$this->load->model("carrera/Empresa_planta_model");
		$this->load->model("carrera/Empresas_model");
		$pagina['listado_empresa'] = $this->Empresas_model->listar();
		$pagina['unidad_negocio'] = $this->Empresa_planta_model->listar();
		$pagina['listado'] = $this->Requerimientos_model->get_result($id);
		$this->load->view('requerimientos/modal_editar_datos_requerimiento', $pagina);
	}

	function actualizar_requerimiento(){
		$this->load->model("carrera/Requerimientos_model");
		$id_req = $_POST['id_req'];

		$datos = array(
			"codigo_requerimiento" => $_POST['codigo'],
			'codigo_centro_costo' => $_POST['centrocosto'],
			"nombre" => $_POST['nombre'],
			"f_solicitud" => $_POST['f_solicitud'],
			'empresa_id' => $_POST['select_empresa'],
			"planta_id" => $_POST['select_planta'],
			"regimen" => $_POST['select_regimen'],
			"f_inicio" => $_POST['f_inicio'],
			"f_fin" => $_POST['f_fin'],
			"causal" => $_POST['causal'],
			"motivo" => $_POST['motivo'],
			"comentario" => $_POST['comentario'],
		);

		$this->Requerimientos_model->actualizar($id_req, $datos);
		echo '<script>alert("Requerimiento Actualizado Exitosamente");</script>';
		redirect('carrera/requerimientos/listado', 'refresh');
	}

	function actualizar_area_cargo_requerimiento(){
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$id_req = $_POST['id_req'];
		$id_area_cargo = $_POST['id_area_cargo'];

		$datos = array(
			"areas_id" => $_POST['area'],
			"cargos_id" => $_POST['cargo'],
			"cantidad" => $_POST['cantidad'],
			"valor_aprox" => $_POST['valor'],
			);

		$this->Requerimiento_area_cargo_model->actualizar($datos, $id_area_cargo);
		echo '<script>alert("Areas/Cargos del Requerimiento Actualizado Exitosamente");</script>';
		redirect('carrera/requerimientos/asignacion/'.$id_req.'', 'refresh');
	}

	function guardar_datos_requerimiento(){
		$this->load->model("carrera/Empresa_planta_model");
		$this->load->model("carrera/Requerimientos_model");
		//$f_solicitud = date('Y-m-d',strtotime($_POST['f_solicitud'])); 
		//$hora = date('H:i:s',strtotime($_POST['f_solicitud']));
		$f_d = explode('-',$_POST['fdesde']);
		$fdesde = $f_d[2].'-'.$f_d[1].'-'.$f_d[0];

		$f_h = explode('-',$_POST['fhasta']);
		$fhasta = $f_h[2].'-'.$f_h[1].'-'.$f_h[0];

		$data = array(
			'codigo_requerimiento' => $_POST['codigo_requerimiento'],
			'codigo_centro_costo' => $_POST['codigo_centro_costo'],
			'nombre' => strtoupper($_POST['n_solicitud']),
			'f_solicitud' => $_POST['f_solicitud'],
			'empresa_id' => $_POST['select_empresa'],
			'centro_costo_id' => NULL,
			'planta_id' => $_POST['select_planta'],
			'regimen' => $_POST['select_regimen'],
			//'fecha_creacion' => date('Y-m-d'),
			'f_inicio' => $fdesde,
			'f_fin' => $fhasta,
			'causal' => $_POST['causal'],
			'motivo' => $_POST['motivo'],
			'comentario' => $_POST['comentarios'],
			'estado' => 1
		);
		$id_req = $this->Requerimientos_model->ingresar($data);
		$this->session->set_userdata('reqCreado',true);
		//echo "<script>alert('Requerimiento Guardado Exitosamente')</script>";
		redirect('carrera/requerimientos/asignacion/'.$id_req, 'refresh');
	}

	function usuarios_requerimiento($id_area_cargo = false, $id_usuario = FALSE){
		if (!$id_area_cargo) {
			redirect(base_url(),'refresh');
		}
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$this->load->model("carrera/Requerimientos_model");
		$this->load->model('carrera/Archivos_trab_model');
		$this->load->model('carrera/Empresas_model');
		$this->load->model("carrera/Evaluaciones_model");
		$this->load->model("carrera/Usuarios_model");
		$this->load->model('carrera/Planta_model');
		$this->load->model("carrera/Areas_model");
		$this->load->model("carrera/Cargos_model");
		$this->load->model("carrera/Empresa_planta_model");
		$this->load->model("carrera/Listanegra_model");
		$this->load->model("carrera/Solicitud_revision_examenes_model");


		$r_area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);

		if( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11){
			$base = array(
				'head_titulo' => "Sistema carrera",
				'titulo' => "Usuarios asignados",
				'subtitulo' => '',
				'side_bar' => false,
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/requerimiento/asignacion/'.(isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0').'','txt' => 'Area-Cargo Requerimiento'), array('url'=>'','txt'=>'Lista de usuarios' )),
				'menu' => $this->menu,
				'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_req.js','js/si_validaciones.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			);
		}else{
			$base = array(
				'head_titulo' => "Sistema carrera",
				'titulo' => "Usuarios asignados",
				'subtitulo' => '',
				'side_bar' => false,
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/requerimiento/listado','txt' => 'Requerimientos'), array('url'=>'carrera/requerimiento/asignacion/'.(isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0').'','txt' => 'Area-Cargo Requerimiento'), array('url'=>'','txt'=>'Lista de usuarios' )),
				'menu' => $this->menu,
				'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','js/lista_usuarios_req.js','js/si_validaciones.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			);
		}

		$listado = array();
		$pagina['id_requerimiento'] = (isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0');
		$reque = $this->Requerimientos_model->get($r_area_cargo->requerimiento_id);
		$pagina['nombre_req'] = isset($reque->nombre)?$reque->nombre:'';
		$pagina['empresa'] = $this->Empresas_model->get($reque->empresa_id)->razon_social;
		$pagina['centro_costo'] = $this->Empresa_planta_model->get_planta_centro_costo($reque->planta_id)->desc_centrocosto;
		$pagina['planta'] = $this->Planta_model->get($reque->planta_id)->nombre;
		$pagina['fecha'] = $reque->f_solicitud;
		$pagina['fecha_inicio'] = $reque->f_inicio;
		$pagina['fecha_termino'] = $reque->f_fin;
		$pagina['area_cargo'] = $id_area_cargo;
		$pagina['area'] = $this->Areas_model->r_get($r_area_cargo->areas_id)->nombre;
		$pagina['cargo'] = $this->Cargos_model->r_get($r_area_cargo->cargos_id)->nombre;
		$pagina['paso_usuario'] =  ($id_usuario)?$id_usuario:FALSE;
		$pagina['cantidad'] = $r_area_cargo->cantidad;
		$fecha_termino_req = $reque->f_fin;
		$fecha_inicio_req = $reque->f_inicio;

		$i = 0;
		foreach($this->Requerimiento_asc_trabajadores_model->get_cargo_area($id_area_cargo) as $r){
			$aux = new stdClass();
			
			$estado_envio = 0;

			$usr = $this->Usuarios_model->get($r->usuario_id);
			
			$ar_contrato = $this->Archivos_trab_model->get_archivo($r->usuario_id,15);
			$ar_certificado = $this->Archivos_trab_model->get_archivo($r->usuario_id,9);
			$aux->id = $r->id;
			$aux->id_req = $id_area_cargo;
			$aux->usuario_id = $r->usuario_id;
			$aux->nombre = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
			$aux->fecha = $r->fecha;
			$aux->referido = $r->referido;
			$aux->contacto = $r->contacto;
			$aux->disponibilidad = $r->disponibilidad;
			$aux->contrato = $r->contrato;
			$aux->status = $r->status;

			
			$preoc = $this->Evaluaciones_model->get_una_preocupacional($r->usuario_id);
			$aux->preocupacional = $preoc;


			$id_asc_trabajador = isset($r->id)?$r->id:'';
			$id_requerimiento = (isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0');
			$get_solicitud = $this->Solicitud_revision_examenes_model->get_usu_req($r->usuario_id, $id_requerimiento, $id_asc_trabajador);
			$id_solicitud_revision = isset($get_solicitud->id)?$get_solicitud->id:'';
			
			$id_preo = isset($preoc->preo_id)?$preoc->preo_id:'';
			$id_psicol = isset($psicol->eval_psic_id)?$psicol->eval_psic_id:'';


			$estado_sre_preo = isset($get_sre_req_preo->estado)?$get_sre_req_preo->estado:NULL;
			$estado_sre_psicol = isset($get_sre_req_psicol->estado)?$get_sre_req_psicol->estado:NULL;


			if($estado_sre_preo == NULL)
				$aux->badge_preo = "<span class='badge' style='background-color:#000000'>NG</span>";
			elseif($estado_sre_preo == 0)
				$aux->badge_preo = "<span class='badge' style='background-color:#D7DF01'>EP</span>";
			elseif($estado_sre_preo == 1)
				$aux->badge_preo = "<span class='badge' style='background-color:green'>A</span>";
			elseif($estado_sre_preo == 2)
				$aux->badge_preo = "<span class='badge' style='background-color:red'>R</span>";
			elseif($estado_sre_preo == 3)
				$aux->badge_preo = "<span class='badge' style='background-color:#886A08'>NA</span>";
			
			if($estado_sre_psicol == NULL)
				$aux->badge_psicol = "<span class='badge' style='background-color:#000000'>NG</span>";
			elseif($estado_sre_psicol == 0)
				$aux->badge_psicol = "<span class='badge' style='background-color:#D7DF01'>EP</span>";
			elseif($estado_sre_psicol == 1)
				$aux->badge_psicol = "<span class='badge' style='background-color:green'>A</span>";
			elseif($estado_sre_psicol == 2)
				$aux->badge_psicol = "<span class='badge' style='background-color:red'>R</span>";
			elseif($estado_sre_psicol == 3)
				$aux->badge_psicol = "<span class='badge' style='background-color:#886A08'>NA</span>";

			$examen_req = $this->Evaluaciones_model->get_una_preocupacional_requerimiento($r->usuario_id, $fecha_inicio_req, $fecha_termino_req);
			$get_estado_inicio_examen = isset($examen_req->estado_inicio_preo)?$examen_req->estado_inicio_preo:"";
			$estado_inicio_examen = $get_estado_inicio_examen + 365; 
			$get_estado_termino_examen = isset($examen_req->estado_fin_preo)?$examen_req->estado_fin_preo:"";
			$estado_termino_examen = $get_estado_termino_examen + 365;

			

			

			if(!$estado_inicio_examen){
				$aux->color_examen = "";
				$aux->preocupacional = "";
			}else{
				if($estado_inicio_examen >= 0 and $estado_termino_examen <= 0){
					$color_examen = "#FFBF00";
					$dedo_preo = "fa fa-thumbs-up";
				}elseif($estado_inicio_examen <= 0){
					$color_examen = "red";
					$dedo_preo = "fa fa-thumbs-down";
				}elseif($estado_termino_examen >= 0){
					$color_examen = "green";
					$dedo_preo = "fa fa-thumbs-up";
				}else{
					$color_examen = "red";
					$dedo_preo = "fa fa-thumbs-down";
				}

				$aux->color_examen = $color_examen;
				$aux->dedo_preo = $dedo_preo;
			}

			$aux->contrato = $ar_contrato;
			$aux->certificado = $ar_certificado;
			$aux->comentario = $r->comentario;
			$aux->jefe_area = $r->jefe_area;
		
			$aux->valor_examen = (isset($preoc->valor_examen)?$preoc->valor_examen:"0");

			$contratos_usu = $this->Requerimiento_Usuario_Archivo_model->get_result_tipo_archivo_usuario($r->usuario_id, $id_asc_trabajador, 1);
			/*$anexos_usu = $this->Requerimiento_Usuario_Archivo_model->get_result_tipo_archivo_usuario($r->usuario_id, $id_asc_trabajador, 2);*/
			$anexos_usu = $this->Requerimiento_Usuario_Archivo_model->get_anexos($r->usuario_id, $id_asc_trabajador);
			$cantidad_contratos_realizados = 0;
			$cantidad_contratos_realizados_generados = 0;
			if($contratos_usu != FALSE){
				foreach($contratos_usu as $row){
					$cantidad_contratos_realizados += 1;

					if($row->estado_generacion_contrato == 1)
						$cantidad_contratos_realizados_generados += 1;
				}
			}

			if($anexos_usu != FALSE){
				foreach($anexos_usu as $row2){
					$cantidad_contratos_realizados += 1;

					if($row2->estado_generacion_contrato == 1)
						$cantidad_contratos_realizados_generados += 1;
				}
			}

			$aux->cantidad_contratos_realizados = $cantidad_contratos_realizados;
			$aux->cantidad_contratos_realizados_generados = $cantidad_contratos_realizados_generados;

			$i++;
			array_push($listado,$aux);
		}
		$pagina['listado'] = $listado;
		$pagina['agregados'] = $i;
		$base['cuerpo'] = $this->load->view('carrera/requerimientos/usuarios_requerimiento',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function usuarios_requerimientos_listado($id_area_cargo){
		$this->load->model('carrera/Requerimiento_area_cargo_model');
		$this->load->model('carrera/Requerimientos_model');
		$this->load->model('carrera/Empresa_planta_model');
		$this->load->model('carrera/Areas_model');
		$this->load->model('carrera/Cargos_model');
		$this->load->model('carrera/Requerimiento_asc_trabajadores_model');
		$this->load->model('carrera/Usuarios_model');

		$area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
		$id_req = isset($area_cargo->requerimiento_id)?$area_cargo->requerimiento_id:0;

		$base = array(
			'head_titulo' => "Lista de Trabajadores - Sistema EST",
			'titulo' => "Listado de Trabajadores",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/requerimientos/usuarios_requerimiento/'.$id_area_cargo."", 'txt'=>'Volver a la Area - Cargo del Requerimiento'), array('url'=>'','txt'=>"Listado Trabajadores requerimiento ".$this->Requerimientos_model->get($id_req)->nombre."" )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','js/lista_req.js', 'js/usuarios_requerimientos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css'),
		);

		$req = $this->Requerimientos_model->get($id_req);
		$planta = $this->Empresa_planta_model->get($req->planta_id);
		$area = $this->Areas_model->r_get($area_cargo->areas_id);
		$cargo = $this->Cargos_model->r_get($area_cargo->cargos_id);
		$r_area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
		$aux_req = new stdClass();
		$aux_req->nombre = $req->nombre;
		$aux_req->planta = $planta->nombre;
		$aux_req->version = $req->version;
		$aux_req->area = $area->nombre;
		$aux_req->cargo = $cargo->nombre;
		$aux_req->cantidad = $r_area_cargo->cantidad;
		$aux_req->agregados = $this->Requerimiento_asc_trabajadores_model->contador($id_area_cargo);

		$listado_usuarios = $this->Usuarios_model->listar_trabajadores_orden_paterno_activos();
		$lista = array();
		if($listado_usuarios != FALSE){
			foreach ($listado_usuarios as $l){
				$aux = new stdClass();
				$aux->id_usuario = $l->id;
				$aux->rut_usuario = $l->rut_usuario;
				$aux->nombre = $l->nombres;
				$aux->ap_paterno = $l->paterno;
				$aux->ap_materno = $l->materno;
				$aux->especialidad = $l->especialidad;
				$aux->observacion = $l->observacion;
				array_push($lista,$aux);
				unset($aux);
			}
		}

		$pagina['datos_req'] = $aux_req;
		$pagina['lista_aux'] = $lista;
		$pagina['id_area_cargo'] = $id_area_cargo;
		$base['cuerpo'] = $this->load->view('carrera/requerimientos/listado_usuarios_req',$pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function agregar_usuarios_requerimiento(){
		$id_area_cargo =  $_POST['id_area_cargo'];
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");

		if (!empty($_POST['check_usuario'])?$_POST['check_usuario']:false){
			foreach($_POST['check_usuario'] as $c){
				$data = array(
					"requerimiento_area_cargo_id" => $id_area_cargo,
					"usuario_id" => $c,
					"quien" => '',
					"fecha" => date('Y-m-d'),
				);
				$this->Requerimiento_asc_trabajadores_model->ingresar($data);
			}
		}
		echo "<script>alert('Usuarios Agregados Exitosamente')</script>";
		redirect('carrera/requerimientos/usuarios_requerimiento/'.$id_area_cargo, 'refresh');
	}

	function contratos_req_trabajador($id_usuario,$id_asc_area_req,$id_area_cargo_req = FALSE,$agregandoAnexo= FALSE){
		$this->load->model("carrera/requerimiento_usuario_archivo_model");
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/ciudades_model");
		$this->load->model("carrera/Afp_model");
		$this->load->model("carrera/Salud_model");
		$this->load->model("carrera/estado_civil_model");
		$this->load->model("carrera/Requerimientos_model");
		$this->load->model("carrera/Nivel_estudios_model");
		$this->load->model("carrera/Areas_model");
		$this->load->model("carrera/Cargos_model");
		$this->load->model("carrera/Empresas_model");
		$this->load->model("carrera/Empresa_planta_model");
		$this->load->model("carrera/regiones_model");
		$this->load->model("carrera/Tipo_gratificacion_model");
		$this->load->model("carrera/Solicitud_revision_examenes_model");
		$this->load->model("carrera/Descripcion_horarios_model");

		$base = array(
			'head_titulo' => "Lista de Contratos - Sistema EST",
			'titulo' => "Listado de Contratos y Anexos",
			'subtitulo' => '',
			'side_bar' => true,
			'menu' => $this->menu,
			'js' => array('js/confirm.js','js/lista_req.js', 'js/usuarios_requerimientos.js','js/valida_fecha_contrato.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css'),
			'lugar' => array(
							array('url' => 'usuarios/home', 'txt' => 'Inicio'), 
							array('url'=>'carrera/requerimientos/asignacion/'.(isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0').'','txt' => 'Area-Cargo Requerimiento'), 
							array('url'=>'carrera/requerimientos/usuarios_requerimiento/'.$id_area_cargo_req,'txt'=>'Lista de usuarios' ), 
							array('url'=>'','txt'=>'Contrato de Trabajo')),
		);

		$usr = $this->Usuarios_model->get($id_usuario);
		$pagina['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$contratos_usu = $this->requerimiento_usuario_archivo_model->get_result_tipo_archivo_usuario($id_usuario, $id_asc_area_req, 1);
		//var_dump($contratos_usu);return false;
		$anexos_usu = $this->requerimiento_usuario_archivo_model->get_anexos($id_usuario, $id_asc_area_req);

		$datos_generales = array();
		if($usr != FALSE){
			$aux = new StdClass();
			$id_ciudad = isset($usr->id_ciudad)?$usr->id_ciudad:'';
			$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
			$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
			$id_estado_civil = isset($usr->id_estado_civil)?$usr->id_estado_civil:'';
			$id_estudios = isset($usr->id_nivel_estudios)?$usr->id_nivel_estudios:'';
			$get_ciudad = $this->ciudades_model->get($id_ciudad);
			$get_nivel_estudios = $this->Nivel_estudios_model->get($id_estudios);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->estado_civil_model->get($id_estado_civil);
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_asc_area_req);
			$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo_req);
			$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
			$id_area = isset($get_area_cargo->areas_id)?$get_area_cargo->areas_id:'';
			$id_cargo = isset($get_area_cargo->cargos_id)?$get_area_cargo->cargos_id:'';
			$get_requerimiento = $this->Requerimientos_model->get($id_requerimiento);
			$get_area = $this->Areas_model->r_get($id_area);
			$get_cargo = $this->Cargos_model->r_get($id_cargo);
			$id_centro_costo = isset($get_requerimiento->empresa_id)?$get_requerimiento->empresa_id:'';
			$id_planta = isset($get_requerimiento->planta_id)?$get_requerimiento->planta_id:'';
			$get_centro_costo = $this->Empresas_model->get($id_centro_costo);
			$get_planta = $this->Empresa_planta_model->get($id_planta);
			$id_region_planta = isset($get_planta->id_regiones)?$get_planta->id_regiones:'';
			$id_ciudad_planta = isset($get_planta->id_ciudad)?$get_planta->id_ciudad:'';
			$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
			$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
			$get_region_planta = $this->regiones_model->get($id_region_planta);
			$get_ciudad_planta = $this->ciudades_model->get($id_ciudad_planta);

			$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->ciudad_planta = isset($get_ciudad_planta->desc_ciudades)?$get_ciudad_planta->desc_ciudades:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
			$aux->id_empresa = isset($get_centro_costo->id)?$get_centro_costo->id:'';//Id de Empresa para validar examenes
			$aux->nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
			$aux->direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
			$aux->nombre_req = isset($get_requerimiento->nombre)?$get_requerimiento->nombre:'';
			$aux->referido = isset($get_asc_trab->referido)?$get_asc_trab->referido:'';
			$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
			$aux->area = isset($get_area->nombre)?$get_area->nombre:'';

			$nombres = isset($usr->nombres)?$usr->nombres:'';
			$paterno = isset($usr->paterno)?$usr->paterno:'';
			$materno = isset($usr->materno)?$usr->materno:'';
			$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
			$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
			$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
			$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
			$aux->domicilo = isset($usr->direccion)?$usr->direccion:'';
			$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
			$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
			$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
			$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			
			$aux->telefono = isset($usr->fono)?$usr->fono:'';
			$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';

			$revisiones_al_dia = 0;
			$solicitudes_aprobadas = $this->Solicitud_revision_examenes_model->get_usu_req_aprobados_result($id_usuario, $id_requerimiento, $id_asc_area_req);
			if (!empty($solicitudes_aprobadas)){
				foreach ($solicitudes_aprobadas as $d) {
					$revisiones_al_dia += 1;
				}
			}
			array_push($datos_generales, $aux);
			unset($aux);
		}
		
		$fechaComparar ='1999-01-01';
		$lista_aux = array();
		if($contratos_usu != FALSE){
			foreach($contratos_usu as $row){
				$aux = new StdClass();
				$get_jornada = $this->Descripcion_horarios_model->get($row->jornada);
				$aux->id_req_usu_arch = $row->id;
				$aux->usuario_id = $id_usuario;
				$aux->nombre = $row->nombre;
				$aux->url = $row->url;
				$aux->causal = $row->causal;
				$aux->motivo = $row->motivo;
				$aux->fecha_inicio = $row->fecha_inicio;
				$aux->fecha_termino = $row->fecha_termino;
				$aux->fecha_termino2 = $row->fecha_termino2;

				$aux->idAreaCargo = $this->requerimiento_usuario_archivo_model->get_area_cargo($row->requerimiento_asc_trabajadores_id)->requerimiento_area_cargo_id;
				#yayo editado el 16-10-2019  al estar en true se valida que los contratos a crear sean con fecha igual o superior a la actual
				//if (date('Y-m-d') > $aux->fecha_termino) {
				//	$pagina['noCrear']=true;
				//}else{
					$pagina['noCrear']=false;
				//} Fin edicion
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->descripcion_jornada = isset($get_jornada->descripcion)?$get_jornada->descripcion:'';
				$aux->renta_imponible = $row->renta_imponible;
				$aux->estado_generacion_contrato = $row->estado_generacion_contrato;
				if (empty($row->nombre) || $row->estado_aprobacion_revision==1) {
					$aux->estadoContrato= $row->estado_aprobacion_revision;
				}
				$aux->cargarArchivo= $row->estado_aprobacion_revision;
				if ($row->estado_aprobacion_revision==1) {
					$ultimaFecha = $row->fecha_termino;
					if ($fechaComparar < $ultimaFecha) {
						$idParaCartaTermino[0] = $row->id;
						$idParaCartaTermino[1] = $row->fecha_termino;
						$idParaCartaTermino[2] = 1;
						$fechaComparar = $ultimaFecha;
					}
				}else{
						$idParaCartaTermino[0] = null;
						$idParaCartaTermino[1] = null;
						$idParaCartaTermino[2] = null;
				}
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}

		$lista_aux2 = array();
		if($anexos_usu != FALSE){
			foreach($anexos_usu as $row2){
				$aux = new StdClass();
				$aux->id_req_usu_arch = $row2->id;
				$aux->usuario_id = $id_usuario;
				$aux->causal = $row2->causal;
				$aux->fecha_inicio = $row2->fecha_termino_contrato_anterior;
				$aux->fecha_termino = $row2->fecha_termino_nuevo_anexo;
				$aux->fecha_termino2 = $row2->fecha_termino2;
				$aux->nombre = $row2->nombre;
				$aux->url = $row2->url;
				#yayo editado el 16-10-2019  al estar en true se valida que los contratos a crear sean con fecha igual o superior a la actual
				//if (date('Y-m-d') > $aux->fecha_termino) {
				//	$pagina['noCrear']=true;
				//}else{
					$pagina['noCrear']=false;
				//}
				$aux->estado = $row2->estado;
				$aux->estado_generacion_contrato = $row2->estado_generacion_contrato;
				if ($aux->estado==2) {
					$ultimaFecha=$row2->fecha_termino_nuevo_anexo;
					if ($fechaComparar < $ultimaFecha) {
						$idParaCartaTermino[0] = $row2->id;
						$idParaCartaTermino[1] = $row2->fecha_termino_nuevo_anexo;
						$idParaCartaTermino[2] = 2;		
						$fechaComparar = $ultimaFecha;
					}
				}/*else{
					$idParaCartaTermino[0] = null;
					$idParaCartaTermino[1] = null;
					$idParaCartaTermino[2] = null;		
				}*/
				array_push($lista_aux2, $aux);
				unset($aux);
			}
		}
		$idParaCartaTermino = isset($idParaCartaTermino)?$idParaCartaTermino:'';
//18138050*/
		if ($agregandoAnexo) {
			$this->session->set_userdata('abrirModalAnexo',true);
		}
		$pagina['soloParaMarina']=true;
		$pagina['cartaTermino'] = $idParaCartaTermino;
		$pagina['soloParaMarina'] = true;
		$pagina['revisiones_al_dia'] = $revisiones_al_dia;
		$pagina['datos_generales'] = $datos_generales;
		$pagina['contratos'] = $lista_aux;
		$pagina['anexos'] = $lista_aux2;
		$pagina['id_usuario'] = $id_usuario;
		$pagina['id_asc_area_req'] = $id_asc_area_req;
		$pagina['id_area_cargo_req'] = $id_area_cargo_req;
		$base['cuerpo'] = $this->load->view('carrera/requerimientos/documentos_contractuales_contratos_req',$pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function eliminar_contratos_req_trabajador($id_usuario, $id_asc_area_req, $id_area_cargo_req, $id_req_usu_arch){
		$this->load->model('carrera/Requerimiento_Usuario_Archivo_model');
		$this->Requerimiento_Usuario_Archivo_model->eliminar($id_req_usu_arch);
		redirect('carrera/requerimientos/contratos_req_trabajador/'.$id_usuario.'/'.$id_asc_area_req.'/'.$id_area_cargo_req.'', 'refresh');
	}

	function modal_agregar_contrato_anexo($usuario,$tipo,$asc_area, $id_req_area_cargo){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/ciudades_model");
		$this->load->model("carrera/Afp_model");
		$this->load->model("carrera/Salud_model");
		$this->load->model("carrera/estado_civil_model");
		$this->load->model("carrera/Requerimientos_model");
		$this->load->model("carrera/Areas_model");
		$this->load->model("carrera/Cargos_model");
		$this->load->model("carrera/Empresas_model");
		$this->load->model("carrera/Empresa_planta_model");
		$this->load->model("carrera/regiones_model");
		$this->load->model("carrera/Tipo_gratificacion_model");
		$this->load->model("carrera/Descripcion_horarios_model");

		$pagina['usuario']= $usuario;
		$pagina['tipo']= $tipo;
		$pagina['asc_area']= $asc_area;
		
		$get_datos_req = $this->Requerimiento_area_cargo_model->r_get_requerimiento($id_req_area_cargo);
		$pagina['motivo_defecto'] = (isset($get_datos_req->motivo)?$get_datos_req->motivo:'0');
		$pagina['causal_defecto'] = (isset($get_datos_req->causal)?$get_datos_req->causal:'0');

		$existe_anexo = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($usuario, $asc_area, 2);
		$existe_contrato = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($usuario, $asc_area, 1);

		if($existe_anexo == 1){
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit_row($usuario, $asc_area, 2);
		}elseif($existe_contrato == 1){
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit_row($usuario, $asc_area, 1);
		}else{
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit_row($usuario, $asc_area, $tipo);
		}

		$datos_generales = array();
		if($usuario != FALSE){
			$usr = $this->Usuarios_model->get($usuario);
			$aux = new StdClass();
			$id_ciudad = isset($usr->id_ciudad)?$usr->id_ciudad:'';
			$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
			$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
			$id_estado_civil = isset($usr->id_estadocivil)?$usr->id_estadocivil:'';
			$id_estudios = isset($usr->id_estudios)?$usr->id_estudios:'';
			$get_ciudad = $this->ciudades_model->get($id_ciudad);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->estado_civil_model->get($id_estado_civil);
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($asc_area);
			$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_req_area_cargo);
			$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
			$id_area = isset($get_area_cargo->areas_id)?$get_area_cargo->areas_id:'';
			$id_cargo = isset($get_area_cargo->cargos_id)?$get_area_cargo->cargos_id:'';
			$get_requerimiento = $this->Requerimientos_model->get($id_requerimiento);
			$get_area = $this->Areas_model->r_get($id_area);
			$get_cargo = $this->Cargos_model->r_get($id_cargo);
			$id_centro_costo = isset($get_requerimiento->empresa_id)?$get_requerimiento->empresa_id:'';
			$id_planta = isset($get_requerimiento->planta_id)?$get_requerimiento->planta_id:'';
			$get_centro_costo = $this->Empresas_model->get($id_centro_costo);
			$get_planta = $this->Empresa_planta_model->get($id_planta);
			$id_region_planta = isset($get_planta->id_regiones)?$get_planta->id_regiones:'';
			$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
			$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
			$get_region_planta = $this->regiones_model->get($id_region_planta);

			$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
			$aux->id_empresa = isset($get_centro_costo->id)?$get_centro_costo->id:'';
			$aux->nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
			$aux->direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
			$aux->nombre_req = isset($get_requerimiento->nombre)?$get_requerimiento->nombre:'';
			$aux->referido = isset($get_asc_trab->referido)?$get_asc_trab->referido:'';
			$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
			$aux->area = isset($get_area->nombre)?$get_area->nombre:'';

			$nombres = isset($usr->nombres)?$usr->nombres:'';
			$paterno = isset($usr->paterno)?$usr->paterno:'';
			$materno = isset($usr->materno)?$usr->materno:'';
			$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
			$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
			$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
			$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
			$aux->domicilo = isset($usr->direccion)?$usr->direccion:'';
			$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
			$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
			$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
			$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			$aux->telefono = isset($usr->fono)?$usr->fono:'';
			$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';
			array_push($datos_generales, $aux);
			unset($aux);
		}

		$jornada = isset($datos_req->jornada)?$datos_req->jornada:'';
		$get_jornada = $this->Descripcion_horarios_model->get($jornada);
		$tipo_jornada = isset($get_jornada->id_tipo_horario)?$get_jornada->id_tipo_horario:'';
		$id_empresa_planta = isset($get_datos_req->planta_id)?$get_datos_req->planta_id:'';
		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_empresa_planta);
		$pagina['datos_generales'] = $datos_generales;
		$pagina['datos_req'] = $datos_req;
		$pagina['tipo_jornada'] = $tipo_jornada;
		$this->load->view('carrera/requerimientos/modal_agregar_contrato_anexo_doc_contractuales', $pagina);
	}

	function guardar_nuevo_contrato_anexo_doc_contractual($usuario,$tipo,$asc_area){
		
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");
		$this->load->model("carrera/Usuarios_model");

		$id_area_cargo = $this->Requerimiento_asc_trabajadores_model->get($asc_area)->requerimiento_area_cargo_id;

		if (empty($_POST['datos_extras']))
			$vienen_datos = "NO";
		else
			$vienen_datos = "SI";

		if(empty($_POST['ano_fi']) || empty($_POST['mes_fi']) || empty($_POST['dia_fi']) )
			$fecha_inicio = '0000-00-00';
		else
			$fecha_inicio = $_POST['ano_fi'].'-'.$_POST['mes_fi'].'-'.$_POST['dia_fi'];

		if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
			$fecha_termino = '0000-00-00';
		else
			$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

		if($vienen_datos == "SI"){
			$data = array(
				'usuario_id' => $usuario,
				'requerimiento_asc_trabajadores_id' => $asc_area,
				'tipo_archivo_requerimiento_id' => $tipo,
				'causal' => $_POST['causal'],
				'motivo' => $_POST['motivo'],
				'fecha_inicio' => $fecha_inicio,
				'fecha_termino' => $fecha_termino,
				'jornada' => $_POST['jornada'],
				'renta_imponible' => $_POST['renta_imponible'],
				'bono_responsabilidad' => $_POST['bono_responsabilidad'],
				'bono_gestion' => $_POST['bono_gestion'],
				'bono_confianza' => $_POST['bono_confianza'],
				'asignacion_movilizacion' => $_POST['asignacion_movilizacion'],
				'asignacion_colacion' => $_POST['asignacion_colacion'],
				'asignacion_zona' => $_POST['asignacion_zona'],
				'asignacion_herramientas' => $_POST['asignacion_herramientas'],
				'viatico' => $_POST['viatico'],
				'seguro_vida_arauco' => 'SI'
			);
		}else{
			$data = array(
				'usuario_id' => $usuario,
				'requerimiento_asc_trabajadores_id' => $asc_area,
				'tipo_archivo_requerimiento_id' => $tipo
			);
		}
		$this->Requerimiento_Usuario_Archivo_model->ingresar($data);
		redirect('carrera/requerimientos/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
	}

	function modal_administrar_contrato_anexo_doc_general($id_usu_arch,$id_area_cargo){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/ciudades_model");
		$this->load->model("carrera/Afp_model");
		$this->load->model("carrera/Salud_model");
		$this->load->model("carrera/estado_civil_model");
		$this->load->model("carrera/Nivel_estudios_model");
		$this->load->model("carrera/Requerimientos_model");
		$this->load->model("carrera/Areas_model");
		$this->load->model("carrera/Cargos_model");
		$this->load->model("carrera/Empresas_model");
		$this->load->model("carrera/Empresa_planta_model");
		$this->load->model("carrera/regiones_model");
		$this->load->model("carrera/Tipo_gratificacion_model");
		$this->load->model("carrera/Solicitud_revision_examenes_model");
		$this->load->model("carrera/Descripcion_horarios_model");
		$this->load->model("carrera/Sre_evaluacion_req_model");

		$revisiones_al_dia = 0;
		$evaluaciones_rechazados = 0;
		$datos_generales = array();
		if($id_usu_arch != FALSE){
			$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);
			$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
			$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
			$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
			$usr = $this->Usuarios_model->get($id_usuario);

			$aux = new StdClass();
			$id_ciudad = isset($usr->id_ciudad)?$usr->id_ciudad:'';
			$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
			$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
			$id_estado_civil = isset($usr->id_estado_civil)?$usr->id_estado_civil:'';
			$id_estudios = isset($usr->id_nivel_estudios)?$usr->id_nivel_estudios:'';
			$get_ciudad = $this->ciudades_model->get($id_ciudad);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->estado_civil_model->get($id_estado_civil);
			$get_nivel_estudios = $this->Nivel_estudios_model->get($id_estudios);
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);

			$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_req_area_cargo);
			$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
			$id_area = isset($get_area_cargo->areas_id)?$get_area_cargo->areas_id:'';
			$id_cargo = isset($get_area_cargo->cargos_id)?$get_area_cargo->cargos_id:'';
			$get_requerimiento = $this->Requerimientos_model->get($id_requerimiento);
			$get_area = $this->Areas_model->r_get($id_area);
			$get_cargo = $this->Cargos_model->r_get($id_cargo);
			$id_centro_costo = isset($get_requerimiento->empresa_id)?$get_requerimiento->empresa_id:'';
			$id_planta = isset($get_requerimiento->planta_id)?$get_requerimiento->planta_id:'';
			$get_centro_costo = $this->Empresas_model->get($id_centro_costo);
			$get_planta = $this->Empresa_planta_model->get($id_planta);
			$id_region_planta = isset($get_planta->id_regiones)?$get_planta->id_regiones:'';
			$id_ciudad_planta = isset($get_planta->id_ciudades)?$get_planta->id_ciudades:'';
			$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
			$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
			$get_region_planta = $this->regiones_model->get($id_region_planta);
			$get_ciudad_planta = $this->ciudades_model->get($id_ciudad_planta);

			$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
			$aux->descripcion_tipo_gratificacion = isset($get_gratif->descripcion)?$get_gratif->descripcion:'';
			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->ciudad_planta = isset($get_ciudad_planta->desc_ciudades)?$get_ciudad_planta->desc_ciudades:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
			$aux->id_empresa = isset($get_centro_costo->id)?$get_centro_costo->id:'';
			$aux->id_centro_costo = isset($get_centro_costo->id)?$get_centro_costo->id:'';
			$aux->id_planta = $id_planta;
			$aux->nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
			$aux->direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
			$aux->nombre_req = isset($get_requerimiento->nombre)?$get_requerimiento->nombre:'';
			$aux->referido = isset($get_asc_trab->referido)?$get_asc_trab->referido:'';
			$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
			$aux->area = isset($get_area->nombre)?$get_area->nombre:'';

			$nombres = isset($usr->nombres)?$usr->nombres:'';
			$paterno = isset($usr->paterno)?$usr->paterno:'';
			$materno = isset($usr->materno)?$usr->materno:'';
			$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
			$aux->nombre_sin_espacios = $paterno.'_'.$materno;
			$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
			$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
			$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
			$aux->domicilio = isset($usr->direccion)?$usr->direccion:'';
			$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
			$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
			$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
			$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			$aux->telefono = isset($usr->fono)?$usr->fono:'';
			$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';
			$solicitudes_aprobadas = $this->Solicitud_revision_examenes_model->get_usu_req_aprobados_result($id_usuario, $id_requerimiento, $id_req_asc_trabajador);
			if (!empty($solicitudes_aprobadas)){
				foreach ($solicitudes_aprobadas as $d){
					$id_solicitud_revision = $d->id;
					$detalle_solicitud = $this->Sre_evaluacion_req_model->get_id_solicitud($id_solicitud_revision);
					foreach ($detalle_solicitud as $ds){
						if($ds->estado == 2)
							$evaluaciones_rechazados += 1;
					}
					$revisiones_al_dia += 1;
				}
			}
			array_push($datos_generales, $aux);
			unset($aux);
		}

		$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);
		$get_solicitudes_contratos = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_usu_arch);

		$solicitud_existente_contrato = isset($get_solicitudes_contratos->id)?$get_solicitudes_contratos->estado:"N/E";
		$estado_aprobacion_revision = isset($get_usu_archivo->estado_aprobacion_revision)?$get_usu_archivo->estado_aprobacion_revision:0;
		
	

		if($solicitud_existente_contrato == '0' or $solicitud_existente_contrato == '1'  or $estado_aprobacion_revision == '1')
			$estado_bloqueo = "si";
		else
			$estado_bloqueo = "no";

		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_planta);
		$pagina['estado_bloqueo'] = $estado_bloqueo;
		$pagina['solicitud_existente_contrato'] = $solicitud_existente_contrato;
		$pagina['comentarios_existente_contrato'] = isset($get_solicitudes_contratos->observaciones)?$get_solicitudes_contratos->observaciones:'';
		$pagina['datos_generales'] = $datos_generales;
		$pagina['id_usu_arch']= $id_usu_arch;
		$pagina['revisiones_al_dia']= $revisiones_al_dia;
		$pagina['evaluaciones_rechazados']= $evaluaciones_rechazados;
		$pagina['id_area_cargo']= $id_area_cargo;
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_usu_arch);
		

		$this->load->view('carrera/requerimientos/modal_administrar_contrato_anexo_doc_contractuales', $pagina);
	}
	function qwea(){
		$fecha = 
		$contratoHoy = $this->Requerimiento_Usuario_Archivo_model->verificarSitieneMasDeUnContrato(81,$fecha);
		var_dump($contratoHoy);
	}

	function actualizar_contrato_anexo_doc_contractual($id_usu_arch,$id_area_cargo){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$this->load->model("carrera/Descripcion_causal_model");
		$this->load->model("carrera/Descripcion_horarios_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->library('zip');
		$this->load->helper('download');


		if(empty($_POST['ano_fi']) || empty($_POST['mes_fi']) || empty($_POST['dia_fi']) )
			$fecha_inicio = '0000-00-00';
		else
			$fecha_inicio = $_POST['ano_fi'].'-'.$_POST['mes_fi'].'-'.$_POST['dia_fi'];

		if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
			$fecha_termino = '0000-00-00';
		else
			$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

		$causal = $_POST['causal'];
		$motivo = $_POST['motivo'];
		$fecha_inicio = $fecha_inicio;
		$fecha_termino = $fecha_termino;
		$jornada = $_POST['jornada'];
		$renta_imponible = $_POST['renta_imponible'];
		$bono_responsabilidad = $_POST['bono_responsabilidad'];
		$bono_gestion = $_POST['bono_gestion'];
		$bono_confianza = $_POST['bono_confianza'];
		$asignacion_movilizacion = $_POST['asignacion_movilizacion'];
		$asignacion_colacion = $_POST['asignacion_colacion'];
		$asignacion_zona = $_POST['asignacion_zona'];
		$asignacion_herramientas = $_POST['asignacion_herramientas'];
		$viatico = $_POST['viatico'];
		$seguro_vida_arauco = 'SI';
		$nombre_trabajador = $_POST['nombre'];
		$rut_trabajador = $_POST['rut_usuario'];
		$estado_civil = $_POST['estado_civil'];
		$fecha_nac = $_POST['fecha_nac'];
		$domicilio_trabajador = $_POST['domicilio'];
		$comuna_trabajador = $_POST['ciudad'];
		$prevision_trabajador = $_POST['prevision'];
		$salud_trabajador = $_POST['salud'];
		$referido = $_POST['referido'];
		$cargo = $_POST['cargo'];
		$area = $_POST['area'];
		$telefono = $_POST['telefono'];
		$nacionalidad = $_POST['nacionalidad'];
		$nombre_centro_costo = $_POST['nombre_centro_costo'];
		$rut_centro_costo = $_POST['rut_centro_costo'];
		$id_planta = $_POST['id_planta'];
		$nombre_planta = $_POST['nombre_planta'];
		$direccion_planta = $_POST['direccion_planta'];
		$comuna_planta = $_POST['ciudad_planta'];
		$region_planta = $_POST['region_planta'];
		$gratificacion = $_POST['descripcion_tipo_gratificacion'];
		$nombre_sin_espacios = $_POST['nombre_sin_espacios'];
		$id_centro_costo = $_POST['id_centro_costo'];
		$data = array(
			'causal' => $causal,
			'motivo' => $motivo,
			'fecha_inicio' => $fecha_inicio,
			'fecha_termino' => $fecha_termino,
			'jornada' => $jornada,
			'renta_imponible' => $renta_imponible,
			'bono_responsabilidad' => $bono_responsabilidad,
			'bono_gestion' => $bono_gestion,
			'bono_confianza' => $bono_confianza,
			'asignacion_movilizacion' => $asignacion_movilizacion,
			'asignacion_colacion' => $asignacion_colacion,
			'asignacion_zona' => $asignacion_zona,
			'asignacion_herramientas' => $asignacion_herramientas,
			'viatico' => $viatico,
			'seguro_vida_arauco' => 'SI'
		);

		$datos_generacion_contrato = array(
			'estado_generacion_contrato' => 1,
			'gc_usuario_id' => $this->session->userdata('id'),
			'gc_fecha' => date('Y-m-d H:i:s'),
		);

		if(isset($_POST['actualizar'])){
			//inicio de boton actualizar
			$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_usu_arch, $data);
			echo '<script>alert("Contrato actualizado exitosamente");</script>';
			//fin de boton actualizar
		}elseif(isset($_POST['envio_solicitud_contrato'])){
			//inicio de boton envio aprobacion de contrato
			$datos_aprobacion = array(
				'id_req_usu_arch' => $id_usu_arch,
				'id_solicitante' => $this->session->userdata('id'),
				'fecha_solicitud' => date('Y-m-d'),
				'estado' => 0,
			);

			$datos_aprobacion_historial = array(
				'id_req_usu_arch' => $id_usu_arch,
				'id_usuario' => $this->session->userdata('id'),
				//'fecha_solicitud' => date('Y-m-d H:m:s'),
				'estado' => 0,
			);
			$data = array(
				'fecha_solicitud' =>date('Y-m-d H:i:s'),
				);
			$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_usu_arch, $data);


			$get_existe = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_usu_arch);
			$existe = isset($get_existe->id)?1:0;

			if($existe == 1)
				$this->Requerimiento_Usuario_Archivo_model->actualizar_solicitud_contrato($id_usu_arch, $datos_aprobacion);
			else
				$this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato($datos_aprobacion);
			
			$this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato_historial($datos_aprobacion_historial);

			$id_solicitante = $this->session->userdata('id');
			$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
			$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
			$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
			$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
			$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;

			$this->load->library('email');
			$config['smtp_host'] = 'mail.empresasintegra.cl';
			$config['smtp_user'] = 'informaciones@empresasintegra.cl';
			$config['smtp_pass'] = '%SYkNLH1';
			$config['mailtype'] = 'html';
			$config['smtp_port']    = '2552';
			$this->email->initialize($config);
		    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - carrera');
		    $this->email->to('nrojas@empresasintegra.cl');
		   // $this->email->cc('jcruces@empresasintegra.cl');
		    $this->email->subject("Solicitud Contrato Trabajador: ".$nombre_trabajador." - Fecha Inicio Contrato: ".$fecha_inicio);
		    $this->email->message('Estimados el administrador '.$nombre_completo_solicitante.' ha realizado una solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.'.<br>Saludos');
		    $this->email->send();

			echo '<script>alert("Solicitud de aprobacion de contrato ha sido enviada exitosamente");</script>';
			//inicio de boton envio aprobacion de contrato
		}elseif(isset($_POST['generar_contrato'])){
			//inicio de boton generar contrato
			if(empty($_POST['gc_ano_fi']) || empty($_POST['gc_mes_fi']) || empty($_POST['gc_dia_fi']) )
				$fecha_inicio = '0000-00-00';
			else
				$fecha_inicio = $_POST['gc_ano_fi'].'-'.$_POST['gc_mes_fi'].'-'.$_POST['gc_dia_fi'];

			if(empty($_POST['gc_ano_ft']) || empty($_POST['gc_mes_ft']) || empty($_POST['gc_dia_ft']) )
				$fecha_termino = '0000-00-00';
			else
				$fecha_termino = $_POST['gc_ano_ft'].'-'.$_POST['gc_mes_ft'].'-'.$_POST['gc_dia_ft'];

			$causal = $_POST['gc_causal'];
			$motivo = $_POST['gc_motivo'];
			$fecha_inicio = $fecha_inicio;
			$fecha_termino = $fecha_termino;
			$jornada = $_POST['gc_jornada'];
			$renta_imponible = $_POST['gc_renta_imponible'];
			$bono_responsabilidad = $_POST['gc_bono_responsabilidad'];
			$bono_gestion = $_POST['gc_bono_gestion'];
			$bono_confianza = $_POST['gc_bono_confianza'];
			$asignacion_movilizacion = $_POST['gc_asignacion_movilizacion'];
			$asignacion_colacion = $_POST['gc_asignacion_colacion'];
			$asignacion_zona = $_POST['gc_asignacion_zona'];
			$asignacion_herramientas = $_POST['gc_asignacion_herramientas'];
			$viatico = $_POST['gc_viatico'];

			if($jornada == "1"){
					$template_formato = base_url()."extras/contratos/formatos_contratos_carrera/2_contrato_sin_pacto_he.docx";
			}else{
					$template_formato = base_url()."extras/contratos/formatos_contratos_carrera/1_contrato_con_pacto_he.docx";
			}

			$templateWord = new TemplateProcessor($template_formato);
			$salto_linea = "<w:br/>";

			$var1 = explode('.',$rut_trabajador); 
			$rut1 = $var1[0];

			if($rut1 < 10)
				$rut_trabajador = "0".$rut_trabajador;

			$get_fecha_inicio=date($fecha_inicio); 
			$var1 = explode('-',$get_fecha_inicio); 
			$get_dia_fi = $var1[2];
			$mes_fi = $var1[1];
			$ano_fi = $var1[0];

			if($get_dia_fi < 10)
				$dia_fi = $var1[2];
			else
				$dia_fi = $var1[2];

			if ($mes_fi=="01") $mes_letra_fi="Enero";
			if ($mes_fi=="02") $mes_letra_fi="Febrero";
			if ($mes_fi=="03") $mes_letra_fi="Marzo";
			if ($mes_fi=="04") $mes_letra_fi="Abril";
			if ($mes_fi=="05") $mes_letra_fi="Mayo";
			if ($mes_fi=="06") $mes_letra_fi="Junio";
			if ($mes_fi=="07") $mes_letra_fi="Julio";
			if ($mes_fi=="08") $mes_letra_fi="Agosto";
			if ($mes_fi=="09") $mes_letra_fi="Septiembre";
			if ($mes_fi=="10") $mes_letra_fi="Octubre";
			if ($mes_fi=="11") $mes_letra_fi="Noviembre";
			if ($mes_fi=="12") $mes_letra_fi="Diciembre";

			$get_fecha_termino=date($fecha_termino); 
			$var2 = explode('-',$get_fecha_termino); 
			$get_dia_ft = $var2[2];
			$mes_ft = $var2[1];
			$ano_ft = $var2[0];
			
			if($get_dia_ft < 10)
				$dia_ft = "0".$var2[2];
			else
				$dia_ft = $var2[2];

			if ($mes_ft=="01") $mes_letra_ft="Enero";
			if ($mes_ft=="02") $mes_letra_ft="Febrero";
			if ($mes_ft=="03") $mes_letra_ft="Marzo";
			if ($mes_ft=="04") $mes_letra_ft="Abril";
			if ($mes_ft=="05") $mes_letra_ft="Mayo";
			if ($mes_ft=="06") $mes_letra_ft="Junio";
			if ($mes_ft=="07") $mes_letra_ft="Julio";
			if ($mes_ft=="08") $mes_letra_ft="Agosto";
			if ($mes_ft=="09") $mes_letra_ft="Septiembre";
			if ($mes_ft=="10") $mes_letra_ft="Octubre";
			if ($mes_ft=="11") $mes_letra_ft="Noviembre";
			if ($mes_ft=="12") $mes_letra_ft="Diciembre";

			$get_fecha_nacimiento=date($fecha_nac); 
			$var3 = explode('-',$get_fecha_nacimiento); 
			$dia_fecha_nac = $var3[2];
			$mes_fecha_nac = $var3[1];
			$ano_fecha_nac = $var3[0];
			if ($mes_fecha_nac=="01") $mes_letra_fecha_nac="Enero";
			if ($mes_fecha_nac=="02") $mes_letra_fecha_nac="Febrero";
			if ($mes_fecha_nac=="03") $mes_letra_fecha_nac="Marzo";
			if ($mes_fecha_nac=="04") $mes_letra_fecha_nac="Abril";
			if ($mes_fecha_nac=="05") $mes_letra_fecha_nac="Mayo";
			if ($mes_fecha_nac=="06") $mes_letra_fecha_nac="Junio";
			if ($mes_fecha_nac=="07") $mes_letra_fecha_nac="Julio";
			if ($mes_fecha_nac=="08") $mes_letra_fecha_nac="Agosto";
			if ($mes_fecha_nac=="09") $mes_letra_fecha_nac="Septiembre";
			if ($mes_fecha_nac=="10") $mes_letra_fecha_nac="Octubre";
			if ($mes_fecha_nac=="11") $mes_letra_fecha_nac="Noviembre";
			if ($mes_fecha_nac=="12") $mes_letra_fecha_nac="Diciembre";

			$fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
			$fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
			$fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

			if($causal == "A")
				$id_descrip_causal = 1;
			elseif($causal == "B")
				$id_descrip_causal = 2;
			elseif($causal == "C")
				$id_descrip_causal = 3;
			elseif($causal == "D")
				$id_descrip_causal = 4;
			elseif($causal == "E")
				$id_descrip_causal = 5;
			else
				$id_descrip_causal = 0;

			$get_descripcion_causal = $this->Descripcion_causal_model->get($id_descrip_causal);
			$descripcion_causal = isset($get_descripcion_causal->descripcion)?$get_descripcion_causal->descripcion:'';

			//parrafo cuando es distinto a "sin horario"
			if($jornada != "1")
				$adicional_cumplimiento_horario_undecimo = "Cumplir con el horario de ingreso y salida establecido en la Usuaria, y no registrar atrasos. ";
			else
				$adicional_cumplimiento_horario_undecimo = "";

			$get_descripcion_sin_horario = $this->Descripcion_horarios_model->get(1);
			$get_descripcion_adic_admin_e_turno_e = $this->Descripcion_horarios_model->get(2);
			$get_descripcion_horario_adicional_tiempo_extra = $this->Descripcion_horarios_model->get(3);
			$get_descripcion_horario = $this->Descripcion_horarios_model->get($jornada);

			if($jornada == "1"){
				$descripcion_jornada = isset($get_descripcion_sin_horario->descripcion)?$get_descripcion_sin_horario->descripcion:'';
			}else{
				$frase1 = isset($get_descripcion_horario->descripcion)?$get_descripcion_horario->descripcion:'';
				$frase2 = isset($get_descripcion_horario_adicional_tiempo_extra->descripcion)?$get_descripcion_horario_adicional_tiempo_extra->descripcion:'';
				$frase3 = isset($get_descripcion_adic_admin_e_turno_e->descripcion)?$get_descripcion_adic_admin_e_turno_e->descripcion:'';

				if($causal == "E")
					$descripcion_jornada = $frase1." ".$frase3.$salto_linea.$frase2;
				else
					$descripcion_jornada = $frase1.$salto_linea.$frase2;
			}

			$id_tipo_horario = isset($get_descripcion_horario->id_tipo_horario)?$get_descripcion_horario->id_tipo_horario:'';
			if($causal == "A"){
				if($id_tipo_horario == 2)
					$parrafo_decimo_tercero = "Las partes convienen que el presente Contrato de Servicios Transitorios tendrá como duración lo señalado en el Art. 183-O INCISO 1°, esto es la puesta disposición del trabajador podrá cubrir el tiempo de duración de la ausencia del trabajador reemplazado. Sus labores finalizarian el ".$fecha_termino_texto_largo.".";
				else
					$parrafo_decimo_tercero = "El presente contrato tendrá una vigencia hasta el ".$fecha_termino_texto_largo.", y podrá ponérsele término cuando concurran para ello causas justificadas que en conformidad a la ley puedan producir su caducidad, las partes fijan domicilio en la ciudad de Concepción y se someten a la jurisdicción de sus Tribunales.";
			}else{
				$parrafo_decimo_tercero = "El presente contrato tendrá una vigencia hasta el ".$fecha_termino_texto_largo.", y podrá ponérsele término cuando concurran para ello causas justificadas que en conformidad a la ley puedan producir su caducidad, las partes fijan domicilio en la ciudad de Concepción y se someten a la jurisdicción de sus Tribunales.";
			}

			$bono_responsabilidad_palabras = num2letras($bono_responsabilidad);
			$bono_gestion_palabras = num2letras($bono_gestion);
			$bono_confianza_palabras = num2letras($bono_confianza);
			$asignacion_zona_palabras = num2letras($asignacion_zona);
			$asignacion_movilizacion_palabras = num2letras($asignacion_movilizacion);
			$asignacion_colacion_palabras = num2letras($asignacion_colacion);
			$viatico_palabras = num2letras($viatico);

			if($bono_responsabilidad > 0)
				$frase_bono_responsabilidad = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono de Responsabilidad por la suma de $ ".str_replace(',','.',number_format($bono_responsabilidad))." (".$bono_responsabilidad_palabras.").".$salto_linea."";
			else
				$frase_bono_responsabilidad = "";

			if($bono_gestion > 0)
				$frase_bono_gestion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono de Gestión por la suma de $ ".str_replace(',','.',number_format($bono_gestion))." (".$bono_gestion_palabras.").".$salto_linea."";
			else
				$frase_bono_gestion = "";

			if($bono_confianza > 0)
				$frase_bono_confianza = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono Confianza por la suma de $ ".str_replace(',','.',number_format($bono_confianza))." (".$bono_confianza_palabras.").".$salto_linea."";
			else
				$frase_bono_confianza = "";

			if($asignacion_movilizacion > 0)
				$frase_asignacion_movilizacion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación de locomoción de $ ".str_replace(',','.',number_format($asignacion_movilizacion))." (".$asignacion_movilizacion_palabras.").".$salto_linea."";
			else
				$frase_asignacion_movilizacion = "";

			if($asignacion_colacion > 0)
				$frase_asignacion_colacion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación de colación de $ ".str_replace(',','.',number_format($asignacion_colacion))." (".$asignacion_colacion_palabras.").".$salto_linea."";
			else
				$frase_asignacion_colacion = "";

			if($asignacion_zona > 0)
				$frase_asignacion_zona = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación Zona por la suma de $ ".str_replace(',','.',number_format($asignacion_zona))." (".$asignacion_zona_palabras.").".$salto_linea."";
			else
				$frase_asignacion_zona = "";

			if($viatico > 0)
				$frase_viatico = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Viático de $ ".str_replace(',','.',number_format($viatico))." (".$viatico_palabras.").".$salto_linea."";
			else
				$frase_viatico = "";

			$detalle_bonos = $frase_bono_responsabilidad.$frase_bono_gestion.$frase_bono_confianza.$frase_asignacion_movilizacion.$frase_asignacion_colacion.$frase_asignacion_zona.$frase_viatico;
			$sueldo_base_palabras = num2letras($renta_imponible);

			// Insertamos variables en el word
			$templateWord->setValue('fecha_ingreso_trabajador_palabras',$fecha_inicio_texto_largo);
			$templateWord->setValue('nombre_trabajador',titleCase($nombre_trabajador));
			$templateWord->setValue('rut_trabajador',$rut_trabajador);
			$templateWord->setValue('nacionalidad',titleCase($nacionalidad));
			$templateWord->setValue('fecha_nacimiento',$fecha_nacimiento_texto_largo);
			$templateWord->setValue('estado_civil',titleCase($estado_civil));
			$templateWord->setValue('domicilio_trabajador',titleCase($domicilio_trabajador));
			$templateWord->setValue('comuna_trabajador',titleCase($comuna_trabajador));
			$templateWord->setValue('nombre_centro_costo',titleCase($nombre_centro_costo));
			$templateWord->setValue('rut_centro_costo',$rut_centro_costo);
			$templateWord->setValue('descripcion_causal',$descripcion_causal);
			$templateWord->setValue('motivo_req',titleCase($motivo));
			$templateWord->setValue('cargo_postulante',titleCase($cargo));
			$templateWord->setValue('centro_costo',$nombre_centro_costo);
			$templateWord->setValue('nombre_planta',titleCase($nombre_planta));
			$templateWord->setValue('direccion_planta',titleCase($direccion_planta));
			$templateWord->setValue('comuna_planta',titleCase($comuna_planta));
			$templateWord->setValue('region_planta',titleCase($region_planta));
			$templateWord->setValue('descripcion_jornada',$descripcion_jornada);
			$templateWord->setValue('sueldo_base_numeros', str_replace(',','.',number_format($renta_imponible)));
			$templateWord->setValue('sueldo_base_palabras',titleCase($sueldo_base_palabras));
			$templateWord->setValue('gratificacion',$gratificacion);
			$templateWord->setValue('detalle_bonos',$detalle_bonos);
			$templateWord->setValue('adicional_cumplimiento_horario_undecimo',$adicional_cumplimiento_horario_undecimo);
			$templateWord->setValue('prevision_trabajador',titleCase($prevision_trabajador));
			$templateWord->setValue('salud_trabajador',titleCase($salud_trabajador));
			$templateWord->setValue('fecha_ingreso_trabajador',$fecha_inicio_texto_largo);
			$templateWord->setValue('fecha_vigencia_contrato',$fecha_termino_texto_largo);
			$templateWord->setValue('parrafo_decimo_tercero',$parrafo_decimo_tercero);

			// Guardamos el documento
			$nombre_documento = "contrato_trabajo_".$nombre_sin_espacios.".docx";
			$templateWord->saveAs("extras/contratos/archivos/".$nombre_documento);

			$get_url = "extras/contratos/archivos/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
			//fin de boton generar contrato
		}elseif(isset($_POST['generar_doc_adicionales_contrato'])){
			//inicio de boton generar documentos adicionales contrato

			if(empty($_POST['gc_ano_fi']) || empty($_POST['gc_mes_fi']) || empty($_POST['gc_dia_fi']) )
				$fecha_inicio = '0000-00-00';
			else
				$fecha_inicio = $_POST['gc_ano_fi'].'-'.$_POST['gc_mes_fi'].'-'.$_POST['gc_dia_fi'];

			if(empty($_POST['gc_ano_ft']) || empty($_POST['gc_mes_ft']) || empty($_POST['gc_dia_ft']) )
				$fecha_termino = '0000-00-00';
			else
				$fecha_termino = $_POST['gc_ano_ft'].'-'.$_POST['gc_mes_ft'].'-'.$_POST['gc_dia_ft'];

			$causal = $_POST['gc_causal'];
			$motivo = $_POST['gc_motivo'];
			$fecha_inicio = $fecha_inicio;
			$fecha_termino = $fecha_termino;

			
				$template_formato = base_url()."extras/contratos/formatos_contratos_carrera/documentos_contractuales.docx";
			

			$templateWord = new TemplateProcessor($template_formato);
			$salto_linea = "<w:br/>";

			$var1 = explode('.',$rut_trabajador); 
			$rut1 = $var1[0];

			if($rut1 < 10)
				$rut_trabajador = "0".$rut_trabajador;

			$get_fecha_inicio=date($fecha_inicio); 
			$var1 = explode('-',$get_fecha_inicio); 
			$get_dia_fi = $var1[2];
			$mes_fi = $var1[1];
			$ano_fi = $var1[0];

			if($get_dia_fi < 10)
				$dia_fi = "0".$var1[2];
			else
				$dia_fi = $var1[2];

			if ($mes_fi=="01") $mes_letra_fi="Enero";
			if ($mes_fi=="02") $mes_letra_fi="Febrero";
			if ($mes_fi=="03") $mes_letra_fi="Marzo";
			if ($mes_fi=="04") $mes_letra_fi="Abril";
			if ($mes_fi=="05") $mes_letra_fi="Mayo";
			if ($mes_fi=="06") $mes_letra_fi="Junio";
			if ($mes_fi=="07") $mes_letra_fi="Julio";
			if ($mes_fi=="08") $mes_letra_fi="Agosto";
			if ($mes_fi=="09") $mes_letra_fi="Septiembre";
			if ($mes_fi=="10") $mes_letra_fi="Octubre";
			if ($mes_fi=="11") $mes_letra_fi="Noviembre";
			if ($mes_fi=="12") $mes_letra_fi="Diciembre";

			$get_fecha_termino=date($fecha_termino); 
			$var2 = explode('-',$get_fecha_termino); 
			$get_dia_ft = $var2[2];
			$mes_ft = $var2[1];
			$ano_ft = $var2[0];
			
			if($get_dia_ft < 10)
				$dia_ft = $var2[2];
			else
				$dia_ft = $var2[2];

			if ($mes_ft=="01") $mes_letra_ft="Enero";
			if ($mes_ft=="02") $mes_letra_ft="Febrero";
			if ($mes_ft=="03") $mes_letra_ft="Marzo";
			if ($mes_ft=="04") $mes_letra_ft="Abril";
			if ($mes_ft=="05") $mes_letra_ft="Mayo";
			if ($mes_ft=="06") $mes_letra_ft="Junio";
			if ($mes_ft=="07") $mes_letra_ft="Julio";
			if ($mes_ft=="08") $mes_letra_ft="Agosto";
			if ($mes_ft=="09") $mes_letra_ft="Septiembre";
			if ($mes_ft=="10") $mes_letra_ft="Octubre";
			if ($mes_ft=="11") $mes_letra_ft="Noviembre";
			if ($mes_ft=="12") $mes_letra_ft="Diciembre";

			$get_fecha_nacimiento=date($fecha_nac); 
			$var3 = explode('-',$get_fecha_nacimiento); 
			$dia_fecha_nac = $var3[2];
			$mes_fecha_nac = $var3[1];
			$ano_fecha_nac = $var3[0];
			if ($mes_fecha_nac=="01") $mes_letra_fecha_nac="Enero";
			if ($mes_fecha_nac=="02") $mes_letra_fecha_nac="Febrero";
			if ($mes_fecha_nac=="03") $mes_letra_fecha_nac="Marzo";
			if ($mes_fecha_nac=="04") $mes_letra_fecha_nac="Abril";
			if ($mes_fecha_nac=="05") $mes_letra_fecha_nac="Mayo";
			if ($mes_fecha_nac=="06") $mes_letra_fecha_nac="Junio";
			if ($mes_fecha_nac=="07") $mes_letra_fecha_nac="Julio";
			if ($mes_fecha_nac=="08") $mes_letra_fecha_nac="Agosto";
			if ($mes_fecha_nac=="09") $mes_letra_fecha_nac="Septiembre";
			if ($mes_fecha_nac=="10") $mes_letra_fecha_nac="Octubre";
			if ($mes_fecha_nac=="11") $mes_letra_fecha_nac="Noviembre";
			if ($mes_fecha_nac=="12") $mes_letra_fecha_nac="Diciembre";

			$fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
			$fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
			$fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

			// Insertamos variables en el word
			$templateWord->setValue('nombre_trabajador',titleCase($nombre_trabajador));
			$templateWord->setValue('rut_trabajador',$rut_trabajador);
			$templateWord->setValue('cargo_postulante',titleCase($cargo));
			$templateWord->setValue('fecha_ingreso_trabajador_palabras',$fecha_inicio_texto_largo);
			$templateWord->setValue('nombre_planta',titleCase($nombre_planta));
			$templateWord->setValue('nombre_planta_may',strtoupper($nombre_planta));
			$templateWord->setValue('nombre_centro_costo',titleCase($nombre_centro_costo));
			$templateWord->setValue('nombre_centro_costo_may',strtoupper($nombre_centro_costo));
			$templateWord->setValue('comuna_planta',titleCase($comuna_planta));

			// Guardamos el documento
			$nombre_documento = "doc_adicional_contrato_trabajo_".$nombre_sin_espacios.".docx";
			$templateWord->saveAs("extras/contratos/archivos/".$nombre_documento);

			$get_url = "extras/contratos/archivos/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
			//fin de boton generar documentos adicionales contrato
		}
		$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);
		$usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
		$asc_area = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
		redirect('carrera/requerimientos/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
	}

	function guardar_fecha(){
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");
		$this->load->library('session');

		$arreglo = array(
			$_POST['name'] => $_POST['value'],
			'quien' => $this->session->userdata('id'),
			'actualizacion' => date("Y-m-d h:i:s")
		);
		$this->Requerimiento_asc_trabajadores_model->editar($_POST['pk'], $arreglo );
	}

	function eliminar_usuarios_req($id,$area_cargo){
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");
		$this->Requerimiento_asc_trabajadores_model->eliminar($id);
		redirect('carrera/requerimientos/usuarios_requerimiento/'.$area_cargo, 'refresh');
	}

	function eliminar($id){
		$this->load->model('carrera/Requerimientos_model');
		$this->Requerimientos_model->eliminar($id);
		echo "<script>alert('Requerimiento Eliminado Exitosamente')</script>";
		redirect(base_url().'carrera/requerimientos/listado', 'refresh');
	}

		#29-11-2018 Contrato puesto a disposicion de trabajadores
			#Edit 16-01-2019
function descargar_puesta_disposicion($id){
		$this->load->library('zip');
		$this->load->helper('download');
		$this->load->model('carrera/Requerimientos_model');
		$this->load->model('carrera/Requerimiento_area_cargo_model');
		$requerimientos = $this->Requerimientos_model->getRequerimientoPuesto($id);
		$ac = $this->Requerimiento_area_cargo_model->getReqContratoPuestoDisposicion($id);
		
		//$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$fechaHoy = date('d')." de ".$meses[date('n')-1]. " de ".date('Y') ;

		#obteniendo la cantidad de dias que dura el requerimiento
		$fecha1 = new DateTime($requerimientos->fechaInicioReq);
	    $fecha2 = new DateTime($requerimientos->fechaFinReq);
	    $resultado = $fecha1->diff($fecha2);
	    $totalDiasRequerimiento = $resultado->format('%a');

		if ($requerimientos->letraCausal== 'A') {
			$descripcionCausal = 'Suspensión del contrato de trabajo o de la obligación de prestar servicios, según corresponda, de uno o más trabajadores por licencias médicas, descansos de maternidad o feriados';
			//articulo quinto
			$articuloQuinto = 'La duración de los servicios prestados bajo la causal dispuesta en el artículo 183 Ñ del Código del Trabajo contratados será de '.$totalDiasRequerimiento.' días, no obstante, de acuerdo a lo señalado en el Art. 183-O inciso 1°, podrá prorrogarse hasta cubrir el tiempo de duración de la ausencia del trabajador reemplazado.';

		}elseif($requerimientos->letraCausal == 'C'){
			$descripcionCausal = 'proyectos nuevos y específicos de la usuaria, tales como la construcción de nuevas instalaciones, la ampliación de las ya existentes o expansión a nuevos mercados';

			$articuloQuinto = 'La duración de los servicios prestados bajo la causal dispuesta en el artículo 183 Ñ del Código del Trabajo contratados será de '.$totalDiasRequerimiento.' días, considerando la totalidad de los trabajadores requeridos, no obstante, de acuerdo a lo señalado en el Art. 183-O inciso 3°, el contrato de trabajo junto a sus anexos para prestar servicios en una misma usuaria, por esta causal, no podrá exceder de 180 días a nivel individual de los trabajadores.';

		}elseif($requerimientos->letraCausal == 'E'){
			$descripcionCausal = 'Aumentos ocasionales, sean o no periódicos, o extraordinarios de la actividad de toda la Empresa Usuaria o en una determinada sección, sucursal, planta, faena o establecimiento de la misma';
			$articuloQuinto = 'La duración de los servicios prestados bajo la causal dispuesta en el artículo 183 Ñ del Código del Trabajo contratados será un total de '.$totalDiasRequerimiento.' días, considerando la totalidad de los trabajadores requeridos, no obstante, de acuerdo a lo señalado en el Art. 183-O inciso 3°, el contrato de trabajo para prestar servicios en una misma usuaria, por esta causal, no podrá exceder de 90 días a nivel individual de los trabajadores.';
		}



			$template_formato = base_url()."extras/contratos/formatos_contrato_disposicion/formatoContratoPuestaDisposicioncarrera.docx";
			$templateWord = new TemplateProcessor($template_formato);
			$salto_linea = "<w:br/>";
			$templateWord->setValue('fechaHoy', $fechaHoy);
			$templateWord->setValue('nombreCiudad',$requerimientos->nombreCiudad);
			$templateWord->setValue('domicilioGerente',$requerimientos->direccionPlanta);
			$templateWord->setValue('razonSocial',$requerimientos->razonSocial);
			$templateWord->setValue('razonSocialMayus',strtoupper($requerimientos->razonSocial));
			$templateWord->setValue('rut',$requerimientos->rut);
			$templateWord->setValue('nombrePlanta',$requerimientos->nombrePlanta);
			$templateWord->setValue('nombreGerente',$requerimientos->nombreGerente);
			$templateWord->setValue('rutGerente',$requerimientos->rutGerente);
			$templateWord->setValue('letraCausal',$requerimientos->letraCausal);
			$templateWord->setValue('descripcionCausal',$descripcionCausal);
			$templateWord->setValue('motivo',$requerimientos->motivo);
			$templateWord->setValue('articuloQuinto',$articuloQuinto);
			$templateWord->setValue('totalDiasRequerimiento',$totalDiasRequerimiento);
			$i = 0;
			$ValorReTotal = 0;

			foreach ($ac as $key) {
				$nombreArea[] = $key->nombreArea;
				$cantidadTrabajadores[] = $key->cantidadTrabajadores;
				$totalDiasReq = $totalDiasRequerimiento*$key->cantidadTrabajadores;
				$nombreCargo[] = $key->nombreCargo;
				$sueldoBase= $key->valor;
				$sueldoBasePorcentaje[$i] = $sueldoBase*0.25;
				if ($sueldoBasePorcentaje[$i] < 119146) {
					$sueldoBaseMasGratificacion[$i] =  $sueldoBase+$sueldoBasePorcentaje[$i];
				}else{
					$sueldoBaseMasGratificacion[$i] = $sueldoBase+119146;
				}
				$subtotal[$i] = ($sueldoBaseMasGratificacion[$i]/30)*$totalDiasReq;//$totalDiasRequerimiento Reemplazar por 1;
				$valorTotal[$i] = $subtotal[$i]+($subtotal[$i]*0.0163)+($subtotal[$i]*0.0153)+($subtotal[$i]*0.03)+((2000/30)*$totalDiasReq);//$totalDiasRequerimiento Reemplazar por 1;
				$valorTotalRedondeado[$i] = round($valorTotal[$i]);
				$ValorReTotal = $ValorReTotal+ $valorTotalRedondeado[$i];
				$i++;
			}
			$ValorReTotalPalabras = num2letras($ValorReTotal);
			//$subtotal = ($sueldoBaseMasGratificacion[$i]/30)*$totalDiasRequerimiento;
			$templateWord->setValue('totalredondeado',$ValorReTotal);
			$templateWord->setValue('totalredondeadopalabras',$ValorReTotalPalabras);

			$templateWord->cloneRow('cargo', count($ac));
			for ($r = 1; $r <= count($ac); $r++) {
				$templateWord->setValue('cargo#'.$r,$nombreCargo[$r-1]);
				$templateWord->setValue('numero#'.$r,$cantidadTrabajadores[$r-1]);
				$templateWord->setValue('area#'.$r,$nombreArea[$r-1]);
				$templateWord->setValue('valor#'.$r,$valorTotalRedondeado[$r-1]);
			}
			// Guardamos el documento
			$nombre_documento = "contrato_trabajo_.docx";
			$templateWord->saveAs("extras/contratos/contratosDisposicionGenerados/".$nombre_documento);

			$get_url = "extras/contratos/contratosDisposicionGenerados/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
	}
	function verificarExamenPreocupacional($idUsuario){
		$this->load->model('carrera/Evaluaciones_model');
		$examen_pre = $this->Evaluaciones_model->get_una_preocupacional($idUsuario);
		echo json_encode($examen_pre);
	}
	function revisar_fecha($idPersona){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$fecha = $_POST['fechaInicio'];
		$contrato = $this->Requerimiento_Usuario_Archivo_model->buscarContrato($idPersona, $fecha);
		$anexo = $this->Requerimiento_Usuario_Archivo_model->buscarAnexo($idPersona, $fecha);
		$resultado=1;
		if ($anexo!= FALSE) {
			if (strtotime($anexo->fecha_termino2) >= strtotime($fecha) ) {
				$resultado = $anexo;
			}				
		}
		if ($contrato!= FALSE){
			$reqAreaCargo = $this->Requerimiento_Usuario_Archivo_model->get_area_cargo($contrato->requerimiento_asc_trabajadores_id);
			$contrato->id_requerimiento_area_cargo = $reqAreaCargo->requerimiento_area_cargo_id;
			if (strtotime($contrato->fecha_termino2) >= strtotime($fecha)) {
				$resultado = $contrato;
			}

		}
		if ($anexo!= FALSE && $contrato!= FALSE) {
			if (strtotime($contrato->fecha_termino2) >= strtotime($anexo->fecha_termino2)) {
				if (strtotime($contrato->fecha_termino2) >= strtotime($fecha)) {
					$resultado = $contrato;
				}
			}else{
				if (strtotime($anexo->fecha_termino2) >= strtotime($fecha) ) {
					$resultado = $anexo;
				}
			}
		}
		echo json_encode($resultado);
	}

	function modal_agregar_anexo($usuario,$tipo,$asc_area, $id_req_area_cargo){

		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/ciudades_model");
		$this->load->model("carrera/Afp_model");
		$this->load->model("carrera/Salud_model");
		$this->load->model("carrera/estado_civil_model");
		$this->load->model("carrera/Requerimientos_model");
		$this->load->model("carrera/Areas_model");
		$this->load->model("carrera/Cargos_model");
		$this->load->model("carrera/Empresas_model");
		$this->load->model("carrera/Empresa_planta_model");
		$this->load->model("carrera/regiones_model");
		$this->load->model("carrera/Tipo_gratificacion_model");
		$this->load->model("carrera/Descripcion_horarios_model");

		$pagina['usuario']= $usuario;
		$pagina['tipo']= $tipo;
		$pagina['asc_area']= $asc_area;
		
		$get_datos_req = $this->Requerimiento_area_cargo_model->r_get_requerimiento($id_req_area_cargo);
		//var_dump($get_datos_req);return false;
		$pagina['motivo_defecto'] = (isset($get_datos_req->motivo)?$get_datos_req->motivo:'0');
		$pagina['causal_defecto'] = (isset($get_datos_req->causal)?$get_datos_req->causal:'0');

		$existe_anexo = $this->Requerimiento_Usuario_Archivo_model->existe_registro_de_anexo($usuario, $asc_area, 2);
		$existe_contrato = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($usuario, $asc_area, 1);

		if($existe_anexo == 1){
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_ultimo_anexo($usuario, $asc_area, 2);
		}elseif($existe_contrato == 1){
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit_row($usuario, $asc_area, 1);
		}else{
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit_row($usuario, $asc_area, $tipo);
		}
		//var_dump($datos_req);

		$datos_generales = array();
		if($usuario != FALSE){
			$usr = $this->Usuarios_model->get($usuario);
			$aux = new StdClass();
			$id_ciudad = isset($usr->id_ciudad)?$usr->id_ciudad:'';
			$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
			$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
			$id_estado_civil = isset($usr->id_estado_civil)?$usr->id_estado_civil:'';
			$id_estudios = isset($usr->id_estudios)?$usr->id_estudios:'';
			$id_banco = isset($usr->id_bancos)?$usr->id_bancos:1;
				$nombreB  = $this->Usuarios_model->getNombreBanco($id_banco);
				$aux->nombre_banco = $nombreB->desc_bancos;
				$aux->tipo_cuenta = isset($usr->tipo_cuenta)?$usr->tipo_cuenta:'';
				$aux->cuenta_banco = isset($usr->cuenta_banco)?$usr->cuenta_banco:'';
			$get_ciudad = $this->ciudades_model->get($id_ciudad);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->estado_civil_model->get($id_estado_civil);
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($asc_area);
			$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_req_area_cargo);
			$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
			$id_area = isset($get_area_cargo->areas_id)?$get_area_cargo->areas_id:'';
			$id_cargo = isset($get_area_cargo->cargos_id)?$get_area_cargo->cargos_id:'';
			$get_requerimiento = $this->Requerimientos_model->get($id_requerimiento);
			$get_area = $this->Areas_model->r_get($id_area);
			$get_cargo = $this->Cargos_model->r_get($id_cargo);
			$id_centro_costo = isset($get_requerimiento->empresa_id)?$get_requerimiento->empresa_id:'';
			$id_planta = isset($get_requerimiento->planta_id)?$get_requerimiento->planta_id:'';
			$get_centro_costo = $this->Empresas_model->get($id_centro_costo);
			$get_planta = $this->Empresa_planta_model->get($id_planta);
			$id_region_planta = isset($get_planta->id_regiones)?$get_planta->id_regiones:'';
			$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
			$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
			$get_region_planta = $this->regiones_model->get($id_region_planta);
			$aux->id_req_area_cargo = $id_req_area_cargo;
			$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
			$aux->id_empresa = isset($get_centro_costo->id)?$get_centro_costo->id:'';
			$aux->nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
			$aux->id_planta = $id_planta;
			$aux->direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
			$aux->nombre_req = isset($get_requerimiento->nombre)?$get_requerimiento->nombre:'';
			$aux->referido = isset($get_asc_trab->referido)?$get_asc_trab->referido:'';
			$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
			$aux->area = isset($get_area->nombre)?$get_area->nombre:'';

			$nombres = isset($usr->nombres)?$usr->nombres:'';
			$paterno = isset($usr->paterno)?$usr->paterno:'';
			$materno = isset($usr->materno)?$usr->materno:'';
			$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
			$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
			$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
			$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
			$aux->domicilo = isset($usr->direccion)?$usr->direccion:'';
			$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
			$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
			$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
			$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			$aux->telefono = isset($usr->fono)?$usr->fono:'';
			$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';
			array_push($datos_generales, $aux);
			unset($aux);
		}

		$jornada = isset($datos_req->jornada)?$datos_req->jornada:'';
		$get_jornada = $this->Descripcion_horarios_model->get($jornada);
		$tipo_jornada = isset($get_jornada->id_tipo_horario)?$get_jornada->id_tipo_horario:'';
		$id_empresa_planta = isset($get_datos_req->planta_id)?$get_datos_req->planta_id:'';
		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_empresa_planta);
		$pagina['datos_generales'] = $datos_generales;
		$pagina['datos_req'] = $datos_req;
		$pagina['tipo_jornada'] = $tipo_jornada;
		$this->load->view('carrera/requerimientos/modal_crear_anexo', $pagina);
	}

	function guardar_anexo($usuario,$tipo,$asc_area){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/Empresa_planta_model");
		$this->load->model("carrera/ciudades_model");
		$id_area_cargo = $this->Requerimiento_asc_trabajadores_model->get($asc_area)->requerimiento_area_cargo_id;

		if (empty($_POST['fechaTerminoAnexo'])) {

			$this->session->set_userdata('error',1);
			redirect('carrera/requerimientos/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
		}
		if (empty($_POST['fecha_termino_contrato_anterior']) || empty($_POST['fechaTerminoAnexo']) || empty($_POST['nombre']) || empty($_POST['rut']) || empty($_POST['nacionalidad']) || empty($_POST['fecha_nacimiento']) || empty($_POST['estado_civil']) || empty($_POST['domicilo']) || empty($_POST['ciudad']) || empty($_POST['id_planta'])  ) {
			$this->session->set_userdata('error',3);
			
			redirect('carrera/requerimientos/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
		}

		if(empty($_POST['fecha_inicio_contrato']))
			$fecha_inicio = '0000-00-00';
		else
			$fecha_inicio = $_POST['fecha_inicio_contrato'];

		$get_planta = $this->Empresa_planta_model->get($_POST['id_planta']);
		$get_ciudad_planta = $this->ciudades_model->get($get_planta->id_ciudades);
		$data = array(
			'usuario_id' => $usuario,
			'requerimiento_asc_trabajadores_id' => $asc_area,
			'id_requerimiento_area_cargo' => $_POST['id_area_cargo'],
			'tipo_archivo_requerimiento_id' => $tipo,
			'fecha_inicio_contrato' => $fecha_inicio,
			'fecha_termino_contrato_anterior' => $_POST['fecha_termino_contrato_anterior'],
			'fecha_termino_nuevo_anexo' => $_POST['fechaTerminoAnexo'],
			'nombres'=> $_POST['nombre'],
			'rut_usuario'=>$_POST['rut'],
			'nacionalidad' => $_POST['nacionalidad'],
			'fecha_nac' => $_POST['fecha_nacimiento'],
			'estado_civil' => $_POST['estado_civil'],
			'direccion'=>$_POST['domicilo'],
			'ciudad' => $_POST['ciudad'],
			'id_planta' => $_POST['id_planta'],
			'lugar_trabajo'=>$get_ciudad_planta->desc_ciudades,
			'afp' => $_POST['afp'],
			'salud' => $_POST['salud'],
			'nombre_centro_costo' => $_POST['nombre_centro_costo'],
			'telefono' => $_POST['telefono'],
			'nivel_estudios' => $_POST['nivel_estudios'],
			'nombre_banco' => $_POST['nombre_banco'],
			'tipo_cuenta' => $_POST['tipo_cuenta'],
			'cuenta_banco' => $_POST['cuenta_banco'],
			'nombre_planta' => $_POST['nombre_planta'],
			'causal' => $_POST['causal'],
			'id_quien_creo' => $this->session->userdata('id'),
			//'id_quien_elimino' => $this->session->userdata('id'),
			'estado' => 0, //0 creado , 1 en revision , 2 aprobado , 3 en proceso de baja , 4 bajado,5 eliminado
		);
		
		$this->session->set_userdata('error',2);
		$this->Requerimiento_Usuario_Archivo_model->ingresarAnexo($data);
		redirect('carrera/requerimientos/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
	}

function descargar_carta_termino($id_usuario, $idArchivo, $tipoArchivo){
		if (empty($id_usuario) || empty($idArchivo) || empty($tipoArchivo)  ) {
			header('Location:' . getenv('HTTP_REFERER'));
		}
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");

		if ($tipoArchivo == 1) { // Contrato
			$datos = $this->Requerimiento_Usuario_Archivo_model->get_contrato($idArchivo);
				
		}elseif ($tipoArchivo == 2) { //Anexo de contrato
			$datos = $this->Requerimiento_Usuario_Archivo_model->get_anexo($idArchivo);
		}
		if ($datos) {
			//var_dump($datos); return false;
			$template_formato = base_url()."extras/contratos/anexos/terminoContratoArauco.docx";
			$templateWord = new TemplateProcessor($template_formato);
			$salto_linea = "<w:br/>";

			$date = $datos->fecha_termino;
			$date1 = str_replace('-', '/', $date);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			$tomorrow2 = date('Y-m-d',strtotime($date1 . "+10 days"));
			#fecha de termino mas 1 dias
			$var1 = explode('-',$tomorrow); 
			$dia = $var1[2];
			$mes = $var1[1];
			$ano = $var1[0];
			switch($mes){
                   case 1: $mesTermino="Enero"; break;
                   case 2: $mesTermino="Febrero"; break;
                   case 3: $mesTermino="Marzo"; break;
                   case 4: $mesTermino="Abril"; break;
                   case 5: $mesTermino="Mayo"; break;
                   case 6: $mesTermino="Junio"; break;
                   case 7: $mesTermino="Julio"; break;
                   case 8: $mesTermino="Agosto"; break;
                   case 9: $mesTermino="Septiembre"; break;
                   case 10: $mesTermino="Octubre"; break;
                   case 11: $mesTermino="Noviembre"; break;
                   case 12: $mesTermino="Diciembre"; break;
                }
			$fechaUnoMasTermino= $dia." de ".$mesTermino." de ".$ano;
			#fecha termino real
			$var1 = explode('-',$datos->fecha_termino); 
			$dia = $var1[2];
			$mes = $var1[1];
			$ano = $var1[0];
			switch($mes){
                   case 1: $mesTermino="Enero"; break;
                   case 2: $mesTermino="Febrero"; break;
                   case 3: $mesTermino="Marzo"; break;
                   case 4: $mesTermino="Abril"; break;
                   case 5: $mesTermino="Mayo"; break;
                   case 6: $mesTermino="Junio"; break;
                   case 7: $mesTermino="Julio"; break;
                   case 8: $mesTermino="Agosto"; break;
                   case 9: $mesTermino="Septiembre"; break;
                   case 10: $mesTermino="Octubre"; break;
                   case 11: $mesTermino="Noviembre"; break;
                   case 12: $mesTermino="Diciembre"; break;
                }
			$fechaTermino= $dia." de ".$mesTermino." de ".$ano;

			$nombreTrabajador = $datos->nombres." ".$datos->paterno." ".$datos->materno;


			$festivosDelAno = array(
				    '01-01',  //  Año Nuevo (irrenunciable)
				    '19-04',  //  Viernes Santo (feriado religioso)
				    '20-04',  //  Sábado Santo (feriado religioso)
				    '01-05',  //  Día Nacional del Trabajo (irrenunciable)
				    '21-05',  //  Día de las Glorias Navales
				    '29-06',  //  San Pedro y San Pablo (feriado religioso)
				    '16-07',  //  Virgen del Carmen (feriado religioso)
				    '15-08',  //  Asunción de la Virgen (feriado religioso)
				    '18-09',  //  Día de la Independencia (irrenunciable)
				    '19-09',  //  Día de las Glorias del Ejército
				    '12-10',  //  Aniversario del Descubrimiento de América
				    '31-10',  //  Día Nacional de las Iglesias Evangélicas y Protestantes (feriado religioso)
				    '01-11',  //  Día de Todos los Santos (feriado religioso)
				    '08-12',  //  Inmaculada Concepción de la Virgen (feriado religioso)
				    '25-12',  //  Natividad del Señor (feriado religioso) (irrenunciable)
				);
				 
				$startDate = (new DateTime($datos->fecha_termino));    //inicia
				$endDate = (new DateTime($datos->fecha_termino))->modify('+30 day');    //termina
				// var_dump($endDate);
				$interval = new DateInterval('P1D'); // intervalo de un día
				/** @var \DateTime[] $date_range */
				$date_range = new DatePeriod($startDate, $interval ,$endDate); //creamos rango de fechas
				//var_dump($date_range);
				 
				$workdays = 0;
				foreach($date_range as $date){
				    //Se considera el Domingo y los feriados como no hábiles
				    if($date->format("N") <7 AND !in_array($date->format("d-m"),$festivosDelAno)){
				        ++$workdays; // se cuentan los días habiles
				        if ($workdays==10) {
				        	$diaqlo =$date;
				        }
				    }
				}

				$wenats =  $diaqlo->format('Y-m-d');
				$diaqlo2 =explode('-', $wenats);
				$dia = $diaqlo2[2];
				$mes = $diaqlo2[1];
				$ano = $diaqlo2[0];

				switch($mes){
                   case 1: $mesTermino="Enero"; break;
                   case 2: $mesTermino="Febrero"; break;
                   case 3: $mesTermino="Marzo"; break;
                   case 4: $mesTermino="Abril"; break;
                   case 5: $mesTermino="Mayo"; break;
                   case 6: $mesTermino="Junio"; break;
                   case 7: $mesTermino="Julio"; break;
                   case 8: $mesTermino="Agosto"; break;
                   case 9: $mesTermino="Septiembre"; break;
                   case 10: $mesTermino="Octubre"; break;
                   case 11: $mesTermino="Noviembre"; break;
                   case 12: $mesTermino="Diciembre"; break;
                }
                $fechaPago = $dia." de ".$mesTermino." de ".$ano;

			// Insertamos variables en el word
			$templateWord->setValue('fechaUnoMasTermino',$fechaUnoMasTermino);
			$templateWord->setValue('nombreTrabajador',$nombreTrabajador);
			$templateWord->setValue('fechaTermino',$fechaTermino);
			$templateWord->setValue('rutTrabajador',$datos->rut_usuario);
			$templateWord->setValue('diaDePago',$fechaPago);
			$templateWord->setValue('nombrePlanta',$datos->nombrePlanta);
			// Guardamos el documento
			$nombre_documento = "carta_termino_".$datos->nombres.".docx";
			$templateWord->saveAs("extras/contratos/termiContratosGenerados/".$nombre_documento);

			$get_url = "extras/contratos/termiContratosGenerados/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);
			header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
		}else{
			header('Location:' . getenv('HTTP_REFERER'));
		}
	}

	function modal_administrar_archivo_usu($id_req_usu_arch = FALSE, $id_area_req = FALSE){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_req_usu_arch);
		$pagina['id_req_usu_arch']= $id_req_usu_arch;
		$pagina['id_area_req']= $id_area_req;
		$this->load->view('carrera/requerimientos/modal_administrar_doc_contractuales', $pagina);
	}


	function actualizar_doc_contractual($id_req_usu_arch, $id_area_req){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		if($_FILES['documento']['error'] == 0){
			$nombreTrabajador= $this->Requerimiento_Usuario_Archivo_model->getNombreTrabajador($id_req_usu_arch);
			//var_dump($nombreTrabajador);return false;
			$this->load->helper("archivo");
			$nb_archivo = urlencode(sanear_string($nombreTrabajador->name));
			$salida = subir($_FILES,"documento","extras/doc_contractuales/",$nb_archivo);
			$archivo = array(
				'nombre' => 'CT_'.$nombreTrabajador->nombreTrabajador,
				'url' => $salida,
			);
		}else{ 
			$archivo = array();
		}
		
		$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $archivo);
		header('Location:' . getenv('HTTP_REFERER'));
		//redirect('est/requerimiento/usuarios_requerimiento/'.$id_area_req, 'refresh');
	}


	function callback_view_documentos($id_usuario,$id_asc_area_req,$id_req = FALSE){
		$this->load->model("carrera/tipoarchivos_requerimiento_model");
		$this->load->model("carrera/requerimiento_usuario_archivo_model");
		$this->load->model("carrera/Tipoarchivos_model");
		$this->load->model("carrera/Archivos_trab_model");
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/Evaluaciones_model");
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$this->load->model("carrera/Pensiones_Requerimiento_model");
		$this->load->model("carrera/Pensiones_Valores_model");
		$this->load->model("carrera/Pensiones_model");
		$usr = $this->Usuarios_model->get($id_usuario);
		$base['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$archivos = $this->tipoarchivos_requerimiento_model->listar();
		$pensiones = $this->Pensiones_Requerimiento_model->get_pension_area_cargo($id_req, $id_usuario);

		$salida = array();
		foreach ($archivos as $a){
			$dato = $this->requerimiento_usuario_archivo_model->get_usuario_requerimiento_archivo($id_usuario,$id_asc_area_req,$a->id);
			$aux = new StdClass();
			$tipo_archivo = isset($a->id)?$a->id:'';
			//if($tipo_archivo != 1 and $tipo_archivo != 2){
				$aux->id = $a->id;
				$aux->usuario_id = $id_usuario;
				$aux->archivo = $a->nombre;
				$aux->id_requerimiento = $id_req;
		
				$aux->datos = array();
				if (!empty($dato)){
					foreach ($dato as $d){
						$archivo = new StdClass();
						$archivo->id = $d->id;
						$archivo->nombre = urldecode($d->nombre);
						$archivo->url = $d->url;
						array_push($aux->datos, $archivo);
					}
					unset($archivo);
				}
				array_push($salida, $aux);
				unset($aux);
			//}
		}

		$salida2 = array();
		foreach ($pensiones as $p){
			$aux2 = new StdClass();
			$get_datos_pension_valores = $this->Pensiones_Valores_model->get_valores($p->id_pension_valores);
			$id_pension = isset($get_datos_pension_valores->id_pension)?$get_datos_pension_valores->id_pension:'0';
			$get_pension = $this->Pensiones_model->get_row($id_pension);
			$aux2->id_pension_req = $p->id;
			$aux2->nombre_pension = isset($get_pension->razon_social)?$get_pension->razon_social:'';
			array_push($salida2, $aux2);
			unset($aux2);
		}

		$archivos_trab = $this->Tipoarchivos_model->listar_2();
		$salida3 = array();
		foreach ($archivos_trab as $a){
			$aux3 = new StdClass();
			$aux3->id_usuario = $id_usuario;
			$aux3->nombre = $a->desc_tipoarchivo;
			$aux3->id_archivo_trabaj = $a->id;
			$aux3->id_requerimiento = $id_req;
			$get_archivo_trabaj = $this->Archivos_trab_model->get_archivo2($id_usuario, $a->id);
			$aux3->nombre_archivo_trabaj = (isset($get_archivo_trabaj->nombre))?$get_archivo_trabaj->nombre:'';
			$aux3->archivo_trabaj = (isset($get_archivo_trabaj->url))?$get_archivo_trabaj->url:'';	
			array_push($salida3, $aux3);
			unset($aux3);
		}

		$base['masso'] = $this->Evaluaciones_model->get_una_masso($id_usuario);
		$base['preocupacional'] = $this->Evaluaciones_model->get_una_preocupacional($id_usuario);
		$base['archivos'] = $salida;
		$base['datos_pension'] = $salida2;
		$base['archivos_trab'] = $salida3;
		$base['asc_area'] = $id_asc_area_req;
		$this->load->view('carrera/requerimientos/documentos_contractuales',$base);
	}
	function modal_administrar_anexo($idAnexo, $id_area_cargo){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($idAnexo);
		//var_dump($datosAnexoContrato);
		$pagina['datosAnexo']= $datosAnexoContrato;
		$pagina['id_planta'] = $this->Requerimiento_Usuario_Archivo_model->getIdEmpresa($datosAnexoContrato->id_planta);
		$pagina['id_area_cargo']= $id_area_cargo;
		$pagina['anexos']= $datosAnexoContrato;
		//var_dump($pagina['anexos']);
		$this->load->view('carrera/requerimientos/modal_administrar_anexo', $pagina);
	}

	function enviar_revision($id= false){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$data = array(
			'id_quien_solicita' => $this->session->userdata('id'),
			'estado' => 1,
			'fecha_solicitud' => date('Y-m-d H:i:s'),
		);
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($id);
		$get_solicitante = $this->Usuarios_general_model->get($this->session->userdata('id'));
			$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
			$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
			$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
			$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
		$resultado = $this->Requerimiento_Usuario_Archivo_model->actualizarAnexo($id, $data);
		if ($resultado == 1) {
			$this->load->library('email');
				$config['smtp_host'] = 'mail.empresasintegra.cl';
				$config['smtp_user'] = 'informaciones@empresasintegra.cl';
				$config['smtp_pass'] = '%SYkNLH1';
				$config['mailtype'] = 'html';
				$config['smtp_port']    = '2552';
				$this->email->initialize($config);
			    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Anexo SGO - carrera');
			   // $this->email->to('nrojas@empresasintegra.cl');
			    $this->email->cc('jcruces@empresasintegra.cl');
			    $this->email->subject("Solicitud Anexo de Contrato Trabajador: ".$datosAnexoContrato->nombres." - Fecha Inicio Contrato: ".$datosAnexoContrato->fecha_inicio_contrato);
			    $this->email->message('Estimados el administrador '.$nombre_completo_solicitante.' ha realizado una solicitud de contrato del trabajador: '.$datosAnexoContrato->nombres.' con el siguiente Rut: '.$datosAnexoContrato->rut_usuario.'.<br>Saludos');
			    $this->email->send();
		}
		echo json_encode($resultado);
	}
	function descargar_anexo($id){
	//inicio de boton generar anexo
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$datos = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($id);
		//var_dump($datos); return false;
		if ($datos->estado == 2) {
				$template_formato = base_url()."extras/contratos/anexos/anexocarrera.docx";
				$templateWord = new TemplateProcessor($template_formato);
				$salto_linea = "<w:br/>";
				$var1 = explode('.',$datos->rut_usuario); 
				$rut1 = $var1[0];

				if($rut1 < 10){
					$datos->rut_usuario = "0".$datos->rut_usuario;
				}

				$getFechaTerminoAnterior=date($datos->fecha_termino_contrato_anterior); 
				$var1 = explode('-',$getFechaTerminoAnterior);
				$dia_fi = $var1[2];
				$mes_fi = $var1[1];
				$ano_fi = $var1[0];

				switch($mes_fi){
                   case 1: $mesTerminoAnterior="Enero"; break;
                   case 2: $mesTerminoAnterior="Febrero"; break;
                   case 3: $mesTerminoAnterior="Marzo"; break;
                   case 4: $mesTerminoAnterior="Abril"; break;
                   case 5: $mesTerminoAnterior="Mayo"; break;
                   case 6: $mesTerminoAnterior="Junio"; break;
                   case 7: $mesTerminoAnterior="Julio"; break;
                   case 8: $mesTerminoAnterior="Agosto"; break;
                   case 9: $mesTerminoAnterior="Septiembre"; break;
                   case 10: $mesTerminoAnterior="Octubre"; break;
                   case 11: $mesTerminoAnterior="Noviembre"; break;
                   case 12: $mesTerminoAnterior="Diciembre"; break;
                }

				$getFechaInicioContrato=date($datos->fecha_inicio_contrato); 
				$var2 = explode('-',$getFechaInicioContrato); 
				$dia_ft = $var2[2];
				$mes_ft = $var2[1];
				$ano_ft = $var2[0];

				switch($mes_ft){
                   case 1: $mesInicioContrato="Enero"; break;
                   case 2: $mesInicioContrato="Febrero"; break;
                   case 3: $mesInicioContrato="Marzo"; break;
                   case 4: $mesInicioContrato="Abril"; break;
                   case 5: $mesInicioContrato="Mayo"; break;
                   case 6: $mesInicioContrato="Junio"; break;
                   case 7: $mesInicioContrato="Julio"; break;
                   case 8: $mesInicioContrato="Agosto"; break;
                   case 9: $mesInicioContrato="Septiembre"; break;
                   case 10: $mesInicioContrato="Octubre"; break;
                   case 11: $mesInicioContrato="Noviembre"; break;
                   case 12: $mesInicioContrato="Diciembre"; break;
                }

				$get_fecha_nacimiento=date($datos->fecha_nac); 
				$var3 = explode('-',$get_fecha_nacimiento); 
				$dia_fecha_nac = $var3[2];
				$mes_fecha_nac = $var3[1];
				$ano_fecha_nac = $var3[0];

				switch($mes_fecha_nac){
                   case 1: $mesFechaNacimiento="Enero"; break;
                   case 2: $mesFechaNacimiento="Febrero"; break;
                   case 3: $mesFechaNacimiento="Marzo"; break;
                   case 4: $mesFechaNacimiento="Abril"; break;
                   case 5: $mesFechaNacimiento="Mayo"; break;
                   case 6: $mesFechaNacimiento="Junio"; break;
                   case 7: $mesFechaNacimiento="Julio"; break;
                   case 8: $mesFechaNacimiento="Agosto"; break;
                   case 9: $mesFechaNacimiento="Septiembre"; break;
                   case 10: $mesFechaNacimiento="Octubre"; break;
                   case 11: $mesFechaNacimiento="Noviembre"; break;
                   case 12: $mesFechaNacimiento="Diciembre"; break;
                }


				$get_fecha_termino_nuevo=date($datos->fecha_termino_nuevo_anexo); 
				$var4 = explode('-',$get_fecha_termino_nuevo); 
				$dia_terminoAnexo = $var4[2];
				$mes_terminoAnexo = $var4[1];
				$ano_terminoAnexo = $var4[0];

				switch($mes_terminoAnexo){
                   case 1: $mesFechaTerminoAnexo="Enero"; break;
                   case 2: $mesFechaTerminoAnexo="Febrero"; break;
                   case 3: $mesFechaTerminoAnexo="Marzo"; break;
                   case 4: $mesFechaTerminoAnexo="Abril"; break;
                   case 5: $mesFechaTerminoAnexo="Mayo"; break;
                   case 6: $mesFechaTerminoAnexo="Junio"; break;
                   case 7: $mesFechaTerminoAnexo="Julio"; break;
                   case 8: $mesFechaTerminoAnexo="Agosto"; break;
                   case 9: $mesFechaTerminoAnexo="Septiembre"; break;
                   case 10: $mesFechaTerminoAnexo="Octubre"; break;
                   case 11: $mesFechaTerminoAnexo="Noviembre"; break;
                   case 12: $mesFechaTerminoAnexo="Diciembre"; break;
                }

				$fechaTerminoContratoAnterior = $dia_fi." de ".$mesTerminoAnterior." de ".$ano_fi;
				$fechaInicioContrato = $dia_ft." de ".$mesInicioContrato." de ".$ano_ft;
				$fechaNacimientoTrabajador = $dia_fecha_nac." de ".$mesFechaNacimiento." de ".$ano_fecha_nac;
				$fechaTerminoAnexo = $dia_terminoAnexo." de ".$mesFechaTerminoAnexo." de ".$ano_terminoAnexo;

				// Insertamos variables en el word
				$templateWord->setValue('lugarTrabajo',$datos->lugar_trabajo);
				$templateWord->setValue('fechaTerminoContratoAnterior',$fechaTerminoContratoAnterior);
				$templateWord->setValue('nombreTrabajador',$datos->nombres);
				$templateWord->setValue('rutTrabajador',$datos->rut_usuario);
				$templateWord->setValue('nacionalidadTrabajador',$datos->nacionalidad);
				$templateWord->setValue('nacimientoTrabajador',$fechaNacimientoTrabajador);
				$templateWord->setValue('civil',$datos->estado_civil);
				$templateWord->setValue('domicilioTrabajador',titleCase($datos->direccion));
				$templateWord->setValue('ciudad',titleCase($datos->ciudad));
				$templateWord->setValue('fechaInicioContrato',$fechaInicioContrato);
				$templateWord->setValue('fechaTerminoAnexo',$fechaTerminoAnexo);


				// Guardamos el documento
				$nombre_documento = "contrato_trabajo_".$datos->nombres.".docx";
				$templateWord->saveAs("extras/contratos/anexosGenerados/".$nombre_documento);

				$get_url = "extras/contratos/anexosGenerados/".$nombre_documento;
				$url_ubicacion_archivo = (BASE_URL2.$get_url);
				header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
				echo file_get_contents($url_ubicacion_archivo);
		}else{
			header('Location:' . getenv('HTTP_REFERER'));
		}
	}
	
function modal_cargar_anexo($idAnexo, $id_area_cargo= false){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($idAnexo);
		//var_dump($datosAnexoContrato);
		$pagina['datosAnexo']= $datosAnexoContrato;
		$pagina['id_planta'] = $this->Requerimiento_Usuario_Archivo_model->getIdEmpresa($datosAnexoContrato->id_planta);
		


		$this->load->view('carrera/requerimientos/modal_subir_anexo', $pagina);
	}
	function eliminar_anexo($id){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$data = array(
			'id_quien_elimino' => $this->session->userdata('id'),
			'estado' => 5, //0 creado , 1 en revision , 2 aprobado , 3 en proceso de baja , 4 bajado,5 eliminado
		);

		$realizado=$this->Requerimiento_Usuario_Archivo_model->actualizarAnexo($id, $data);
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($id);
		//$this->session->set_userdata('error',6);
		/*redirect('est/requerimiento/contratos_req_trabajador/'.$datosAnexoContrato->usuario_id.'/'.$datosAnexoContrato->requerimiento_asc_trabajadores_id.'/'.$datosAnexoContrato->id_requerimiento_area_cargo.'', 'refresh');*/
		echo json_encode($realizado);
	}
	function actualizar_anexo($id=false){
		if ($id == false) {
			redirect(base_url());
		}
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$data = array(
			'fecha_termino_nuevo_anexo' => $_POST['fechaTerminoAnexo'],
		);
		$this->Requerimiento_Usuario_Archivo_model->actualizarAnexo($id, $data);
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($id);
		$this->session->set_userdata('error',4);
		redirect('carrera/requerimientos/contratos_req_trabajador/'.$datosAnexoContrato->usuario_id.'/'.$datosAnexoContrato->requerimiento_asc_trabajadores_id.'/'.$datosAnexoContrato->id_requerimiento_area_cargo.'', 'refresh');
	}
}

?>