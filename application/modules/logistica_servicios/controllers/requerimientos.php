<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

$archivo_numero_letras = "extras/contratos/numero_letras.php";
$autoloader = "extras/contratos/PHPWord-master/src/PhpWord/Autoloader.php";
require_once (BASE_URL2.$autoloader);
require_once (BASE_URL2.$archivo_numero_letras);
\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\TemplateProcessor;

class Requerimientos extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 12)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_logistica_servicios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 13)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_logistica_servicios_supervisor','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){

	}

	//OK
	function agregar(){
		$base = array(
			'head_titulo' => "Agregar Requerimiento - Sistema EST",
			'titulo' => "Publicacion de requerimiento",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'logistica_servicios/requerimientos/listado','txt' => 'Listado Requerimientos'), array('url'=>'','txt'=>'Crear Requerimiento' )),
			'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
				'js/form-wizard.js','plugins/select2/select2.min.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/requerimiento.js'),
			'css' => array('plugins/datepicker/css/datepicker.css','plugins/select2/select2.css','plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'menu' => $this->menu
		);
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model('logistica_servicios/Empresas_model');
		$this->load->model('Centrocostos_model');
		$this->load->model("logistica_servicios/Empresa_planta_model");
		$this->load->model("Relacion_usuario_planta_model");
		$this->load->model('Requerimientos_model');
		$pagina['listado_areas'] = $this->Areas_model->lista_orden_nombre();
		$pagina['listado_cargos'] = $this->Cargos_model->lista_orden_nombre();
		$pagina['listado_empresa'] = $this->Empresas_model->listar();
		$pagina['listado_centro_costo'] = $this->Centrocostos_model->listar();
		$pagina['unidad_negocio'] = $this->Empresa_planta_model->listar();
		$base['cuerpo'] = $this->load->view('requerimientos/crear_requerimiento',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	//OK
	function asignacion($id){
		$this->load->model("logistica_servicios/Requerimiento_area_cargo_model");
		$this->load->model('logistica_servicios/Requerimientos_model');
		$this->load->model('logistica_servicios/Empresa_planta_model');
		$this->load->model('logistica_servicios/Areas_model');
		$this->load->model('logistica_servicios/Cargos_model');
		$this->load->model('logistica_servicios/Requerimiento_asc_trabajadores_model');

		$datos_req = $this->Requerimientos_model->get_req_planta($id);
		$planta_id = (isset($datos_req->planta_id)?$datos_req->planta_id:"");

		$base = array(
			'head_titulo' => "Agregar Area/Cargos al Requerimiento - Sistema EST",
			'titulo' => "Asignacion area/cargo de requerimientos",
			'subtitulo' => '',
			'side_bar' => true,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'logistica_servicios/requerimientos/listado','txt' => 'Listado Requerimientos'), array('url'=>'','txt'=>'Asignar Areas - Cargos Requerimiento' )),
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
		$base['cuerpo'] = $this->load->view('requerimientos/asignar_area_cargo_requerimiento',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	//OK
	function guardar_area_cargo_req(){
		$this->load->model("logistica_servicios/Requerimiento_area_cargo_model");
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
		redirect('logistica_servicios/requerimientos/asignacion/'.$id_req.'', 'refresh');
	}

	//OK
	function eliminar_area_cargo_req($id_area_cargo, $id_req){
		$this->load->model("logistica_servicios/Requerimiento_area_cargo_model");
		$this->Requerimiento_area_cargo_model->eliminar($id_area_cargo);
		redirect('logistica_servicios/requerimientos/asignacion/'.$id_req, 'refresh');
	}

	//OK
	function listado(){
		$base = array(
			'head_titulo' => "Lista de Requerimientos - Sistema EST",
			'titulo' => "Listado de requerimientos",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Requerimientos' )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$this->load->model("logistica_servicios/Requerimiento_area_cargo_model");
		$this->load->model("logistica_servicios/Requerimientos_model");
		$this->load->model('logistica_servicios/Empresas_model');
		$this->load->model('logistica_servicios/Empresa_planta_model');

		$requerimientos = $this->Requerimientos_model->r_listar_order_estado();
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
		$base['cuerpo'] = $this->load->view('requerimientos/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	//OK
	function cambiar_estados_requerimientos(){
		$this->load->model("logistica_servicios/Requerimientos_model");

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
		redirect('logistica_servicios/requerimientos/listado', 'refresh');
	}

	//OK
	function editar_area_cargo_requerimiento($id_area_cargo, $id_req){
		$this->load->model("logistica_servicios/Requerimiento_area_cargo_model");
		$this->load->model('logistica_servicios/Areas_model');
		$this->load->model('logistica_servicios/Cargos_model');
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

	//OK
	function editar_requerimiento($id){
		$this->load->model("logistica_servicios/Requerimientos_model");
		$this->load->model("logistica_servicios/Empresa_planta_model");
		$pagina['listado_empresa'] = $this->Empresa_planta_model->listar();
		$pagina['listado'] = $this->Requerimientos_model->get_result($id);
		$this->load->view('requerimientos/modal_editar_datos_requerimiento', $pagina);
	}

	//OK
	function actualizar_requerimiento(){
		$this->load->model("logistica_servicios/Requerimientos_model");
		$id_req = $_POST['id_req'];

		$datos = array(
			"codigo_requerimiento" => $_POST['codigo'],
			"nombre" => $_POST['nombre'],
			"f_solicitud" => $_POST['f_solicitud'],
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
		redirect('logistica_servicios/requerimientos/listado', 'refresh');
	}

	//OK
	function actualizar_area_cargo_requerimiento(){
		$this->load->model("logistica_servicios/Requerimiento_area_cargo_model");
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
		redirect('logistica_servicios/requerimientos/asignacion/'.$id_req.'', 'refresh');
	}

	//OK
	function guardar_datos_requerimiento(){
		$this->load->model("logistica_servicios/Empresa_planta_model");
		$this->load->model("logistica_servicios/Requerimientos_model");

		$f_s = explode('-',$_POST['f_solicitud']);
		$f_solicitud = $f_s[2].'-'.$f_s[1].'-'.$f_s[0];

		$f_d = explode('-',$_POST['fdesde']);
		$fdesde = $f_d[2].'-'.$f_d[1].'-'.$f_d[0];

		$f_h = explode('-',$_POST['fhasta']);
		$fhasta = $f_h[2].'-'.$f_h[1].'-'.$f_h[0];
		$planta = $_POST['select_planta'];
		$get_datos_planta = $this->Empresa_planta_model->get($planta);
		$empresa_id = isset($get_datos_planta->id_centro_costo)?$get_datos_planta->id_centro_costo:'2';

		$data = array(
			'codigo_requerimiento' => $_POST['codigo_requerimiento'],
			'codigo_centro_costo' => $_POST['codigo_centro_costo'],
			'nombre' => strtoupper($_POST['n_solicitud']),
			'f_solicitud' => $f_solicitud,
			'empresa_id' => $empresa_id,
			'centro_costo_id' => NULL,
			'planta_id' => $_POST['select_planta'],
			'regimen' => $_POST['select_regimen'],
			'fecha_creacion' => date('Y-m-d'),
			'f_inicio' => $fdesde,
			'f_fin' => $fhasta,
			'causal' => $_POST['causal'],
			'motivo' => $_POST['motivo'],
			'comentario' => $_POST['comentarios'],
			'estado' => 1
		);
		$id_req = $this->Requerimientos_model->ingresar($data);
		echo "<script>alert('Requerimiento Guardado Exitosamente')</script>";
		redirect('logistica_servicios/requerimientos/asignacion/'.$id_req, 'refresh');
	}

	//OK
	function usuarios_requerimiento($id_area_cargo, $id_usuario = FALSE){
		$this->load->model("logistica_servicios/Requerimiento_Usuario_Archivo_model");
		$this->load->model("logistica_servicios/Requerimiento_asc_trabajadores_model");
		$this->load->model("logistica_servicios/Requerimiento_area_cargo_model");
		$this->load->model("logistica_servicios/Requerimientos_model");
		$this->load->model('logistica_servicios/Archivos_trab_model');
		$this->load->model('logistica_servicios/Empresas_model');
		$this->load->model("logistica_servicios/Usuarios_model");
		$this->load->model("logistica_servicios/Areas_model");
		$this->load->model("logistica_servicios/Cargos_model");
		$this->load->model("logistica_servicios/Empresa_planta_model");

		$r_area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Usuarios asignados",
			'subtitulo' => '',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'logistica_servicios/requerimientos/listado','txt' => 'Listado Requerimientos'), array('url'=>'logistica_servicios/requerimientos/asignacion/'.(isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0').'','txt' => 'Area-Cargo Requerimiento'), array('url'=>'','txt'=>'Listado de usuarios' )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_req.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$listado = array();
		$pagina['id_requerimiento'] = (isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0');
		$reque = $this->Requerimientos_model->get($r_area_cargo->requerimiento_id);
		$pagina['nombre_req'] = isset($reque->nombre)?$reque->nombre:'';
		$pagina['empresa'] = $this->Empresas_model->get($reque->empresa_id)->razon_social;
		$pagina['centro_costo'] = $this->Empresa_planta_model->get_planta_centro_costo($reque->planta_id)->desc_centrocosto;
		$pagina['planta'] = $this->Empresa_planta_model->get($reque->planta_id)->nombre;
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
			//$masso = $this->Evaluaciones_model->get_una_masso($r->usuario_id);
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

			$id_asc_trabajador = isset($r->id)?$r->id:'';
			$id_requerimiento = (isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0');
			$aux->contrato = $ar_contrato;
			$aux->certificado = $ar_certificado;
			$aux->comentario = $r->comentario;
			$aux->jefe_area = $r->jefe_area;

			$contratos_usu = $this->Requerimiento_Usuario_Archivo_model->get_result_tipo_archivo_usuario($r->usuario_id, $id_asc_trabajador, 1);
			$anexos_usu = $this->Requerimiento_Usuario_Archivo_model->get_result_tipo_archivo_usuario($r->usuario_id, $id_asc_trabajador, 2);

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
		$base['cuerpo'] = $this->load->view('requerimientos/usuarios_requerimiento',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	//OK
	function usuarios_requerimientos_listado($id_area_cargo){
		$this->load->model('logistica_servicios/Requerimiento_area_cargo_model');
		$this->load->model('logistica_servicios/Requerimientos_model');
		$this->load->model('logistica_servicios/Empresa_planta_model');
		$this->load->model('logistica_servicios/Areas_model');
		$this->load->model('logistica_servicios/Cargos_model');
		$this->load->model('logistica_servicios/Requerimiento_asc_trabajadores_model');
		$this->load->model('logistica_servicios/Usuarios_model');

		$area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
		$id_req = isset($area_cargo->requerimiento_id)?$area_cargo->requerimiento_id:0;

		$base = array(
			'head_titulo' => "Lista de Trabajadores - Sistema EST",
			'titulo' => "Listado de Trabajadores",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'logistica_servicios/requerimientos/usuarios_requerimiento/'.$id_area_cargo."", 'txt'=>'Volver a la Area - Cargo del Requerimiento'), array('url'=>'','txt'=>"Listado Trabajadores requerimiento ".$this->Requerimientos_model->get($id_req)->nombre."" )),
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
				array_push($lista,$aux);
				unset($aux);
			}
		}

		$pagina['datos_req'] = $aux_req;
		$pagina['lista_aux'] = $lista;
		$pagina['id_area_cargo'] = $id_area_cargo;
		$base['cuerpo'] = $this->load->view('requerimientos/listado_usuarios_req',$pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	//OK
	function agregar_usuarios_requerimiento(){
		$id_area_cargo =  $_POST['id_area_cargo'];
		$this->load->model("logistica_servicios/Requerimiento_asc_trabajadores_model");

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
		redirect('logistica_servicios/requerimientos/usuarios_requerimiento/'.$id_area_cargo, 'refresh');
	}

	//OK
	function contratos_req_trabajador($id_usuario,$id_asc_area_req,$id_area_cargo_req = FALSE){
		$this->load->model("logistica_servicios/requerimiento_usuario_archivo_model");
		$this->load->model("logistica_servicios/Requerimiento_asc_trabajadores_model");
		$this->load->model("logistica_servicios/Requerimiento_area_cargo_model");
		$this->load->model("logistica_servicios/Usuarios_model");
		$this->load->model("logistica_servicios/Ciudades_model");
		$this->load->model("logistica_servicios/Afp_model");
		$this->load->model("logistica_servicios/Salud_model");
		$this->load->model("logistica_servicios/Estado_civil_model");
		$this->load->model("logistica_servicios/Nivel_estudios_model");
		$this->load->model("logistica_servicios/Requerimientos_model");
		$this->load->model("logistica_servicios/Areas_model");
		$this->load->model("logistica_servicios/Cargos_model");
		$this->load->model("logistica_servicios/Empresas_model");
		$this->load->model("logistica_servicios/Empresa_planta_model");
		$this->load->model("logistica_servicios/Regiones_model");
		$this->load->model("logistica_servicios/Tipo_gratificacion_model");
		$this->load->model("logistica_servicios/Descripcion_horarios_model");

		$base = array(
			'head_titulo' => "Lista de Contratos - Sistema EST",
			'titulo' => "Listado de Contratos y/o Anexos",
			'subtitulo' => '',
			'side_bar' => true,
			'menu' => $this->menu,
			'js' => array('js/confirm.js','js/lista_req.js', 'js/usuarios_requerimientos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css'),
		);

		$usr = $this->Usuarios_model->get($id_usuario);
		$pagina['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$contratos_usu = $this->requerimiento_usuario_archivo_model->get_result_tipo_archivo_usuario($id_usuario, $id_asc_area_req, 1);
		$anexos_usu = $this->requerimiento_usuario_archivo_model->get_result_tipo_archivo_usuario($id_usuario, $id_asc_area_req, 2);

		$datos_generales = array();
		if($usr != FALSE){
			$aux = new StdClass();
			$id_ciudad = isset($usr->id_ciudad)?$usr->id_ciudad:'';
			$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
			$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
			$id_estado_civil = isset($usr->id_estado_civil)?$usr->id_estado_civil:'';
			$id_estudios = isset($usr->id_nivel_estudios)?$usr->id_nivel_estudios:'';
			$get_ciudad = $this->Ciudades_model->get($id_ciudad);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->Estado_civil_model->get($id_estado_civil);
			$get_nivel_estudios = $this->Nivel_estudios_model->get($id_estudios);
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
			$id_ciudad_planta = isset($get_planta->id_ciudades)?$get_planta->id_ciudades:'';
			$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
			$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
			$get_region_planta = $this->Regiones_model->get($id_region_planta);
			$get_ciudad_planta = $this->Ciudades_model->get($id_ciudad_planta);

			$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->ciudad_planta = isset($get_ciudad_planta->desc_ciudades)?$get_ciudad_planta->desc_ciudades:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
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
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->desc_jornada = isset($get_jornada->descripcion)?$get_jornada->descripcion:'';
				$aux->renta_imponible = $row->renta_imponible;
				$aux->estado_generacion_contrato = $row->estado_generacion_contrato;
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}

		$lista_aux2 = array();
		if($anexos_usu != FALSE){
			foreach($anexos_usu as $row2){
				$aux = new StdClass();
				$get_jornada = $this->Descripcion_horarios_model->get($row->jornada);
				$aux->id_req_usu_arch = $row2->id;
				$aux->usuario_id = $id_usuario;
				$aux->nombre = $row2->nombre;
				$aux->url = $row2->url;
				$aux->causal = $row2->causal;
				$aux->motivo = $row2->motivo;
				$aux->fecha_inicio = $row2->fecha_inicio;
				$aux->fecha_termino = $row2->fecha_termino;
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->desc_jornada = isset($get_jornada->descripcion)?$get_jornada->descripcion:'';
				$aux->renta_imponible = $row2->renta_imponible;
				$aux->estado_generacion_contrato = $row2->estado_generacion_contrato;
				array_push($lista_aux2, $aux);
				unset($aux);
			}
		}

		$pagina['datos_generales'] = $datos_generales;
		$pagina['contratos'] = $lista_aux;
		$pagina['anexos'] = $lista_aux2;
		$pagina['id_usuario'] = $id_usuario;
		$pagina['id_asc_area_req'] = $id_asc_area_req;
		$pagina['id_area_cargo_req'] = $id_area_cargo_req;
		$base['cuerpo'] = $this->load->view('requerimientos/documentos_contractuales_contratos_req',$pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	//OK
	function eliminar_contratos_req_trabajador($id_usuario, $id_asc_area_req, $id_area_cargo_req, $id_req_usu_arch){
		$this->load->model('logistica_servicios/Requerimiento_Usuario_Archivo_model');
		$this->Requerimiento_Usuario_Archivo_model->eliminar($id_req_usu_arch);
		redirect('logistica_servicios/requerimientos/contratos_req_trabajador/'.$id_usuario.'/'.$id_asc_area_req.'/'.$id_area_cargo_req.'', 'refresh');
	}

	//OK
	function modal_agregar_contrato_anexo($usuario,$tipo,$asc_area, $id_req_area_cargo){
		$this->load->model("logistica_servicios/Requerimiento_Usuario_Archivo_model");
		$this->load->model("logistica_servicios/Requerimiento_area_cargo_model");
		$this->load->model("logistica_servicios/Requerimiento_asc_trabajadores_model");
		$this->load->model("logistica_servicios/Usuarios_model");
		$this->load->model("logistica_servicios/Ciudades_model");
		$this->load->model("logistica_servicios/Afp_model");
		$this->load->model("logistica_servicios/Salud_model");
		$this->load->model("logistica_servicios/Estado_civil_model");
		$this->load->model("logistica_servicios/Nivel_estudios_model");
		$this->load->model("logistica_servicios/Requerimientos_model");
		$this->load->model("logistica_servicios/Areas_model");
		$this->load->model("logistica_servicios/Cargos_model");
		$this->load->model("logistica_servicios/Empresas_model");
		$this->load->model("logistica_servicios/Empresa_planta_model");
		$this->load->model("logistica_servicios/Regiones_model");
		$this->load->model("logistica_servicios/Tipo_gratificacion_model");
		$this->load->model("logistica_servicios/Descripcion_horarios_model");

		$pagina['usuario']= $usuario;
		$pagina['tipo']= $tipo;
		$pagina['asc_area']= $asc_area;
		
		$get_datos_req = $this->Requerimiento_area_cargo_model->r_get_requerimiento($id_req_area_cargo);
		$pagina['motivo_defecto'] = (isset($get_datos_req->motivo)?$get_datos_req->motivo:'');
		$pagina['causal_defecto'] = (isset($get_datos_req->causal)?$get_datos_req->causal:'');

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
			$id_estado_civil = isset($usr->id_estado_civil)?$usr->id_estado_civil:'';
			$id_estudios = isset($usr->id_nivel_estudios)?$usr->id_nivel_estudios:'';
			$get_ciudad = $this->Ciudades_model->get($id_ciudad);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->Estado_civil_model->get($id_estado_civil);
			$get_nivel_estudios = $this->Nivel_estudios_model->get($id_estudios);
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
			$get_region_planta = $this->Regiones_model->get($id_region_planta);

			$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
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
		$id_empresa_planta = isset($get_datos_req->planta_id)?$get_datos_req->planta_id:'';
		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_empresa_planta);
		$pagina['datos_generales'] = $datos_generales;
		$pagina['datos_req'] = $datos_req;
		$pagina['datos_generales'] = $datos_generales;
		$this->load->view('requerimientos/modal_agregar_contrato_anexo_doc_contractuales', $pagina);
	}

	//OK
	function guardar_nuevo_contrato_anexo_doc_contractual($usuario,$tipo,$asc_area){
		$this->load->model("logistica_servicios/Requerimiento_Usuario_Archivo_model");
		$this->load->model("logistica_servicios/Requerimiento_asc_trabajadores_model");
		$this->load->model("logistica_servicios/Usuarios_model");

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
				'nombre' => '',
				'url' => '',
				'causal' => $_POST['causal'],
				'motivo' => $_POST['motivo'],
				'fecha_inicio' => $fecha_inicio,
				'fecha_termino' => $fecha_termino,
				'jornada' => $_POST['jornada'],
				'renta_imponible' => $_POST['renta_imponible'],
				'asignacion_movilizacion' => $_POST['asignacion_movilizacion'],
				'asignacion_colacion' => $_POST['asignacion_colacion'],
				'asignacion_zona' => $_POST['asignacion_zona'],
				'viatico' => $_POST['viatico'],
				'seguro_vida_arauco' => 'SI',
				'estado_proceso' => 0,
				'gc_usuario_id' => null,
				'gc_fecha' => null,
			);
		}else{
			$data = array(
				'usuario_id' => $usuario,
				'requerimiento_asc_trabajadores_id' => $asc_area,
				'tipo_archivo_requerimiento_id' => $tipo
			);
		}
		$this->Requerimiento_Usuario_Archivo_model->ingresar($data);
		redirect('logistica_servicios/requerimientos/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
	}

	//OK
	function modal_administrar_contrato_anexo_doc_general($id_usu_arch,$id_area_cargo){
		$this->load->model("logistica_servicios/Requerimiento_Usuario_Archivo_model");
		$this->load->model("logistica_servicios/Requerimiento_area_cargo_model");
		$this->load->model("logistica_servicios/Requerimiento_asc_trabajadores_model");
		$this->load->model("logistica_servicios/Usuarios_model");
		$this->load->model("logistica_servicios/Ciudades_model");
		$this->load->model("logistica_servicios/Afp_model");
		$this->load->model("logistica_servicios/Salud_model");
		$this->load->model("logistica_servicios/Estado_civil_model");
		$this->load->model("logistica_servicios/Nivel_estudios_model");
		$this->load->model("logistica_servicios/Requerimientos_model");
		$this->load->model("logistica_servicios/Areas_model");
		$this->load->model("logistica_servicios/Cargos_model");
		$this->load->model("logistica_servicios/Empresas_model");
		$this->load->model("logistica_servicios/Empresa_planta_model");
		$this->load->model("logistica_servicios/Regiones_model");
		$this->load->model("logistica_servicios/Tipo_gratificacion_model");
		$this->load->model("logistica_servicios/Descripcion_horarios_model");

		$revisiones_al_dia = 0;
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
			$get_ciudad = $this->Ciudades_model->get($id_ciudad);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->Estado_civil_model->get($id_estado_civil);
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
			$get_region_planta = $this->Regiones_model->get($id_region_planta);
			$get_ciudad_planta = $this->Ciudades_model->get($id_ciudad_planta);

			$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
			$aux->descripcion_tipo_gratificacion = isset($get_gratif->descripcion)?$get_gratif->descripcion:'';
			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->ciudad_planta = isset($get_ciudad_planta->desc_ciudades)?$get_ciudad_planta->desc_ciudades:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
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

			$get_proceso_val_contr = $this->Requerimiento_Usuario_Archivo_model->get_proceso_contrato_tipo($id_usu_arch, 1);
			$get_proceso_validado = $this->Requerimiento_Usuario_Archivo_model->get_proceso_contrato_tipo($id_usu_arch, 2);
			$get_proceso_aprobado = $this->Requerimiento_Usuario_Archivo_model->get_proceso_contrato_tipo($id_usu_arch, 3);
			$get_proceso_rechazo = $this->Requerimiento_Usuario_Archivo_model->get_proceso_contrato_tipo($id_usu_arch, 4);
			$get_solicitudes_contratos = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_usu_arch);

			$aux->comentarios = isset($get_solicitudes_contratos->observaciones)?$get_solicitudes_contratos->observaciones:"";
			$aux->get_proceso_val_contr = isset($get_proceso_val_contr->id)?1:0;
			$aux->get_proceso_validado = isset($get_proceso_validado->id)?1:0;
			$aux->get_proceso_aprobado = isset($get_proceso_aprobado->id)?1:0;
			$aux->get_proceso_rechazo = isset($get_proceso_rechazo->id)?1:0;

			array_push($datos_generales, $aux);
			unset($aux);
		}

		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_planta);
		$pagina['datos_generales'] = $datos_generales;
		$pagina['id_usu_arch']= $id_usu_arch;
		$pagina['revisiones_al_dia']= $revisiones_al_dia;
		$pagina['id_area_cargo']= $id_area_cargo;
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_usu_arch);
		$this->load->view('requerimientos/modal_administrar_contrato_anexo_doc_contractuales', $pagina);
	}

	//OK
	function actualizar_contrato_anexo_doc_contractual($id_usu_arch,$id_area_cargo){
		$this->load->model("logistica_servicios/Requerimiento_Usuario_Archivo_model");
		$this->load->model("logistica_servicios/Descripcion_horarios_model");
		$this->load->model("logistica_servicios/Descripcion_causal_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->library('zip');
		$this->load->helper('download');

		if(empty($_POST['ano_fi']) || empty($_POST['mes_fi']) || empty($_POST['dia_fi']) )
			$fecha_inicio = NULL;
		else
			$fecha_inicio = $_POST['ano_fi'].'-'.$_POST['mes_fi'].'-'.$_POST['dia_fi'];

		if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
			$fecha_termino = NULL;
		else
			$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

		$causal = isset($_POST['causal'])?$_POST['causal']:'';
		$motivo = isset($_POST['motivo'])?$_POST['motivo']:'';
		$fecha_inicio = $fecha_inicio;
		$fecha_termino = $fecha_termino;
		$jornada = isset($_POST['jornada'])?$_POST['jornada']:'';
		$renta_imponible = isset($_POST['renta_imponible'])?$_POST['renta_imponible']:'';
		$asignacion_movilizacion = isset($_POST['asignacion_movilizacion'])?$_POST['asignacion_movilizacion']:0;
		$asignacion_colacion = isset($_POST['asignacion_colacion'])?$_POST['asignacion_colacion']:0;
		$asignacion_zona = isset($_POST['asignacion_zona'])?$_POST['asignacion_zona']:0;
		$viatico = isset($_POST['viatico'])?$_POST['viatico']:0;
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
		$nivel_estudios = $_POST['nivel_estudios'];
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

		$data = array(
			'causal' => $causal,
			'motivo' => $motivo,
			'fecha_inicio' => $fecha_inicio,
			'fecha_termino' => $fecha_termino,
			'jornada' => $jornada,
			'renta_imponible' => $renta_imponible,
			'asignacion_movilizacion' => $asignacion_movilizacion,
			'asignacion_colacion' => $asignacion_colacion,
			'asignacion_zona' => $asignacion_zona,
			'viatico' => $viatico,
			'seguro_vida_arauco' => 'SI'
		);

		$datos_generacion_contrato = array(
			'estado_generacion_contrato' => 1,
			'gc_usuario_id' => $this->session->userdata('id'),
			'gc_fecha' => date('Y-m-d H:i:s')
		);

		if (isset($_POST['actualizar'])){
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
				'estado' => 0,
			);

			$data2 = array('estado_proceso' => 1, );
			$total_datos = array_merge($data, $data2);
			$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_usu_arch, $total_datos);
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
		    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - BLUE');
		    $this->email->to('veronica.figueroa@empresasintegra.cl');
		    $this->email->subject("Solicitud Contrato Trabajador: ".$nombre_trabajador);
		    $this->email->message('Estimada el supervisor '.$nombre_completo_solicitante.' ha realizado una solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.'.<br>Saludos');
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
			$jornada = $_POST['gc_jornada'];
			$renta_imponible = $_POST['gc_renta_imponible'];
			$asignacion_zona = $_POST['gc_asignacion_zona'];
			$asignacion_movilizacion = $_POST['gc_asignacion_movilizacion'];
			$asignacion_colacion = $_POST['gc_asignacion_colacion'];
			$viatico = $_POST['gc_viatico'];
			$motivo = $_POST['gc_motivo'];

			$template_formato = base_url()."extras/contratos/formato_contratos_blue_express.docx";
			$templateWord = new TemplateProcessor($template_formato);

			$salto_linea = "<w:br/>";

			$var1 = explode('.',$rut_trabajador); 
			$rut1 = $var1[0];

			if($rut1 < 10)
				$rut_trabajador = "0".$rut_trabajador;

			$get_fecha_inicio=date($fecha_inicio); 
			$var1 = explode('-',$get_fecha_inicio); 
			$get_dia_fi = $var1[2];
			$dia_fi = $var1[2];
			$mes_fi = $var1[1];
			$ano_fi = $var1[0];

			/*
			if($get_dia_fi < 10)
				$dia_fi = "0".$var1[2];
			else
				$dia_fi = $var1[2];
			*/

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
			$dia_ft = $var2[2];
			$mes_ft = $var2[1];
			$ano_ft = $var2[0];
			
			/*
			if($get_dia_ft < 10)
				$dia_ft = "0".$var2[2];
			else
				$dia_ft = $var2[2];
			*/

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

			$get_descripcion_horario = $this->Descripcion_horarios_model->get($jornada);
			$descripcion_jornada = isset($get_descripcion_horario->descripcion)?$get_descripcion_horario->descripcion:'';

			$asignacion_zona_palabras = num2letras($asignacion_zona);
			$asignacion_movilizacion_palabras = num2letras($asignacion_movilizacion);
			$asignacion_colacion_palabras = num2letras($asignacion_colacion);
			$viatico_palabras = num2letras($viatico);

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

			$detalle_bonos = $frase_asignacion_movilizacion.$frase_asignacion_colacion.$frase_asignacion_zona.$frase_viatico;
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
			$templateWord->setValue('motivo_req',titleCase($motivo));
			$templateWord->setValue('cargo_postulante',titleCase($cargo));
			$templateWord->setValue('comuna_planta',titleCase($comuna_planta));
			$templateWord->setValue('descripcion_causal',$descripcion_causal);
			$templateWord->setValue('descripcion_jornada',$descripcion_jornada);
			$templateWord->setValue('sueldo_base_numeros', str_replace(',','.',number_format($renta_imponible)));
			$templateWord->setValue('sueldo_base_palabras',titleCase($sueldo_base_palabras));
			$templateWord->setValue('detalle_bonos',$detalle_bonos);
			$templateWord->setValue('prevision_trabajador',titleCase($prevision_trabajador));
			$templateWord->setValue('salud_trabajador',titleCase($salud_trabajador));
			$templateWord->setValue('fecha_ingreso_trabajador',$fecha_inicio_texto_largo);
			$templateWord->setValue('fecha_vigencia_contrato',$fecha_termino_texto_largo);

			// Guardamos el documento
			$nombre_documento = "contrato_trabajo_".$nombre_sin_espacios.".docx";
			$templateWord->saveAs("extras/contratos/archivos_blue/".$nombre_documento);

			$get_url = "extras/contratos/archivos_blue/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename='".$nombre_documento."'; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
			echo '<script>alert("Contrato generado exitosamente");</script>';
			//fin de boton generar contrato
		}
		$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);
		$usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
		$asc_area = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
		redirect('logistica_servicios/requerimientos/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
	}

	//OK
	function guardar_fecha(){
		$this->load->model("logistica_servicios/Requerimiento_asc_trabajadores_model");
		$this->load->library('session');

		$arreglo = array(
			$_POST['name'] => $_POST['value'],
			'quien' => $this->session->userdata('id'),
			'actualizacion' => date("Y-m-d h:i:s")
		);
		$this->Requerimiento_asc_trabajadores_model->editar($_POST['pk'], $arreglo );
	}















	function revisar_cambios(){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		if( $this->Requerimiento_asc_trabajadores_model->consultar_actualizacion($this->session->userdata('id'),$this->fecha_actual) )
			print_r($this->Requerimiento_asc_trabajadores_model->consultar_actualizacion($this->session->userdata('id'),$this->fecha_actual));
	}
	
	function modal_comentario($id){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$base['id'] = $id;
		$base['comentario'] = ($this->Requerimiento_asc_trabajadores_model->get($id)->comentario)?$this->Requerimiento_asc_trabajadores_model->get($id)->comentario:'';
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->model("Requerimiento_asc_trabajadores_model");

			$data = array('comentario' => $_POST['comentario']);
			$this->Requerimiento_asc_trabajadores_model->editar($id,$data);
		} 
		else
			$this ->load->view('requerimiento/modal_comentario',$base);
	}

	function editar_usuarios_req(){
		$this->load->model("Requerimiento_asc_trabajadores_model");

		$data = json_decode($_POST['json']);
		foreach ($data as $k => $v){
			if ($k == 'id') $id = $v;
			if( $k == 'referido') $referido = $v;
			if( $k == 'contacto' ) $contacto = $v;
			if( $k == 'disponibilidad' ) $disponibilidad = $v;
			if( $k == 'contrato' ) $contrato = $v;
			if( $k == 'status' ) $status = $v;
		}
		$salida = array( 
			'referido' => $referido,
			'contacto' => $contacto,
			'disponibilidad' => $disponibilidad,
			'contrato' => $contrato,
			'status' => $status
		);
		$this->Requerimiento_asc_trabajadores_model->editar($id,$salida);
	}



	//OK
	function eliminar_usuarios_req($id,$area_cargo){
		$this->load->model("logistica_servicios/Requerimiento_asc_trabajadores_model");
		$this->Requerimiento_asc_trabajadores_model->eliminar($id);
		redirect('logistica_servicios/requerimientos/usuarios_requerimiento/'.$area_cargo, 'refresh');
	}

	//OK
	function eliminar($id){
		$this->load->model('logistica_servicios/Requerimientos_model');
		$this->Requerimientos_model->eliminar($id);
		echo "<script>alert('Requerimiento Eliminado Exitosamente')</script>";
		redirect(base_url().'logistica_servicios/requerimientos/listado', 'refresh');
	}

}
?>