<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

$archivo_numero_letras = "extras/contratos/numero_letras.php";
$autoloader = "extras/contratos/PHPWord-master/src/PhpWord/Autoloader.php";
require_once (BASE_URL2.$autoloader);
require_once (BASE_URL2.$archivo_numero_letras);
\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\TemplateProcessor;

class Contratos_log extends CI_Controller{
	public function __construct(){
    	parent::__construct();
		$this->load->model("logistica_servicios/Requerimiento_asc_trabajadores_model");
		$this->load->model("logistica_servicios/Ciudades_model");
		$this->load->model("logistica_servicios/Afp_model");
		$this->load->model("logistica_servicios/Salud_model");
		$this->load->model("logistica_servicios/Estado_civil_model");
		$this->load->model("logistica_servicios/Nivel_estudios_model");
		$this->load->model("logistica_servicios/Requerimiento_area_cargo_model");
		$this->load->model("logistica_servicios/Requerimientos_model");
		$this->load->model("logistica_servicios/Areas_model");
		$this->load->model("logistica_servicios/Cargos_model");
		$this->load->model("logistica_servicios/Empresas_model");
		$this->load->model("logistica_servicios/Tipo_gratificacion_model");
		$this->load->model("logistica_servicios/Regiones_model");
		$this->load->model('logistica_servicios/Requerimiento_Usuario_Archivo_model');
		$this->load->model('logistica_servicios/Empresa_planta_model');
		$this->load->model('logistica_servicios/Usuarios_model');
		$this->load->model('logistica_servicios/Descripcion_horarios_model');
		$this->load->model('logistica_servicios/Descripcion_causal_model');
		$this->load->model("usuarios/Usuarios_general_model");

		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 11)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_rrhh','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		redirect('est/contratos_log/solicitudes_pendientes', 'refresh');
	}

	//OK
	function solicitudes_pendientes(){
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de contratos pendientes",
			'titulo' => "Listado solicitudes pendientes (Logistica y Servicios)",
			'subtitulo' => 'Unidad de Negocio: Logistica y Servicios',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado solicitudes pendientes' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);

		$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_validadas();
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
				$get_proceso = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato_tipo_proceso($id_req_usu_arch, 1);
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

				$aux->codigo_centro_costo = isset($get_requerimiento->codigo_centro_costo)?$get_requerimiento->codigo_centro_costo:'';
				$aux->id_req_usu_arch = $id_req_usu_arch;
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

				$nombreBanco = $this->Usuarios_model->getNombreBanco($usr->id_bancos);
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

				$aux->nombre = $get_usu_archivo->nombre;
				$aux->url = $get_usu_archivo->url;
				$aux->causal = $get_usu_archivo->causal;
				$aux->motivo = $get_usu_archivo->motivo;
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->desc_jornada = isset($get_jornada->descripcion)?$get_jornada->descripcion:'';
				$aux->renta_imponible = $get_usu_archivo->renta_imponible;
				$aux->asignacion_movilizacion = $get_usu_archivo->asignacion_movilizacion;
				$aux->asignacion_colacion = $get_usu_archivo->asignacion_colacion;
				$aux->asignacion_zona = $get_usu_archivo->asignacion_zona;
				$aux->viatico = $get_usu_archivo->viatico;
				$aux->fecha_inicio = $get_usu_archivo->fecha_inicio;
				$aux->fecha_termino = $get_usu_archivo->fecha_termino;

				$fecha_inicio = $get_usu_archivo->fecha_inicio;
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

				$fecha_termino = $get_usu_archivo->fecha_termino;
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

				$fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'0000-00-00';
				$get_fecha_nacimiento=date($fecha_nac); 
				$var3 = explode('-',$get_fecha_nacimiento); 
				$dia_fecha_nac = $var3[2];
				$mes_fecha_nac = $var3[1];
				$ano_fecha_nac = $var3[0];
				if ($mes_fecha_nac=="00") $mes_letra_fecha_nac="";
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

				$aux->fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
				$aux->fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
				$aux->fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

				array_push($listado, $aux);
				unset($aux);
			}
		}

		$pagina['listado'] = $listado;
		$base['cuerpo'] = $this->load->view('contratos_log/listado_solicitudes_pendientes',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	//OK
	function solicitudes_completas(){
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de contratos completas",
			'titulo' => "Listado solicitudes completas (Logistica y Servicios)",
			'subtitulo' => 'Unidad de Negocio: Casa Matriz',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado solicitudes completas' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);

		$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas();
		$listado = array();
		if($trabajadores != FALSE){
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$id_req_usu_arch = isset($rm->id)?$rm->id:NULL;
				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$usr = $this->Usuarios_model->get($id_usuario);
				$get_proceso = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato_tipo_proceso($id_req_usu_arch, 1);
				$id_solicitante = isset($get_proceso->id_solicitante)?$get_proceso->id_solicitante:'';
				$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
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

				$aux->codigo_centro_costo = isset($get_requerimiento->codigo_centro_costo)?$get_requerimiento->codigo_centro_costo:'';
				$aux->id_req_usu_arch = $id_req_usu_arch;
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

				$nombreBanco = $this->Usuarios_model->getNombreBanco($usr->id_bancos);
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

				$id_tipo_archivo = isset($get_usu_archivo->tipo_archivo_requerimiento_id)?$get_usu_archivo->tipo_archivo_requerimiento_id:NULL;

				if($id_tipo_archivo == 1)
					$aux->tipo_archivo = "Contrato de Trabajo";
				elseif($id_tipo_archivo == 2)
					$aux->tipo_archivo = "Anexo de Contrato";
				else
					$aux->tipo_archivo = "";

				$aux->nombre = $get_usu_archivo->nombre;
				$aux->url = $get_usu_archivo->url;
				$aux->causal = $get_usu_archivo->causal;
				$aux->motivo = $get_usu_archivo->motivo;
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->desc_jornada = isset($get_jornada->descripcion)?$get_jornada->descripcion:'';
				$aux->renta_imponible = $get_usu_archivo->renta_imponible;
				$aux->asignacion_movilizacion = $get_usu_archivo->asignacion_movilizacion;
				$aux->asignacion_colacion = $get_usu_archivo->asignacion_colacion;
				$aux->asignacion_zona = $get_usu_archivo->asignacion_zona;
				$aux->viatico = $get_usu_archivo->viatico;
				$aux->fecha_inicio = $get_usu_archivo->fecha_inicio;
				$aux->fecha_termino = $get_usu_archivo->fecha_termino;
				$fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'0000-00-00';
				//var_dump($fecha_inicio);
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
				if ($mes_fi=="00") $mes_letra_fi="";

				$fecha_termino = isset($get_usu_archivo->fecha_termino)?$get_usu_archivo->fecha_termino:'0000-00-00';
				$get_fecha_termino=date($fecha_termino); 
				//var_dump($get_fecha_termino);
				$var2 = explode('-',$get_fecha_termino); 				
				$ano_ft = $var2[0];
				$mes_ft = $var2[1];
				$get_dia_ft = $var2[2];
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
				if ($mes_ft=="00") $mes_letra_ft="";

				$fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
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

				$aux->fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
				$aux->fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
				$aux->fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

				array_push($listado, $aux);
				unset($aux);
			}
		}

		$pagina['listado'] = $listado;
		$base['cuerpo'] = $this->load->view('contratos_log/listado_solicitudes_completas',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	//OK
	function aprobar_contrato_anexo_doc_general($id_req_usu_arch){
		$datos_aprobacion = array(
			'id_req_usu_arch' => $id_req_usu_arch,
			'id_solicitante' => $this->session->userdata('id'),
			'fecha_solicitud' => date('Y-m-d'),
			'estado' => 2,
		);
		$datos_usu_arch = array('estado_proceso' => 3,);

		$this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato($datos_aprobacion);
		$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_usu_arch);

		$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
		$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
		$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
		$fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';

		$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
		$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';

		$get_solicitante1 = $this->Requerimiento_Usuario_Archivo_model->get_proceso_contrato_tipo($id_req_usu_arch, 0);
		$get_solicitante2 = $this->Requerimiento_Usuario_Archivo_model->get_proceso_contrato_tipo($id_req_usu_arch, 1);
		$id_solicitante1 = isset($get_solicitante1->id_solicitante)?$get_solicitante1->id_solicitante:'';
		$id_solicitante2 = isset($get_solicitante2->id_solicitante)?$get_solicitante2->id_solicitante:'';
		$get_solicitante1 = $this->Usuarios_general_model->get($id_solicitante1);
		$nombre_solicitante1 = isset($get_solicitante1->nombres)?$get_solicitante1->nombres:'';
		$paterno_solicitante1 = isset($get_solicitante1->paterno)?$get_solicitante1->paterno:'';
		$materno_solicitante1 = isset($get_solicitante1->materno)?$get_solicitante1->materno:'';
		$nombre_completo_solicitante1 = $nombre_solicitante1.' '.$paterno_solicitante1.' '.$materno_solicitante1;
		$email_solicitante1 = isset($get_solicitante1->email)?$get_solicitante1->email:'';

		$get_solicitante2 = $this->Usuarios_general_model->get($id_solicitante2);
		$nombre_solicitante2 = isset($get_solicitante2->nombres)?$get_solicitante2->nombres:'';
		$paterno_solicitante2 = isset($get_solicitante2->paterno)?$get_solicitante2->paterno:'';
		$materno_solicitante2 = isset($get_solicitante2->materno)?$get_solicitante2->materno:'';
		$nombre_completo_solicitante2 = $nombre_solicitante2.' '.$paterno_solicitante2.' '.$materno_solicitante2;
		$email_solicitante2 = isset($get_solicitante2->email)?$get_solicitante2->email:'';

		$usr = $this->Usuarios_model->get($id_usuario);
		$rut_trabajador = isset($usr->rut_usuario)?$usr->rut_usuario:'';
		$nombres = isset($usr->nombres)?$usr->nombres:'';
		$paterno = isset($usr->paterno)?$usr->paterno:'';
		$materno = isset($usr->materno)?$usr->materno:'';
		$nombre_trabajador = $nombres.' '.$paterno.' '.$materno;
        $correoAenviar = "jsilva@empresasintegra.cl";
		$this->load->library('email');
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);
		$destinatarios = array($email_solicitante1, $email_solicitante2,$correoAenviar);

	    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - BLUE');
	    $this->email->to($destinatarios);
	    $this->email->cc('contratos@empresasintegra.cl');
	    $this->email->subject("Aprobacion Contrato Trabajador: ".$nombre_trabajador." - Fecha Inicio Contrato: ".$fecha_inicio);
	    $this->email->message('Estimado(a) '.$nombre_completo_solicitante1.' la solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.' ha sido aprobada con exito.<br>Saludos');
	    $this->email->send();

		echo '<script>alert("Solicitud de aprobacion de contrato aprobado exitosamente");</script>';
		redirect('est/contratos_log/solicitudes_pendientes', 'refresh');
	}

	//OK
	function modal_visualizar_contrato_anexo_doc_general($id_usu_arch){
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
			array_push($datos_generales, $aux);
			unset($aux);
		}

		$get_solicitudes_contratos = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_usu_arch);
		$pagina['solicitud_existente_contrato'] = isset($get_solicitudes_contratos->id)?1:0;
		$pagina['datos_generales'] = $datos_generales;
		$pagina['id_usu_arch']= $id_usu_arch;
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_usu_arch);
		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_planta);
		$this->load->view('est/contratos_log/modal_administrar_contrato_anexo_doc_contractuales', $pagina);
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
			array_push($datos_generales, $aux);
			unset($aux);
		}

		$get_solicitudes_contratos = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_usu_arch);
		$pagina['solicitud_existente_contrato'] = isset($get_solicitudes_contratos->id)?1:0;
		$pagina['datos_generales'] = $datos_generales;
		$pagina['id_usu_arch']= $id_usu_arch;
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_usu_arch);
		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_planta);
		$this->load->view('est/contratos_log/modal_rechazar_contrato_anexo_doc_contractuales', $pagina);
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

	    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - BLUE');
	    $this->email->to($email_solicitante);
		$this->email->to('contratos@empresasintegra.cl');
	    $this->email->subject("Rechazo Contrato Trabajador: ".$nombre_trabajador." - Fecha Inicio Contrato: ".$fecha_inicio);
	    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' la solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.' ha sido rechazado.<br>Con la siguiente observacion:<br>'.$_POST['observaciones'].'.<br>Saludos');
	    $this->email->send();

		echo '<script>alert("Solicitud de contrato fue rechazada exitosamente");</script>';
		redirect('est/contratos_log/solicitudes_pendientes', 'refresh');
	}

	function generar_contrato_anexo_doc_contractual(){
		$this->load->library('zip');
		$this->load->helper('download');

		$causal = $_POST['causal'];
		$motivo = $_POST['motivo'];
		$fecha_inicio = $_POST['fecha_inicio'];
		$fecha_termino = $_POST['fecha_termino'];
		$jornada = $_POST['jornada'];
		$renta_imponible = $_POST['renta_imponible'];
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
		$nombre_centro_costo = $_POST['nombre_centro_costo'];
		$rut_centro_costo = $_POST['rut_centro_costo'];
		$id_planta = $_POST['id_planta'];
		$nombre_planta = $_POST['nombre_planta'];
		$direccion_planta = $_POST['direccion_planta'];
		$comuna_planta = $_POST['ciudad_planta'];
		$region_planta = $_POST['region_planta'];
		$nombre_sin_espacios = $_POST['nombre_sin_espacios'];

		//inicio de boton generar contrato
		$template_formato = base_url()."extras/contratos/formato_contratos_blue_express.docx";
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
		$nombre_documento = "contrato_trabajo_SGO_".$rut_trabajador.".docx";
		$templateWord->saveAs("extras/contratos/archivos_blue/".$nombre_documento);

		$get_url = "extras/contratos/archivos_blue/".$nombre_documento;
		$url_ubicacion_archivo = (BASE_URL2.$get_url);

		header("Content-Disposition: attachment; filename='".$nombre_documento."'; charset=iso-8859-1");
		echo file_get_contents($url_ubicacion_archivo);
	}

	function aprobacion_masiva_contrato_anexo_doc(){
		if($_POST['solicitudes']){
			foreach($_POST['solicitudes'] as $c=>$valores){
				$id_req_usu_arch = $valores;
				$datos_aprobacion = array(
					'id_req_usu_arch' => $id_req_usu_arch,
					'id_solicitante' => $this->session->userdata('id'),
					'fecha_solicitud' => date('Y-m-d'),
					'estado' => 2,
				);
				$datos_usu_arch = array('estado_proceso' => 3,);

				$this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato($datos_aprobacion);
				$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_usu_arch);

				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';

				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';

				$get_solicitante1 = $this->Requerimiento_Usuario_Archivo_model->get_proceso_contrato_tipo($id_req_usu_arch, 0);
				$get_solicitante2 = $this->Requerimiento_Usuario_Archivo_model->get_proceso_contrato_tipo($id_req_usu_arch, 1);
				$id_solicitante1 = isset($get_solicitante1->id_solicitante)?$get_solicitante1->id_solicitante:'';
				$id_solicitante2 = isset($get_solicitante2->id_solicitante)?$get_solicitante2->id_solicitante:'';
				$get_solicitante1 = $this->Usuarios_general_model->get($id_solicitante1);
				$nombre_solicitante1 = isset($get_solicitante1->nombres)?$get_solicitante1->nombres:'';
				$paterno_solicitante1 = isset($get_solicitante1->paterno)?$get_solicitante1->paterno:'';
				$materno_solicitante1 = isset($get_solicitante1->materno)?$get_solicitante1->materno:'';
				$nombre_completo_solicitante1 = $nombre_solicitante1.' '.$paterno_solicitante1.' '.$materno_solicitante1;
				$email_solicitante1 = isset($get_solicitante1->email)?$get_solicitante1->email:'';

				$get_solicitante2 = $this->Usuarios_general_model->get($id_solicitante2);
				$nombre_solicitante2 = isset($get_solicitante2->nombres)?$get_solicitante2->nombres:'';
				$paterno_solicitante2 = isset($get_solicitante2->paterno)?$get_solicitante2->paterno:'';
				$materno_solicitante2 = isset($get_solicitante2->materno)?$get_solicitante2->materno:'';
				$nombre_completo_solicitante2 = $nombre_solicitante2.' '.$paterno_solicitante2.' '.$materno_solicitante2;
				$email_solicitante2 = isset($get_solicitante2->email)?$get_solicitante2->email:'';

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
				$destinatarios = array($email_solicitante1, $email_solicitante2);

			    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - BLUE');
			    $this->email->to($destinatarios);
			    $this->email->cc('contratos@empresasintegra.cl');
			    $this->email->subject("Aprobacion Contrato Trabajador: ".$nombre_trabajador." - Fecha Inicio Contrato: ".$fecha_inicio);
			    $this->email->message('Estimado(a) '.$nombre_completo_solicitante1.' la solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.' ha sido aprobada con exito.<br>Saludos');
			    $this->email->send();
			}
		}
		echo '<script>alert("Solicitud de aprobacion de contrato aprobado exitosamente");</script>';
		redirect('est/contratos_log/solicitudes_pendientes', 'refresh');
	}

}

?>