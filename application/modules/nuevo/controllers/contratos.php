<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

$archivo_numero_letras = "extras/contratos/numero_letras.php";
$autoloader = "extras/contratos/PHPWord-master/src/PhpWord/Autoloader.php";
require_once (BASE_URL2.$autoloader);
require_once (BASE_URL2.$archivo_numero_letras);
\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\TemplateProcessor;

class Contratos extends CI_Controller{
	public function __construct(){
    	parent::__construct();
		$this->load->model("enjoy/Descripcion_horarios_model");
		$this->load->model("enjoy/Requerimiento_asc_trabajadores_model");
		$this->load->model("enjoy/Ciudades_model");
		$this->load->model("enjoy/Afp_model");
		$this->load->model("enjoy/Salud_model");
		$this->load->model("enjoy/Estado_civil_model");
		$this->load->model("enjoy/Nivel_estudios_model");
		$this->load->model("enjoy/Requerimiento_area_cargo_model");
		$this->load->model("enjoy/Requerimientos_model");
		$this->load->model("enjoy/Areas_model");
		$this->load->model("enjoy/Cargos_model");
		$this->load->model("enjoy/Empresas_model");
		$this->load->model("enjoy/Regiones_model");
		$this->load->model('enjoy/Requerimiento_Usuario_Archivo_model');
		$this->load->model('enjoy/Empresa_planta_model');
		$this->load->model('enjoy/Usuarios_model');
		$this->load->model("Solicitud_revision_examenes_model");
		$this->load->model("usuarios/Usuarios_general_model");

		if($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 11)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_rrhh','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 12)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_logistica_servicios','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 14)
			$this->menu = $this->load->view('layout2.0/menus/enjoy_menu_admin','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 15)
			$this->menu = $this->load->view('layout2.0/menus/enjoy_menu_admin_supervisor','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		redirect('enjoy/contratos/solicitudes_pendientes', 'refresh');
	}
	
	function exportar_excel_contratos_y_anexos(){
		/*header("Content-type: application/vnd.ms-excel; name='excel'");
		header("Content-Disposition: filename=ficheroExcel.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $_POST['datos_a_enviar'];*/
		//es reemplazado por estos header para respetar los acentos y ñ al exportar\\
		header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
		header("Content-Disposition: filename=ficheroExcel.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo utf8_decode($_POST['datos_a_enviar']);
	}

	function solicitudes_pendientes(){
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de contratos pendientes",
			'titulo' => "Listado solicitudes pendientes",
			'subtitulo' => 'Unidad de Negocio: Enjoy Antofagasta',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado solicitudes pendientes' )),
			'menu' => $this->menu,
			'js' => array(/*'plugins/DataTables/media/js/jquery.dataTables.min.js'*//*'plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js',*/'js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/si_validaciones.js','js/validacion/validarEnviarSolicitudContrato.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);

		$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_pendientes();
		$listado = array();
		if($trabajadores != FALSE){
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$id_req_usu_arch = isset($rm->id)?$rm->id:'';
				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$fecha_solicitud = isset($get_usu_archivo->fecha_solicitud)?$get_usu_archivo->fecha_solicitud:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$usr = $this->Usuarios_model->get($id_usuario);
				$get_proceso = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato_tipo_proceso($id_req_usu_arch, 0);
				$id_solicitante = isset($get_proceso->id_solicitante)?$get_proceso->id_solicitante:'';
				$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';

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
				$get_region_planta = $this->Regiones_model->get($id_region_planta);
				$get_ciudad_planta = $this->Ciudades_model->get($id_ciudad_planta);
				$get_jornada = $this->Descripcion_horarios_model->get($get_usu_archivo->jornada);
				$aux->fechaSolicitud = $fecha_solicitud;
				$aux->regimen = isset($get_requerimiento->regimen)?$get_requerimiento->regimen:'';
				$aux->codigo_centro_costo = isset($get_requerimiento->codigo_centro_costo)?$get_requerimiento->codigo_centro_costo:'';
				$aux->id_req_usu_arch = isset($rm->id)?$rm->id:'';
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
				$aux->nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;

				$nombres = isset($usr->nombres)?$usr->nombres:'';
				$paterno = isset($usr->paterno)?$usr->paterno:'';
				$materno = isset($usr->materno)?$usr->materno:'';
				$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
				$aux->nombre_sin_espacios = $paterno.'_'.$materno;
				$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';

				$idBancoo = isset($usr->id_bancos)?$usr->id_bancos:'';
				if (!empty($idBancoo)) {
					$nombreBanco = $this->Usuarios_model->getNombreBanco($idBancoo);
				}else{
					$nombreBanco='';
				}
				//$nombreBanco = $this->Usuarios_model->getNombreBanco($usr->id_bancos);
				$aux->banco = isset($nombreBanco->desc_bancos)?$nombreBanco->desc_bancos:'';
				$aux->tipo_cuenta = isset($usr->tipo_cuenta)?$usr->tipo_cuenta:'';
				$aux->cuenta_banco = isset($usr->cuenta_banco)?$usr->cuenta_banco:'';



				$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
				$aux->domicilio = isset($usr->direccion)?$usr->direccion:'';
				$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
				$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';

				$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
				$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
				$aux->telefono = isset($usr->fono)?$usr->fono:'';
				$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';

				if($get_usu_archivo->tipo_archivo_requerimiento_id == 1)
					$aux->tipo_archivo = "Contrato de Trabajo";
				elseif($get_usu_archivo->tipo_archivo_requerimiento_id == 2)
					$aux->tipo_archivo = "Anexo de Contrato";
				else
					$aux->tipo_archivo = "";

				$aux->estado_proceso = $get_usu_archivo->estado_proceso;
				$aux->id_tipo_contrato = $get_usu_archivo->id_tipo_contrato;
				$aux->nombre = $get_usu_archivo->nombre;
				$aux->url = $get_usu_archivo->url;
				$aux->causal = $get_usu_archivo->causal;
				$aux->motivo = $get_usu_archivo->motivo;
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->renta_imponible = $get_usu_archivo->renta_imponible;
				/*edit 03-07-2018 Calculo finiquito*/
				$prevision_trabajador= $aux->prevision;

				$get_afp = $this->Afp_model->buscar($prevision_trabajador);
				$porcentaje_afp = isset($get_afp->tasas)?$get_afp->tasas:0;
				$sueldo_liquido_15mil = isset($get_afp->sueldo_liquido_15mil)?$get_afp->sueldo_liquido_15mil:0;
				$sueldo_liquido_20mil = isset($get_afp->sueldo_liquido_20mil)?$get_afp->sueldo_liquido_20mil:0;
				$sueldo_liquido_25mil = isset($get_afp->sueldo_liquido_25mil)?$get_afp->sueldo_liquido_25mil:0;

				$renta_imponible = $aux->renta_imponible;
				if($renta_imponible == 15000){
					/*30-07-2018 obteniendo sueldo mensual por persona sueldoMensualDeAcuerdoAsuAFP  g.r.m*/
					$renta_imponible = round($sueldo_liquido_15mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_15mil;
				}elseif($renta_imponible == 20000){
					$renta_imponible = round($sueldo_liquido_20mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_20mil;
				}elseif($renta_imponible == 25000){
					$renta_imponible = round($sueldo_liquido_25mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_25mil;
				}else{
					$renta_imponible = 0;
					$sueldoMensualDeAcuerdoAsuAFP = 0;
				}
				$aux->sueldoMensual = $sueldoMensualDeAcuerdoAsuAFP;
				$gratificacion_mensual = round($renta_imponible * 0.25);
				$feriado_proporcional = round(($renta_imponible * 1.25) / 30);
				$total_imponibles = round($renta_imponible + $gratificacion_mensual);
				$total_no_imponibles = $feriado_proporcional;
				$total_haberes = round($total_imponibles + $total_no_imponibles);
				$fondo_pension = round(($total_imponibles * $porcentaje_afp) / 100);
				$aporte_salud = round($total_imponibles * 0.07);
				$total_leyes_sociales = round($fondo_pension + $aporte_salud);
				$total_descuentos = $total_leyes_sociales;
				$total_liquido = round($total_haberes - $total_descuentos);
				//ahora guardo el resultado en las variables auxiliares
				$aux->total_liquido_finiquito = $total_liquido;
				$aux->feriado_proporcional_finiquito = $feriado_proporcional;


				/*fin calculo pago liquido y feriado proporcional*/
				$aux->asignacion_movilizacion = $get_usu_archivo->asignacion_movilizacion;
				$aux->asignacion_colacion = $get_usu_archivo->asignacion_colacion;
				$aux->asignacion_zona = $get_usu_archivo->asignacion_zona;
				$aux->viatico = $get_usu_archivo->viatico;
				$aux->fecha_inicio = $get_usu_archivo->fecha_inicio;
				$aux->fecha_termino = $get_usu_archivo->fecha_termino;
				$aux->fecha_pago = $get_usu_archivo->fecha_pago;

				$fecha_inicio = $get_usu_archivo->fecha_inicio;
				$get_fecha_inicio=date($fecha_inicio); 
				$var1 = explode('-',$get_fecha_inicio); 
				$dia_fi = $var1[2];
				$mes_fi = $var1[1];
				$ano_fi = $var1[0];

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

				$fecha_termino = $get_usu_archivo->fecha_termino;
				$get_fecha_termino=date($fecha_termino); 
				$var2 = explode('-',$get_fecha_termino); 
				$dia_ft = $var2[2];
				$mes_ft = $var2[1];
				$ano_ft = $var2[0];

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

				$fecha_pago = $get_usu_archivo->fecha_pago;
				$get_fecha_pago = date($fecha_pago); 
				$var4 = explode('-',$get_fecha_pago); 
				$dia_fp = $var4[2];
				$mes_fp = $var4[1];
				$ano_fp = $var4[0];

				if($mes_fp == "01") $mes_letra_fp = "Enero";
				if($mes_fp == "02") $mes_letra_fp = "Febrero";
				if($mes_fp == "03") $mes_letra_fp = "Marzo";
				if($mes_fp == "04") $mes_letra_fp = "Abril";
				if($mes_fp == "05") $mes_letra_fp = "Mayo";
				if($mes_fp == "06") $mes_letra_fp = "Junio";
				if($mes_fp == "07") $mes_letra_fp = "Julio";
				if($mes_fp == "08") $mes_letra_fp = "Agosto";
				if($mes_fp == "09") $mes_letra_fp = "Septiembre";
				if($mes_fp == "10") $mes_letra_fp = "Octubre";
				if($mes_fp == "11") $mes_letra_fp = "Noviembre";
				if($mes_fp == "12") $mes_letra_fp = "Diciembre";

				$fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
				$get_fecha_nacimiento=date($fecha_nac); 

				if (!empty($get_fecha_nacimiento)) {
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
				}else{
					$dia_fecha_nac=0;
					$mes_letra_fecha_nac='';
					$ano_fecha_nac=0000;
				}

				$aux->fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
				$aux->fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
				$aux->fecha_pago_texto_largo = $dia_fp." de ".$mes_letra_fp." de ".$ano_fp;
				$aux->fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

				array_push($listado, $aux);
				unset($aux);
			}
		}

		$pagina['listado'] = $listado;
		$base['cuerpo'] = $this->load->view('contratos/listado_solicitudes_pendientes',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function horas(){
		$fecha = new DateTime('2018-06');
		$fecha->modify('first day of this month');
		echo $fecha->format('d/m/Y'); // imprime por ejemplo: 01/12/2012
		echo "<br>";
				$fecha = new DateTime('2018-06');
		$fecha->modify('last day of this month');
		echo $fecha->format('d/m/Y'); // imprime por ejemplo: 31/12/2012
	}

	function solicitudes_completas($fecha = false){
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de contratos completas",
			'titulo' => "Listado solicitudes completas",
			'subtitulo' => 'Unidad de Negocio: Casa Matriz',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado solicitudes completas' )),
			'menu' => $this->menu,
			'js' => array('js/exportarExcelEnjoy.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','js/exportarExcelEnjoy.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);

		if ($fecha =='historico') {
			$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas();
			$pagina['mes'] = 'historico';
		}elseif($fecha){
			$fechaI = new DateTime($fecha);
				$fechaI->modify('first day of this month');
				$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
			$fechaT = new DateTime($fecha);
				$fechaT->modify('last day of this month');
				$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31
			$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas($fechaInicio, $fechaTermino);
			$f= explode("-", $fecha);
				$mes =$f[1];
			setlocale(LC_TIME, 'spanish');
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
			$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas($fechaInicio, $fechaTermino);
			setlocale(LC_TIME, 'spanish');
			$monthNum  = date('m');
			$dateObj   = DateTime::createFromFormat('!m', $monthNum);
			$nombreDelMes = strftime('%B', $dateObj->getTimestamp());
			$pagina['mes']= $nombreDelMes;
		}
		$listado = array();
		if($trabajadores != FALSE){
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$id_req_usu_arch = isset($rm->id)?$rm->id:'';
				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$usr = $this->Usuarios_model->get($id_usuario);
				$get_proceso = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato_tipo_proceso($id_req_usu_arch, 0);
				$id_solicitante = isset($get_proceso->id_solicitante)?$get_proceso->id_solicitante:'';
				$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';

				$aux = new StdClass();
				$aux->nombreRequerimiento = $rm->motivo;
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
				$get_region_planta = $this->Regiones_model->get($id_region_planta);
				$get_ciudad_planta = $this->Ciudades_model->get($id_ciudad_planta);
				$get_jornada = $this->Descripcion_horarios_model->get($get_usu_archivo->jornada);

				$aux->regimen = isset($get_requerimiento->regimen)?$get_requerimiento->regimen:'';
				$aux->codigo_centro_costo = isset($get_requerimiento->codigo_centro_costo)?$get_requerimiento->codigo_centro_costo:'';
				$aux->id_req_usu_arch = $id_req_usu_arch;
				$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
				$aux->ciudad_planta = isset($get_ciudad_planta->desc_ciudades)?$get_ciudad_planta->desc_ciudades:'';
				$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
				$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
				$aux->id_centro_costo = $id_centro_costo;
				$aux->id_requerimiento = $id_req_area_cargo;
				$aux->id_planta = $id_planta;
				$aux->nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
				$aux->direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
				$aux->nombre_req = isset($get_requerimiento->nombre)?$get_requerimiento->nombre:'';
				$aux->referido = isset($get_asc_trab->referido)?$get_asc_trab->referido:'';
				$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
				$aux->area = isset($get_area->nombre)?$get_area->nombre:'';
				$aux->nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;

				$nombres = isset($usr->nombres)?$usr->nombres:'';
				$paterno = isset($usr->paterno)?$usr->paterno:'';
				$materno = isset($usr->materno)?$usr->materno:'';
				$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
				$aux->nombre_sin_espacios = $paterno.'_'.$materno;
				$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
				$idBancoo = isset($usr->id_bancos)?$usr->id_bancos:'';
				if (!empty($idBancoo)) {
					$nombreBanco = $this->Usuarios_model->getNombreBanco($idBancoo);
				}else{
					$nombreBanco='';
				}
				
				$aux->banco = isset($nombreBanco->desc_bancos)?$nombreBanco->desc_bancos:'';
				$aux->tipo_cuenta = isset($usr->tipo_cuenta)?$usr->tipo_cuenta:'';
				$aux->cuenta_banco = isset($usr->cuenta_banco)?$usr->cuenta_banco:'';

				$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
				$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
				$aux->domicilio = isset($usr->direccion)?$usr->direccion:'';
				$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
				$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
				$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
				$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
				$aux->telefono = isset($usr->fono)?$usr->fono:'';
				$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';

				if($get_usu_archivo->tipo_archivo_requerimiento_id == 1)
					$aux->tipo_archivo = "Contrato de Trabajo";
				elseif($get_usu_archivo->tipo_archivo_requerimiento_id == 2)
					$aux->tipo_archivo = "Anexo de Contrato";
				else
					$aux->tipo_archivo = "";

				$aux->id_tipo_contrato = $get_usu_archivo->id_tipo_contrato;
				$aux->nombre = $get_usu_archivo->nombre;
				$aux->url = $get_usu_archivo->url;
				$aux->causal = $get_usu_archivo->causal;
				$aux->motivo = $get_usu_archivo->motivo;
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->renta_imponible = $get_usu_archivo->renta_imponible;
				/*edit 03-07-2018 Calculo finiquito*/
				$prevision_trabajador= $aux->prevision;

				$get_afp = $this->Afp_model->buscar($prevision_trabajador);
				$porcentaje_afp = isset($get_afp->tasas)?$get_afp->tasas:0;
				$sueldo_liquido_15mil = isset($get_afp->sueldo_liquido_15mil)?$get_afp->sueldo_liquido_15mil:0;
				$sueldo_liquido_20mil = isset($get_afp->sueldo_liquido_20mil)?$get_afp->sueldo_liquido_20mil:0;
				$sueldo_liquido_25mil = isset($get_afp->sueldo_liquido_25mil)?$get_afp->sueldo_liquido_25mil:0;
				$renta_imponible = $aux->renta_imponible;
				if($renta_imponible == 15000){
					/*30-07-2018 obteniendo sueldo mensual por persona sueldoMensualDeAcuerdoAsuAFP g.r.m*/
					$renta_imponible = round($sueldo_liquido_15mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_15mil;
				}elseif($renta_imponible == 20000){
					$renta_imponible = round($sueldo_liquido_20mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_20mil;
				}elseif($renta_imponible == 25000){
					$renta_imponible = round($sueldo_liquido_25mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_25mil;
				}else{
					$renta_imponible = 0;
					$sueldoMensualDeAcuerdoAsuAFP = 0;
				}

				$aux->sueldoMensual = $sueldoMensualDeAcuerdoAsuAFP;
				$gratificacion_mensual = round($renta_imponible * 0.25);
				$feriado_proporcional = round(($renta_imponible * 1.25) / 30);
				$total_imponibles = round($renta_imponible + $gratificacion_mensual);
				$total_no_imponibles = $feriado_proporcional;
				$total_haberes = round($total_imponibles + $total_no_imponibles);
				$fondo_pension = round(($total_imponibles * $porcentaje_afp) / 100);
				$aporte_salud = round($total_imponibles * 0.07);
				$total_leyes_sociales = round($fondo_pension + $aporte_salud);
				$total_descuentos = $total_leyes_sociales;
				$total_liquido = round($total_haberes - $total_descuentos);
					#ahora guardo el resultado en las variables auxiliares
				$aux->total_liquido_finiquito = $total_liquido;
				$aux->feriado_proporcional_finiquito = $feriado_proporcional;


				/*fin calculo pago liquido y feriado proporcional*/
				$aux->asignacion_movilizacion = $get_usu_archivo->asignacion_movilizacion;
				$aux->asignacion_colacion = $get_usu_archivo->asignacion_colacion;
				$aux->asignacion_zona = $get_usu_archivo->asignacion_zona;
				$aux->viatico = $get_usu_archivo->viatico;
				$aux->fecha_inicio = $get_usu_archivo->fecha_inicio;
				$aux->fecha_termino = $get_usu_archivo->fecha_termino;

				$fecha_inicio = $get_usu_archivo->fecha_inicio;
				$get_fecha_inicio=date($fecha_inicio); 
				$var1 = explode('-',$get_fecha_inicio); 
				$dia_fi = $var1[2];
				$mes_fi = $var1[1];
				$ano_fi = $var1[0];

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

				$fecha_termino = $get_usu_archivo->fecha_termino;
				$get_fecha_termino=date($fecha_termino); 
				$var2 = explode('-',$get_fecha_termino); 
				$dia_ft = $var2[2];
				$mes_ft = $var2[1];
				$ano_ft = $var2[0];

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

				$fecha_pago = $get_usu_archivo->fecha_pago;
				$get_fecha_pago = date($fecha_pago); 
				$var4 = explode('-',$get_fecha_pago); 
				$dia_fp = $var4[2];
				$mes_fp = $var4[1];
				$ano_fp = $var4[0];

				if($mes_fp == "01") $mes_letra_fp = "Enero";
				if($mes_fp == "02") $mes_letra_fp = "Febrero";
				if($mes_fp == "03") $mes_letra_fp = "Marzo";
				if($mes_fp == "04") $mes_letra_fp = "Abril";
				if($mes_fp == "05") $mes_letra_fp = "Mayo";
				if($mes_fp == "06") $mes_letra_fp = "Junio";
				if($mes_fp == "07") $mes_letra_fp = "Julio";
				if($mes_fp == "08") $mes_letra_fp = "Agosto";
				if($mes_fp == "09") $mes_letra_fp = "Septiembre";
				if($mes_fp == "10") $mes_letra_fp = "Octubre";
				if($mes_fp == "11") $mes_letra_fp = "Noviembre";
				if($mes_fp == "12") $mes_letra_fp = "Diciembre";

				$fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
				$get_fecha_nacimiento=date($fecha_nac); 
				//var_dump($get_fecha_nacimiento);
				if (!empty($get_fecha_nacimiento)) {
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
				}else{
					$dia_fecha_nac=0;
					$mes_letra_fecha_nac='';
					$ano_fecha_nac=0000;
				}

				$aux->fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
				$aux->fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
				$aux->fecha_pago_texto_largo = $dia_fp." de ".$mes_letra_fp." de ".$ano_fp;
				$aux->fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

				array_push($listado, $aux);
				unset($aux);
			}
		}

		$pagina['listado'] = $listado;
		$base['cuerpo'] = $this->load->view('contratos/listado_solicitudes_completas_validadas',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function rqla(){
		$id_req_usu_arch = 1692;
		$data = 23;
		$get_solicitud_contrato = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_req_usu_arch, '0');
		var_dump($get_solicitud_contrato);

	}

	function validar_contrato_anexo_doc($id_req_usu_arch){

		$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
		$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
		$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
		$fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';

		$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
		$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
		$get_solicitud_contrato = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_req_usu_arch, '0');
		$id_solicitante = isset($get_solicitud_contrato->id_solicitante)?$get_solicitud_contrato->id_solicitante:'';
		$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
		$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
		$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
		$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
		$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
		$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';

		$usr = $this->Usuarios_model->get($id_usuario);
		$rut_trabajador = isset($usr->rut_usuario)?$usr->rut_usuario:'';
		$nombres = isset($usr->nombres)?$usr->nombres:'';
		$paterno = isset($usr->paterno)?$usr->paterno:'';
		$materno = isset($usr->materno)?$usr->materno:'';
		$nombre_trabajador = $nombres.' '.$paterno.' '.$materno;

		//verificacion y creacion de codigo  de contrato
		$fechaI = new DateTime($fecha_inicio);
				$fechaI->modify('first day of this month');
				$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
		$fechaT = new DateTime($fecha_inicio);
				$fechaT->modify('last day of this month');
				$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31
		//**********************************************************************************\\

		$verificarCodigoDisponibleDeBaja = $this->Requerimiento_Usuario_Archivo_model->getCodigoDisponible($id_usuario, $fechaInicio,$fechaTermino);
		//var_dump($verificarCodigoDisponibleDeBaja);
		if ($verificarCodigoDisponibleDeBaja != false) {// si es que tome el codigo de la tabla codigo_libre, lo asigno  a este contrato  y lo elimino de la tabla
				$idCodigoLibre = $verificarCodigoDisponibleDeBaja->id;
				$idLetraAbecedario = $verificarCodigoDisponibleDeBaja->codigoLibre;
				$letraAbecedario = $this->Requerimiento_Usuario_Archivo_model->getLetraAbecedario($idLetraAbecedario);
				$cambiandoEstado = array(
					'estado'=>1,
					);
				$this->Requerimiento_Usuario_Archivo_model->actualizarCodigoLibre($idCodigoLibre, $cambiandoEstado);//cambio su estado a 1 (eliminado)

				$datos_aprobacion = array(
					'id_req_usu_arch' => $id_req_usu_arch,
					'id_solicitante' => $this->session->userdata('id'),
					'fecha_solicitud' => date('Y-m-d'),
					'estado' => 1,
				);
				$datos_usu_arch = array(
					'estado_proceso' => 2,
					'fecha_aprobacion'=> date('Y-m-d H:i:s'),
					'codigo_contrato'=>$rut_trabajador.$letraAbecedario->letra,
					'id_abecedario_asignado'=>$idLetraAbecedario,
				);
				$id_registro = $this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato($datos_aprobacion);
				$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_usu_arch);
		}else{	// en caso de que no exista codigo disponible en la tabla codigo libre
				$result = $this->Requerimiento_Usuario_Archivo_model->getCodigoContrato($id_usuario, $fechaInicio, $fechaTermino);
				if ($result != false) {//si ya hay codigos en el mes
						$idLetraAbecedario = count($result)+1;
						$letraAbecedario   = $this->Requerimiento_Usuario_Archivo_model->getLetraAbecedario($idLetraAbecedario);
						$datos_aprobacion = array(
							'id_req_usu_arch' => $id_req_usu_arch,
							'id_solicitante' => $this->session->userdata('id'),
							'fecha_solicitud' => date('Y-m-d'),
							'estado' => 1,
						);
						$datos_usu_arch = array(
							'estado_proceso' => 2,
							'fecha_aprobacion'=> date('Y-m-d H:i:s'),
							'codigo_contrato'=>$rut_trabajador.$letraAbecedario->letra,
							'id_abecedario_asignado' =>$idLetraAbecedario,
						);
						$id_registro = $this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato($datos_aprobacion);
						$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_usu_arch);
				}else{
						$idLetraAbecedario = count($result)+1;
						$letraAbecedario   = $this->Requerimiento_Usuario_Archivo_model->getLetraAbecedario($idLetraAbecedario);
						$datos_aprobacion = array(
							'id_req_usu_arch' => $id_req_usu_arch,
							'id_solicitante' => $this->session->userdata('id'),
							'fecha_solicitud' => date('Y-m-d'),
							'estado' => 1,
						);
						$datos_usu_arch = array(
							'estado_proceso' => 2,
							'fecha_aprobacion'=> date('Y-m-d H:i:s'),
							'codigo_contrato'=>$rut_trabajador."A",
							'id_abecedario_asignado' =>1,
						);
						$id_registro = $this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato($datos_aprobacion);
						$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_usu_arch);
				}
		}
		$this->load->library('email');
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);

		$destinatarios_cc = array('contratos@empresasintegra.cl','jsilva@empresasintegra.cl');
	    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - ENJOY');
	    $this->email->to($email_solicitante);
		$this->email->cc($destinatarios_cc);
	    $this->email->subject("Aprobacion Contrato Trabajador: ".$nombre_trabajador." - Fecha Inicio Contrato: ".$fecha_inicio);
	    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' email '.$email_solicitante.' la solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.' ha sido aprobado exitosamente.<br>Saludos');
	    $this->email->send();
		echo '<script>alert("Solicitud de aprobacion de contrato aprobado exitosamente");</script>';
		redirect('enjoy/contratos/solicitudes_pendientes', 'refresh');
	}

	function modal_visualizar_contrato_anexo_doc_general($id_usu_arch,  $bajar = false){
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
			if ($bajar == 'bajar') {
				$pagina['pedientes_baja'] = true;
				$aux->codigoContrato = isset($get_usu_archivo->codigo_contrato)?$get_usu_archivo->codigo_contrato:'';
			}
			if (!empty($get_usu_archivo->id_ciudad) || !empty($get_usu_archivo->nombres)) {//solo para mostrar los datos del usuario guardados cuando se solicito el contrato
				$id_ciudad = isset($get_usu_archivo->id_ciudad)?$get_usu_archivo->id_ciudad:'';
				$id_afp = isset($get_usu_archivo->id_afp)?$get_usu_archivo->id_afp:'';
				$id_salud = isset($get_usu_archivo->id_salud)?$get_usu_archivo->id_salud:'';
				$id_estado_civil = isset($get_usu_archivo->id_estado_civil)?$get_usu_archivo->id_estado_civil:'';
				$id_estudios = isset($get_usu_archivo->id_nivel_estudios)?$get_usu_archivo->id_nivel_estudios:'';
				$nombres = isset($get_usu_archivo->nombres)?$get_usu_archivo->nombres:'';
				$paterno = isset($get_usu_archivo->paterno)?$get_usu_archivo->paterno:'';
				$materno = isset($get_usu_archivo->materno)?$get_usu_archivo->materno:'';
				$aux->rut = isset($get_usu_archivo->rut_usuario)?$get_usu_archivo->rut_usuario:'';
				$aux->fecha_nac = isset($get_usu_archivo->fecha_nac)?$get_usu_archivo->fecha_nac:'';
				$aux->domicilio = isset($get_usu_archivo->direccion)?$get_usu_archivo->direccion:'';
				$get_ciudad = $this->Ciudades_model->get($id_ciudad);
				$aux->telefono = isset($get_usu_archivo->fono)?$get_usu_archivo->fono:'';
				$aux->nacionalidad = isset($get_usu_archivo->nacionalidad)?$get_usu_archivo->nacionalidad:'';
				$get_afp = $this->Afp_model->get($id_afp);
				$get_salud = $this->Salud_model->get($id_salud);
				$get_estado_civil = $this->Estado_civil_model->get($id_estado_civil);
				$get_nivel_estudios = $this->Nivel_estudios_model->get($id_estudios);
				$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
				$aux->nombre_sin_espacios = $paterno.'_'.$materno;
				$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
				$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
				$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
				$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
				$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			}else{
				$usr = $this->Usuarios_model->get($id_usuario);
				$id_ciudad = isset($usr->id_ciudad)?$usr->id_ciudad:'';
				$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
				$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
				$id_estado_civil = isset($usr->id_estado_civil)?$usr->id_estado_civil:'';
				$id_estudios = isset($usr->id_nivel_estudios)?$usr->id_nivel_estudios:'';
				$nombres = isset($usr->nombres)?$usr->nombres:'';
				$paterno = isset($usr->paterno)?$usr->paterno:'';
				$materno = isset($usr->materno)?$usr->materno:'';
				$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
				$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
				$aux->domicilio = isset($usr->direccion)?$usr->direccion:'';
				$get_ciudad = $this->Ciudades_model->get($id_ciudad);
				$aux->telefono = isset($usr->fono)?$usr->fono:'';
				$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';
				$get_afp = $this->Afp_model->get($id_afp);
				$get_salud = $this->Salud_model->get($id_salud);
				$get_estado_civil = $this->Estado_civil_model->get($id_estado_civil);
				$get_nivel_estudios = $this->Nivel_estudios_model->get($id_estudios);
				$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
				$aux->nombre_sin_espacios = $paterno.'_'.$materno;
				$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
				$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
				$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
				$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
				$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			}
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
			$get_region_planta = $this->Regiones_model->get($id_region_planta);
			$get_ciudad_planta = $this->Ciudades_model->get($id_ciudad_planta);

			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->ciudad_planta = isset($get_ciudad_planta->desc_ciudades)?$get_ciudad_planta->desc_ciudades:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
			$aux->id_planta = $id_planta;
			$aux->id_centro_costo = $id_centro_costo;
			$aux->nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
			$aux->direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
			$aux->nombre_req = isset($get_requerimiento->nombre)?$get_requerimiento->nombre:'';
			$aux->referido = isset($get_asc_trab->referido)?$get_asc_trab->referido:'';
			$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
			$aux->area = isset($get_area->nombre)?$get_area->nombre:'';
			
			$solicitudes_aprobadas = $this->Solicitud_revision_examenes_model->get_usu_req_aprobados_result($id_usuario, $id_requerimiento, $id_req_asc_trabajador);

			if (!empty($solicitudes_aprobadas)){
				foreach ($solicitudes_aprobadas as $d) {
					$revisiones_al_dia += 1;
				}
			}
			array_push($datos_generales, $aux);
			unset($aux);
		}
		

		$get_solicitudes_contratos = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_usu_arch);
		$pagina['solicitud_existente_contrato'] = isset($get_solicitudes_contratos->id)?1:0;
		$pagina['datos_generales'] = $datos_generales;
		$pagina['id_usu_arch']= $id_usu_arch;
		$pagina['listado_horarios'] = $this->Descripcion_horarios_model->listar();
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_usu_arch);
		$this->load->view('contratos/modal_administrar_contrato_anexo_doc_contractuales', $pagina);
	}

	//Rechazo
	function modal_rechazar_contrato_anexo_doc_general($id_usu_arch){
		$revisiones_al_dia = 0;
		$datos_generales = array();
		if($id_usu_arch != FALSE){
			$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);
			$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
			$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
			$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
			$aux = new StdClass();
			if (!empty($get_usu_archivo->id_ciudad) || !empty($get_usu_archivo->nombres)) {//solo para mostrar los datos del usuario guardados cuando se solicito el contrato
				$id_ciudad = isset($get_usu_archivo->id_ciudad)?$get_usu_archivo->id_ciudad:'';
				$id_afp = isset($get_usu_archivo->id_afp)?$get_usu_archivo->id_afp:'';
				$id_salud = isset($get_usu_archivo->id_salud)?$get_usu_archivo->id_salud:'';
				$id_estado_civil = isset($get_usu_archivo->id_estado_civil)?$get_usu_archivo->id_estado_civil:'';
				$id_estudios = isset($get_usu_archivo->id_nivel_estudios)?$get_usu_archivo->id_nivel_estudios:'';
				$nombres = isset($get_usu_archivo->nombres)?$get_usu_archivo->nombres:'';
				$paterno = isset($get_usu_archivo->paterno)?$get_usu_archivo->paterno:'';
				$materno = isset($get_usu_archivo->materno)?$get_usu_archivo->materno:'';
				$aux->rut = isset($get_usu_archivo->rut_usuario)?$get_usu_archivo->rut_usuario:'';
				$aux->fecha_nac = isset($get_usu_archivo->fecha_nac)?$get_usu_archivo->fecha_nac:'';
				$aux->domicilio = isset($get_usu_archivo->direccion)?$get_usu_archivo->direccion:'';
				$get_ciudad = $this->Ciudades_model->get($id_ciudad);
				$aux->telefono = isset($get_usu_archivo->fono)?$get_usu_archivo->fono:'';
				$aux->nacionalidad = isset($get_usu_archivo->nacionalidad)?$get_usu_archivo->nacionalidad:'';
				$get_afp = $this->Afp_model->get($id_afp);
				$get_salud = $this->Salud_model->get($id_salud);
				$get_estado_civil = $this->Estado_civil_model->get($id_estado_civil);
				$get_nivel_estudios = $this->Nivel_estudios_model->get($id_estudios);
				$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
				$aux->nombre_sin_espacios = $paterno.'_'.$materno;
				$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
				$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
				$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
				$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
				$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			}else{
				$usr = $this->Usuarios_model->get($id_usuario);
				$id_ciudad = isset($usr->id_ciudad)?$usr->id_ciudad:'';
				$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
				$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
				$id_estado_civil = isset($usr->id_estado_civil)?$usr->id_estado_civil:'';
				$id_estudios = isset($usr->id_nivel_estudios)?$usr->id_nivel_estudios:'';
				$nombres = isset($usr->nombres)?$usr->nombres:'';
				$paterno = isset($usr->paterno)?$usr->paterno:'';
				$materno = isset($usr->materno)?$usr->materno:'';
				$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
				$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
				$aux->domicilio = isset($usr->direccion)?$usr->direccion:'';
				$get_ciudad = $this->Ciudades_model->get($id_ciudad);
				$aux->telefono = isset($usr->fono)?$usr->fono:'';
				$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';
				$get_afp = $this->Afp_model->get($id_afp);
				$get_salud = $this->Salud_model->get($id_salud);
				$get_estado_civil = $this->Estado_civil_model->get($id_estado_civil);
				$get_nivel_estudios = $this->Nivel_estudios_model->get($id_estudios);
				$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
				$aux->nombre_sin_espacios = $paterno.'_'.$materno;
				$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
				$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
				$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
				$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
				$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			}

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
			$get_region_planta = $this->Regiones_model->get($id_region_planta);
			$get_ciudad_planta = $this->Ciudades_model->get($id_ciudad_planta);

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

			array_push($datos_generales, $aux);
			unset($aux);
		}

		$get_solicitudes_contratos = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_usu_arch);
		$pagina['solicitud_existente_contrato'] = isset($get_solicitudes_contratos->id)?1:0;
		$pagina['datos_generales'] = $datos_generales;
		$pagina['id_usu_arch']= $id_usu_arch;
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_usu_arch);
		$this->load->view('enjoy/contratos/modal_rechazar_contrato_anexo_doc_contractuales', $pagina);
	}

	//rechazo de contrato desde el modal
	function rechazar_contrato_anexo_doc_general(){
		$id_req_usu_arch = $_POST['id_usu_arch'];

		$datos_aprobacion = array(
			'observaciones' => $_POST['observaciones'],
			'estado' => 4,
		);

		$datos_aprobacion2 = array(
			'estado_proceso' => 4,
		);

		$datos_aprobacion_historial = array(
			'id_req_usu_arch' => $id_req_usu_arch,
			'id_usuario' => $this->session->userdata('id'),
			'estado' => 4
		);

		$this->Requerimiento_Usuario_Archivo_model->actualizar_solicitud_contrato($id_req_usu_arch, $datos_aprobacion);
		$this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato_historial($datos_aprobacion_historial);
		$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_aprobacion2);

		$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
		$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
		$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
		$fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';
		
		$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
		$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
		$get_solicitud_contrato = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_req_usu_arch);
		$id_solicitante = isset($get_solicitud_contrato->id_solicitante)?$get_solicitud_contrato->id_solicitante:'';
		$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
		$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
		$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
		$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
		$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
		$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';

		$usr = $this->Usuarios_model->get($id_usuario);
		$rut_trabajador = isset($usr->rut_usuario)?$usr->rut_usuario:'';
		$nombres = isset($usr->nombres)?$usr->nombres:'';
		$paterno = isset($usr->paterno)?$usr->paterno:'';
		$materno = isset($usr->materno)?$usr->materno:'';
		$nombre_trabajador = $nombres.' '.$paterno.' '.$materno;

		$this->load->library('email');
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);

		$destinatarios_cc = array('contratos@empresasintegra.cl','jsilva@empresasintegra.cl');
	    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - ENJOY');
	    $this->email->to($email_solicitante);
		$this->email->to($destinatarios_cc);
	    $this->email->subject("Rechazo Contrato Trabajador: ".$nombre_trabajador." - Fecha Inicio Contrato: ".$fecha_inicio);
	    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' la solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.' ha sido rechazado.<br>Con la siguiente observacion:<br>'.$_POST['observaciones'].'.<br>Saludos');
	    $this->email->send();

		echo '<script>alert("Solicitud de contrato fue rechazada exitosamente");</script>';
		redirect('enjoy/contratos/solicitudes_pendientes', 'refresh');
	}

	function generar_contrato_anexo_doc_contractual(){
		$this->load->model("enjoy/Requerimiento_Usuario_Archivo_model");
		$this->load->model("enjoy/Descripcion_horarios_model");
		$this->load->model("enjoy/Descripcion_causal_model");
		$this->load->model('enjoy/Afp_model');
		$this->load->model('enjoy/Finiquitos_model');
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->library('zip');
		$this->load->helper('download');
		$id_req_usu_archivo = $_POST['id_req_usu_arch'];
		$causal = $_POST['causal'];
		$motivo = $_POST['motivo'];
		$fecha_inicio = $_POST['fecha_inicio'];
		$fecha_termino = $_POST['fecha_termino'];
		$fecha_pago = $_POST['fecha_pago'];
		$jornada = $_POST['jornada'];
		$renta_imponible = $_POST['renta_imponible'];
		$tipo_contrato = $_POST['gc_tipo_contrato'];
		$bono_gestion = $_POST['bono_gestion'];
		$asignacion_movilizacion = $_POST['asignacion_movilizacion'];
		$asignacion_colacion = $_POST['asignacion_colacion'];
		$asignacion_zona = $_POST['asignacion_zona'];
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
		$nivel_estudios = $_POST['nivel_estudios'];
		$telefono = $_POST['telefono'];
		$nacionalidad = $_POST['nacionalidad'];
		$nombre_centro_costo = $_POST['nombre_centro_costo'];//nombre empresa
		$rut_centro_costo = $_POST['rut_centro_costo'];
		$id_planta = $_POST['id_planta'];
		$nombre_planta = $_POST['nombre_planta'];
		$direccion_planta = $_POST['direccion_planta'];
		$comuna_planta = $_POST['ciudad_planta'];
		$region_planta = $_POST['region_planta'];
		$nombre_sin_espacios = $_POST['nombre_sin_espacios'];
		if (isset($_POST['dar_de_baja'])) { //para dar de baja un contrato
			$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_archivo);
			$id_abecedario_asignado = isset($get_usu_archivo->id_abecedario_asignado)?$get_usu_archivo->id_abecedario_asignado:false;
			$usuario_id = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
			if ($id_abecedario_asignado != false) {//inserto en la tabla codigo libre
				$data1 = array(
					'usuario_id'=>$usuario_id,
					'codigoLibre'=>$id_abecedario_asignado,
					'fechaRegistro'=>date('Y-m-d'),
					'estado'=>0,
					);
				$this->Requerimiento_Usuario_Archivo_model->guardar_codigo_libre($data1);
			}
			$data = array(
				'estado_proceso' => 5,//  contrato bajado
				'fecha_aprobacion_baja' => date('Y-m-d H:i:s'),
				'id_abecedario_asignado'=>0,
				);
			$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_archivo, $data);

			//var_dump($data);
			redirect('enjoy/contratos/solicitudes_pendientes_baja','refresh');
			return false;
		}elseif(isset($_POST['deshacer_solicitud'])){
			$data = array(
				'estado_proceso'=>2,
				);
			$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_archivo, $data);
			redirect('enjoy/contratos/solicitudes_pendientes_baja','refresh');
			return false;
		}elseif(isset($_POST['generar_contrato'])){
			//inicio de boton generar contrato
			$template_formato = base_url()."extras/contratos/formatos_contratos_enjoy/formato_contrato.docx";
			$templateWord = new TemplateProcessor($template_formato);

			$salto_linea = "<w:br/>";

			$var1 = explode('.',$rut_trabajador); 
			$rut1 = $var1[0];

			if($rut1 < 10)
				$rut_trabajador = "0".$rut_trabajador;

			$get_fecha_inicio=date($fecha_inicio);
			$var1 = explode('-',$get_fecha_inicio);
			$dia_fi = $var1[2];
			$mes_fi = $var1[1];
			$ano_fi = $var1[0];

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
			$dia_ft = $var2[2];
			$mes_ft = $var2[1];
			$ano_ft = $var2[0];

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

			$get_fecha_pago=date($fecha_pago);
			$var3 = explode('-',$get_fecha_pago);
			$dia_fp = $var3[2];
			$mes_fp = $var3[1];
			$ano_fp = $var3[0];

			if ($mes_fp=="01") $mes_letra_fp="Enero";
			if ($mes_fp=="02") $mes_letra_fp="Febrero";
			if ($mes_fp=="03") $mes_letra_fp="Marzo";
			if ($mes_fp=="04") $mes_letra_fp="Abril";
			if ($mes_fp=="05") $mes_letra_fp="Mayo";
			if ($mes_fp=="06") $mes_letra_fp="Junio";
			if ($mes_fp=="07") $mes_letra_fp="Julio";
			if ($mes_fp=="08") $mes_letra_fp="Agosto";
			if ($mes_fp=="09") $mes_letra_fp="Septiembre";
			if ($mes_fp=="10") $mes_letra_fp="Octubre";
			if ($mes_fp=="11") $mes_letra_fp="Noviembre";
			if ($mes_fp=="12") $mes_letra_fp="Diciembre";

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
			$fecha_pago_texto_largo = $dia_fp." de ".$mes_letra_fp." de ".$ano_fp;
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

			$get_causal = $this->Descripcion_causal_model->get($id_descrip_causal);
			$descripcion_causal = isset($get_causal->descripcion)?$get_causal->descripcion:'';

			$get_horario = $this->Descripcion_horarios_model->get($jornada);
			$descripcion_jornada = isset($get_horario->descripcion)?$get_horario->descripcion:'';

			$bono_gestion_palabras = num2letras($bono_gestion);
			$asignacion_zona_palabras = num2letras($asignacion_zona);
			$asignacion_movilizacion_palabras = num2letras($asignacion_movilizacion);
			$asignacion_colacion_palabras = num2letras($asignacion_colacion);
			$viatico_palabras = num2letras($viatico);

			if($bono_gestion > 0)
				$frase_bono_gestion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación de locomoción de $ ".str_replace(',','.',number_format($bono_gestion))." (".$bono_gestion_palabras.").".$salto_linea."";
			else
				$frase_bono_gestion = "";

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

			$detalle_bonos = $frase_bono_gestion.$frase_bono_confianza.$frase_asignacion_movilizacion.$frase_asignacion_colacion.$frase_asignacion_zona.$frase_viatico;
			$sueldo_base_palabras = num2letras($renta_imponible);

			if($tipo_contrato == 1){
				$frase_adicional_parrafo_2 = "Las partes pactan que la jornada de trabajo de 45 horas semanales, se desarrollará en un sistema de días continuos, que incluyen los días domingos y festivos, conforme al artículo 38 de Código del Trabajo.";
				$frase_adicional_parrafo_3 = "Por los servicios prestados el Empleador pagará al trabajador una remuneración que estará compuesta de un sueldo líquido diario de $ ".str_replace(',','.',number_format($renta_imponible))." (".titleCase($sueldo_base_palabras).").";
				$frase_adicional_parrafo_5 = "La remuneración se liquidará el día ".$fecha_pago_texto_largo." y, el empleador pagará al trabajador las remuneraciones de acuerdo a lo indicado por el trabajador en solicitud expresa, debidamente firmada por él.";
			}elseif($tipo_contrato == 2){
				$frase_adicional_parrafo_2 = "Las partes pactan que la jornada de trabajo de 45 horas semanales, tendrá la siguiente distribución";
				$frase_adicional_parrafo_3 = "Por los servicios prestados el Empleador pagará al trabajador una remuneración que estará compuesta de un sueldo base de $ ".str_replace(',','.',number_format($renta_imponible)).".- (".titleCase($sueldo_base_palabras)."), por mes efectivamente trabajado, más una gratificación mensual de un 25% sobre el sueldo con tope de 1/12 de 4,75 I.M.M.";
				$frase_adicional_parrafo_5 = "La remuneración se liquidará mensualmente y el medio de pago será de acuerdo a la autorización previamente escrita del trabajador, el primer día hábil del mes siguiente en que se prestan los servicios.";
			}else{
				$frase_adicional_parrafo_2 = "";
				$frase_adicional_parrafo_3 = "";
				$frase_adicional_parrafo_5 = "";
			}

			// Insertamos variables en el word
			$templateWord->setValue('frase_adicional_parrafo_2',$frase_adicional_parrafo_2);
			$templateWord->setValue('frase_adicional_parrafo_3',$frase_adicional_parrafo_3);
			$templateWord->setValue('frase_adicional_parrafo_5',$frase_adicional_parrafo_5);
			$templateWord->setValue('fecha_ingreso_trabajador_palabras',$fecha_inicio_texto_largo);
			$templateWord->setValue('nombre_centro_costo',titleCase($nombre_centro_costo));
			$templateWord->setValue('rut_centro_costo',titleCase($rut_centro_costo));
			$templateWord->setValue('nombre_trabajador',titleCase($nombre_trabajador));
			$templateWord->setValue('rut_trabajador',$rut_trabajador);
			$templateWord->setValue('nacionalidad',titleCase($nacionalidad));
			$templateWord->setValue('fecha_nacimiento',$fecha_nacimiento_texto_largo);
			$templateWord->setValue('estado_civil',titleCase($estado_civil));
			$templateWord->setValue('domicilio_trabajador',titleCase($domicilio_trabajador));
			$templateWord->setValue('comuna_trabajador',titleCase($comuna_trabajador));
			$templateWord->setValue('motivo_req',titleCase($motivo));
			$templateWord->setValue('cargo_postulante',titleCase($cargo));
			$templateWord->setValue('descripcion_jornada',$descripcion_jornada);
			$templateWord->setValue('sueldo_base_numeros', str_replace(',','.',number_format($renta_imponible)));
			$templateWord->setValue('sueldo_base_palabras',titleCase($sueldo_base_palabras));
			$templateWord->setValue('detalle_bonos',$detalle_bonos);
			$templateWord->setValue('prevision_trabajador',titleCase($prevision_trabajador));
			$templateWord->setValue('salud_trabajador',titleCase($salud_trabajador));
			$templateWord->setValue('fecha_ingreso_trabajador',$fecha_inicio_texto_largo);
			$templateWord->setValue('fecha_vigencia_contrato',$fecha_termino_texto_largo);
			$templateWord->setValue('fecha_pago',$fecha_pago_texto_largo);
			$templateWord->setValue('descripcion_causal',$descripcion_causal);

			// Guardamos el documento
			$nombre_documento = "contrato_trabajo_SGO_".$rut_trabajador.".docx";
			$templateWord->saveAs("extras/contratos/archivos_enjoy/".$nombre_documento);
			$get_url = "extras/contratos/archivos_enjoy/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename='".$nombre_documento."'; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
			//fin de boton generar contrato
		}elseif(isset($_POST['generar_doc_adicionales_contrato'])){
			//inicio de boton generar documentos adicionales contrato
			$template_formato = base_url()."extras/contratos/formatos_contratos_enjoy/formato_archivos_adicionales.docx";
			$templateWord = new TemplateProcessor($template_formato);
			$salto_linea = "<w:br/>";

			$var1 = explode('.',$rut_trabajador); 
			$rut1 = $var1[0];

			if($rut1 < 10)
				$rut_trabajador = "0".$rut_trabajador;

			$get_fecha_inicio=date($fecha_inicio); 
			$var1 = explode('-',$get_fecha_inicio); 
			$dia_fi = $var1[2];
			$mes_fi = $var1[1];
			$ano_fi = $var1[0];

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
			$dia_ft = $var2[2];
			$mes_ft = $var2[1];
			$ano_ft = $var2[0];

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

			$get_fecha_pago=date($fecha_pago);
			$var3 = explode('-',$get_fecha_pago);
			$dia_fp = $var3[2];
			$mes_fp = $var3[1];
			$ano_fp = $var3[0];

			if ($mes_fp=="01") $mes_letra_fp="Enero";
			if ($mes_fp=="02") $mes_letra_fp="Febrero";
			if ($mes_fp=="03") $mes_letra_fp="Marzo";
			if ($mes_fp=="04") $mes_letra_fp="Abril";
			if ($mes_fp=="05") $mes_letra_fp="Mayo";
			if ($mes_fp=="06") $mes_letra_fp="Junio";
			if ($mes_fp=="07") $mes_letra_fp="Julio";
			if ($mes_fp=="08") $mes_letra_fp="Agosto";
			if ($mes_fp=="09") $mes_letra_fp="Septiembre";
			if ($mes_fp=="10") $mes_letra_fp="Octubre";
			if ($mes_fp=="11") $mes_letra_fp="Noviembre";
			if ($mes_fp=="12") $mes_letra_fp="Diciembre";

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
			$fecha_pago_texto_largo = $dia_fp." de ".$mes_letra_fp." de ".$ano_fp;
			$fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

			// Insertamos variables en el word
			$templateWord->setValue('nombre_trabajador',titleCase($nombre_trabajador));
			$templateWord->setValue('rut_trabajador',$rut_trabajador);
			$templateWord->setValue('fecha_ingreso_trabajador',$fecha_inicio_texto_largo);
			$templateWord->setValue('fecha_pago',$fecha_pago_texto_largo);
			$templateWord->setValue('fecha_vigencia_contrato',$fecha_termino_texto_largo);

			// Guardamos el documento
			$nombre_documento = "doc_adicional_contrato_trabajo_".$rut_trabajador.".docx";
			$templateWord->saveAs("extras/contratos/archivos_enjoy/".$nombre_documento);

			$get_url = "extras/contratos/archivos_enjoy/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename='".$nombre_documento."'; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
			//fin de boton generar documentos adicionales contrato
		}elseif(isset($_POST['generar_finiquito_diario'])){
			//inicio de boton generar finiquito del contrato
			$template_formato = base_url()."extras/contratos/formatos_contratos_enjoy/formato_finiquitos_diarios.docx";
			$templateWord = new TemplateProcessor($template_formato);
			$salto_linea = "<w:br/>";

			$var1 = explode('.',$rut_trabajador); 
			$rut1 = $var1[0];

			if($rut1 < 10)
				$rut_trabajador = "0".$rut_trabajador;

			$get_fecha_inicio=date($fecha_inicio); 
			$var1 = explode('-',$get_fecha_inicio); 
			$dia_fi = $var1[2];
			$mes_fi = $var1[1];
			$ano_fi = $var1[0];

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
			$dia_ft = $var2[2];
			$mes_ft = $var2[1];
			$ano_ft = $var2[0];

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

			$get_fecha_pago=date($fecha_pago); 
			$var3 = explode('-',$get_fecha_pago); 
			$dia_fp = $var3[2];
			$mes_fp = $var3[1];
			$ano_fp = $var3[0];

			if ($mes_fp=="01") $mes_letra_fp="Enero";
			if ($mes_fp=="02") $mes_letra_fp="Febrero";
			if ($mes_fp=="03") $mes_letra_fp="Marzo";
			if ($mes_fp=="04") $mes_letra_fp="Abril";
			if ($mes_fp=="05") $mes_letra_fp="Mayo";
			if ($mes_fp=="06") $mes_letra_fp="Junio";
			if ($mes_fp=="07") $mes_letra_fp="Julio";
			if ($mes_fp=="08") $mes_letra_fp="Agosto";
			if ($mes_fp=="09") $mes_letra_fp="Septiembre";
			if ($mes_fp=="10") $mes_letra_fp="Octubre";
			if ($mes_fp=="11") $mes_letra_fp="Noviembre";
			if ($mes_fp=="12") $mes_letra_fp="Diciembre";

			$fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
			$fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
			$fecha_pago_texto_largo = $dia_fp." de ".$mes_letra_fp." de ".$ano_fp;

			$get_afp = $this->Afp_model->buscar($prevision_trabajador);
			$porcentaje_afp = isset($get_afp->tasas)?$get_afp->tasas:0;
			$sueldo_liquido_15mil = isset($get_afp->sueldo_liquido_15mil)?$get_afp->sueldo_liquido_15mil:0;
			$sueldo_liquido_20mil = isset($get_afp->sueldo_liquido_20mil)?$get_afp->sueldo_liquido_20mil:0;
			$sueldo_liquido_25mil = isset($get_afp->sueldo_liquido_25mil)?$get_afp->sueldo_liquido_25mil:0;

			if($renta_imponible == 15000){
				$renta_imponible = round($sueldo_liquido_15mil / 30);
			}elseif($renta_imponible == 20000){
				$renta_imponible = round($sueldo_liquido_20mil / 30);
			}elseif($renta_imponible == 25000){
				$renta_imponible = round($sueldo_liquido_25mil / 30);
			}else{
				$renta_imponible = 0;
			}

			$gratificacion_mensual = round($renta_imponible * 0.25);
			$feriado_proporcional = round(($renta_imponible * 1.25) / 30);
			$total_imponibles = round($renta_imponible + $gratificacion_mensual);
			$total_no_imponibles = $feriado_proporcional;
			$total_haberes = round($total_imponibles + $total_no_imponibles);
			$fondo_pension = round(($total_imponibles * $porcentaje_afp) / 100);
			$aporte_salud = round($total_imponibles * 0.07);
			$total_leyes_sociales = round($fondo_pension + $aporte_salud);
			$total_descuentos = $total_leyes_sociales;
			$periodo_contrato = $mes_letra_ft." ".$ano_ft;
			$total_liquido = round($total_haberes - $total_descuentos);
			$liquido_en_palabras = num2letras($total_liquido);

			// Insertamos variables en el word
			$templateWord->setValue('nombre_trabajador',titleCase($nombre_trabajador));
			$templateWord->setValue('rut_trabajador',$rut_trabajador);
			$templateWord->setValue('fecha_inicio_contrato',$fecha_inicio_texto_largo);
			$templateWord->setValue('fecha_termino_contrato',$fecha_termino_texto_largo);
			$templateWord->setValue('fecha_pago_contrato',$fecha_pago_texto_largo);
			$templateWord->setValue('cargo_postulante',$cargo);
			$templateWord->setValue('sueldo_base',$renta_imponible);
			$templateWord->setValue('gratificacion_mensual',$gratificacion_mensual);
			$templateWord->setValue('bono_gestion',$bono_gestion);
			$templateWord->setValue('total_imponibles',$total_imponibles);
			$templateWord->setValue('feriado_proporcional',$feriado_proporcional);
			$templateWord->setValue('total_no_imponibles',$total_no_imponibles);
			$templateWord->setValue('total_haberes',$total_haberes);
			$templateWord->setValue('total_liquido',$total_liquido);
			$templateWord->setValue('fondo_pension',$fondo_pension);
			$templateWord->setValue('aporte_salud',$aporte_salud);
			$templateWord->setValue('total_leyes_sociales',$total_leyes_sociales);
			$templateWord->setValue('total_descuentos',$total_descuentos);
			$templateWord->setValue('periodo_contrato',$periodo_contrato);
			$templateWord->setValue('liquido_en_palabras', titleCase($liquido_en_palabras));

			

			$datos_finiquito = array(
				'id_req_usu_archivo' => $id_req_usu_archivo,
				'id_usuario_generacion' => $this->session->userdata('id'),
				'gratificacion_mensual' => $gratificacion_mensual,
				'total_haberes_imponibles' => $total_imponibles,
				'feriado_proporcional' => $feriado_proporcional,
				'total_haberes_no_imponibles' => $total_no_imponibles,
				'total_haberes' => $total_haberes,
				'total_fondo_pension' => $fondo_pension,
				'aporte_salud' => $aporte_salud,
				'total_leyes_sociales' => $total_leyes_sociales,
				'impuesto_unico' => 0,
				'total_descuentos' => $total_descuentos,
				'total_liquido' => $total_liquido,
			);

			$get_registro_finiquito = $this->Finiquitos_model->get_archivo($id_req_usu_archivo);
			$existe_registro = isset($get_registro_finiquito->id)?1:0;

			if($this->session->userdata('tipo_usuario') == 14 or $this->session->userdata('tipo_usuario') == 15){
				if($existe_registro == 0){
					$this->Finiquitos_model->guardar($datos_finiquito);
				}
			}

			// Guardamos el documento
			$nombre_documento = "finiquito_contrato_trabajo_".$rut_trabajador.".docx";
			$templateWord->saveAs("extras/contratos/archivos_enjoy/".$nombre_documento);

			$get_url = "extras/contratos/archivos_enjoy/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename='".$nombre_documento."'; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
			//fin de boton generar finiquito del contrato
		}
	}

	function aprobacion_masiva_contrato_anexo_doc(){
		$solicitud = isset($_POST['solicitudes'])?$_POST['solicitudes']:false;
		if($solicitud){
			foreach($_POST['solicitudes'] as $c=>$valores){
				$id_req_usu_arch = $valores;
				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';

				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$get_solicitud_contrato = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_req_usu_arch, '0');
				$id_solicitante = isset($get_solicitud_contrato->id_solicitante)?$get_solicitud_contrato->id_solicitante:'';
				$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
				$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
				$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';

				$usr = $this->Usuarios_model->get($id_usuario);
				$rut_trabajador = isset($usr->rut_usuario)?$usr->rut_usuario:'';
				$nombres = isset($usr->nombres)?$usr->nombres:'';
				$paterno = isset($usr->paterno)?$usr->paterno:'';
				$materno = isset($usr->materno)?$usr->materno:'';
				$nombre_trabajador = $nombres.' '.$paterno.' '.$materno;

				//verificacion y creacion de codigo  de contrato
				$fechaI = new DateTime($fecha_inicio);
						$fechaI->modify('first day of this month');
						$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
				$fechaT = new DateTime($fecha_inicio);
						$fechaT->modify('last day of this month');
						$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31
				//**********************************************************************************\\

				$verificarCodigoDisponibleDeBaja = $this->Requerimiento_Usuario_Archivo_model->getCodigoDisponible($id_usuario, $fechaInicio,$fechaTermino);
				//var_dump($verificarCodigoDisponibleDeBaja);
				if ($verificarCodigoDisponibleDeBaja != false) {// si es que tome el codigo de la tabla codigo_libre, lo asigno  a este contrato  y lo elimino de la tabla
						$idCodigoLibre = $verificarCodigoDisponibleDeBaja->id;
						$idLetraAbecedario = $verificarCodigoDisponibleDeBaja->codigoLibre;
						$letraAbecedario = $this->Requerimiento_Usuario_Archivo_model->getLetraAbecedario($idLetraAbecedario);
						$cambiandoEstado = array(
							'estado'=>1,
							);
						$this->Requerimiento_Usuario_Archivo_model->actualizarCodigoLibre($idCodigoLibre, $cambiandoEstado);//cambio su estado a 1 (eliminado)

						$datos_aprobacion = array(
							'id_req_usu_arch' => $id_req_usu_arch,
							'id_solicitante' => $this->session->userdata('id'),
							'fecha_solicitud' => date('Y-m-d'),
							'estado' => 1,
						);
						$datos_usu_arch = array(
							'estado_proceso' => 2,
							'fecha_aprobacion'=> date('Y-m-d H:i:s'),
							'codigo_contrato'=>$rut_trabajador.$letraAbecedario->letra,
							'id_abecedario_asignado'=>$idLetraAbecedario,
						);
						$id_registro = $this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato($datos_aprobacion);
						$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_usu_arch);
				}else{	// en caso de que no exista codigo disponible en la tabla codigo libre
						$result = $this->Requerimiento_Usuario_Archivo_model->getCodigoContrato($id_usuario, $fechaInicio, $fechaTermino);
						if ($result != false) {//si ya hay codigos en el mes
								$idLetraAbecedario = count($result)+1;
								$letraAbecedario   = $this->Requerimiento_Usuario_Archivo_model->getLetraAbecedario($idLetraAbecedario);
								$datos_aprobacion = array(
									'id_req_usu_arch' => $id_req_usu_arch,
									'id_solicitante' => $this->session->userdata('id'),
									'fecha_solicitud' => date('Y-m-d'),
									'estado' => 1,
								);
								$datos_usu_arch = array(
									'estado_proceso' => 2,
									'fecha_aprobacion'=> date('Y-m-d H:i:s'),
									'codigo_contrato'=>$rut_trabajador.$letraAbecedario->letra,
									'id_abecedario_asignado' =>$idLetraAbecedario,
								);
								$id_registro = $this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato($datos_aprobacion);
								$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_usu_arch);
						}else{
								$idLetraAbecedario = count($result)+1;
								$letraAbecedario   = $this->Requerimiento_Usuario_Archivo_model->getLetraAbecedario($idLetraAbecedario);
								$datos_aprobacion = array(
									'id_req_usu_arch' => $id_req_usu_arch,
									'id_solicitante' => $this->session->userdata('id'),
									'fecha_solicitud' => date('Y-m-d'),
									'estado' => 1,
								);
								$datos_usu_arch = array(
									'estado_proceso' => 2,
									'fecha_aprobacion'=> date('Y-m-d H:i:s'),
									'codigo_contrato'=>$rut_trabajador."A",
									'id_abecedario_asignado' =>1,
								);
								$id_registro = $this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato($datos_aprobacion);
								$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_usu_arch);
						}
				}
				$this->load->library('email');
				$config['smtp_host'] = 'mail.empresasintegra.cl';
				$config['smtp_user'] = 'informaciones@empresasintegra.cl';
				$config['smtp_pass'] = '%SYkNLH1';
				$config['mailtype'] = 'html';
				$config['smtp_port']    = '2552';
				$this->email->initialize($config);

				$destinatarios_cc = array('contratos@empresasintegra.cl','jsilva@empresasintegra.cl');
			    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - ENJOY');
			    $this->email->to($email_solicitante);
				$this->email->cc($destinatarios_cc);
			    $this->email->subject("Aprobacion Contrato Trabajador: ".$nombre_trabajador." - Fecha Inicio Contrato: ".$fecha_inicio);
			    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' email '.$email_solicitante.' la solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.' ha sido aprobado exitosamente.<br>Saludos');
			    $this->email->send();
			}
			echo '<script>alert("Solicitud de aprobacion de contrato aprobado exitosamente");</script>';
		}else{
			echo '<script>alert("Debe seleccionar  al menos una solicitud");</script>';
		}
		redirect('enjoy/contratos/solicitudes_pendientes', 'refresh');
	}

	#07-08-2018 solicitud de baja de  contratos

	function solicitud_bajar_contrato($id_usu_arch){
		if($id_usu_arch != FALSE){
			$data = array(
				'estado_proceso' => 3,// en proceso de baja
				'fecha_solicitud_baja'=> date('Y-m-d H:i:s'),
				);
			$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_usu_arch, $data);
			echo '<script>alert("Contrato se encuentra en proceso de baja");</script>';
		}

		redirect('enjoy/contratos/solicitudes_completas','refresh');
	}

	function solicitudes_pendientes_baja(){
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de contratos pendientes",
			'titulo' => "Listado solicitudes pendientes para  bajar",
			'subtitulo' => 'Unidad de Negocio: Enjoy Antofagasta',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado solicitudes pendientes para  bajar' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/si_validaciones.js','js/validacion/validarEnviarSolicitudContrato.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);

		$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_pendientes_baja();
		$listado = array();
		if($trabajadores != FALSE){
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$id_req_usu_arch = isset($rm->id)?$rm->id:'';
				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$usr = $this->Usuarios_model->get($id_usuario);
				$get_proceso = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato_tipo_proceso($id_req_usu_arch, 0);
				$id_solicitante = isset($get_proceso->id_solicitante)?$get_proceso->id_solicitante:'';
				$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';

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
				$get_region_planta = $this->Regiones_model->get($id_region_planta);
				$get_ciudad_planta = $this->Ciudades_model->get($id_ciudad_planta);
				$get_jornada = $this->Descripcion_horarios_model->get($get_usu_archivo->jornada);

				$aux->regimen = isset($get_requerimiento->regimen)?$get_requerimiento->regimen:'';
				$aux->codigo_centro_costo = isset($get_requerimiento->codigo_centro_costo)?$get_requerimiento->codigo_centro_costo:'';
				$aux->id_req_usu_arch = isset($rm->id)?$rm->id:'';
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
				$aux->nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;

				$nombres = isset($usr->nombres)?$usr->nombres:'';
				$paterno = isset($usr->paterno)?$usr->paterno:'';
				$materno = isset($usr->materno)?$usr->materno:'';
				$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
				$aux->nombre_sin_espacios = $paterno.'_'.$materno;
				$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';

				$idBancoo = isset($usr->id_bancos)?$usr->id_bancos:'';
				if (!empty($idBancoo)) {
					$nombreBanco = $this->Usuarios_model->getNombreBanco($idBancoo);
				}else{
					$nombreBanco='';
				}
				//$nombreBanco = $this->Usuarios_model->getNombreBanco($usr->id_bancos);
				$aux->banco = isset($nombreBanco->desc_bancos)?$nombreBanco->desc_bancos:'';
				$aux->tipo_cuenta = isset($usr->tipo_cuenta)?$usr->tipo_cuenta:'';
				$aux->cuenta_banco = isset($usr->cuenta_banco)?$usr->cuenta_banco:'';



				$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
				$aux->domicilio = isset($usr->direccion)?$usr->direccion:'';
				$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
				$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';

				$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
				$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
				$aux->telefono = isset($usr->fono)?$usr->fono:'';
				$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';

				if($get_usu_archivo->tipo_archivo_requerimiento_id == 1)
					$aux->tipo_archivo = "Contrato de Trabajo";
				elseif($get_usu_archivo->tipo_archivo_requerimiento_id == 2)
					$aux->tipo_archivo = "Anexo de Contrato";
				else
					$aux->tipo_archivo = "";

				$aux->estado_proceso = $get_usu_archivo->estado_proceso;
				$aux->id_tipo_contrato = $get_usu_archivo->id_tipo_contrato;
				$aux->nombre = $get_usu_archivo->nombre;
				$aux->url = $get_usu_archivo->url;
				$aux->causal = $get_usu_archivo->causal;
				$aux->motivo = $get_usu_archivo->motivo;
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->renta_imponible = $get_usu_archivo->renta_imponible;
				/*edit 03-07-2018 Calculo finiquito*/
				$prevision_trabajador= $aux->prevision;

				$get_afp = $this->Afp_model->buscar($prevision_trabajador);
				$porcentaje_afp = isset($get_afp->tasas)?$get_afp->tasas:0;
				$sueldo_liquido_15mil = isset($get_afp->sueldo_liquido_15mil)?$get_afp->sueldo_liquido_15mil:0;
				$sueldo_liquido_20mil = isset($get_afp->sueldo_liquido_20mil)?$get_afp->sueldo_liquido_20mil:0;
				$sueldo_liquido_25mil = isset($get_afp->sueldo_liquido_25mil)?$get_afp->sueldo_liquido_25mil:0;

				$renta_imponible = $aux->renta_imponible;
				if($renta_imponible == 15000){
					/*30-07-2018 obteniendo sueldo mensual por persona sueldoMensualDeAcuerdoAsuAFP  g.r.m*/
					$renta_imponible = round($sueldo_liquido_15mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_15mil;
				}elseif($renta_imponible == 20000){
					$renta_imponible = round($sueldo_liquido_20mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_20mil;
				}elseif($renta_imponible == 25000){
					$renta_imponible = round($sueldo_liquido_25mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_25mil;
				}else{
					$renta_imponible = 0;
					$sueldoMensualDeAcuerdoAsuAFP = 0;
				}
				$aux->sueldoMensual = $sueldoMensualDeAcuerdoAsuAFP;
				$gratificacion_mensual = round($renta_imponible * 0.25);
				$feriado_proporcional = round(($renta_imponible * 1.25) / 30);
				$total_imponibles = round($renta_imponible + $gratificacion_mensual);
				$total_no_imponibles = $feriado_proporcional;
				$total_haberes = round($total_imponibles + $total_no_imponibles);
				$fondo_pension = round(($total_imponibles * $porcentaje_afp) / 100);
				$aporte_salud = round($total_imponibles * 0.07);
				$total_leyes_sociales = round($fondo_pension + $aporte_salud);
				$total_descuentos = $total_leyes_sociales;
				$total_liquido = round($total_haberes - $total_descuentos);
				//ahora guardo el resultado en las variables auxiliares
				$aux->total_liquido_finiquito = $total_liquido;
				$aux->feriado_proporcional_finiquito = $feriado_proporcional;


				/*fin calculo pago liquido y feriado proporcional*/
				$aux->asignacion_movilizacion = $get_usu_archivo->asignacion_movilizacion;
				$aux->asignacion_colacion = $get_usu_archivo->asignacion_colacion;
				$aux->asignacion_zona = $get_usu_archivo->asignacion_zona;
				$aux->viatico = $get_usu_archivo->viatico;
				$aux->fecha_inicio = $get_usu_archivo->fecha_inicio;
				$aux->fecha_termino = $get_usu_archivo->fecha_termino;
				$aux->fecha_pago = $get_usu_archivo->fecha_pago;

				$fecha_inicio = $get_usu_archivo->fecha_inicio;
				$get_fecha_inicio=date($fecha_inicio); 
				$var1 = explode('-',$get_fecha_inicio); 
				$dia_fi = $var1[2];
				$mes_fi = $var1[1];
				$ano_fi = $var1[0];

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

				$fecha_termino = $get_usu_archivo->fecha_termino;
				$get_fecha_termino=date($fecha_termino); 
				$var2 = explode('-',$get_fecha_termino); 
				$dia_ft = $var2[2];
				$mes_ft = $var2[1];
				$ano_ft = $var2[0];

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

				$fecha_pago = $get_usu_archivo->fecha_pago;
				$get_fecha_pago = date($fecha_pago); 
				$var4 = explode('-',$get_fecha_pago); 
				$dia_fp = $var4[2];
				$mes_fp = $var4[1];
				$ano_fp = $var4[0];

				if($mes_fp == "01") $mes_letra_fp = "Enero";
				if($mes_fp == "02") $mes_letra_fp = "Febrero";
				if($mes_fp == "03") $mes_letra_fp = "Marzo";
				if($mes_fp == "04") $mes_letra_fp = "Abril";
				if($mes_fp == "05") $mes_letra_fp = "Mayo";
				if($mes_fp == "06") $mes_letra_fp = "Junio";
				if($mes_fp == "07") $mes_letra_fp = "Julio";
				if($mes_fp == "08") $mes_letra_fp = "Agosto";
				if($mes_fp == "09") $mes_letra_fp = "Septiembre";
				if($mes_fp == "10") $mes_letra_fp = "Octubre";
				if($mes_fp == "11") $mes_letra_fp = "Noviembre";
				if($mes_fp == "12") $mes_letra_fp = "Diciembre";

				$fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
				$get_fecha_nacimiento=date($fecha_nac); 

				if (!empty($get_fecha_nacimiento)) {
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
				}else{
					$dia_fecha_nac=0;
					$mes_letra_fecha_nac='';
					$ano_fecha_nac=0000;
				}

				$aux->fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
				$aux->fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
				$aux->fecha_pago_texto_largo = $dia_fp." de ".$mes_letra_fp." de ".$ano_fp;
				$aux->fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

				array_push($listado, $aux);
				unset($aux);
			}
		}
		$pagina['pedientes_baja']= true;
		$pagina['listado'] = $listado;
		$base['cuerpo'] = $this->load->view('contratos/listado_solicitudes_pendientes',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function solicitudes_completas_baja(){
				$base = array(
			'head_titulo' => "Sistema EST - Listado de bajas",
			'titulo' => "Listado de bajas",
			'subtitulo' => 'Unidad de Negocio: Enjoy Antofagasta',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado de bajas' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/si_validaciones.js','js/validacion/validarEnviarSolicitudContrato.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);

		$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas_baja();
		$listado = array();
		if($trabajadores != FALSE){
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$id_req_usu_arch = isset($rm->id)?$rm->id:'';
				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$usr = $this->Usuarios_model->get($id_usuario);
				$get_proceso = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato_tipo_proceso($id_req_usu_arch, 0);
				$id_solicitante = isset($get_proceso->id_solicitante)?$get_proceso->id_solicitante:'';
				$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';

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
				$get_region_planta = $this->Regiones_model->get($id_region_planta);
				$get_ciudad_planta = $this->Ciudades_model->get($id_ciudad_planta);
				$get_jornada = $this->Descripcion_horarios_model->get($get_usu_archivo->jornada);

				$aux->regimen = isset($get_requerimiento->regimen)?$get_requerimiento->regimen:'';
				$aux->codigo_centro_costo = isset($get_requerimiento->codigo_centro_costo)?$get_requerimiento->codigo_centro_costo:'';
				$aux->id_req_usu_arch = isset($rm->id)?$rm->id:'';
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
				$aux->nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;

				$nombres = isset($usr->nombres)?$usr->nombres:'';
				$paterno = isset($usr->paterno)?$usr->paterno:'';
				$materno = isset($usr->materno)?$usr->materno:'';
				$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
				$aux->nombre_sin_espacios = $paterno.'_'.$materno;
				$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';

				$idBancoo = isset($usr->id_bancos)?$usr->id_bancos:'';
				if (!empty($idBancoo)) {
					$nombreBanco = $this->Usuarios_model->getNombreBanco($idBancoo);
				}else{
					$nombreBanco='';
				}
				//$nombreBanco = $this->Usuarios_model->getNombreBanco($usr->id_bancos);
				$aux->banco = isset($nombreBanco->desc_bancos)?$nombreBanco->desc_bancos:'';
				$aux->tipo_cuenta = isset($usr->tipo_cuenta)?$usr->tipo_cuenta:'';
				$aux->cuenta_banco = isset($usr->cuenta_banco)?$usr->cuenta_banco:'';



				$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
				$aux->domicilio = isset($usr->direccion)?$usr->direccion:'';
				$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
				$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';

				$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
				$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
				$aux->telefono = isset($usr->fono)?$usr->fono:'';
				$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';

				if($get_usu_archivo->tipo_archivo_requerimiento_id == 1)
					$aux->tipo_archivo = "Contrato de Trabajo";
				elseif($get_usu_archivo->tipo_archivo_requerimiento_id == 2)
					$aux->tipo_archivo = "Anexo de Contrato";
				else
					$aux->tipo_archivo = "";

				$aux->estado_proceso = $get_usu_archivo->estado_proceso;
				$aux->id_tipo_contrato = $get_usu_archivo->id_tipo_contrato;
				$aux->nombre = $get_usu_archivo->nombre;
				$aux->url = $get_usu_archivo->url;
				$aux->causal = $get_usu_archivo->causal;
				$aux->motivo = $get_usu_archivo->motivo;
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->renta_imponible = $get_usu_archivo->renta_imponible;
				/*edit 03-07-2018 Calculo finiquito*/
				$prevision_trabajador= $aux->prevision;

				$get_afp = $this->Afp_model->buscar($prevision_trabajador);
				$porcentaje_afp = isset($get_afp->tasas)?$get_afp->tasas:0;
				$sueldo_liquido_15mil = isset($get_afp->sueldo_liquido_15mil)?$get_afp->sueldo_liquido_15mil:0;
				$sueldo_liquido_20mil = isset($get_afp->sueldo_liquido_20mil)?$get_afp->sueldo_liquido_20mil:0;
				$sueldo_liquido_25mil = isset($get_afp->sueldo_liquido_25mil)?$get_afp->sueldo_liquido_25mil:0;

				$renta_imponible = $aux->renta_imponible;
				if($renta_imponible == 15000){
					/*30-07-2018 obteniendo sueldo mensual por persona sueldoMensualDeAcuerdoAsuAFP  g.r.m*/
					$renta_imponible = round($sueldo_liquido_15mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_15mil;
				}elseif($renta_imponible == 20000){
					$renta_imponible = round($sueldo_liquido_20mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_20mil;
				}elseif($renta_imponible == 25000){
					$renta_imponible = round($sueldo_liquido_25mil / 30);
					$sueldoMensualDeAcuerdoAsuAFP = $sueldo_liquido_25mil;
				}else{
					$renta_imponible = 0;
					$sueldoMensualDeAcuerdoAsuAFP = 0;
				}
				$aux->sueldoMensual = $sueldoMensualDeAcuerdoAsuAFP;
				$gratificacion_mensual = round($renta_imponible * 0.25);
				$feriado_proporcional = round(($renta_imponible * 1.25) / 30);
				$total_imponibles = round($renta_imponible + $gratificacion_mensual);
				$total_no_imponibles = $feriado_proporcional;
				$total_haberes = round($total_imponibles + $total_no_imponibles);
				$fondo_pension = round(($total_imponibles * $porcentaje_afp) / 100);
				$aporte_salud = round($total_imponibles * 0.07);
				$total_leyes_sociales = round($fondo_pension + $aporte_salud);
				$total_descuentos = $total_leyes_sociales;
				$total_liquido = round($total_haberes - $total_descuentos);
				//ahora guardo el resultado en las variables auxiliares
				$aux->total_liquido_finiquito = $total_liquido;
				$aux->feriado_proporcional_finiquito = $feriado_proporcional;


				/*fin calculo pago liquido y feriado proporcional*/
				$aux->asignacion_movilizacion = $get_usu_archivo->asignacion_movilizacion;
				$aux->asignacion_colacion = $get_usu_archivo->asignacion_colacion;
				$aux->asignacion_zona = $get_usu_archivo->asignacion_zona;
				$aux->viatico = $get_usu_archivo->viatico;
				$aux->fecha_inicio = $get_usu_archivo->fecha_inicio;
				$aux->fecha_termino = $get_usu_archivo->fecha_termino;
				$aux->fecha_pago = $get_usu_archivo->fecha_pago;

				$fecha_inicio = $get_usu_archivo->fecha_inicio;
				$get_fecha_inicio=date($fecha_inicio); 
				$var1 = explode('-',$get_fecha_inicio); 
				$dia_fi = $var1[2];
				$mes_fi = $var1[1];
				$ano_fi = $var1[0];

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

				$fecha_termino = $get_usu_archivo->fecha_termino;
				$get_fecha_termino=date($fecha_termino); 
				$var2 = explode('-',$get_fecha_termino); 
				$dia_ft = $var2[2];
				$mes_ft = $var2[1];
				$ano_ft = $var2[0];

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

				$fecha_pago = $get_usu_archivo->fecha_pago;
				$get_fecha_pago = date($fecha_pago); 
				$var4 = explode('-',$get_fecha_pago); 
				$dia_fp = $var4[2];
				$mes_fp = $var4[1];
				$ano_fp = $var4[0];

				if($mes_fp == "01") $mes_letra_fp = "Enero";
				if($mes_fp == "02") $mes_letra_fp = "Febrero";
				if($mes_fp == "03") $mes_letra_fp = "Marzo";
				if($mes_fp == "04") $mes_letra_fp = "Abril";
				if($mes_fp == "05") $mes_letra_fp = "Mayo";
				if($mes_fp == "06") $mes_letra_fp = "Junio";
				if($mes_fp == "07") $mes_letra_fp = "Julio";
				if($mes_fp == "08") $mes_letra_fp = "Agosto";
				if($mes_fp == "09") $mes_letra_fp = "Septiembre";
				if($mes_fp == "10") $mes_letra_fp = "Octubre";
				if($mes_fp == "11") $mes_letra_fp = "Noviembre";
				if($mes_fp == "12") $mes_letra_fp = "Diciembre";

				$fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
				$get_fecha_nacimiento=date($fecha_nac); 

				if (!empty($get_fecha_nacimiento)) {
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
				}else{
					$dia_fecha_nac=0;
					$mes_letra_fecha_nac='';
					$ano_fecha_nac=0000;
				}

				$aux->fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
				$aux->fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
				$aux->fecha_pago_texto_largo = $dia_fp." de ".$mes_letra_fp." de ".$ano_fp;
				$aux->fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

				array_push($listado, $aux);
				unset($aux);
			}
		}
		$pagina['completa_baja']= true;//variable que envio a la vista para determinar que vengo desde esta funcion
		$pagina['listado'] = $listado;
		$base['cuerpo'] = $this->load->view('contratos/listado_solicitudes_completas_validadas',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

}

?>