<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Trabajadores extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
    	$this->load->library('encrypt');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 12)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_logistica_servicios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 14)
			$this->menu = $this->load->view('layout2.0/menus/enjoy_menu_admin','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 15)
			$this->menu = $this->load->view('layout2.0/menus/enjoy_menu_admin_supervisor','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		$this->load->model("enjoy/Usuarios_model");
		$this->load->model("enjoy/Salud_model");
		$this->load->model("enjoy/Afp_model");
		$this->load->model("enjoy/Ciudades_model");
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> Logistica y Servicios',
			'side_bar' => true,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/exportarExcelEnjoy.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Listado Trabajadores') ),
			'menu' => $this->menu
		);
		$lista = array();
		foreach($this->Usuarios_model->listar_activos() as $l){
			//var_dump($l);
			$aux = new stdClass();

			$id_ciudad = $l->id_ciudad;
			$id_salud = $l->id_salud;
			$id_afp = $l->id_afp;

			$nombreBanco = $this->Usuarios_model->getNombreBanco($l->id_bancos);
			$aux->nombreBanco = isset($nombreBanco->desc_bancos)?$nombreBanco->desc_bancos:'';
			$aux->tipo_cuenta = $l->tipo_cuenta;
			$aux->cuenta_banco = $l->cuenta_banco;
			$aux->nacionalidad = $l->nacionalidad;

			$get_ciudad = $this->Ciudades_model->get($id_ciudad);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_afp = $this->Afp_model->get($id_afp);
			$listaNegra = $this->Usuarios_model->getListaNegraTrabajador($l->id);
			$aux->listaNegra = $listaNegra;
			$aux->id_usuario = $l->id;
			$aux->rut_usuario = $l->rut_usuario;
			$aux->nombres = $l->nombres;
			$aux->paterno = $l->paterno;
			$aux->materno = $l->materno;
			$aux->correo = $l->email;
			$aux->fono = $l->fono;
			$aux->observacion = $l->observacion;
			$aux->usuario_observacion = $l->usuario_observacion;
			$aux->fecha_nac = $l->fecha_nac;
			$aux->direccion = $l->direccion;
			$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
			$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
			$aux->afp = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
			$aux->estado = $l->estado;
			array_push($lista,$aux);
			unset($aux);
		}
		//var_dump($nombreBanco);

		$pagina['listado'] = $lista;
		$base['cuerpo'] = $this->load->view('trabajadores/listado_general',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function exportar_excel_contratos_y_anexos(){#20-09-2018 g.r.m
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

	function crear(){
		$this->load->model("enjoy/Usuarios_model");
		$this->load->model("enjoy/Salud_model");
		$this->load->model("enjoy/Afp_model");
		$this->load->model("enjoy/Regiones_model");
		$this->load->model("enjoy/Ciudades_model");
		$this->load->model("enjoy/Estado_civil_model");
		$this->load->model("enjoy/Nivel_estudios_model");
		$this->load->model("enjoy/Usu_parentesco_model");
		$this->load->model("enjoy/Profesiones_model");

		$base = array(
			'head_titulo' => "Sistema EST - Datos Trabajador",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'enjoy/trabajadores','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Crear Trabajador')),
			'js' => array('js/jquery.Rut.min.js','js/usuarios.js', 'js/confirm.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css'),
			'menu' => $this->menu
		);

		$pagina['lista_civil'] = $this->Estado_civil_model->listar();
		$pagina['lista_region'] = $this->Regiones_model->listar();
		$pagina['lista_ciudad'] = $this->Ciudades_model->listar();
		$pagina['lista_afp'] = $this->Afp_model->listar();
		$pagina['lista_salud'] = $this->Salud_model->listar();
		$pagina['lista_estudios'] = $this->Nivel_estudios_model->listar();
		$pagina['lista_parentesco'] = $this->Usu_parentesco_model->listar();
		$pagina['lista_profesiones'] = $this->Profesiones_model->listar();
		$base['cuerpo'] = $this->load->view('enjoy/trabajadores/crear_trabajador',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function detalle($id){
		$this->load->model("enjoy/Usuarios_model");
		$this->load->model("enjoy/Salud_model");
		$this->load->model("enjoy/Afp_model");
		$this->load->model("enjoy/Regiones_model");
		$this->load->model("enjoy/Ciudades_model");
		$this->load->model("enjoy/Estado_civil_model");
		$this->load->model("enjoy/Nivel_estudios_model");
		$this->load->model("enjoy/Usu_parentesco_model");
		$this->load->model("enjoy/Profesiones_model");

		$base = array(
			'head_titulo' => "Sistema EST - Datos Trabajador",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'enjoy/trabajadores','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Datos Trabajador')),
			'js' => array('js/jquery.Rut.min.js','js/usuarios.js', 'js/confirm.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css'),
			'menu' => $this->menu
		);

		$pagina['lista_bancos'] = $this->Usuarios_model->getBancos();
		$pagina['datos_usuario'] = $this->Usuarios_model->get($id);
		$pagina['lista_civil'] = $this->Estado_civil_model->listar();
		$pagina['lista_region'] = $this->Regiones_model->listar();
		$pagina['lista_ciudad'] = $this->Ciudades_model->listar();
		$pagina['lista_afp'] = $this->Afp_model->listar();
		$pagina['lista_salud'] = $this->Salud_model->listar();
		$pagina['lista_estudios'] = $this->Nivel_estudios_model->listar();
		$pagina['lista_parentesco'] = $this->Usu_parentesco_model->listar();
		$pagina['lista_profesiones'] = $this->Profesiones_model->listar();
		$pagina['id_usuario'] = $id;
		$pagina['id'] = $id;
		$usr = $this->Usuarios_model->get($id);
		$pagina['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$base['cuerpo'] = $this->load->view('enjoy/trabajadores/detalle',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function eliminar_trabajador($id_usuario){
		$this->load->model("enjoy/Usuarios_model");
		$this->Usuarios_model->eliminar($id_usuario);
		echo "<script>alert('Usuario Eliminado Exitosamente')</script>";
		redirect('enjoy/trabajadores', 'refresh');
	}

	function guardar_nuevo_trabajador(){
		$this->load->model("enjoy/Usuarios_model");
		
		if(empty($_POST['select_nac_ano']) || empty($_POST['select_nac_mes']) || empty($_POST['select_nac_dia']) )
			$nacimiento = NULL;
		else $nacimiento = $_POST['select_nac_ano'].'-'.$_POST['select_nac_mes'].'-'.$_POST['select_nac_dia'];

		$data = array(
			"rut_usuario" => $_POST['rut'],
			"nombres" => $_POST['nombres'],
			"paterno" => $_POST['paterno'],
			'materno' => $_POST['materno'],
			'email' => $_POST['email'],
			'id_nivel_estudios' => 0,
			'id_profesion' => 0,
			'id_afp' => 0,
			'id_salud' => 0,
			'id_estado_civil' => 0,
			'id_ciudad' => 0,
			'direccion' => '',
			'nacionalidad' => '',
			'talla_zapato' => '',
			'talla_buzo' => '',
			'talla_polera' => '',
			'institucion' => '',
			'ano_egreso' => '',
			'emerg_nombre' => ($_POST['emerg_nombre'])?$_POST['emerg_nombre']:NULL,
			'emerg_telefono' => ($_POST['emerg_telefono'])?$_POST['emerg_telefono']:NULL,
			'emerg_parentesco_id' => ($_POST['emerg_parentesco'])?$_POST['emerg_parentesco']:NULL,
			'fono' => $_POST['fono1'],
			'fecha_nac' => $nacimiento,
			'sexo' => ($_POST['genero'])?$_POST['genero']:0,
			'estado' => 1,
		);

		$id_usuario = $this->Usuarios_model->ingresar($data);
		redirect('enjoy/trabajadores/detalle/'.$id_usuario.'#datos-personales', 'refresh');
	}

	function guardar_personales(){
		$this->load->model("enjoy/Usuarios_model");
		$id_usuario = $_POST['id'];
		if(empty($_POST['nac_ano']) || empty($_POST['nac_mes']) || empty($_POST['nac_dia']) )
			$nacimiento = NULL;
		else $nacimiento = $_POST['nac_ano'].'-'.$_POST['nac_mes'].'-'.$_POST['nac_dia'];

		$data = array(
			"rut_usuario" => $_POST['rut'],
			"nombres" => $_POST['nombres'],
			"paterno" => $_POST['paterno'],
			'materno' => $_POST['materno'],
			'fecha_nac' => $nacimiento,
			'id_ciudad' => $_POST['select_ciudad'],
			'direccion' => $_POST['direccion'],
			'sexo' => $_POST['select_sexo'],
			'email' => $_POST['email'],
			'fono' => $_POST['fono1'],
			'id_estado_civil' => $_POST['select_civil'],
			'nacionalidad' => $_POST['select_nacionalidad']
		);

		$this->Usuarios_model->editar($id_usuario,$data);
		redirect('enjoy/trabajadores/detalle/'.$id_usuario.'#datos-personales', 'refresh');
	}

	function guardar_datos_de_emergencia(){
		$this->load->model("enjoy/Usuarios_model");
		$id_usuario = $_POST['id'];
		$data = array(
			'emerg_nombre' => ($_POST['nombres_emergencia'])?$_POST['nombres_emergencia']:NULL,
			'emerg_telefono' => ($_POST['fono_emergencia'])?$_POST['fono_emergencia']:NULL,
			'emerg_parentesco_id' => ($_POST['emerg_parentesco'])?$_POST['emerg_parentesco']:NULL,
		);
		$this->Usuarios_model->editar($id_usuario,$data);
		redirect('enjoy/trabajadores/detalle/'.$id_usuario.'#contacto-emergencia', 'refresh');
	}

	function guardar_tecnicos(){
		$this->load->model("enjoy/Usuarios_model");
		$id_usuario = $_POST['id'];
		$data = array(
			'id_nivel_estudios' => ($_POST['select_estudios'])?$_POST['select_estudios']:NULL,
			'institucion' => ($_POST['institucion'])?$_POST['institucion']:NULL,
			'ano_egreso' => ($_POST['ano_egreso'])?$_POST['ano_egreso']:NULL,
			'id_profesion' => ($_POST['select_profesiones'])?$_POST['select_profesiones']:NULL,
		);

		$this->Usuarios_model->editar($id_usuario,$data);
		redirect('enjoy/trabajadores/detalle/'.$id_usuario.'#datos-tecnicos', 'refresh');
	}

	function guardar_extra(){
		$this->load->model("enjoy/Usuarios_model");

		$id_usuario = $_POST['id'];
		$data = array(
			'id_bancos'=>$_POST['select_bancos'],
			'tipo_cuenta'=>$_POST['tipo_cuenta'],
			'cuenta_banco'=>$_POST['n_cuenta'],
			'id_afp' => $_POST['select_afp'],
			'id_salud' => $_POST['select_salud'],
			'talla_zapato' => $_POST['n_zapato'],
			'talla_buzo' => $_POST['talla_buzo'],
			'talla_polera' => $_POST['talla_polera']
		);
		$this->Usuarios_model->editar($id_usuario,$data);
		redirect('enjoy/trabajadores/detalle/'.$id_usuario.'#datos-extras', 'refresh');
	}

		function contratos_y_anexos(){
		$this->load->model("enjoy/Usuarios_model");
		$base = array(
			'head_titulo' => "EST ENJOY",
			'titulo' => "Empresas: Enjoy",
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Contratos y Anexos')),
			'side_bar' => true,
			'js' => array('js/si_exportar_excel_jquery.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-daterangepicker/daterangepicker.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','js/datePickerParaContratosAnexos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
		);
		$fecha_hoy = date('Y-m-d');
		$listado = $this->Usuarios_model->todos_los_contratos();
		//var_dump($listado);
		$listadoOpcion = array();
		if (isset($_POST['vigencia'])) {
			$pagina['inptradio'] = $_POST['vigencia'];
		}

		if (isset($_POST['nombrePlantaSeleccionada'])) {

			$pagina['plantaSeleccionada']= $_POST['nombrePlantaSeleccionada'];
			if ($_POST['nombrePlantaSeleccionada'] == 'todasLasPlantas') {
				foreach ($listado as $key) {
					if (!empty($_POST['fecha_inicio']) && !empty($_POST['fecha_termino'])) {
						$fechaFiltroInicio  = $_POST['fecha_inicio'];
						$pagina['fechaFiltroInicio'] = $fechaFiltroInicio;
						$fechaFiltroTermino = $_POST['fecha_termino'];
						$pagina['fechaFiltroTermino'] = $fechaFiltroTermino;
						$obtengoLosAnexos = $this->Usuarios_model->todos_los_anexos($key->usuario_id, $key->idRequerimientoAsociado);
						if (!empty($obtengoLosAnexos)) {//si tiene anexo
							$url = isset($obtengoLosAnexos->url)?$obtengoLosAnexos->url:'';
							$fecha_termino = isset($obtengoLosAnexos->fecha_termino)?$obtengoLosAnexos->fecha_termino:'';
							$tipo_archivo = isset($obtengoLosAnexos->tipo_archivo_requerimiento_id)?$obtengoLosAnexos->tipo_archivo_requerimiento_id:'';
						}else{//si no tiene  anexo
							$url = isset($key->url)?$key->url:'';
							$fecha_termino = isset($key->fecha_termino)?$key->fecha_termino:'';
							$tipo_archivo = isset($key->tipo_archivo)?$key->tipo_archivo:'';
						}
						if ($fecha_termino >= $fechaFiltroInicio && $fecha_termino <= $fechaFiltroTermino) {
							$aux = new stdClass();
								$aux->tipo_archivo = $tipo_archivo;
								$aux->usuario_id = $key->usuario_id;
								$aux->url = $url; // varia si tiene anexo
								$aux->causal = $key->causal;
								$aux->motivo = $key->motivo;
								$aux->fecha_inicio = $key->fecha_inicio;
								$aux->fecha_termino = $fecha_termino; // varia si tiene anexo
								$aux->jornada = $key->jornada;
								$aux->renta_imponible = $key->renta_imponible;
							//	$aux->bono_responsabilidad = $key->bono_responsabilidad;
							//	$aux->sueldo_base_mas_bonos_fijos = $key->sueldo_base_mas_bonos_fijos;
								$aux->asignacion_colacion = $key->asignacion_colacion;
							//	$aux->otros_no_imponibles = $key->otros_no_imponibles;
								$aux->seguro_vida_arauco = $key->seguro_vida_arauco;
								$aux->nombre_usuario = $key->nombre_usuario;
								$aux->paterno = $key->paterno;
								$aux->materno = $key->materno;
								$aux->rut_usuario = $key->rut_usuario;
								$aux->referido = $key->referido;
								$aux->codigo_requerimiento = $key->codigo_requerimiento;
								$aux->nombre_req = $key->nombre_req;
								$aux->f_solicitud = $key->f_solicitud;
								$aux->fecha_inicio_req = $key->fecha_inicio_req;
								$aux->f_fin_req = $key->f_fin_req;
								$aux->nombre_empresa = $key->nombre_empresa;
								$aux->nombre_area = $key->nombre_area;
								$aux->nombre_cargo = $key->nombre_cargo;
								array_push($listadoOpcion,$aux);
								unset($aux);
						}
						
					}
					if (isset($_POST['estado'])) {
						$pagina['estado'] = $_POST['estado'];

						if($_POST['estado'] =='vigente'){	
							$obtengoLosAnexos = $this->Usuarios_model->todos_los_anexos($key->usuario_id, $key->idRequerimientoAsociado);
							if (!empty($obtengoLosAnexos)) {//si tiene anexo
								$url = isset($obtengoLosAnexos->url)?$obtengoLosAnexos->url:'';
								$fecha_termino = isset($obtengoLosAnexos->fecha_termino)?$obtengoLosAnexos->fecha_termino:'';
								$tipo_archivo = isset($obtengoLosAnexos->tipo_archivo_requerimiento_id)?$obtengoLosAnexos->tipo_archivo_requerimiento_id:'';
							}else{//si no tiene  anexo
								$url = isset($key->url)?$key->url:'';
								$fecha_termino = isset($key->fecha_termino)?$key->fecha_termino:'';
								$tipo_archivo = isset($key->tipo_archivo)?$key->tipo_archivo:'';
							}
							if ($fecha_termino >= $fecha_hoy) {
								$aux = new stdClass();
									$aux->tipo_archivo = $tipo_archivo;
									$aux->usuario_id = $key->usuario_id;
									$aux->url = $url; // varia si tiene anexo
									$aux->causal = $key->causal;
									$aux->motivo = $key->motivo;
									$aux->fecha_inicio = $key->fecha_inicio;
									$aux->fecha_termino = $fecha_termino; // varia si tiene anexo
									$aux->jornada = $key->jornada;
									$aux->renta_imponible = $key->renta_imponible;
								//	$aux->bono_responsabilidad = $key->bono_responsabilidad;
								//	$aux->sueldo_base_mas_bonos_fijos = $key->sueldo_base_mas_bonos_fijos;
									$aux->asignacion_colacion = $key->asignacion_colacion;
								//	$aux->otros_no_imponibles = $key->otros_no_imponibles;
									$aux->seguro_vida_arauco = $key->seguro_vida_arauco;
									$aux->nombre_usuario = $key->nombre_usuario;
									$aux->paterno = $key->paterno;
									$aux->materno = $key->materno;
									$aux->rut_usuario = $key->rut_usuario;
									$aux->referido = $key->referido;
									$aux->codigo_requerimiento = $key->codigo_requerimiento;
									$aux->nombre_req = $key->nombre_req;
									$aux->f_solicitud = $key->f_solicitud;
									$aux->fecha_inicio_req = $key->fecha_inicio_req;
									$aux->f_fin_req = $key->f_fin_req;
									$aux->nombre_empresa = $key->nombre_empresa;
									$aux->nombre_area = $key->nombre_area;
									$aux->nombre_cargo = $key->nombre_cargo;
									array_push($listadoOpcion,$aux);
									unset($aux);
							}
						}

						if($_POST['estado'] =='no_vigente'){
							$obtengoLosAnexos = $this->Usuarios_model->todos_los_anexos($key->usuario_id, $key->idRequerimientoAsociado);
							if (!empty($obtengoLosAnexos)) {//si tiene anexo
									$url = isset($obtengoLosAnexos->url)?$obtengoLosAnexos->url:'';
									$fecha_termino = isset($obtengoLosAnexos->fecha_termino)?$obtengoLosAnexos->fecha_termino:'';
									$tipo_archivo = isset($obtengoLosAnexos->tipo_archivo_requerimiento_id)?$obtengoLosAnexos->tipo_archivo_requerimiento_id:'';
							}else{//si no tiene  anexo
									$url = isset($key->url)?$key->url:'';
									$fecha_termino = isset($key->fecha_termino)?$key->fecha_termino:'';
									$tipo_archivo = isset($key->tipo_archivo)?$key->tipo_archivo:'';
							}
							if ($fecha_termino < $fecha_hoy) { // NO VIGENTE Fecha termino contrato inferior a la fecha actual
								$aux = new stdClass();
									$aux->tipo_archivo = $tipo_archivo;
									$aux->usuario_id = $key->usuario_id;
									$aux->url = $url; // varia si tiene anexo
									$aux->causal = $key->causal;
									$aux->motivo = $key->motivo;
									$aux->fecha_inicio = $key->fecha_inicio;
									$aux->fecha_termino = $fecha_termino; // varia si tiene anexo
									$aux->jornada = $key->jornada;
									$aux->renta_imponible = $key->renta_imponible;
								//	$aux->bono_responsabilidad = $key->bono_responsabilidad;
								//	$aux->sueldo_base_mas_bonos_fijos = $key->sueldo_base_mas_bonos_fijos;
									$aux->asignacion_colacion = $key->asignacion_colacion;
								//	$aux->otros_no_imponibles = $key->otros_no_imponibles;
									$aux->seguro_vida_arauco = $key->seguro_vida_arauco;
									$aux->nombre_usuario = $key->nombre_usuario;
									$aux->paterno = $key->paterno;
									$aux->materno = $key->materno;
									$aux->rut_usuario = $key->rut_usuario;
									$aux->referido = $key->referido;
									$aux->codigo_requerimiento = $key->codigo_requerimiento;
									$aux->nombre_req = $key->nombre_req;
									$aux->f_solicitud = $key->f_solicitud;
									$aux->fecha_inicio_req = $key->fecha_inicio_req;
									$aux->f_fin_req = $key->f_fin_req;
									$aux->nombre_empresa = $key->nombre_empresa;
									$aux->nombre_area = $key->nombre_area;
									$aux->nombre_cargo = $key->nombre_cargo;
									array_push($listadoOpcion,$aux);
									unset($aux);
							}	
						}
					}

				}
			}
		}

		//$pagina['plantas']= $this->Requerimientos_model->getFaenas();
		$pagina['listado']= $listadoOpcion;	
		$base['cuerpo'] = $this->load->view('enjoy/trabajadores/base_datos_contratos_y_anexos',$pagina,TRUE);
	 	$this->load->view('layout2.0/layout',$base);
	}
	
/*	function exportar_excel_contratos_y_anexos(){
		header("Content-type: application/vnd.ms-excel; name='excel'");
		header("Content-Disposition: filename=ficheroExcel.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $_POST['datos_a_enviar'];
	}*/
	/*Lista negra*/

	function anotaciones($id){
		$this->load->model("enjoy/Usuarios_model");
		$this->load->model("enjoy/Salud_model");
		$this->load->model("enjoy/Afp_model");
		$this->load->model("enjoy/Ciudades_model");
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> Enjoy',
			'side_bar' => true,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','js/anotaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'enjoy/trabajadores','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Anotaciones')),
			'menu' => $this->menu
		);
		$pagina ="";
		$pagina['usuario'] =$this->Usuarios_model->get($id);
		$pagina['listado'] = $this->Usuarios_model->getListaNegraTrabajador($id);
		$base['cuerpo'] = $this->load->view('trabajadores/anotaciones',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}


	function guardar_anotacion($id){
		$this->load->model("enjoy/Usuarios_model");
		$tipo = $_POST['tipo'];
		$fecha = $_POST['fecha'];
		$fecha = explode('-', $fecha);
		$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
		$texto = $_POST['texto'];
		$quien = $this->session->userdata('nombres');
		$usuario = $this->Usuarios_model->get($id);
		$aux = str_replace(" ", "_", $usuario->nombres);
		$ape = $aux."_".$usuario->paterno.'_'.$usuario->materno;
		$data = array(
			'id_usuario' => $id,
			'tipo' => $tipo,
			'fecha' => $fecha,
			'anotacion' => $texto,
			'quien' => $quien,
			);
		$this->Usuarios_model->ingresarListaNegra($data);
		redirect('enjoy/trabajadores/anotaciones/'.$id, 'refresh');
	}

	function eliminar_anotacion($id_usuario,$id_anotacion){
		$this->load->model("enjoy/Usuarios_model");
		$id = $this->session->userdata('id');
		$data = array('usuarioElimino'=>$id);
		$this->Usuarios_model->eliminarListaNegra($id_anotacion);
		redirect('enjoy/trabajadores/anotaciones/'.$id_usuario, 'refresh');
	}
	/*END Lista Negra*/

	/*Observacion*/

	function guardarObservacion($id){
		$this->load->model('enjoy/Usuarios_model');
		$observacion =$_POST['datos'];
        $data = array(
         	'observacion'=> $observacion,
         );
      	$ok = $this->Usuarios_model->guardarAnotacion($id,$data);  
      	if ($ok == 1 ) {
	      	$data = array(
	         	'usuario_observacion'=>$this->session->userdata('nombres'),
	         );
	      	$this->Usuarios_model->guardarAnotacion($id,$data);
      	}
		echo json_encode($ok);
	}

	function eliminar_observacion($id){
		$this->load->model('enjoy/Usuarios_model');
		$data = array(
			'observacion'=>null,
			'usuario_observacion'=>null,
			);
		$resultado =$this->Usuarios_model->guardarAnotacion($id, $data);
		echo json_encode($resultado);
	}

}
?>