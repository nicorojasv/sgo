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
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");
		$this->load->model("carrera/ciudades_model");
		$this->load->model("carrera/Afp_model");
		$this->load->model("carrera/Salud_model");
		$this->load->model("carrera/estado_civil_model");
		$this->load->model("carrera/Requerimiento_area_cargo_model");
		$this->load->model("carrera/Requerimientos_model");
		$this->load->model("carrera/Areas_model");
		$this->load->model("carrera/Cargos_model");
		$this->load->model("carrera/Empresas_model");
		$this->load->model("carrera/Tipo_gratificacion_model");
		$this->load->model("carrera/regiones_model");
		$this->load->model('carrera/Requerimiento_Usuario_Archivo_model');
		$this->load->model('carrera/Empresa_planta_model');
		$this->load->model('carrera/Usuarios_model');
		$this->load->model("carrera/Solicitud_revision_examenes_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->model("carrera/Descripcion_horarios_model");
		$this->load->model("carrera/Descripcion_causal_model");



		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 11)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_rrhh','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif($this->session->userdata('id') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 4)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_externo','',TRUE);
		elseif( $this->session->userdata('id') == 120)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_psicologo','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);

		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		redirect('carrera/contratos/solicitudes_pendientes', 'refresh');
	}

	function solicitudes_pendientes($get_id_planta = FALSE){
		if ($this->session->userdata('id') == 10) {
			redirect('/usuarios/login/index', 'refresh');
		}
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de contratos pendientes",
			'titulo' => "Listado solicitudes pendientes",
			'subtitulo' => 'Unidad de Negocio: Casa Matriz',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado solicitudes pendientes' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);


		
                 $this->load->model('Nivel_estudios_model');
		$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_pendientes($get_id_planta);
		

       //var_dump($trabajadores);
       //return false;

		$listado = array();
		if($trabajadores != FALSE){
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$id_solicitante = isset($rm->id_solicitante)?$rm->id_solicitante:'';
				$id_usu_arch = isset($rm->id_req_usu_arch)?$rm->id_req_usu_arch:'';
				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);

				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$usr = $this->Usuarios_model->get($id_usuario);
				$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
				$id_jornada = isset($get_usu_archivo->jornada)?$get_usu_archivo->jornada:'';
				$get_jornada = $this->Descripcion_horarios_model->get($id_jornada);

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
				#12-11-2018 incorporacion banco, tipo  y numero de cuenta.
				$id_banco = isset($usr->id_bancos)?$usr->id_bancos:1;
				$nombreB  = $this->Usuarios_model->getNombreBanco($id_banco);
				$aux->nombre_banco = $nombreB->desc_bancos;
				$aux->tipo_cuenta = isset($usr->tipo_cuenta)?$usr->tipo_cuenta:'';
				$aux->cuenta_banco = isset($usr->cuenta_banco)?$usr->cuenta_banco:'';
				$aux->uf_pactada = isset($usr->uf_pactada)?$usr->uf_pactada:'';
				#Fin 12-11-2018 incorporacion banco, tipo  y numero de cuenta.

				$aux->codigo_centro_costo = isset($get_requerimiento->codigo_centro_costo)?$get_requerimiento->codigo_centro_costo:'';
				$aux->id_req_usu_arch = isset($rm->id_req_usu_arch)?$rm->id_req_usu_arch:'';
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

				$aux->nombre = isset($get_usu_archivo->nombre)?$get_usu_archivo->nombre:'';
				$aux->url = isset($get_usu_archivo->url)?$get_usu_archivo->url:'';
				$aux->causal = isset($get_usu_archivo->causal)?$get_usu_archivo->causal:'';
				$aux->motivo = isset($get_usu_archivo->motivo)?$get_usu_archivo->motivo:'';
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->renta_imponible = isset($get_usu_archivo->renta_imponible)?$get_usu_archivo->renta_imponible:'';
				$aux->bono_responsabilidad = isset($get_usu_archivo->bono_responsabilidad)?$get_usu_archivo->bono_responsabilidad:'';
				$aux->bono_gestion = isset($get_usu_archivo->bono_gestion)?$get_usu_archivo->bono_gestion:'';
				$aux->bono_confianza = isset($get_usu_archivo->bono_confianza)?$get_usu_archivo->bono_confianza:'';
				$aux->asignacion_movilizacion = isset($get_usu_archivo->asignacion_movilizacion)?$get_usu_archivo->asignacion_movilizacion:'';
				$aux->asignacion_colacion = isset($get_usu_archivo->asignacion_colacion)?$get_usu_archivo->asignacion_colacion:'';
				$aux->asignacion_zona = isset($get_usu_archivo->asignacion_zona)?$get_usu_archivo->asignacion_zona:'';
				$aux->asignacion_herramientas = isset($get_usu_archivo->asignacion_herramientas)?$get_usu_archivo->asignacion_herramientas:'';
				$aux->viatico = isset($get_usu_archivo->viatico)?$get_usu_archivo->viatico:'';
				$aux->fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';
				$aux->fecha_termino = isset($get_usu_archivo->fecha_termino)?$get_usu_archivo->fecha_termino:'';

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
		$pagina['planta_seleccionada'] = $get_id_planta;
		$pagina['listado_plantas'] = $this->Empresa_planta_model->listar();
		$base['cuerpo'] = $this->load->view('carrera/contratos/listado_solicitudes_pendientes',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}


	function solicitudes_completas($get_id_planta = FALSE,$fecha = false){
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de contratos completas",
			'titulo' => "Listado solicitudes completas",
			'subtitulo' => 'Unidad de Negocio: Casa Matriz',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado solicitudes completas' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/exportarExcelArauco.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);
		if ($fecha =='historico') {
			$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas2();
			$pagina['mes'] = 'historico';
		}elseif($fecha){
			$fechaI = new DateTime($fecha);
				$fechaI->modify('first day of this month');
				$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
			$fechaT = new DateTime($fecha);
				$fechaT->modify('last day of this month');
				$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31
			$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas2($fechaInicio, $fechaTermino);
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
			$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas2($fechaInicio, $fechaTermino);
			setlocale(LC_TIME, 'spanish');
			$monthNum  = date('m');
			$dateObj   = DateTime::createFromFormat('!m', $monthNum);
			$nombreDelMes = strftime('%B', $dateObj->getTimestamp());
			$pagina['mes']= $nombreDelMes;
		}
		//$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas($get_id_planta);
		$listado = array();
		if($trabajadores != FALSE){
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$id_solicitante = isset($rm->id_solicitante)?$rm->id_solicitante:'';
				$id_req_usu_arch = isset($rm->id_req_usu_arch)?$rm->id_req_usu_arch:NULL;
				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$usr = $this->Usuarios_model->get($id_usuario);
				$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
				$id_jornada = isset($get_usu_archivo->jornada)?$get_usu_archivo->jornada:'';
				$get_jornada = $this->Descripcion_horarios_model->get($id_jornada);

				$aux = new StdClass();
				$id_ciudad = isset($usr->id_ciudades)?$usr->id_ciudades:'';
				$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
				$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
				$id_estado_civil = isset($usr->id_estadocivil)?$usr->id_estadocivil:'';
				$id_estudios = isset($usr->id_estudios)?$usr->id_estudios:'';
				#12-11-2018 incorporacion banco, tipo  y numero de cuenta.
				$id_banco = isset($usr->id_bancos)?$usr->id_bancos:1;
				$nombreB  = $this->Usuarios_model->getNombreBanco($id_banco);
				$aux->nombre_banco = $nombreB->desc_bancos;
				$aux->tipo_cuenta = isset($usr->tipo_cuenta)?$usr->tipo_cuenta:'';
				$aux->cuenta_banco = isset($usr->cuenta_banco)?$usr->cuenta_banco:'';
				$aux->uf_pactada = isset($usr->uf_pactada)?$usr->uf_pactada:'';
				#Fin 12-11-2018 incorporacion banco, tipo  y numero de cuenta.
				$get_ciudad = $this->ciudades_model->get($id_ciudad);
				$get_afp = $this->Afp_model->get($id_afp);
				$get_salud = $this->Salud_model->get($id_salud);
				$get_estado_civil = $this->estado_civil_model->get($id_estado_civil);
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

				$aux->codigo_centro_costo = isset($get_requerimiento->codigo_centro_costo)?$get_requerimiento->codigo_centro_costo:'';
				$aux->id_req_usu_arch = isset($rm->id_req_usu_arch)?$rm->id_req_usu_arch:'';
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

				$aux->nombre = isset($get_usu_archivo->nombre)?$get_usu_archivo->nombre:'';
				$aux->url = isset($get_usu_archivo->url)?$get_usu_archivo->url:'';
				$aux->causal = isset($get_usu_archivo->causal)?$get_usu_archivo->causal:'';
				$aux->motivo = isset($get_usu_archivo->motivo)?$get_usu_archivo->motivo:'';
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->renta_imponible = isset($get_usu_archivo->renta_imponible)?$get_usu_archivo->renta_imponible:'';
				$aux->bono_responsabilidad = isset($get_usu_archivo->bono_responsabilidad)?$get_usu_archivo->bono_responsabilidad:'';
				$aux->bono_gestion = isset($get_usu_archivo->bono_gestion)?$get_usu_archivo->bono_gestion:'';
				$aux->bono_confianza = isset($get_usu_archivo->bono_confianza)?$get_usu_archivo->bono_confianza:'';
				$aux->asignacion_movilizacion = isset($get_usu_archivo->asignacion_movilizacion)?$get_usu_archivo->asignacion_movilizacion:'';
				$aux->asignacion_colacion = isset($get_usu_archivo->asignacion_colacion)?$get_usu_archivo->asignacion_colacion:'';
				$aux->asignacion_zona = isset($get_usu_archivo->asignacion_zona)?$get_usu_archivo->asignacion_zona:'';
				$aux->asignacion_herramientas = isset($get_usu_archivo->asignacion_herramientas)?$get_usu_archivo->asignacion_herramientas:'';
				$aux->viatico = isset($get_usu_archivo->viatico)?$get_usu_archivo->viatico:'';
				$aux->fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';
				$aux->fecha_termino = isset($get_usu_archivo->fecha_termino)?$get_usu_archivo->fecha_termino:'';

				$fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'0000-00-00';
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
		$pagina['planta_seleccionada'] = $get_id_planta;
		$pagina['listado_plantas'] = $this->Empresa_planta_model->listar();
		$base['cuerpo'] = $this->load->view('contratos/listado_solicitudes_completas',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_rechazar_contrato_anexo_doc_general($id_usu_arch){
		$datos_generales = array();
		if($id_usu_arch != FALSE){
			$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);
			$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
			$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
			$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
			$usr = $this->Usuarios_model->get($id_usuario);

			$aux = new StdClass();
			$id_ciudad = isset($usr->id_ciudades)?$usr->id_ciudades:'';
			$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
			$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
			$id_estado_civil = isset($usr->id_estadocivil)?$usr->id_estadocivil:'';
			$id_estudios = isset($usr->id_estudios)?$usr->id_estudios:'';
			$get_ciudad = $this->ciudades_model->get($id_ciudad);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->estado_civil_model->get($id_estado_civil);
			//$get_nivel_estudios = $this->Nivelestudios_model->get($id_estudios);
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
		}else{
			$id_planta = 0;
		}

		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_usu_arch);
		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_planta);
		$pagina['datos_generales'] = $datos_generales;
		$pagina['id_usu_arch'] = $id_usu_arch;
		$this->load->view('contratos/modal_rechazar_contrato_anexo_doc_contractuales', $pagina);
	}

	function rechazar_contrato_anexo_doc_general(){
		$id_req_usu_arch = $_POST['id_usu_arch'];

		$datos_aprobacion = array(
			'observaciones' => $_POST['observaciones'],
			'estado' => 2,
		);

		$datos_aprobacion2 = array(
			'estado_aprobacion_revision' => 0,
		);

		$datos_aprobacion_historial = array(
			'id_req_usu_arch' => $id_req_usu_arch,
			'id_usuario' => $this->session->userdata('id'),
			'estado' => 2,
		);

		$this->Requerimiento_Usuario_Archivo_model->actualizar_solicitud_contrato($id_req_usu_arch, $datos_aprobacion);
		$this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato_historial($datos_aprobacion_historial);
		$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_aprobacion2);

		$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
		$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
		$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
		$fecha_inicio_contrato = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';
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

	    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - carrera');
	    $this->email->to($email_solicitante);
		//$this->email->cc('contratos@empresasintegra.cl');
		$this->email->subject("Rechazo Contrato Trabajador: ".$nombre_trabajador." - Fecha Inicio Contrato: ".$fecha_inicio_contrato);
	    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' la solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.' ha sido rechazado.<br>Con la siguiente observacion:<br>'.$_POST['observaciones'].'.<br>Saludos');
	    $this->email->send();

		echo '<script>alert("Solicitud de contrato fue rechazada exitosamente");</script>';
		redirect('carrera/contratos/solicitudes_pendientes', 'refresh');
	}

	function aprobar_contrato_anexo_doc_general($id_req_usu_arch){
		$datos_aprobacion = array(
			'estado' => 1,
		);

		$datos_aprobacion2 = array(
			'estado_aprobacion_revision' => 1,
			'fecha_aprobacion'=>date('Y-m-d H:i:s'),
		);

		$datos_aprobacion_historial = array(
			'id_req_usu_arch' => $id_req_usu_arch,
			'id_usuario' => $this->session->userdata('id'),
			'estado' => 1,
		);

		$this->Requerimiento_Usuario_Archivo_model->actualizar_solicitud_contrato($id_req_usu_arch, $datos_aprobacion);
		$this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato_historial($datos_aprobacion_historial);
		$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_aprobacion2);

		$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
		$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
		$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
		$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
		$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
		$fecha_inicio_contrato = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';
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
		#yayo 09-10-2019 Generar el contrato  y 
		$get_requerimientoId = $this->Requerimiento_Usuario_Archivo_model->getRequerimienton($id_req_area_cargo);
		$get_requerimiento = $this->Requerimientos_model->get($get_requerimientoId->requerimiento_id);
		$id_centro_costo = isset($get_requerimiento->empresa_id)?$get_requerimiento->empresa_id:'';
		if($get_usu_archivo->jornada == "1"){
				$template_formato = base_url()."extras/contratos/formatos_contratos_carrera/2_contrato_sin_pacto_he.docx";
		}else{
				$template_formato = base_url()."extras/contratos/formatos_contratos_carrera/1_contrato_con_pacto_he.docx";	
		}

		$templateWord = new TemplateProcessor($template_formato);
		$salto_linea = "<w:br/>";
		$var1 = explode('.',$usr->rut_usuario); 
		$rut1 = $var1[0];
		if($rut1 < 10)
			$rut_trabajador = "0".$usr->rut_usuario;
		$get_fecha_inicio=date($get_usu_archivo->fecha_inicio); 
		$var1 = explode('-',$get_fecha_inicio);
		$dia_fi = $var1[2];
		$mes_fi = $var1[1];
		$ano_fi = $var1[0];

		if ($mes_fi=="01") $mes_letra_fi="Enero";if ($mes_fi=="02") $mes_letra_fi="Febrero";
		if ($mes_fi=="03") $mes_letra_fi="Marzo";if ($mes_fi=="04") $mes_letra_fi="Abril";
		if ($mes_fi=="05") $mes_letra_fi="Mayo";if ($mes_fi=="06") $mes_letra_fi="Junio";
		if ($mes_fi=="07") $mes_letra_fi="Julio";if ($mes_fi=="08") $mes_letra_fi="Agosto";
		if ($mes_fi=="09") $mes_letra_fi="Septiembre";if ($mes_fi=="10") $mes_letra_fi="Octubre";	
		if ($mes_fi=="11") $mes_letra_fi="Noviembre";if ($mes_fi=="12") $mes_letra_fi="Diciembre";

		$get_fecha_termino=date($get_usu_archivo->fecha_termino); 
		$var2 = explode('-',$get_fecha_termino); 
		$dia_ft = $var2[2];
		$mes_ft = $var2[1];
		$ano_ft = $var2[0];

		if ($mes_ft=="01") $mes_letra_ft="Enero";if ($mes_ft=="02") $mes_letra_ft="Febrero";
		if ($mes_ft=="03") $mes_letra_ft="Marzo";if ($mes_ft=="04") $mes_letra_ft="Abril";
		if ($mes_ft=="05") $mes_letra_ft="Mayo";if ($mes_ft=="06") $mes_letra_ft="Junio";
		if ($mes_ft=="07") $mes_letra_ft="Julio";if ($mes_ft=="08") $mes_letra_ft="Agosto";
		if ($mes_ft=="09") $mes_letra_ft="Septiembre";if ($mes_ft=="10") $mes_letra_ft="Octubre";
		if ($mes_ft=="11") $mes_letra_ft="Noviembre";if ($mes_ft=="12") $mes_letra_ft="Diciembre";

		$get_fecha_nacimiento=date($usr->fecha_nac); 
		$var3 = explode('-',$get_fecha_nacimiento); 
		$dia_fecha_nac = $var3[2];
		$mes_fecha_nac = $var3[1];
		$ano_fecha_nac = $var3[0];
		if ($mes_fecha_nac=="01") $mes_letra_fecha_nac="Enero";if ($mes_fecha_nac=="02") $mes_letra_fecha_nac="Febrero";
		if ($mes_fecha_nac=="03") $mes_letra_fecha_nac="Marzo";if ($mes_fecha_nac=="04") $mes_letra_fecha_nac="Abril";
		if ($mes_fecha_nac=="05") $mes_letra_fecha_nac="Mayo";if ($mes_fecha_nac=="06") $mes_letra_fecha_nac="Junio";
		if ($mes_fecha_nac=="07") $mes_letra_fecha_nac="Julio";if ($mes_fecha_nac=="08") $mes_letra_fecha_nac="Agosto";
		if ($mes_fecha_nac=="09") $mes_letra_fecha_nac="Septiembre";if ($mes_fecha_nac=="10") $mes_letra_fecha_nac="Octubre";
		if ($mes_fecha_nac=="11") $mes_letra_fecha_nac="Noviembre";if ($mes_fecha_nac=="12") $mes_letra_fecha_nac="Diciembre";

		$fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
		$fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
		$fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

		if($get_usu_archivo->causal == "A")
			$id_descrip_causal = 1;
		elseif($get_usu_archivo->causal == "B")
			$id_descrip_causal = 2;
		elseif($get_usu_archivo->causal == "C")
			$id_descrip_causal = 3;
		elseif($get_usu_archivo->causal == "D")
			$id_descrip_causal = 4;
		elseif($get_usu_archivo->causal == "E")
			$id_descrip_causal = 5;
		else
			$id_descrip_causal = 0;

		$get_descripcion_causal = $this->Descripcion_causal_model->get($id_descrip_causal);
		$descripcion_causal = isset($get_descripcion_causal->descripcion)?$get_descripcion_causal->descripcion:'';
			//parrafo cuando es distinto a "sin horario"
		if($get_usu_archivo->jornada != "1")
			$adicional_cumplimiento_horario_undecimo = "Cumplir con el horario de ingreso y salida establecido en la Usuaria, y no registrar atrasos. ";
		else
			$adicional_cumplimiento_horario_undecimo = "";

		$get_descripcion_sin_horario = $this->Descripcion_horarios_model->get(1);
		$get_descripcion_adic_admin_e_turno_e = $this->Descripcion_horarios_model->get(2);
		$get_descripcion_horario_adicional_tiempo_extra = $this->Descripcion_horarios_model->get(3);
		$get_descripcion_horario = $this->Descripcion_horarios_model->get($get_usu_archivo->jornada);

		if($get_usu_archivo->jornada == "1"){
			$descripcion_jornada = isset($get_descripcion_sin_horario->descripcion)?$get_descripcion_sin_horario->descripcion:'';
		}else{
			$frase1 = isset($get_descripcion_horario->descripcion)?$get_descripcion_horario->descripcion:'';
			$frase2 = isset($get_descripcion_horario_adicional_tiempo_extra->descripcion)?$get_descripcion_horario_adicional_tiempo_extra->descripcion:'';
			$frase3 = isset($get_descripcion_adic_admin_e_turno_e->descripcion)?$get_descripcion_adic_admin_e_turno_e->descripcion:'';

			if($get_usu_archivo->causal == "E")
				$descripcion_jornada = $frase1." ".$frase3.$salto_linea.$frase2;
			else
				$descripcion_jornada = $frase1.$salto_linea.$frase2;
		}
		$id_tipo_horario = isset($get_descripcion_horario->id_tipo_horario)?$get_descripcion_horario->id_tipo_horario:'';
		if($get_usu_archivo->causal == "A"){
			if($id_tipo_horario == 2)
				$parrafo_decimo_tercero = "Las partes convienen que el presente Contrato de Servicios Transitorios tendrá como duración lo señalado en el Art. 183-O INCISO 1°, esto es la puesta disposición del trabajador podrá cubrir el tiempo de duración de la ausencia del trabajador reemplazado. Sus labores finalizarian el ".$fecha_termino_texto_largo.".";
			else
				$parrafo_decimo_tercero = "El presente contrato tendrá una vigencia hasta el ".$fecha_termino_texto_largo.", y podrá ponérsele término cuando concurran para ello causas justificadas que en conformidad a la ley puedan producir su caducidad, las partes fijan domicilio en la ciudad de Concepción y se someten a la jurisdicción de sus Tribunales.";
		}else{
			$parrafo_decimo_tercero = "El presente contrato tendrá una vigencia hasta el ".$fecha_termino_texto_largo.", y podrá ponérsele término cuando concurran para ello causas justificadas que en conformidad a la ley puedan producir su caducidad, las partes fijan domicilio en la ciudad de Concepción y se someten a la jurisdicción de sus Tribunales.";
		}
		$bono_responsabilidad_palabras = num2letras($get_usu_archivo->bono_responsabilidad);
		$bono_gestion_palabras = num2letras($get_usu_archivo->bono_gestion);
		$bono_confianza_palabras = num2letras($get_usu_archivo->bono_confianza);
		$asignacion_zona_palabras = num2letras($get_usu_archivo->asignacion_zona);
		$asignacion_movilizacion_palabras = num2letras($get_usu_archivo->asignacion_movilizacion);
		$asignacion_colacion_palabras = num2letras($get_usu_archivo->asignacion_colacion);
		$viatico_palabras = num2letras($get_usu_archivo->viatico);

		if($get_usu_archivo->bono_responsabilidad > 0)
			$frase_bono_responsabilidad = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono de Responsabilidad por la suma de $ ".str_replace(',','.',number_format($get_usu_archivo->bono_responsabilidad))." (".$bono_responsabilidad_palabras.").".$salto_linea."";
		else
			$frase_bono_responsabilidad = "";

		if($get_usu_archivo->bono_gestion > 0)
			$frase_bono_gestion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono de Gestión por la suma de $ ".str_replace(',','.',number_format($get_usu_archivo->bono_gestion))." (".$bono_gestion_palabras.").".$salto_linea."";
		else
			$frase_bono_gestion = "";

		if($get_usu_archivo->bono_confianza > 0)
			$frase_bono_confianza = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono Confianza por la suma de $ ".str_replace(',','.',number_format($get_usu_archivo->bono_confianza))." (".$bono_confianza_palabras.").".$salto_linea."";
		else
			$frase_bono_confianza = "";

		if($get_usu_archivo->asignacion_movilizacion > 0)
			$frase_asignacion_movilizacion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación de locomoción de $ ".str_replace(',','.',number_format($get_usu_archivo->asignacion_movilizacion))." (".$asignacion_movilizacion_palabras.").".$salto_linea."";
		else
			$frase_asignacion_movilizacion = "";

		if($get_usu_archivo->asignacion_colacion > 0)
			$frase_asignacion_colacion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación de colación de $ ".str_replace(',','.',number_format($get_usu_archivo->asignacion_colacion))." (".$asignacion_colacion_palabras.").".$salto_linea."";
		else
			$frase_asignacion_colacion = "";

		if($get_usu_archivo->asignacion_zona > 0)
			$frase_asignacion_zona = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación Zona por la suma de $ ".str_replace(',','.',number_format($get_usu_archivo->asignacion_zona))." (".$asignacion_zona_palabras.").".$salto_linea."";
		else
			$frase_asignacion_zona = "";

		if($get_usu_archivo->viatico > 0)
			$frase_viatico = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Viático de $ ".str_replace(',','.',number_format($get_usu_archivo->viatico))." (".$viatico_palabras.").".$salto_linea."";
		else
			$frase_viatico = "";

		$detalle_bonos = $frase_bono_responsabilidad.$frase_bono_gestion.$frase_bono_confianza.$frase_asignacion_movilizacion.$frase_asignacion_colacion.$frase_asignacion_zona.$frase_viatico;
		$sueldo_base_palabras = num2letras($get_usu_archivo->renta_imponible);
		$get_estado_civil = $this->estado_civil_model->get($usr->id_estado_civil);
		$get_ciudad = $this->ciudades_model->get($usr->id_ciudad);
		$get_centro_costo = $this->Empresas_model->get($id_centro_costo);
		$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_req_area_cargo);
		$nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
		$rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
		$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
		$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
		$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
		$id_cargo = isset($get_area_cargo->cargos_id)?$get_area_cargo->cargos_id:'';
		$get_cargo = $this->Cargos_model->r_get($id_cargo);
		$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
		$get_requerimiento = $this->Requerimientos_model->get($id_requerimiento);

		$id_planta = isset($get_requerimiento->planta_id)?$get_requerimiento->planta_id:'';
		$get_planta = $this->Empresa_planta_model->get($id_planta);
		$id_region_planta = isset($get_planta->id_regiones)?$get_planta->id_regiones:'';
		$id_ciudad_planta = isset($get_planta->id_ciudades)?$get_planta->id_ciudades:'';
		$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
		$nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
		$direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
		$get_region_planta = $this->regiones_model->get($id_region_planta);
		$get_ciudad_planta = $this->ciudades_model->get($id_ciudad_planta);
		$region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
		$ciudad_planta = isset($get_ciudad_planta->desc_ciudades)?$get_ciudad_planta->desc_ciudades:'';

		$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
		$tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
		$get_afp = $this->Afp_model->get($usr->id_afp);
		$prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
		$get_salud = $this->Salud_model->get($usr->id_salud);
		$salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
		$nombre_sin_espacios = trim($usr->paterno).'_'.trim($usr->materno);
		// Insertamos variables en el word
		$templateWord->setValue('fecha_ingreso_trabajador_palabras',$fecha_inicio_texto_largo);
		$templateWord->setValue('nombre_trabajador',titleCase($nombre_trabajador));
		$templateWord->setValue('rut_trabajador',$rut_trabajador);
		$templateWord->setValue('nacionalidad',titleCase($usr->nacionalidad));
		$templateWord->setValue('fecha_nacimiento',$fecha_nacimiento_texto_largo);
		$templateWord->setValue('estado_civil',titleCase($get_estado_civil->desc_estadocivil));
		$templateWord->setValue('domicilio_trabajador',titleCase($usr->direccion));
		$templateWord->setValue('comuna_trabajador',titleCase($get_ciudad->desc_ciudades));
		$templateWord->setValue('nombre_centro_costo',titleCase($nombre_centro_costo));
		$templateWord->setValue('rut_centro_costo',$rut_centro_costo);
		$templateWord->setValue('descripcion_causal',$descripcion_causal);
		$templateWord->setValue('motivo_req',titleCase($get_usu_archivo->motivo));
		$templateWord->setValue('cargo_postulante',titleCase($get_cargo->nombre));
		$templateWord->setValue('centro_costo',$nombre_centro_costo);
		$templateWord->setValue('nombre_planta',titleCase($nombre_planta));
		$templateWord->setValue('direccion_planta',titleCase($direccion_planta));
		$templateWord->setValue('comuna_planta',titleCase($ciudad_planta));
		$templateWord->setValue('region_planta',titleCase($region_planta));
		$templateWord->setValue('descripcion_jornada',$descripcion_jornada);
		$templateWord->setValue('sueldo_base_numeros', str_replace(',','.',number_format($get_usu_archivo->renta_imponible)));
		$templateWord->setValue('sueldo_base_palabras',titleCase($sueldo_base_palabras));
		$templateWord->setValue('gratificacion',$tipo_gratificacion);
		$templateWord->setValue('detalle_bonos',$detalle_bonos);
		$templateWord->setValue('adicional_cumplimiento_horario_undecimo',$adicional_cumplimiento_horario_undecimo);
		$templateWord->setValue('prevision_trabajador',titleCase($prevision));
		$templateWord->setValue('salud_trabajador',titleCase($salud));
		$templateWord->setValue('fecha_ingreso_trabajador',$fecha_inicio_texto_largo);
		$templateWord->setValue('fecha_vigencia_contrato',$fecha_termino_texto_largo);
		$templateWord->setValue('parrafo_decimo_tercero',$parrafo_decimo_tercero);

		// Guardamos el documento
		$nombre_documento = "contrato_".$nombre_sin_espacios.".docx";
		$carpeta = "extras/contratos_masivos/".$id_requerimiento."";
		if (!file_exists($carpeta)) {
		    mkdir($carpeta, 0777, true);
		}
		$templateWord->saveAs("extras/contratos_masivos/".$id_requerimiento."/".$nombre_documento);

		$get_url = "extras/contratos_masivos/".$id_requerimiento."/".$nombre_documento;
		$informacion = array(
			'id_requerimiento'=>$id_requerimiento,
			'id_trabajador'=>$usr->id,
			'url'=>$get_url,
			'nombre_archivo'=>$nombre_documento,
			);
		$this->Requerimiento_Usuario_Archivo_model->insertarContratoAprobado($informacion);
		$this->load->library('email');
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);

	    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - carrera');
	    $this->email->to($email_solicitante);
	    $this->email->to('nrojas@empresasintegra.cl');
		//$this->email->cc('contratos@empresasintegra.cl');
		$this->email->subject("Aprobacion Contrato Trabajador: ".$nombre_trabajador." - Fecha Inicio Contrato: ".$fecha_inicio_contrato);
	    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' la solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.' ha sido aprobada con exito.<br>Saludos');
	    $this->email->send();

		echo '<script>alert("Solicitud de contrato fue aprobado exitosamente");</script>';
		redirect('carrera/contratos/solicitudes_pendientes', 'refresh');
	}

	

	function modal_visualizar_contrato_anexo_doc_general($id_usu_arch, $bajar = false){
		$this->load->model('carrera/Nivel_estudios_model');

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
				//$aux->codigoContrato = isset($get_usu_archivo->codigo_contrato)?$get_usu_archivo->codigo_contrato:'';
			}
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
				foreach ($solicitudes_aprobadas as $d) {
					$revisiones_al_dia += 1;
				}
			}
			array_push($datos_generales, $aux);
			unset($aux);
		}
	//	var_dump($get_centro_costo);
	//	return false;

		$get_solicitudes_contratos = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_usu_arch);
		$pagina['solicitud_existente_contrato'] = isset($get_solicitudes_contratos->id)?1:0;
		$pagina['datos_generales'] = $datos_generales;
		$pagina['id_usu_arch']= $id_usu_arch;
		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_planta);
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_usu_arch);
		$this->load->view('carrera/contratos/modal_administrar_contrato_anexo_doc_contractuales', $pagina);
	}

	function generar_contrato_anexo_doc_contractual(){
		$this->load->library('zip');
		$this->load->helper('download');
		$id_req_usu_archivo = $_POST['id_req_usu_arch'];
		$causal = $_POST['causal'];
		$motivo = $_POST['motivo'];
		$fecha_inicio = $_POST['fecha_inicio'];
		$fecha_termino = $_POST['fecha_termino'];
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
		$id_centro_costo = $_POST['id_centro_costo'];
		if (isset($_POST['dar_de_baja'])) { //para dar de baja un contrato
			$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_archivo);
			/*$id_abecedario_asignado = isset($get_usu_archivo->id_abecedario_asignado)?$get_usu_archivo->id_abecedario_asignado:false;
			$usuario_id = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
			if ($id_abecedario_asignado != false) {//inserto en la tabla codigo libre
				$data1 = array(
					'usuario_id'=>$usuario_id,
					'codigoLibre'=>$id_abecedario_asignado,
					'fechaRegistro'=>date('Y-m-d'),
					'estado'=>0,
					);
				$this->Requerimiento_Usuario_Archivo_model->guardar_codigo_libre($data1);
			}*/
			$data = array(
				'estado' => 5,//  contrato bajado
				'fecha_aprobacion_baja' => date('Y-m-d H:i:s'),
				);
			$fechaSolicitudBaja = array(
				'fecha_solicitud_baja'=> date('Y-m-d H:i:s'),
				);
			$this->Requerimiento_Usuario_Archivo_model->actualizar_solicitud_contrato($id_req_usu_archivo, $data);
			$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $fechaSolicitudBaja);

			$nombre = isset($get_usu_archivo->nombres)?$get_usu_archivo->nombres:'';
			$aP = isset($get_usu_archivo->paterno)?$get_usu_archivo->paterno:'';
			$aM =isset($get_usu_archivo->materno)?$get_usu_archivo->materno:'';
			$nombre_trabajador = $nombre." ".$aP." ".$aM;
			/*	$this->load->library('email');
				$config['smtp_host'] = 'mail.empresasintegra.cl';
				$config['smtp_user'] = 'informaciones@empresasintegra.cl';
				$config['smtp_pass'] = '%SYkNLH1';
				$config['mailtype'] = 'html';
				$config['smtp_port']    = '2552';
				$this->email->initialize($config);
				$destinatarios_cc = array('contratos@empresasintegra.cl','jsilva@empresasintegra.cl');
			    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - ENJOY');
			    $this->email->to('sastudillo@empresasintegra.cl');
				$this->email->cc($destinatarios_cc);
			    $this->email->subject("Baja de Contrato Enjoy Trabajador: ".$nombre_trabajador." APROBADA ");
			    $this->email->message('Estimado(a),<br> Solicitud de baja de contrato Aprobada.  <br>Saludos');
			    $this->email->send();*/
			redirect('carrera/contratos/solicitudes_pendientes_baja','refresh');
			return false;
		}elseif(isset($_POST['deshacer_solicitud'])){
			$data = array(
				'estado'=>1,
				);
			$this->Requerimiento_Usuario_Archivo_model->actualizar_solicitud_contrato($id_req_usu_archivo, $data);
			redirect('carrera/contratos/solicitudes_pendientes_baja','refresh');
			return false;
		}elseif(isset($_POST['generar_contrato'])){
			//inicio de boton generar contrato
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
		}elseif(isset($_POST['generar_doc_adicionales_contrato'])){
			//inicio de boton generar documentos adicionales contrato
			
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
			 
			$phpWord =new TemplateProcessor($get_url);
    		$zipFile = new \ZipArchive();
            $zipFile->open($get_url);
            $fullXml = $zipFile->getFromName('word/document.xml');
            if (false === $zipFile->close()) {
                throw new \Exception("Could not close zip file");
            }
            $data = array(
            	'xml'=>$fullXml,
            );
            //$this->Requerimiento_Usuario_Archivo_model->insertXML($data); 

			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
			//fin de boton generar documentos adicionales contrato
		}
	}

	function aprobacion_masiva_contrato_anexo_doc(){
		if($_POST['solicitudes']){
			foreach($_POST['solicitudes'] as $c=>$valores){
				$id_req_usu_arch = $valores;

				$datos_aprobacion = array(
					'estado' => 1,
				);

				$datos_aprobacion2 = array(
					'estado_aprobacion_revision' => 1,
				);

				$datos_aprobacion_historial = array(
					'id_req_usu_arch' => $id_req_usu_arch,
					'id_usuario' => $this->session->userdata('id'),
					'estado' => 1,
				);
				$this->Requerimiento_Usuario_Archivo_model->actualizar_solicitud_contrato($id_req_usu_arch, $datos_aprobacion);
				$this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato_historial($datos_aprobacion_historial);
				$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $datos_aprobacion2);

				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$fecha_inicio_contrato = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';
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
				#yayo 09-10-2019 Generar el contrato  y 
				$get_requerimientoId = $this->Requerimiento_Usuario_Archivo_model->getRequerimienton($id_req_area_cargo);
				$get_requerimiento = $this->Requerimientos_model->get($get_requerimientoId->requerimiento_id);
				$id_centro_costo = isset($get_requerimiento->empresa_id)?$get_requerimiento->empresa_id:'';
				if($get_usu_archivo->jornada == "1"){
					if ($id_centro_costo==2 || $id_centro_costo == 4 || $id_centro_costo==5) {
						$template_formato = base_url()."extras/contratos/formatos_contratos_carrera/2_contrato_sin_pacto_heNuevo.docx";
					}else{
						$template_formato = base_url()."extras/contratos/formatos_contratos_carrera/2_contrato_sin_pacto_he.docx";
					}
				}else{
					if ($id_centro_costo==2 || $id_centro_costo == 4 || $id_centro_costo==5) {
						$template_formato = base_url()."extras/contratos/formatos_contratos_carrera/2_contrato_sin_pacto_heNuevo.docx";
					}else{
						$template_formato = base_url()."extras/contratos/formatos_contratos_carrera/1_contrato_con_pacto_he.docx";
					}
				}

				$templateWord = new TemplateProcessor($template_formato);
				$salto_linea = "<w:br/>";
				$var1 = explode('.',$usr->rut_usuario); 
				$rut1 = $var1[0];
				if($rut1 < 10)
					$rut_trabajador = "0".$usr->rut_usuario;
				$get_fecha_inicio=date($get_usu_archivo->fecha_inicio); 
				$var1 = explode('-',$get_fecha_inicio);
				$dia_fi = $var1[2];
				$mes_fi = $var1[1];
				$ano_fi = $var1[0];

				if ($mes_fi=="01") $mes_letra_fi="Enero";if ($mes_fi=="02") $mes_letra_fi="Febrero";
				if ($mes_fi=="03") $mes_letra_fi="Marzo";if ($mes_fi=="04") $mes_letra_fi="Abril";
				if ($mes_fi=="05") $mes_letra_fi="Mayo";if ($mes_fi=="06") $mes_letra_fi="Junio";
				if ($mes_fi=="07") $mes_letra_fi="Julio";if ($mes_fi=="08") $mes_letra_fi="Agosto";
				if ($mes_fi=="09") $mes_letra_fi="Septiembre";if ($mes_fi=="10") $mes_letra_fi="Octubre";	
				if ($mes_fi=="11") $mes_letra_fi="Noviembre";if ($mes_fi=="12") $mes_letra_fi="Diciembre";

				$get_fecha_termino=date($get_usu_archivo->fecha_termino); 
				$var2 = explode('-',$get_fecha_termino); 
				$dia_ft = $var2[2];
				$mes_ft = $var2[1];
				$ano_ft = $var2[0];

				if ($mes_ft=="01") $mes_letra_ft="Enero";if ($mes_ft=="02") $mes_letra_ft="Febrero";
				if ($mes_ft=="03") $mes_letra_ft="Marzo";if ($mes_ft=="04") $mes_letra_ft="Abril";
				if ($mes_ft=="05") $mes_letra_ft="Mayo";if ($mes_ft=="06") $mes_letra_ft="Junio";
				if ($mes_ft=="07") $mes_letra_ft="Julio";if ($mes_ft=="08") $mes_letra_ft="Agosto";
				if ($mes_ft=="09") $mes_letra_ft="Septiembre";if ($mes_ft=="10") $mes_letra_ft="Octubre";
				if ($mes_ft=="11") $mes_letra_ft="Noviembre";if ($mes_ft=="12") $mes_letra_ft="Diciembre";

				$get_fecha_nacimiento=date($usr->fecha_nac); 
				$var3 = explode('-',$get_fecha_nacimiento); 
				$dia_fecha_nac = $var3[2];
				$mes_fecha_nac = $var3[1];
				$ano_fecha_nac = $var3[0];
				if ($mes_fecha_nac=="01") $mes_letra_fecha_nac="Enero";if ($mes_fecha_nac=="02") $mes_letra_fecha_nac="Febrero";
				if ($mes_fecha_nac=="03") $mes_letra_fecha_nac="Marzo";if ($mes_fecha_nac=="04") $mes_letra_fecha_nac="Abril";
				if ($mes_fecha_nac=="05") $mes_letra_fecha_nac="Mayo";if ($mes_fecha_nac=="06") $mes_letra_fecha_nac="Junio";
				if ($mes_fecha_nac=="07") $mes_letra_fecha_nac="Julio";if ($mes_fecha_nac=="08") $mes_letra_fecha_nac="Agosto";
				if ($mes_fecha_nac=="09") $mes_letra_fecha_nac="Septiembre";if ($mes_fecha_nac=="10") $mes_letra_fecha_nac="Octubre";
				if ($mes_fecha_nac=="11") $mes_letra_fecha_nac="Noviembre";if ($mes_fecha_nac=="12") $mes_letra_fecha_nac="Diciembre";

				$fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
				$fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
				$fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

				if($get_usu_archivo->causal == "A")
					$id_descrip_causal = 1;
				elseif($get_usu_archivo->causal == "B")
					$id_descrip_causal = 2;
				elseif($get_usu_archivo->causal == "C")
					$id_descrip_causal = 3;
				elseif($get_usu_archivo->causal == "D")
					$id_descrip_causal = 4;
				elseif($get_usu_archivo->causal == "E")
					$id_descrip_causal = 5;
				else
					$id_descrip_causal = 0;

				$get_descripcion_causal = $this->Descripcion_causal_model->get($id_descrip_causal);
				$descripcion_causal = isset($get_descripcion_causal->descripcion)?$get_descripcion_causal->descripcion:'';
					//parrafo cuando es distinto a "sin horario"
				if($get_usu_archivo->jornada != "1")
					$adicional_cumplimiento_horario_undecimo = "Cumplir con el horario de ingreso y salida establecido en la Usuaria, y no registrar atrasos. ";
				else
					$adicional_cumplimiento_horario_undecimo = "";

				$get_descripcion_sin_horario = $this->Descripcion_horarios_model->get(1);
				$get_descripcion_adic_admin_e_turno_e = $this->Descripcion_horarios_model->get(2);
				$get_descripcion_horario_adicional_tiempo_extra = $this->Descripcion_horarios_model->get(3);
				$get_descripcion_horario = $this->Descripcion_horarios_model->get($get_usu_archivo->jornada);

				if($get_usu_archivo->jornada == "1"){
					$descripcion_jornada = isset($get_descripcion_sin_horario->descripcion)?$get_descripcion_sin_horario->descripcion:'';
				}else{
					$frase1 = isset($get_descripcion_horario->descripcion)?$get_descripcion_horario->descripcion:'';
					$frase2 = isset($get_descripcion_horario_adicional_tiempo_extra->descripcion)?$get_descripcion_horario_adicional_tiempo_extra->descripcion:'';
					$frase3 = isset($get_descripcion_adic_admin_e_turno_e->descripcion)?$get_descripcion_adic_admin_e_turno_e->descripcion:'';

					if($get_usu_archivo->causal == "E")
						$descripcion_jornada = $frase1." ".$frase3.$salto_linea.$frase2;
					else
						$descripcion_jornada = $frase1.$salto_linea.$frase2;
				}
				$id_tipo_horario = isset($get_descripcion_horario->id_tipo_horario)?$get_descripcion_horario->id_tipo_horario:'';
				if($get_usu_archivo->causal == "A"){
					if($id_tipo_horario == 2)
						$parrafo_decimo_tercero = "Las partes convienen que el presente Contrato de Servicios Transitorios tendrá como duración lo señalado en el Art. 183-O INCISO 1°, esto es la puesta disposición del trabajador podrá cubrir el tiempo de duración de la ausencia del trabajador reemplazado. Sus labores finalizarian el ".$fecha_termino_texto_largo.".";
					else
						$parrafo_decimo_tercero = "El presente contrato tendrá una vigencia hasta el ".$fecha_termino_texto_largo.", y podrá ponérsele término cuando concurran para ello causas justificadas que en conformidad a la ley puedan producir su caducidad, las partes fijan domicilio en la ciudad de Concepción y se someten a la jurisdicción de sus Tribunales.";
				}else{
					$parrafo_decimo_tercero = "El presente contrato tendrá una vigencia hasta el ".$fecha_termino_texto_largo.", y podrá ponérsele término cuando concurran para ello causas justificadas que en conformidad a la ley puedan producir su caducidad, las partes fijan domicilio en la ciudad de Concepción y se someten a la jurisdicción de sus Tribunales.";
				}
				$bono_responsabilidad_palabras = num2letras($get_usu_archivo->bono_responsabilidad);
				$bono_gestion_palabras = num2letras($get_usu_archivo->bono_gestion);
				$bono_confianza_palabras = num2letras($get_usu_archivo->bono_confianza);
				$asignacion_zona_palabras = num2letras($get_usu_archivo->asignacion_zona);
				$asignacion_movilizacion_palabras = num2letras($get_usu_archivo->asignacion_movilizacion);
				$asignacion_colacion_palabras = num2letras($get_usu_archivo->asignacion_colacion);
				$viatico_palabras = num2letras($get_usu_archivo->viatico);

				if($get_usu_archivo->bono_responsabilidad > 0)
					$frase_bono_responsabilidad = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono de Responsabilidad por la suma de $ ".str_replace(',','.',number_format($get_usu_archivo->bono_responsabilidad))." (".$bono_responsabilidad_palabras.").".$salto_linea."";
				else
					$frase_bono_responsabilidad = "";

				if($get_usu_archivo->bono_gestion > 0)
					$frase_bono_gestion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono de Gestión por la suma de $ ".str_replace(',','.',number_format($get_usu_archivo->bono_gestion))." (".$bono_gestion_palabras.").".$salto_linea."";
				else
					$frase_bono_gestion = "";

				if($get_usu_archivo->bono_confianza > 0)
					$frase_bono_confianza = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono Confianza por la suma de $ ".str_replace(',','.',number_format($get_usu_archivo->bono_confianza))." (".$bono_confianza_palabras.").".$salto_linea."";
				else
					$frase_bono_confianza = "";

				if($get_usu_archivo->asignacion_movilizacion > 0)
					$frase_asignacion_movilizacion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación de locomoción de $ ".str_replace(',','.',number_format($get_usu_archivo->asignacion_movilizacion))." (".$asignacion_movilizacion_palabras.").".$salto_linea."";
				else
					$frase_asignacion_movilizacion = "";

				if($get_usu_archivo->asignacion_colacion > 0)
					$frase_asignacion_colacion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación de colación de $ ".str_replace(',','.',number_format($get_usu_archivo->asignacion_colacion))." (".$asignacion_colacion_palabras.").".$salto_linea."";
				else
					$frase_asignacion_colacion = "";

				if($get_usu_archivo->asignacion_zona > 0)
					$frase_asignacion_zona = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación Zona por la suma de $ ".str_replace(',','.',number_format($get_usu_archivo->asignacion_zona))." (".$asignacion_zona_palabras.").".$salto_linea."";
				else
					$frase_asignacion_zona = "";

				if($get_usu_archivo->viatico > 0)
					$frase_viatico = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Viático de $ ".str_replace(',','.',number_format($get_usu_archivo->viatico))." (".$viatico_palabras.").".$salto_linea."";
				else
					$frase_viatico = "";

				$detalle_bonos = $frase_bono_responsabilidad.$frase_bono_gestion.$frase_bono_confianza.$frase_asignacion_movilizacion.$frase_asignacion_colacion.$frase_asignacion_zona.$frase_viatico;
				$sueldo_base_palabras = num2letras($get_usu_archivo->renta_imponible);
				$get_estado_civil = $this->estado_civil_model->get($usr->id_estadocivil);
				$get_ciudad = $this->ciudades_model->get($usr->id_ciudades);
				$get_centro_costo = $this->Empresas_model->get($id_centro_costo);
				$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_req_area_cargo);
				$nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
				$rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$id_cargo = isset($get_area_cargo->cargos_id)?$get_area_cargo->cargos_id:'';
				$get_cargo = $this->Cargos_model->r_get($id_cargo);
				$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
				$get_requerimiento = $this->Requerimientos_model->get($id_requerimiento);

				$id_planta = isset($get_requerimiento->planta_id)?$get_requerimiento->planta_id:'';
				$get_planta = $this->Empresa_planta_model->get($id_planta);
				$id_region_planta = isset($get_planta->id_regiones)?$get_planta->id_regiones:'';
				$id_ciudad_planta = isset($get_planta->id_ciudades)?$get_planta->id_ciudades:'';
				$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
				$nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
				$direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
				$get_region_planta = $this->regiones_model->get($id_region_planta);
				$get_ciudad_planta = $this->ciudades_model->get($id_ciudad_planta);
				$region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
				$ciudad_planta = isset($get_ciudad_planta->desc_ciudades)?$get_ciudad_planta->desc_ciudades:'';

				$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
				$tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
				$get_afp = $this->Afp_model->get($usr->id_afp);
				$prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
				$get_salud = $this->Salud_model->get($usr->id_salud);
				$salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
				$nombre_sin_espacios = trim($usr->paterno).'_'.trim($usr->materno);
				// Insertamos variables en el word
				$templateWord->setValue('fecha_ingreso_trabajador_palabras',$fecha_inicio_texto_largo);
				$templateWord->setValue('nombre_trabajador',titleCase($nombre_trabajador));
				$templateWord->setValue('rut_trabajador',$rut_trabajador);
				$templateWord->setValue('nacionalidad',titleCase($usr->nacionalidad));
				$templateWord->setValue('fecha_nacimiento',$fecha_nacimiento_texto_largo);
				$templateWord->setValue('estado_civil',titleCase($get_estado_civil->desc_estadocivil));
				$templateWord->setValue('domicilio_trabajador',titleCase($usr->direccion));
				$templateWord->setValue('comuna_trabajador',titleCase($get_ciudad->desc_ciudades));
				$templateWord->setValue('nombre_centro_costo',titleCase($nombre_centro_costo));
				$templateWord->setValue('rut_centro_costo',$rut_centro_costo);
				$templateWord->setValue('descripcion_causal',$descripcion_causal);
				$templateWord->setValue('motivo_req',titleCase($get_usu_archivo->motivo));
				$templateWord->setValue('cargo_postulante',titleCase($get_cargo->nombre));
				$templateWord->setValue('centro_costo',$nombre_centro_costo);
				$templateWord->setValue('nombre_planta',titleCase($nombre_planta));
				$templateWord->setValue('direccion_planta',titleCase($direccion_planta));
				$templateWord->setValue('comuna_planta',titleCase($ciudad_planta));
				$templateWord->setValue('region_planta',titleCase($region_planta));
				$templateWord->setValue('descripcion_jornada',$descripcion_jornada);
				$templateWord->setValue('sueldo_base_numeros', str_replace(',','.',number_format($get_usu_archivo->renta_imponible)));
				$templateWord->setValue('sueldo_base_palabras',titleCase($sueldo_base_palabras));
				$templateWord->setValue('gratificacion',$tipo_gratificacion);
				$templateWord->setValue('detalle_bonos',$detalle_bonos);
				$templateWord->setValue('adicional_cumplimiento_horario_undecimo',$adicional_cumplimiento_horario_undecimo);
				$templateWord->setValue('prevision_trabajador',titleCase($prevision));
				$templateWord->setValue('salud_trabajador',titleCase($salud));
				$templateWord->setValue('fecha_ingreso_trabajador',$fecha_inicio_texto_largo);
				$templateWord->setValue('fecha_vigencia_contrato',$fecha_termino_texto_largo);
				$templateWord->setValue('parrafo_decimo_tercero',$parrafo_decimo_tercero);

				// Guardamos el documento
				$nombre_documento = $nombre_sin_espacios.$usr->id."_contrato.docx";
				$carpeta = "extras/contratos_masivos/".$id_requerimiento."";
				if (!file_exists($carpeta)) {
				    mkdir($carpeta, 0777, true);
				}
				$templateWord->saveAs("extras/contratos_masivos/".$id_requerimiento."/".$nombre_documento);

				$get_url = "extras/contratos_masivos/".$id_requerimiento."/".$nombre_documento;
				$informacion = array(
					'id_requerimiento'=>$id_requerimiento,
					'id_trabajador'=>$usr->id,
					'url'=>$get_url,
					'nombre_archivo'=>$nombre_documento,
					);
				$this->Requerimiento_Usuario_Archivo_model->insertarContratoAprobado($informacion);
				$this->load->library('email');
				$config['smtp_host'] = 'mail.empresasintegra.cl';
				$config['smtp_user'] = 'informaciones@empresasintegra.cl';
				$config['smtp_pass'] = '%SYkNLH1';
				$config['mailtype'] = 'html';
				$config['smtp_port']    = '2552';
				$this->email->initialize($config);

			    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - carrera');
			    $this->email->to($email_solicitante);
			    $this->email->to('nrojas@empresasintegra.cl');
				//$this->email->cc('contratos@empresasintegra.cl');
				$this->email->subject("Aprobacion Contrato Trabajador: ".$nombre_trabajador." - Fecha Inicio Contrato: ".$fecha_inicio_contrato);
			    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' la solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.' ha sido aprobada con exito.<br>Saludos');
			    $this->email->send();
			}
		}
		echo '<script>alert("Solicitud de contrato fue aprobado exitosamente");</script>';
		redirect('carrera/contratos/solicitudes_pendientes', 'refresh');
	}
	#Solicitud baja de contrato 20-09-2018 g.r.m
	function solicitud_bajar_contrato($id_usu_arch){
		if($id_usu_arch != FALSE ){
			$motivoDeSolicitud = $_POST['value'];
			$verificandoExisteMotivo = $this->Requerimiento_Usuario_Archivo_model->getMotivoSolicitud($id_usu_arch);
			if ($verificandoExisteMotivo == false) {
				$array = array(
					'id_solicitante'=>$this->session->userdata('id'),
					'id_r_requerimiento_usuario_archivo'=>$id_usu_arch,
					'motivoSolicitud'=>$motivoDeSolicitud,
					);
				$this->Requerimiento_Usuario_Archivo_model->guardarMotivoSolicitud($array);
			}else{
				$array = array(
					'id_solicitante'=>$this->session->userdata('id'),
					'motivoSolicitud'=>$motivoDeSolicitud,
					);
				$this->Requerimiento_Usuario_Archivo_model->actualizarMotivoSolicitud($verificandoExisteMotivo->id, $array);
			}

			$data = array(
				'estado' => 4,// en proceso de baja
				);
			$this->Requerimiento_Usuario_Archivo_model->actualizar_solicitud_contrato($id_usu_arch, $data);
			$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);
			$nombre = isset($get_usu_archivo->nombres)?$get_usu_archivo->nombres:'';
			$aP = isset($get_usu_archivo->paterno)?$get_usu_archivo->paterno:'';
			$aM =isset($get_usu_archivo->materno)?$get_usu_archivo->materno:'';
			$nombre_trabajador = $nombre." ".$aP." ".$aM;
			$hoy = date('Y-m-d');
				$this->load->library('email');
				$config['smtp_host'] = 'mail.empresasintegra.cl';
				$config['smtp_user'] = 'informaciones@empresasintegra.cl';
				$config['smtp_pass'] = '%SYkNLH1';
				$config['mailtype'] = 'html';
				$config['smtp_port']    = '2552';
				$this->email->initialize($config);
				//$destinatarios_cc = array('contratos@empresasintegra.cl','jsilva@empresasintegra.cl');
			    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - ENJOY');
			   // $this->email->to('contratos@empresasintegra.cl');
				$this->email->cc('nrojas@empresasintegra.cl');
			    $this->email->subject("Baja de Contrato carrera Trabajador: ".$nombre_trabajador." fecha: ".$hoy." PENDIENTE ");
			    $this->email->message('Estimado(a) Hay una nueva solicitud de baja de contrato.<br> Motivo: '.$motivoDeSolicitud.'<br> Saludos');
			    $this->email->send();
			$variable=1;
		}else{
			$variable=0;//error al enviar id del requerimiento
		}
		echo json_encode($variable);
	}

	function solicitudes_pendientes_baja($get_id_planta = false){
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de contratos pendientes",
			'titulo' => "Solicitud de contratos de baja",
			'subtitulo' => 'Unidad de Negocio: Casa Matriz',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado solicitudes pendientes' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);

		$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_pendientes_baja();
		$listado = array();
		if($trabajadores != FALSE){
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$id_solicitante = isset($rm->id_solicitante)?$rm->id_solicitante:'';
				$id_req_usu_arch = isset($rm->id_req_usu_arch)?$rm->id_req_usu_arch:'';
				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$usr = $this->Usuarios_model->get($id_usuario);
				$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
				$id_jornada = isset($get_usu_archivo->jornada)?$get_usu_archivo->jornada:'';
				$get_jornada = $this->Descripcion_horarios_model->get($id_jornada);
				#Verifico si hay comentarios 21-09-2018 g.r.m
				$motivoSolicitud = $this->Requerimiento_Usuario_Archivo_model->getMotivoSolicitud($id_req_usu_arch);

				$aux = new StdClass();
				$id_ciudad = isset($usr->id_ciudades)?$usr->id_ciudades:'';
				$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
				$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
				$id_estado_civil = isset($usr->id_estadocivil)?$usr->id_estadocivil:'';
				$id_estudios = isset($usr->id_estudios)?$usr->id_estudios:'';
				$get_ciudad = $this->ciudades_model->get($id_ciudad);
				$get_afp = $this->Afp_model->get($id_afp);
				$get_salud = $this->Salud_model->get($id_salud);
				$get_estado_civil = $this->estado_civil_model->get($id_estado_civil);
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

				$aux->motivoSolicitud= isset($motivoSolicitud->motivoSolicitud)?$motivoSolicitud->motivoSolicitud:'';
				$aux->codigo_centro_costo = isset($get_requerimiento->codigo_centro_costo)?$get_requerimiento->codigo_centro_costo:'';
				$aux->id_req_usu_arch = isset($rm->id_req_usu_arch)?$rm->id_req_usu_arch:'';
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

				$aux->nombre = isset($get_usu_archivo->nombre)?$get_usu_archivo->nombre:'';
				$aux->url = isset($get_usu_archivo->url)?$get_usu_archivo->url:'';
				$aux->causal = isset($get_usu_archivo->causal)?$get_usu_archivo->causal:'';
				$aux->motivo = isset($get_usu_archivo->motivo)?$get_usu_archivo->motivo:'';
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->renta_imponible = isset($get_usu_archivo->renta_imponible)?$get_usu_archivo->renta_imponible:'';
				$aux->bono_responsabilidad = isset($get_usu_archivo->bono_responsabilidad)?$get_usu_archivo->bono_responsabilidad:'';
				$aux->bono_gestion = isset($get_usu_archivo->bono_gestion)?$get_usu_archivo->bono_gestion:'';
				$aux->bono_confianza = isset($get_usu_archivo->bono_confianza)?$get_usu_archivo->bono_confianza:'';
				$aux->asignacion_movilizacion = isset($get_usu_archivo->asignacion_movilizacion)?$get_usu_archivo->asignacion_movilizacion:'';
				$aux->asignacion_colacion = isset($get_usu_archivo->asignacion_colacion)?$get_usu_archivo->asignacion_colacion:'';
				$aux->asignacion_zona = isset($get_usu_archivo->asignacion_zona)?$get_usu_archivo->asignacion_zona:'';
				$aux->asignacion_herramientas = isset($get_usu_archivo->asignacion_herramientas)?$get_usu_archivo->asignacion_herramientas:'';
				$aux->viatico = isset($get_usu_archivo->viatico)?$get_usu_archivo->viatico:'';
				$aux->fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';
				$aux->fecha_termino = isset($get_usu_archivo->fecha_termino)?$get_usu_archivo->fecha_termino:'';

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
		$pagina['pedientes_baja']= true;
		$pagina['listado'] = $listado;
		$pagina['planta_seleccionada'] = $get_id_planta;
		$pagina['listado_plantas'] = $this->Empresa_planta_model->listar();
		$base['cuerpo'] = $this->load->view('contratos/listado_solicitudes_pendientes',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function solicitudes_completas_baja(){
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de contratos completas",
			'titulo' => "Contratos de baja",
			'subtitulo' => 'Unidad de Negocio: Casa Matriz',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado solicitudes completas' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);
		$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas_baja();
		$listado = array();
		if($trabajadores != FALSE){
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$id_solicitante = isset($rm->id_solicitante)?$rm->id_solicitante:'';
				$id_req_usu_arch = isset($rm->id_req_usu_arch)?$rm->id_req_usu_arch:NULL;
				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$usr = $this->Usuarios_model->get($id_usuario);
				$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
				$id_jornada = isset($get_usu_archivo->jornada)?$get_usu_archivo->jornada:'';
				$get_jornada = $this->Descripcion_horarios_model->get($id_jornada);
				$motivoSolicitud = $this->Requerimiento_Usuario_Archivo_model->getMotivoSolicitud($id_req_usu_arch);

				$aux = new StdClass();
				$id_ciudad = isset($usr->id_ciudades)?$usr->id_ciudades:'';
				$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
				$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
				$id_estado_civil = isset($usr->id_estadocivil)?$usr->id_estadocivil:'';
				$id_estudios = isset($usr->id_estudios)?$usr->id_estudios:'';
				$get_ciudad = $this->Ciudad_model->get($id_ciudad);
				$get_afp = $this->Afp_model->get($id_afp);
				$get_salud = $this->Salud_model->get($id_salud);
				$get_estado_civil = $this->Estadocivil_model->get($id_estado_civil);
				$get_nivel_estudios = $this->Nivelestudios_model->get($id_estudios);
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
				$get_region_planta = $this->Region_model->get($id_region_planta);
				$get_ciudad_planta = $this->Ciudad_model->get($id_ciudad_planta);

				$aux->motivoSolicitud= isset($motivoSolicitud->motivoSolicitud)?$motivoSolicitud->motivoSolicitud:'';
				$aux->codigo_centro_costo = isset($get_requerimiento->codigo_centro_costo)?$get_requerimiento->codigo_centro_costo:'';
				$aux->id_req_usu_arch = isset($rm->id_req_usu_arch)?$rm->id_req_usu_arch:'';
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

				$aux->nombre = isset($get_usu_archivo->nombre)?$get_usu_archivo->nombre:'';
				$aux->url = isset($get_usu_archivo->url)?$get_usu_archivo->url:'';
				$aux->causal = isset($get_usu_archivo->causal)?$get_usu_archivo->causal:'';
				$aux->motivo = isset($get_usu_archivo->motivo)?$get_usu_archivo->motivo:'';
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->renta_imponible = isset($get_usu_archivo->renta_imponible)?$get_usu_archivo->renta_imponible:'';
				$aux->bono_responsabilidad = isset($get_usu_archivo->bono_responsabilidad)?$get_usu_archivo->bono_responsabilidad:'';
				$aux->bono_gestion = isset($get_usu_archivo->bono_gestion)?$get_usu_archivo->bono_gestion:'';
				$aux->bono_confianza = isset($get_usu_archivo->bono_confianza)?$get_usu_archivo->bono_confianza:'';
				$aux->asignacion_movilizacion = isset($get_usu_archivo->asignacion_movilizacion)?$get_usu_archivo->asignacion_movilizacion:'';
				$aux->asignacion_colacion = isset($get_usu_archivo->asignacion_colacion)?$get_usu_archivo->asignacion_colacion:'';
				$aux->asignacion_zona = isset($get_usu_archivo->asignacion_zona)?$get_usu_archivo->asignacion_zona:'';
				$aux->asignacion_herramientas = isset($get_usu_archivo->asignacion_herramientas)?$get_usu_archivo->asignacion_herramientas:'';
				$aux->viatico = isset($get_usu_archivo->viatico)?$get_usu_archivo->viatico:'';
				$aux->fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';
				$aux->fecha_termino = isset($get_usu_archivo->fecha_termino)?$get_usu_archivo->fecha_termino:'';

				$fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'0000-00-00';
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
		$pagina['completa_baja']= true;//variable que envio a la vista para determinar que vengo desde esta funcion
		$pagina['listado'] = $listado;
		$pagina['listado_plantas'] = $this->Empresa_planta_model->listar();
		$base['cuerpo'] = $this->load->view('carrera/contratos/listado_solicitudes_completas',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function exportar_excel_contratos_y_anexos(){
		header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
		header("Content-Disposition: filename=ficheroExcel.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo utf8_decode($_POST['datos_a_enviar']);
	}
	/*
		#21-09-2018 g.r.m
			Se Agrega Solicitud de baja de contratos  con comentarios 
			Se Copia la informacion basica del trabajador al contrato
			Exportacion de mas de mil registros en solicitudes completas
	*/

	function solicitudes_pendientes_anexo($get_id_planta = false){
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de Anexos Pendientes",
			'titulo' => "Anexos de Contratos",
			'subtitulo' => 'Unidad de Negocio: Casa Matriz',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado de anexos pendientes' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);


			$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_pendientes_anexo($get_id_planta);
			//var_dump($trabajadores);return false;
			$pagina['trabajadores']=$trabajadores;
			$base['cuerpo'] = $this->load->view('contratos/anexos_pendientes',$pagina,TRUE);
			$this->load->view('layout2.0/layout',$base);
	}

	function descargar_anexo($id){
	//inicio de boton generar anexo
		$datos = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($id);
		//var_dump($datos); return false;
		$template_formato = base_url()."extras/contratos/anexos/anexocarrera.docx";

		$templateWord = new TemplateProcessor($template_formato);

		$salto_linea = "<w:br/>";

		$var1 = explode('.',$datos->rut_usuario); 
		$rut1 = $var1[0];

		if($rut1 < 10)
			$datos->rut_usuario = "0".$datos->rut_usuario;

		$getFechaTerminoAnterior=date($datos->fecha_termino_contrato_anterior); 
		$var1 = explode('-',$getFechaTerminoAnterior);
		$dia_fi = $var1[2];
		$mes_fi = $var1[1];
		$ano_fi = $var1[0];

		if ($mes_fi=="01") $mesTerminoAnterior="Enero";
		if ($mes_fi=="02") $mesTerminoAnterior="Febrero";
		if ($mes_fi=="03") $mesTerminoAnterior="Marzo";
		if ($mes_fi=="04") $mesTerminoAnterior="Abril";
		if ($mes_fi=="05") $mesTerminoAnterior="Mayo";
		if ($mes_fi=="06") $mesTerminoAnterior="Junio";
		if ($mes_fi=="07") $mesTerminoAnterior="Julio";
		if ($mes_fi=="08") $mesTerminoAnterior="Agosto";
		if ($mes_fi=="09") $mesTerminoAnterior="Septiembre";
		if ($mes_fi=="10") $mesTerminoAnterior="Octubre";
		if ($mes_fi=="11") $mesTerminoAnterior="Noviembre";
		if ($mes_fi=="12") $mesTerminoAnterior="Diciembre";

		$getFechaInicioContrato=date($datos->fecha_inicio_contrato); 
		$var2 = explode('-',$getFechaInicioContrato); 
		$dia_ft = $var2[2];
		$mes_ft = $var2[1];
		$ano_ft = $var2[0];

		if ($mes_ft=="01") $mesInicioContrato="Enero";
		if ($mes_ft=="02") $mesInicioContrato="Febrero";
		if ($mes_ft=="03") $mesInicioContrato="Marzo";
		if ($mes_ft=="04") $mesInicioContrato="Abril";
		if ($mes_ft=="05") $mesInicioContrato="Mayo";
		if ($mes_ft=="06") $mesInicioContrato="Junio";
		if ($mes_ft=="07") $mesInicioContrato="Julio";
		if ($mes_ft=="08") $mesInicioContrato="Agosto";
		if ($mes_ft=="09") $mesInicioContrato="Septiembre";
		if ($mes_ft=="10") $mesInicioContrato="Octubre";
		if ($mes_ft=="11") $mesInicioContrato="Noviembre";
		if ($mes_ft=="12") $mesInicioContrato="Diciembre";

		$get_fecha_nacimiento=date($datos->fecha_nac); 
		$var3 = explode('-',$get_fecha_nacimiento); 
		$dia_fecha_nac = $var3[2];
		$mes_fecha_nac = $var3[1];
		$ano_fecha_nac = $var3[0];
		if ($mes_fecha_nac=="01") $mesFechaNacimiento="Enero";
		if ($mes_fecha_nac=="02") $mesFechaNacimiento="Febrero";
		if ($mes_fecha_nac=="03") $mesFechaNacimiento="Marzo";
		if ($mes_fecha_nac=="04") $mesFechaNacimiento="Abril";
		if ($mes_fecha_nac=="05") $mesFechaNacimiento="Mayo";
		if ($mes_fecha_nac=="06") $mesFechaNacimiento="Junio";
		if ($mes_fecha_nac=="07") $mesFechaNacimiento="Julio";
		if ($mes_fecha_nac=="08") $mesFechaNacimiento="Agosto";
		if ($mes_fecha_nac=="09") $mesFechaNacimiento="Septiembre";
		if ($mes_fecha_nac=="10") $mesFechaNacimiento="Octubre";
		if ($mes_fecha_nac=="11") $mesFechaNacimiento="Noviembre";
		if ($mes_fecha_nac=="12") $mesFechaNacimiento="Diciembre";

		$get_fecha_termino_nuevo=date($datos->fecha_termino_nuevo_anexo); 
		$var4 = explode('-',$get_fecha_termino_nuevo); 
		$dia_terminoAnexo = $var4[2];
		$mes_terminoAnexo = $var4[1];
		$ano_terminoAnexo = $var4[0];
		if ($mes_terminoAnexo=="01") $mesFechaTerminoAnexo="Enero";
		if ($mes_terminoAnexo=="02") $mesFechaTerminoAnexo="Febrero";
		if ($mes_terminoAnexo=="03") $mesFechaTerminoAnexo="Marzo";
		if ($mes_terminoAnexo=="04") $mesFechaTerminoAnexo="Abril";
		if ($mes_terminoAnexo=="05") $mesFechaTerminoAnexo="Mayo";
		if ($mes_terminoAnexo=="06") $mesFechaTerminoAnexo="Junio";
		if ($mes_terminoAnexo=="07") $mesFechaTerminoAnexo="Julio";
		if ($mes_terminoAnexo=="08") $mesFechaTerminoAnexo="Agosto";
		if ($mes_terminoAnexo=="09") $mesFechaTerminoAnexo="Septiembre";
		if ($mes_terminoAnexo=="10") $mesFechaTerminoAnexo="Octubre";
		if ($mes_terminoAnexo=="11") $mesFechaTerminoAnexo="Noviembre";
		if ($mes_terminoAnexo=="12") $mesFechaTerminoAnexo="Diciembre";

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
	}

	function aprobar_anexo($id){
		if ($id == false) {
			redirect(base_url());
		}
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		
		$data = array(
			'id_quien_aprueba' => $this->session->userdata('id'),
			'estado' => 2,
			'fecha_aprobacion' => date('Y-m-d H:i:s'),
		);
		$data3 = array(
			'existe_otro_anexo'=>1,
		);
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($id);
		$siExisteOtroAnexo = $this->Requerimiento_Usuario_Archivo_model->marcarAnexoAnteriorComoFinalizado($datosAnexoContrato->usuario_id,$datosAnexoContrato->requerimiento_asc_trabajadores_id,$data3);
		$data2 = array(
			'anexogenerado'=>1,
		);

		$this->Requerimiento_Usuario_Archivo_model->actualizarContrato($datosAnexoContrato->usuario_id,$datosAnexoContrato->requerimiento_asc_trabajadores_id, $data2);
		//yayo 14-10-2019 guardar anexo aprobado para descargar de manera masiva
		$datos = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($id);
		$template_formato = base_url()."extras/contratos/anexos/anexocarrera.docx";

		$templateWord = new TemplateProcessor($template_formato);
		$salto_linea = "<w:br/>";
		$var1 = explode('.',$datos->rut_usuario); 
		$rut1 = $var1[0];
		if($rut1 < 10)
			$datos->rut_usuario = "0".$datos->rut_usuario;
		$getFechaTerminoAnterior=date($datos->fecha_termino_contrato_anterior); 
		$var1 = explode('-',$getFechaTerminoAnterior);
		$dia_fi = $var1[2];
		$mes_fi = $var1[1];
		$ano_fi = $var1[0];

		if ($mes_fi=="01") $mesTerminoAnterior="Enero";
		if ($mes_fi=="02") $mesTerminoAnterior="Febrero";
		if ($mes_fi=="03") $mesTerminoAnterior="Marzo";
		if ($mes_fi=="04") $mesTerminoAnterior="Abril";
		if ($mes_fi=="05") $mesTerminoAnterior="Mayo";
		if ($mes_fi=="06") $mesTerminoAnterior="Junio";
		if ($mes_fi=="07") $mesTerminoAnterior="Julio";
		if ($mes_fi=="08") $mesTerminoAnterior="Agosto";
		if ($mes_fi=="09") $mesTerminoAnterior="Septiembre";
		if ($mes_fi=="10") $mesTerminoAnterior="Octubre";
		if ($mes_fi=="11") $mesTerminoAnterior="Noviembre";
		if ($mes_fi=="12") $mesTerminoAnterior="Diciembre";

		$getFechaInicioContrato=date($datos->fecha_inicio_contrato); 
		$var2 = explode('-',$getFechaInicioContrato); 
		$dia_ft = $var2[2];
		$mes_ft = $var2[1];
		$ano_ft = $var2[0];

		if ($mes_ft=="01") $mesInicioContrato="Enero";
		if ($mes_ft=="02") $mesInicioContrato="Febrero";
		if ($mes_ft=="03") $mesInicioContrato="Marzo";
		if ($mes_ft=="04") $mesInicioContrato="Abril";
		if ($mes_ft=="05") $mesInicioContrato="Mayo";
		if ($mes_ft=="06") $mesInicioContrato="Junio";
		if ($mes_ft=="07") $mesInicioContrato="Julio";
		if ($mes_ft=="08") $mesInicioContrato="Agosto";
		if ($mes_ft=="09") $mesInicioContrato="Septiembre";
		if ($mes_ft=="10") $mesInicioContrato="Octubre";
		if ($mes_ft=="11") $mesInicioContrato="Noviembre";
		if ($mes_ft=="12") $mesInicioContrato="Diciembre";

		$get_fecha_nacimiento=date($datos->fecha_nac); 
		$var3 = explode('-',$get_fecha_nacimiento); 
		$dia_fecha_nac = $var3[2];
		$mes_fecha_nac = $var3[1];
		$ano_fecha_nac = $var3[0];
		if ($mes_fecha_nac=="01") $mesFechaNacimiento="Enero";
		if ($mes_fecha_nac=="02") $mesFechaNacimiento="Febrero";
		if ($mes_fecha_nac=="03") $mesFechaNacimiento="Marzo";
		if ($mes_fecha_nac=="04") $mesFechaNacimiento="Abril";
		if ($mes_fecha_nac=="05") $mesFechaNacimiento="Mayo";
		if ($mes_fecha_nac=="06") $mesFechaNacimiento="Junio";
		if ($mes_fecha_nac=="07") $mesFechaNacimiento="Julio";
		if ($mes_fecha_nac=="08") $mesFechaNacimiento="Agosto";
		if ($mes_fecha_nac=="09") $mesFechaNacimiento="Septiembre";
		if ($mes_fecha_nac=="10") $mesFechaNacimiento="Octubre";
		if ($mes_fecha_nac=="11") $mesFechaNacimiento="Noviembre";
		if ($mes_fecha_nac=="12") $mesFechaNacimiento="Diciembre";

		$get_fecha_termino_nuevo=date($datos->fecha_termino_nuevo_anexo); 
		$var4 = explode('-',$get_fecha_termino_nuevo); 
		$dia_terminoAnexo = $var4[2];
		$mes_terminoAnexo = $var4[1];
		$ano_terminoAnexo = $var4[0];
		if ($mes_terminoAnexo=="01") $mesFechaTerminoAnexo="Enero";
		if ($mes_terminoAnexo=="02") $mesFechaTerminoAnexo="Febrero";
		if ($mes_terminoAnexo=="03") $mesFechaTerminoAnexo="Marzo";
		if ($mes_terminoAnexo=="04") $mesFechaTerminoAnexo="Abril";
		if ($mes_terminoAnexo=="05") $mesFechaTerminoAnexo="Mayo";
		if ($mes_terminoAnexo=="06") $mesFechaTerminoAnexo="Junio";
		if ($mes_terminoAnexo=="07") $mesFechaTerminoAnexo="Julio";
		if ($mes_terminoAnexo=="08") $mesFechaTerminoAnexo="Agosto";
		if ($mes_terminoAnexo=="09") $mesFechaTerminoAnexo="Septiembre";
		if ($mes_terminoAnexo=="10") $mesFechaTerminoAnexo="Octubre";
		if ($mes_terminoAnexo=="11") $mesFechaTerminoAnexo="Noviembre";
		if ($mes_terminoAnexo=="12") $mesFechaTerminoAnexo="Diciembre";

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
		$requerimientou = $this->Requerimiento_Usuario_Archivo_model->getRequerimienton($datos->id_requerimiento_area_cargo);
		$nombre_documento = $datos->nombres."_Anexo.docx";
		$carpeta = "extras/anexos_masivos/".$requerimientou->requerimiento_id;
		if (!file_exists($carpeta)) {
		    mkdir($carpeta, 0777, true);
		}
		$templateWord->saveAs("extras/anexos_masivos/".$requerimientou->requerimiento_id."/".$nombre_documento);
		$get_url = "extras/anexos_masivos/".$requerimientou->requerimiento_id."/".$nombre_documento;

		$informacion = array(
			'id_requerimiento'=>$requerimientou->requerimiento_id,
			'id_trabajador'=>$datos->usuario_id,
			'url'=>$get_url,
			'nombre_archivo'=>$nombre_documento,
			);
		$this->Requerimiento_Usuario_Archivo_model->insertarAnexoAprobado($informacion);
		$get_solicitante = $this->Usuarios_general_model->get($datosAnexoContrato->id_quien_solicita);
		$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
		$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
		$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
		$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
		$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';

				$this->load->library('email');
				$config['smtp_host'] = 'mail.empresasintegra.cl';
				$config['smtp_user'] = 'informaciones@empresasintegra.cl';
				$config['smtp_pass'] = '%SYkNLH1';
				$config['mailtype'] = 'html';
				$config['smtp_port']    = '2552';
				$this->email->initialize($config);
			    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Anexo de Contrato SGO - carrera');
			    $this->email->to($email_solicitante);
			    $this->email->to('nrojas@empresasintegra.cl');
				//$this->email->cc('contratos@empresasintegra.cl');
				$this->email->subject("Aprobacion Anexo Trabajador: ".$datosAnexoContrato->nombres." - Fecha Inicio Contrato: ".$datosAnexoContrato->fecha_inicio_contrato);
			    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' la solicitud de Anexo de contrato del trabajador: '.$datosAnexoContrato->nombres.' con el siguiente Rut: '.$datosAnexoContrato->rut_usuario.' ha sido aprobada con exito.<br>Saludos');
			    $this->email->send();
		$this->Requerimiento_Usuario_Archivo_model->actualizarAnexo($id, $data);
		redirect('carrera/contratos/solicitudes_pendientes_anexo/', 'refresh');
	}
	
	function aprobacion_masiva_anexos(){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		if($_POST['solicitudes']){
			foreach($_POST['solicitudes'] as $c=>$valores){
				$data = array(
					'id_quien_aprueba' => $this->session->userdata('id'),
					'estado' => 2,
					'fecha_aprobacion' => date('Y-m-d H:i:s'),
				);
				$this->Requerimiento_Usuario_Archivo_model->actualizarAnexo($valores, $data);
				$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($valores);
				$data2 = array(
					'anexogenerado'=>1,
					);
				//if ($datosAnexoContrato->estado == 1) {
					$this->Requerimiento_Usuario_Archivo_model->actualizarContrato($datosAnexoContrato->usuario_id,$datosAnexoContrato->requerimiento_asc_trabajadores_id, $data2);
					$get_solicitante = $this->Usuarios_general_model->get($datosAnexoContrato->id_quien_solicita);
					$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
					$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
					$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
					$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
					$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';
					//yayo 14-10-2019 guardar anexo aprobado para descargar de manera masiva
					$datos = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($valores);
					$template_formato = base_url()."extras/contratos/anexos/anexocarrera.docx";

					$templateWord = new TemplateProcessor($template_formato);
					$salto_linea = "<w:br/>";
					$var1 = explode('.',$datos->rut_usuario); 
					$rut1 = $var1[0];
					if($rut1 < 10)
						$datos->rut_usuario = "0".$datos->rut_usuario;
					$getFechaTerminoAnterior=date($datos->fecha_termino_contrato_anterior); 
					$var1 = explode('-',$getFechaTerminoAnterior);
					$dia_fi = $var1[2];
					$mes_fi = $var1[1];
					$ano_fi = $var1[0];

					if ($mes_fi=="01") $mesTerminoAnterior="Enero";
					if ($mes_fi=="02") $mesTerminoAnterior="Febrero";
					if ($mes_fi=="03") $mesTerminoAnterior="Marzo";
					if ($mes_fi=="04") $mesTerminoAnterior="Abril";
					if ($mes_fi=="05") $mesTerminoAnterior="Mayo";
					if ($mes_fi=="06") $mesTerminoAnterior="Junio";
					if ($mes_fi=="07") $mesTerminoAnterior="Julio";
					if ($mes_fi=="08") $mesTerminoAnterior="Agosto";
					if ($mes_fi=="09") $mesTerminoAnterior="Septiembre";
					if ($mes_fi=="10") $mesTerminoAnterior="Octubre";
					if ($mes_fi=="11") $mesTerminoAnterior="Noviembre";
					if ($mes_fi=="12") $mesTerminoAnterior="Diciembre";

					$getFechaInicioContrato=date($datos->fecha_inicio_contrato); 
					$var2 = explode('-',$getFechaInicioContrato); 
					$dia_ft = $var2[2];
					$mes_ft = $var2[1];
					$ano_ft = $var2[0];

					if ($mes_ft=="01") $mesInicioContrato="Enero";
					if ($mes_ft=="02") $mesInicioContrato="Febrero";
					if ($mes_ft=="03") $mesInicioContrato="Marzo";
					if ($mes_ft=="04") $mesInicioContrato="Abril";
					if ($mes_ft=="05") $mesInicioContrato="Mayo";
					if ($mes_ft=="06") $mesInicioContrato="Junio";
					if ($mes_ft=="07") $mesInicioContrato="Julio";
					if ($mes_ft=="08") $mesInicioContrato="Agosto";
					if ($mes_ft=="09") $mesInicioContrato="Septiembre";
					if ($mes_ft=="10") $mesInicioContrato="Octubre";
					if ($mes_ft=="11") $mesInicioContrato="Noviembre";
					if ($mes_ft=="12") $mesInicioContrato="Diciembre";

					$get_fecha_nacimiento=date($datos->fecha_nac); 
					$var3 = explode('-',$get_fecha_nacimiento); 
					$dia_fecha_nac = $var3[2];
					$mes_fecha_nac = $var3[1];
					$ano_fecha_nac = $var3[0];
					if ($mes_fecha_nac=="01") $mesFechaNacimiento="Enero";
					if ($mes_fecha_nac=="02") $mesFechaNacimiento="Febrero";
					if ($mes_fecha_nac=="03") $mesFechaNacimiento="Marzo";
					if ($mes_fecha_nac=="04") $mesFechaNacimiento="Abril";
					if ($mes_fecha_nac=="05") $mesFechaNacimiento="Mayo";
					if ($mes_fecha_nac=="06") $mesFechaNacimiento="Junio";
					if ($mes_fecha_nac=="07") $mesFechaNacimiento="Julio";
					if ($mes_fecha_nac=="08") $mesFechaNacimiento="Agosto";
					if ($mes_fecha_nac=="09") $mesFechaNacimiento="Septiembre";
					if ($mes_fecha_nac=="10") $mesFechaNacimiento="Octubre";
					if ($mes_fecha_nac=="11") $mesFechaNacimiento="Noviembre";
					if ($mes_fecha_nac=="12") $mesFechaNacimiento="Diciembre";

					$get_fecha_termino_nuevo=date($datos->fecha_termino_nuevo_anexo); 
					$var4 = explode('-',$get_fecha_termino_nuevo); 
					$dia_terminoAnexo = $var4[2];
					$mes_terminoAnexo = $var4[1];
					$ano_terminoAnexo = $var4[0];
					if ($mes_terminoAnexo=="01") $mesFechaTerminoAnexo="Enero";
					if ($mes_terminoAnexo=="02") $mesFechaTerminoAnexo="Febrero";
					if ($mes_terminoAnexo=="03") $mesFechaTerminoAnexo="Marzo";
					if ($mes_terminoAnexo=="04") $mesFechaTerminoAnexo="Abril";
					if ($mes_terminoAnexo=="05") $mesFechaTerminoAnexo="Mayo";
					if ($mes_terminoAnexo=="06") $mesFechaTerminoAnexo="Junio";
					if ($mes_terminoAnexo=="07") $mesFechaTerminoAnexo="Julio";
					if ($mes_terminoAnexo=="08") $mesFechaTerminoAnexo="Agosto";
					if ($mes_terminoAnexo=="09") $mesFechaTerminoAnexo="Septiembre";
					if ($mes_terminoAnexo=="10") $mesFechaTerminoAnexo="Octubre";
					if ($mes_terminoAnexo=="11") $mesFechaTerminoAnexo="Noviembre";
					if ($mes_terminoAnexo=="12") $mesFechaTerminoAnexo="Diciembre";

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
					$requerimientou = $this->Requerimiento_Usuario_Archivo_model->getRequerimienton($datos->id_requerimiento_area_cargo);
					$nombre_documento = $datos->nombres."_Anexo.docx";
					$carpeta = "extras/anexos_masivos/".$requerimientou->requerimiento_id;
					if (!file_exists($carpeta)) {
					    mkdir($carpeta, 0777, true);
					}
					$templateWord->saveAs("extras/anexos_masivos/".$requerimientou->requerimiento_id."/".$nombre_documento);
					$get_url = "extras/anexos_masivos/".$requerimientou->requerimiento_id."/".$nombre_documento;

					$informacion = array(
						'id_requerimiento'=>$requerimientou->requerimiento_id,
						'id_trabajador'=>$datos->usuario_id,
						'url'=>$get_url,
						'nombre_archivo'=>$nombre_documento,
						);
					$this->Requerimiento_Usuario_Archivo_model->insertarAnexoAprobado($informacion);
					$this->load->library('email');
					$config['smtp_host'] = 'mail.empresasintegra.cl';
					$config['smtp_user'] = 'informaciones@empresasintegra.cl';
					$config['smtp_pass'] = '%SYkNLH1';
					$config['mailtype'] = 'html';
					$config['smtp_port']    = '2552';
					$this->email->initialize($config);
				    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Anexo de Contrato SGO - carrera');
				    //$this->email->to($email_solicitante);
					$this->email->cc('contratos@empresasintegra.cl');
					//$this->email->cc('gramirez@empresasintegra.cl');
					$this->email->subject("Aprobacion Anexo Trabajador: ".$datosAnexoContrato->nombres." - Fecha Inicio Contrato: ".$datosAnexoContrato->fecha_inicio_contrato);
				    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' la solicitud de Anexo de contrato del trabajador: '.$datosAnexoContrato->nombres.' con el siguiente Rut: '.$datosAnexoContrato->rut_usuario.' ha sido aprobada con exito.<br>Saludos');
				    $this->email->send();
				//}
			}
		}
		$this->session->set_userdata('msg',1);
		redirect('carrera/contratos/solicitudes_pendientes_anexo', 'refresh');
	}

	function rechazar_anexo($idAnexo){
		$this->load->model("carrera/Requerimiento_Usuario_Archivo_model");
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($idAnexo);
		if ($datosAnexoContrato->estado == 1) {
			$data = array(
				'estado' => 6,//rechazado
				'motivo_rechazo' => $_POST['value'],
			);
			$resultado = $this->Requerimiento_Usuario_Archivo_model->actualizarAnexo($idAnexo, $data);
			$get_solicitante = $this->Usuarios_general_model->get($datosAnexoContrato->id_quien_solicita);
			$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
			$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
			$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
			$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
			$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';
				$this->load->library('email');
				$config['smtp_host'] = 'mail.empresasintegra.cl';
				$config['smtp_user'] = 'informaciones@empresasintegra.cl';
				$config['smtp_pass'] = '%SYkNLH1';
				$config['mailtype'] = 'html';
				$config['smtp_port']    = '2552';
				$this->email->initialize($config);
			    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Anexo de Contrato SGO - carrera');
			    $this->email->to($email_solicitante);
				//$this->email->cc('contratos@empresasintegra.cl');
				$this->email->subject("Rechazo Anexo Trabajador: ".$datosAnexoContrato->nombres." - Fecha Inicio Contrato: ".$datosAnexoContrato->fecha_inicio_contrato);
			    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' la solicitud de Anexo de contrato del trabajador: '.$datosAnexoContrato->nombres.' con el siguiente Rut: '.$datosAnexoContrato->rut_usuario.' ha sido rechazada bajo el motivo: '.$_POST['value'].' <br>Saludos');
			    $this->email->send();

		}else{
			$resultado=0;
		}
		echo json_encode($resultado);
	}

	function solicitudes_completas_anexo($get_id_planta = false){
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de Anexos Completos",
			'titulo' => "Anexos de Contratos",
			'subtitulo' => 'Unidad de Negocio: Casa Matriz',
			'side_bar' => true,
			'lugar' => array(
							array('url' => 'usuarios/home', 'txt' => 'Inicio'), 
							array('url'=>'','txt'=>'Listado de Anexos Aprobados' )
						),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);

		$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas_anexo($get_id_planta);
		$pagina['trabajadores']=$trabajadores;
		$base['cuerpo'] = $this->load->view('contratos/anexos_completos',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
	

}
?>