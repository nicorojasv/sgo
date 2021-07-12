<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Pensiones extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 3)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 4)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_externo','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 5)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_psicologo','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 6)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_contabilidad','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador_general','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		$this->load->model('Empresa_Planta_model');
		$this->load->model('Pensiones_model');
		$this->load->model('Pensiones_Valores_model');

		$base = array(
			'head_titulo' => "Administracion de Pensiones - Sistema EST",
			'titulo' => "Administracion de Pensiones",
			'subtitulo' => '',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Administracion de Pensiones' )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$lista = array();
		$consulta = $this->Pensiones_model->listar();
		foreach ($consulta as $p){
			$aux = new stdClass();
			$get_valores = $this->Pensiones_Valores_model->listar_valores($p->id);
			$get_centro_costo = $this->Empresa_Planta_model->get($p->id_centro_costo);
			$aux->id_pension = $p->id;
			$aux->razon_social = (isset($p->razon_social))?$p->razon_social:'';
			$aux->rut = (isset($p->rut))?$p->rut:'';
			$aux->telefono = (isset($p->telefono))?$p->telefono:'';
			$aux->fecha_contrato = (isset($get_valores->fecha_contrato))?$get_valores->fecha_contrato:'';
			$aux->n_cuenta = (isset($get_valores->n_cuenta))?$get_valores->n_cuenta:'';
			$aux->pension_completa = (isset($get_valores->pension_completa))?$get_valores->pension_completa:'';
			$aux->almuerzo = (isset($get_valores->almuerzo))?$get_valores->almuerzo:'';
			$aux->reserva = (isset($get_valores->reserva))?$get_valores->reserva:'';
			$aux->otros_valores = (isset($get_valores->otros_valores))?$get_valores->otros_valores:'';
			$aux->centro_costo = (isset($get_centro_costo->nombre))?$get_centro_costo->nombre:'';
			$aux->doc_contrato = (isset($get_valores->doc_contrato))?$get_valores->doc_contrato:'';
			$aux->doc_cuenta = (isset($get_valores->doc_cuenta))?$get_valores->doc_cuenta:'';
			array_push($lista,$aux);
			unset($aux);
		}

		$pagina['lista_aux'] = $lista;
		$pagina['empresas_planta'] = $this->Empresa_Planta_model->listar();
		$base['cuerpo'] = $this->load->view('pensiones/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function editar($id_pension){
		$this->load->model('Empresa_Planta_model');
		$this->load->model("Pensiones_model");
		$this->load->model("Pensiones_Valores_model");
		$lista = array();
		foreach ($this->Pensiones_model->get_result($id_pension) as $p){
			$aux = new stdClass();
			$get_valores = $this->Pensiones_Valores_model->listar_valores($p->id);
			$aux->id_pension = $p->id;
			$aux->id_centro_costo = $p->id_centro_costo;
			$aux->razon_social = (isset($p->razon_social))?$p->razon_social:'';
			$aux->rut = (isset($p->rut))?$p->rut:'';
			$aux->telefono = (isset($p->telefono))?$p->telefono:'';
			$aux->fecha_contrato = (isset($get_valores->fecha_contrato))?$get_valores->fecha_contrato:'';
			$aux->n_cuenta = (isset($get_valores->n_cuenta))?$get_valores->n_cuenta:'';
			$aux->pension_completa = (isset($get_valores->pension_completa))?$get_valores->pension_completa:'';
			$aux->almuerzo = (isset($get_valores->almuerzo))?$get_valores->almuerzo:'';
			$aux->reserva = (isset($get_valores->reserva))?$get_valores->reserva:'';
			$aux->otros_valores = (isset($get_valores->otros_valores))?$get_valores->otros_valores:'';
			$aux->doc_contrato = (isset($get_valores->doc_contrato))?$get_valores->doc_contrato:'';
			$aux->doc_cuenta = (isset($get_valores->doc_cuenta))?$get_valores->doc_cuenta:'';
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['pension'] = $lista;
		$pagina['empresas_planta'] = $this->Empresa_Planta_model->listar();
		$this->load->view('pensiones/modal_editar_datos_pension', $pagina);
	}

	function guardar_pension(){
		$this->load->model('Pensiones_model');
		$this->load->model('Pensiones_Valores_model');
		$this->load->helper("archivo");

		$datos_pension = array(
			'id_centro_costo' => $_POST['centro_costo'],
			'razon_social' => $_POST['razon_social'],
			'rut' => $_POST['rut'],
			'telefono' => $_POST['telefono'],
		);

		$this->Pensiones_model->ingresar($datos_pension);
		$ultimo_id_pension = $this->db->insert_id();

		if(isset($_POST['ano_fc']) && isset($_POST['mes_fc']) && isset($_POST['dia_fc'])){
			$fecha_contrato = $_POST['ano_fc'].'-'.$_POST['mes_fc'].'-'.$_POST['dia_fc'];
		}else{
			$fecha_contrato = '0000-00-00';
		}

		$datos_valores = array(
			'id_pension' => $ultimo_id_pension,
			'fecha_contrato' => $fecha_contrato,
			'n_cuenta' => $_POST['cuenta'],
			'pension_completa' => $_POST['pension_completa'],
			'almuerzo' => $_POST['almuerzo'],
			'reserva' => $_POST['reserva'],
			'otros_valores' => $_POST['otros_valores'],
		);

		if($_FILES['doc_contrato']['error'] == 0){
			$salida = subir($_FILES,"doc_contrato","extras/docs_pensiones/");
			$datos_contrato = array(
				'doc_contrato' => $salida
			);
		}else{
			$datos_contrato = array(
				'doc_contrato' => NULL
			);
		}

		if($_FILES['doc_cuenta']['error'] == 0){
			$salida2 = subir($_FILES,"doc_cuenta","extras/docs_pensiones/");
			$datos_cuenta = array(
				'doc_cuenta' => $salida2
			);
		}else{
			$datos_cuenta = array(
				'doc_cuenta' => NULL
			);
		}

		$datos_pensiones_valores = array_merge($datos_valores, $datos_contrato, $datos_cuenta);
		$this->Pensiones_Valores_model->ingresar($datos_pensiones_valores);
		echo "<script>alert('Pension Ingresada Exitosamente')</script>";
		redirect('/est/pensiones', 'refresh');
	}

	function actualizar_pension(){
		$this->load->model('Pensiones_model');
		$this->load->model('Pensiones_Valores_model');
		$this->load->helper("archivo");
		$id_pension = $_POST['id_pension'];

		$datos_pension = array(
			'id_centro_costo' => $_POST['centro_costo'],
			'razon_social' => $_POST['razon_social'],
			'rut' => $_POST['rut'],
			'telefono' => $_POST['telefono']
		);

		$this->Pensiones_model->actualizar($id_pension, $datos_pension);

		if(isset($_POST['ano_fc']) && isset($_POST['mes_fc']) && isset($_POST['dia_fc'])){
			$fecha_contrato = $_POST['ano_fc'].'-'.$_POST['mes_fc'].'-'.$_POST['dia_fc'];
		}else{
			$fecha_contrato = '0000-00-00';
		}

		$datos_pensiones_valores = array(
			'id_pension' => $id_pension,
			'fecha_contrato' => $fecha_contrato,
			'n_cuenta' => $_POST['cuenta'],
			'pension_completa' => $_POST['pension_completa'],
			'almuerzo' => $_POST['almuerzo'],
			'reserva' => $_POST['reserva'],
			'otros_valores' => $_POST['otros_valores'],
		);

		if($_FILES['doc_contrato']['error'] == 0){
			$salida = subir($_FILES,"doc_contrato","extras/docs_pensiones/");
			$datos_contrato = array(
				'doc_contrato' => $salida
			);
		}else{
			$datos_contrato = array();
		}

		if($_FILES['doc_cuenta']['error'] == 0){
			$salida2 = subir($_FILES,"doc_cuenta","extras/docs_pensiones/");
			$datos_cuenta = array(
				'doc_cuenta' => $salida2
			);
		}else{
			$datos_cuenta = array();
		}

		$datos_valores = array_merge($datos_pensiones_valores, $datos_contrato, $datos_cuenta);
		$si_existe = $this->Pensiones_Valores_model->existe_registro_pension($id_pension, $fecha_contrato);
		if($si_existe == 'N/E'){
			$this->Pensiones_Valores_model->ingresar($datos_valores);
		}else{
			$this->Pensiones_Valores_model->actualizar($si_existe->id, $datos_valores);
		}
		echo "<script>alert('Pension Actualizada Exitosamente')</script>";
		redirect('/est/pensiones', 'refresh');
	}

	function redireccionar_informe(){
		$id_centro_costo = $_POST['centro_costo'];
		$fecha_inicio = $_POST['fecha_inicio'];
		$fecha_termino = $_POST['fecha_termino'];
		redirect('/est/pensiones/informe_pensiones/'.$id_centro_costo.'/'.$fecha_inicio.'/'.$fecha_termino, 'refresh');
	}

	function informe_pensiones($id_centro_costo = FALSE, $fecha_inicio = FALSE, $fecha_termino = FALSE){
		$this->load->model('Requerimiento_Area_Cargo_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('Areas_model');
		$this->load->model('Cargos_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Empresa_Planta_model');
		$this->load->model('Pensiones_model');
		$this->load->model('Pensiones_Valores_model');

		if( $this->session->userdata('tipo_usuario') == 6){
			$base = array(
				'head_titulo' => "Informe de Pensiones - Sistema EST",
				'titulo' => "Informe de Pensiones",
				'subtitulo' => '',
				'side_bar' => false,
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Informe de Pensiones' ) ),
				'menu' => $this->menu,
				'js' => array('js/si_datepicker_pensiones.js','js/si_exportar_excel.js','js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			);
		}else{
			$base = array(
				'head_titulo' => "Informe de Pensiones - Sistema EST",
				'titulo' => "Informe de Pensiones",
				'subtitulo' => '',
				'side_bar' => false,
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/pensiones','txt'=>'Administracion de Pensiones'), array('url'=>'','txt'=>'Informe de Pensiones' ) ),
				'menu' => $this->menu,
				'js' => array('js/si_datepicker_pensiones.js','js/si_exportar_excel.js','js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			);
		}

		if($fecha_inicio < $fecha_termino){
			$fecha_mayor = 1;
		}else{
			$fecha_mayor = 0;
		}

		$get_centro_costo = $this->Empresa_Planta_model->get($id_centro_costo);
		$lista = array();
		if($fecha_mayor == 1 and $fecha_inicio != FALSE and $fecha_termino != FALSE){
			foreach ($this->Pensiones_model->listar_segun_cc($id_centro_costo) as $p){
				$fecha_inicio_contrato = $p->fecha_inicio;
				$fecha_termino_contrato = $p->fecha_termino;
				if($fecha_inicio_contrato <= $fecha_inicio and $fecha_termino_contrato >= $fecha_termino or $fecha_inicio_contrato <= $fecha_inicio and $fecha_termino_contrato >= $fecha_inicio and $fecha_termino_contrato <= $fecha_termino or $fecha_inicio_contrato >= $fecha_inicio and $fecha_inicio_contrato <= $fecha_termino and $fecha_termino_contrato >= $fecha_termino or $fecha_inicio_contrato >= $fecha_inicio and $fecha_termino_contrato <= $fecha_termino){
					$aux = new stdClass();
					$get_usu = $this->Usuarios_model->get($p->id_usuario);
					$get_ciudad_trab = $this->Ciudad_model->get($get_usu->id_ciudades);
					$get_requerimiento_area_cargo = $this->Requerimiento_Area_Cargo_model->get($p->id_requerimiento_area_cargo);
					$id_req = isset($get_requerimiento_area_cargo->requerimiento_id)?$get_requerimiento_area_cargo->requerimiento_id:'';
					$id_cargo = isset($get_requerimiento_area_cargo->cargos_id)?$get_requerimiento_area_cargo->cargos_id:'';
					$id_area = isset($get_requerimiento_area_cargo->areas_id)?$get_requerimiento_area_cargo->areas_id:'';
					$get_cargo = $this->Cargos_model->r_get($id_cargo);
					$get_area = $this->Areas_model->r_get($id_area);
					$get_req = $this->Requerimientos_model->get($id_req);
					$nombre_trabajador = isset($get_usu->nombres)?$get_usu->nombres:'';
					$ap_trabajador = isset($get_usu->paterno)?$get_usu->paterno:'';
					$am_trabajador = isset($get_usu->materno)?$get_usu->materno:'';

					$aux->id_requerimiento_area_cargo = $p->id_requerimiento_area_cargo;
					$aux->id_usuario = $p->id_usuario;
					$aux->nombre_trabajador = $nombre_trabajador." ".$ap_trabajador." ".$am_trabajador;
					$aux->rut_trabajador = isset($get_usu->rut_usuario)?$get_usu->rut_usuario:'';
					$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
					$aux->area = isset($get_area->nombre)?$get_area->nombre:'';
					$aux->codigo_req = isset($get_req->codigo_requerimiento)?$get_req->codigo_requerimiento:'';
					$aux->nombre_req = isset($get_req->nombre)?$get_req->nombre:'';
					$aux->motivo_req = isset($get_req->motivo)?$get_req->motivo:'';
					$aux->procedencia_trab = isset($get_ciudad_trab->desc_ciudades)?$get_ciudad_trab->desc_ciudades:'';
					$aux->id_pension = $p->id_pension;
					$aux->nombre_pension = $p->razon_social;
					$aux->rut_pension = $p->rut;
					$aux->telefono_pension = $p->telefono;
					$aux->fecha_contrato_pension = $p->fecha_contrato;
					$aux->numero_cuenta_pension = $p->n_cuenta;
					$aux->valor_pension_completa = $p->pension_completa;
					$aux->valor_almuerzo = $p->almuerzo;
					$aux->valor_reserva = $p->reserva;
					$aux->valor_otros_valores = $p->otros_valores;
					$aux->n_dias_pension_completa = $p->n_dias_pension_completa;
					$aux->n_dias_almuerzo = $p->n_dias_almuerzo;
					$aux->n_dias_reserva = $p->n_dias_reserva;
					$aux->n_dias_otros_valores = $p->n_dias_otros_valores;
					$aux->fecha_inicio_contrato = $p->fecha_inicio;
					$aux->fecha_termino_contrato = $p->fecha_termino;

					if($p->pension_completa > 0 and $p->n_dias_pension_completa > 0){
						$aux->total_pension_completa = ($p->pension_completa * $p->n_dias_pension_completa);
						$total_pension_completa = ($p->pension_completa * $p->n_dias_pension_completa);
					}else{
						$aux->total_pension_completa = 0;
						$total_pension_completa = 0;
					}

					if($p->almuerzo > 0 and $p->n_dias_almuerzo > 0){
						$aux->total_almuerzo = ($p->almuerzo * $p->n_dias_almuerzo);
						$total_almuerzo = ($p->almuerzo * $p->n_dias_almuerzo);
					}else{
						$aux->total_almuerzo = 0;
						$total_almuerzo = 0;
					}

					if($p->reserva > 0 and $p->n_dias_reserva > 0){
						$aux->total_reserva = ($p->reserva * $p->n_dias_reserva);
						$total_reserva = ($p->reserva * $p->n_dias_reserva);
					}else{
						$aux->total_reserva = 0;
						$total_reserva = 0;
					}

					if($p->otros_valores > 0 and $p->n_dias_otros_valores > 0){
						$aux->total_otros_valores = ($p->otros_valores * $p->n_dias_otros_valores);
						$total_otros_valores = ($p->otros_valores * $p->n_dias_otros_valores);
					}else{
						$aux->total_otros_valores = 0;
						$total_otros_valores = 0;
					}

					$aux->total_total = $total_pension_completa + $total_almuerzo + $total_reserva + $total_otros_valores;
					array_push($lista,$aux);
					unset($aux);
				}
			}
		}

		if($fecha_mayor == 0 and $fecha_inicio != FALSE and $fecha_termino != FALSE){
			$pagina['mensaje'] = "La fecha de termino ingresada es menor a la fecha inicio";
		}elseif($fecha_inicio == FALSE or $fecha_termino == FALSE){
			$pagina['mensaje'] = "Ambas fechas son obligatorias";
		}

		$pagina['lista_aux'] = $lista;
		$pagina['empresas_planta'] = $this->Empresa_Planta_model->listar();
		$pagina['centro_costo'] = isset($get_centro_costo->nombre)?$get_centro_costo->nombre:"";
		$pagina['id_centro_costo'] = $id_centro_costo;
		$pagina['fecha_inicio'] = $fecha_inicio;
		$pagina['fecha_termino'] = $fecha_termino;
		$base['cuerpo'] = $this->load->view('pensiones/informe',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

}
?>