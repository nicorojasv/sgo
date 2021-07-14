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
			$this->menu = $this->load->view('layout2.0/menus/aramark_menu_admin','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 18)
			$this->menu = $this->load->view('layout2.0/menus/menu_carrera','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 4)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_externo','',TRUE);
		elseif( $this->session->userdata('id') == 120)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_psicologo','',TRUE);
		elseif( $this->session->userdata('id') == 39)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif( $this->session->userdata('id') == 97)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/Salud_model");
		$this->load->model("carrera/Afp_model");
		$this->load->model("carrera/ciudades_model");
		$this->load->model("Profesiones_model");
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> carrera',
			'side_bar' => true,
			'js' => array('js/validar_rut_op.js','plugins/flatpickr/flatpickr.js','js/crud_agregar_usuario.js','js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js','js/exportarExcelaramark.js'),
			'css' => array('plugins/flatpickr/flatpickr.min.css','plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Listado Trabajadores') ),
			'menu' => $this->menu
		);
		$lista = array();
		foreach($this->Usuarios_model->listar_activos() as $l){
			$aux = new stdClass();

			$id_ciudad = $l->id_ciudad;
			$id_salud = $l->id_salud;
			$id_afp = $l->id_afp;

			$get_ciudad = $this->ciudades_model->get($id_ciudad);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_afp = $this->Afp_model->get($id_afp);
			$listaNegra = $this->Usuarios_model->getListaNegraTrabajador($l->id);
			$aux->listaNegra = $listaNegra;
			$aux->id_usuario = $l->id;
			$aux->rut_usuario = $l->rut_usuario;
			$aux->nombres = $l->nombres;
			$aux->paterno = $l->paterno;
			$aux->materno = $l->materno;
			$aux->fono = $l->fono;
			$aux->fecha_nac = $l->fecha_nac;
			$aux->direccion = $l->direccion;
			$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
			$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
			$aux->afp = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
			$aux->estado = $l->estado;
			array_push($lista,$aux);
			unset($aux);
		}
        $pagina['lista_profesiones'] = $this->Profesiones_model->listar();
		$pagina['listado'] = $lista;
		$base['cuerpo'] = $this->load->view('carrera/trabajadores/listado_general',$pagina,TRUE);
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
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/Salud_model");
		$this->load->model("carrera/Afp_model");
		$this->load->model("carrera/Regiones_model");
		$this->load->model("carrera/ciudades_model");
		$this->load->model("carrera/Estado_civil_model");
		$this->load->model("carrera/Nivel_estudios_model");
		$this->load->model("carrera/Usu_parentesco_model");
		$this->load->model("carrera/Profesiones_model");

		$base = array(
			'head_titulo' => "Sistema EST - Datos Trabajador",
			'titulo' => "Empresa:  carrera S.A.",
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'|/trabajadores','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Crear Trabajador')),
			'js' => array('js/validar_rut_op2.js','plugins/flatpickr/flatpickr.js','js/crud_agregar_usuario.js','js/jquery.Rut.min.js','js/usuarios2.js', 'js/confirm.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js','js/si_validaciones.js'),
			'css' => array('plugins/flatpickr/flatpickr.min.css','plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css'),
			'menu' => $this->menu
		);

		$pagina['lista_civil'] = $this->Estado_civil_model->listar();
		$pagina['lista_region'] = $this->Regiones_model->listar();
		$pagina['lista_ciudad'] = $this->ciudades_model->listar();
		$pagina['lista_afp'] = $this->Afp_model->listar();
		$pagina['lista_salud'] = $this->Salud_model->listar();
		$pagina['lista_estudios'] = $this->Nivel_estudios_model->listar();
		$pagina['lista_parentesco'] = $this->Usu_parentesco_model->listar();
		$pagina['lista_profesiones'] = $this->Profesiones_model->listar();
		$base['cuerpo'] = $this->load->view('carrera/trabajadores/crear_trabajador',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function detalle($id){
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/Salud_model");
		$this->load->model("carrera/Afp_model");
		$this->load->model("carrera/Regiones_model");
		$this->load->model("carrera/ciudades_model");
		$this->load->model("carrera/Estado_civil_model");
		$this->load->model("carrera/Nivel_estudios_model");
		$this->load->model("carrera/Usu_parentesco_model");
		$this->load->model("carrera/Profesiones_model");
		$this->load->model("carrera/Archivos_trab_model");
		$this->load->model("carrera/Evaluaciones_model");
		$this->load->model("carrera/Tipoarchivos_model");

		$base = array(
			'head_titulo' => "Sistema EST - Datos Trabajador",
			'titulo' => "Empresa:carrera S.A.",
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/trabajadores','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Datos Trabajador')),
			'js' => array('js/usuarios2.js','js/validar_rut_op.js','plugins/flatpickr/flatpickr.js','js/crud_agregar_usuario.js','js/jquery.Rut.min.js','js/usuarios.js', 'js/confirm.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js','js/si_validaciones.js'),
			'css' => array('plugins/flatpickr/flatpickr.min.css','plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css'),
			'menu' => $this->menu
		);

        $pagina['lista_archivos'] = $this->Tipoarchivos_model->listar();
		$pagina['lista_bancos'] = $this->Usuarios_model->getBancos();
		$pagina['datos_usuario'] = $this->Usuarios_model->get($id);
		$pagina['lista_civil'] = $this->Estado_civil_model->listar();
		$pagina['lista_region'] = $this->Regiones_model->listar();
		$pagina['lista_ciudad'] = $this->ciudades_model->listar();
		$pagina['lista_afp'] = $this->Afp_model->listar();
		$pagina['lista_salud'] = $this->Salud_model->listar();
		$pagina['lista_estudios'] = $this->Nivel_estudios_model->listar();
		$pagina['lista_parentesco'] = $this->Usu_parentesco_model->listar();
		$pagina['lista_profesiones'] = $this->Profesiones_model->listar();
		$pagina['lista_archivos_subidos'] = $this->Archivos_trab_model->get_usuario($id);
		$eval = $this->Evaluaciones_model->get_all($id);
		$pagina['listado'] = $eval;
		$pagina['id_usuario'] = $id;
		$pagina['id'] = $id;
		$usr = $this->Usuarios_model->get($id);
		$pagina['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$base['cuerpo'] = $this->load->view('carrera/trabajadores/detalle',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function eliminar_trabajador($id_usuario){
		$this->load->model("carrera/Usuarios_model");
		$this->Usuarios_model->eliminar($id_usuario);
		echo "<script>alert('Usuario Eliminado Exitosamente')</script>";
		redirect('carrera/trabajadores', 'refresh');
	}

	function guardar_nuevo_trabajador(){
		$this->load->model("carrera/Usuarios_model");
		
		if(empty($_POST['nac_ano']) || empty($_POST['nac_mes']) || empty($_POST['nac_dia']) )
			$nacimiento = NULL;
		else
			$nacimiento = $_POST['nac_ano'].'-'.$_POST['nac_mes'].'-'.$_POST['nac_dia'];


		$data = array(
			"rut_usuario" => $_POST['rut'],
			'fecha_nac' => $_POST['fecha_nacimiento'],
			"nombres" => $_POST['nombres'],
			"paterno" => $_POST['paterno'],
			'materno' => $_POST['materno'],
			"id_regiones" => $_POST['select_region'],
			"id_ciudad" => $_POST['select_ciudad'],
			"direccion" => $_POST['direccion'],
			"sexo" => ($_POST['select_sexo'])?$_POST['select_sexo']:0,
			"fono" => $_POST['fono1'],
			"telefono2" => $_POST['fono3'],
			"email" => $_POST['email'],
			"id_estado_civil" => $_POST['select_civil'],
			"nacionalidad" => $_POST['select_nacionalidad'],
			'id_nivel_estudios' => 0,
			'id_profesion' => 0,
			'id_afp' => 0,
			'id_salud' => 0,
			'talla_zapato' => '',
			'talla_buzo' => '',
			'talla_polera' => '',
			'institucion' => '',
			'ano_egreso' => '',	
			'estado' => 1,
		);

		$id_usuario = $this->Usuarios_model->ingresar($data);
		redirect('carrera/trabajadores/detalle/'.$id_usuario.'#datos-personales', 'refresh');
	}

	function guardar_personales(){
		$this->load->model("carrera/Usuarios_model");
		$id_usuario = $_POST['id'];
		if(empty($_POST['nac_ano']) || empty($_POST['nac_mes']) || empty($_POST['nac_dia']) )
			$nacimiento = NULL;
		else $nacimiento = $_POST['nac_ano'].'-'.$_POST['nac_mes'].'-'.$_POST['nac_dia'];

		$data = array(
			"rut_usuario" => $_POST['rut'],
			"nombres" => $_POST['nombres'],
			"paterno" => $_POST['paterno'],
			'materno' => $_POST['materno'],
			'fecha_nac' => $_POST['fecha_nacimiento'],
			'id_ciudad' => $_POST['select_ciudad'],
			'direccion' => $_POST['direccion'],
			'sexo' => $_POST['select_sexo'],
			'email' => $_POST['email']
,			'fono' => $_POST['fono1'],
			'telefono2' => $_POST['fono2'],
			'id_estado_civil' => $_POST['select_civil'],
			'nacionalidad' => $_POST['select_nacionalidad']
		);

		$this->Usuarios_model->editar($id_usuario,$data);
		echo "<script>alert('Los datos se actualizaron exitosamente')</script>";
		redirect('carrera/trabajadores/detalle/'.$id_usuario.'#datos-personales', 'refresh');
	}

	function guardar_datos_de_emergencia(){
		$this->load->model("carrera/Usuarios_model");
		$id_usuario = $_POST['id'];
		$data = array(
			'emerg_nombre' => ($_POST['nombres_emergencia'])?$_POST['nombres_emergencia']:NULL,
			'emerg_telefono' => ($_POST['fono_emergencia'])?$_POST['fono_emergencia']:NULL,
			'emerg_parentesco_id' => ($_POST['emerg_parentesco'])?$_POST['emerg_parentesco']:NULL,
		);
		$this->Usuarios_model->editar($id_usuario,$data);
		redirect('carrera/trabajadores/detalle/'.$id_usuario.'#contacto-emergencia', 'refresh');
	}

	function guardar_tecnicos(){
		$this->load->model("carrera/Usuarios_model");
		$id_usuario = $_POST['id'];
		$data = array(
			'id_nivel_estudios' => ($_POST['select_estudios'])?$_POST['select_estudios']:NULL,
			'institucion' => ($_POST['institucion'])?$_POST['institucion']:NULL,
			'ano_egreso' => ($_POST['ano_egreso'])?$_POST['ano_egreso']:NULL,
			'id_profesion' => ($_POST['select_profesiones'])?$_POST['select_profesiones']:NULL,
		);

		$this->Usuarios_model->editar($id_usuario,$data);
		redirect('carrera/trabajadores/detalle/'.$id_usuario.'#datos-tecnicos', 'refresh');
	}

	function guardar_extra(){
		$this->load->model("carrera/Usuarios_model");

		$id_usuario = $_POST['id'];
		$data = array(
			'id_bancos'=>$_POST['select_bancos'],
			'tipo_cuenta'=>$_POST['tipo_cuenta'],
			'cuenta_banco'=>$_POST['n_cuenta'],
			'id_afp' => $_POST['select_afp'],
			'id_salud' => $_POST['select_salud'],
			'uf_pactada' => $_POST['uf_pactada'],
			'licencia' => $_POST['licencia'],
			'num_zapato' => $_POST['n_zapato'],
			'talla_buzo' => $_POST['talla_buzo'],
			
		);
		$this->Usuarios_model->editar($id_usuario,$data);
		redirect('carrera/trabajadores/detalle/'.$id_usuario.'#datos-extras', 'refresh');
	}

		function contratos_y_anexos(){
		$this->load->model("carrera/Usuarios_model");
		$base = array(
			'head_titulo' => "EST carrera",
			'titulo' => "Empresas: carrera",
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
		$base['cuerpo'] = $this->load->view('carrera/trabajadores/base_datos_contratos_y_anexos',$pagina,TRUE);
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
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/Salud_model");
		$this->load->model("carrera/Afp_model");
		$this->load->model("carrera/ciudades_model");
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> carrera',
			'side_bar' => true,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js','js/ui-subview.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','js/anotaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/trabajadores','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Anotaciones')),
			'menu' => $this->menu
		);
		$pagina ="";
		$pagina['usuario'] =$this->Usuarios_model->get($id);
		$pagina['listado'] = $this->Usuarios_model->getListaNegraTrabajador($id);
		$base['cuerpo'] = $this->load->view('trabajadores/anotaciones',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_anotacion($id){
		$this->load->model("carrera/Usuarios_model");
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
		redirect('carrera/trabajadores/anotaciones/'.$id, 'refresh');
	}

	function eliminar_anotacion($id_usuario,$id_anotacion){
		$this->load->model("carrera/Usuarios_model");
		$id = $this->session->userdata('id');
		$data = array('usuarioElimino'=>$id);
		
		$this->Usuarios_model->eliminarListaNegra($id_anotacion);
		redirect('carrera/trabajadores/anotaciones/'.$id_usuario, 'refresh');
	}
	/*END Lista Negra*/
	function crear_examen($id,$id_evaluacion=FALSE){
		$this->load->model("carrera/Cargos_model");
		$this->load->model("carrera/Empresa_planta_model");
		$this->load->model("carrera/Evaluaciones_model");
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/Evaluacionestipo_model");
		$this->load->model("carrera/Evaluacionesevaluacion_model");
		$this->load->model("carrera/Evaluacionesbaterias_model");
		$this->load->model("carrera/Evaluacionescargos_model");
		$usr = $this->Usuarios_model->get($id);
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: carrera S.A.",
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/trabajadores/detalle/'.$id.'','txt'=>'Datos Trabajador '.$usr->nombres.'' ), array('url'=>'','txt'=>'Agregar Examen Preocupacional' )),
			'js' => array('js/jquery.Rut.min.js','js/usuarios.js', 'js/examen_preo_masso.js', 'js/confirm.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css'),
			'menu' => $this->menu
		);

		if( $usr->fecha_nac ){
			$fecha_cumple = time() - strtotime($usr->fecha_nac);
			$edad = floor((($fecha_cumple / 3600) / 24) / 360);
			$pagina['edad'] = $edad.' Años';
		}
		else
			$pagina['edad'] = "No esta ingresada la fecha de nacimiento";

		$cargos_aptos = $this->Cargos_model->r_listar();
		$lista_aux = array();
		if (!empty($cargos_aptos)){
			foreach ($cargos_aptos as $cga){
				$aux = new stdClass();
				$aux->id_r_cargo = $cga->id;
				$aux->nombre_r_cargo = $cga->nombre;

				$get_estado = $this->Evaluacionescargos_model->get($cga->id, $id_evaluacion);
				$aux->estado = isset($get_estado->id)?'1':'0';
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}

		$pagina['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$pagina['id'] = $id;
		$pagina['rut'] = $usr->rut_usuario;
		$pagina['tipo'] = $this->Evaluacionestipo_model->listar();
		$pagina['eval'] = ( $id_evaluacion )? $this->Evaluaciones_model->get($id_evaluacion) : false;
		$pagina['bat'] = ( $id_evaluacion )? $this->Evaluacionesbaterias_model->get_eval($id_evaluacion) : false;
		$pagina['empresa_planta'] = $this->Empresa_planta_model->listar();
		$pagina['evaluaciones'] = $this->Evaluacionesevaluacion_model->get_tipo(2);
		$pagina['r_cargos'] = $lista_aux;
		$base['cuerpo'] = $this->load->view('carrera/trabajadores/crear_examen',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}


	function guardar_creacion_eval($id_usr, $id_evalua=FALSE){
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/Evaluaciones_model");
		$this->load->model("carrera/Evaluacionesarchivo_model");
		$this->load->model("carrera/Evaluacionesbaterias_model");
		$this->load->model("carrera/Evaluacionescargos_model");
		$this->load->helper("archivo");

		if(empty($id_usr)){
			redirect('carrera/trabajadores/detalle/'.$id_usr.'#datos-examenes', 'refresh');
		}

		$id_evaluacion = $_POST['id_ee'];
		$fecha_e = $_POST['ano_e'].'-'.$_POST['mes_e'].'-'.$_POST['dia_e'];
		if(isset($_POST['ano_v']) && isset($_POST['mes_v']) && isset($_POST['dia_v'])){
		$fecha_v = $_POST['ano_v'].'-'.$_POST['mes_v'].'-'.$_POST['dia_v'];}
		else {$fecha_v = '0000-00-00';}

		$ultimo_id =$this->Evaluaciones_model->ultimo_id_eval();

		if(isset($_POST['resultado_cualitativo'])){
			$get_resultado = $_POST['resultado_cualitativo'];
			if($get_resultado == 0 or $get_resultado == 1){
				$resultado = $_POST['resultado_cualitativo'];
			}else{
				$resultado = 2;
			}

			if($get_resultado == 2){
				$asiste_examen = 0;
			}elseif($get_resultado == 0 or $get_resultado == 1){
				$asiste_examen = 1;
			}else{
				$asiste_examen = NULL;
			}
		}else{
			$resultado = 2;
			$asiste_examen = 0;
		}

		if($_POST['id_ee'] == 4 || $_POST['id_ee'] == 20){
			$arr = array(
				'id_usuarios' => $id_usr,
				'id_evaluacion' => $_POST['id_ee'],
				'observaciones' => trim( mb_strtoupper($_POST['obs'], 'UTF-8')),
				'resultado' => $resultado,
				'recomienda' => ( !empty($_POST['recomienda']))?$_POST['recomienda']:NULL,
				'fecha_e' => $fecha_e,
				'fecha_v' => $fecha_v,
				'pago' => $_POST['pago'],
				'valor_examen' => (!empty($_POST['valor_examen']))?$_POST['valor_examen']:'0',
				'indice_ganancia' => (!empty($_POST['indice_ganancia']))?$_POST['indice_ganancia']:'0',
				'oc' => (!empty($_POST['oc']))?$_POST['oc']:NULL,
				'ccosto' => (!empty($_POST['ccosto']))?$_POST['ccosto']:NULL,
				'ciudadch' =>  (!empty($_POST['ciudadch']))?$_POST['ciudadch']:NULL,
				'examen_referido' =>  (!empty($_POST['referido']))?$_POST['referido']:'0',
				'asistencia_examen' =>  $asiste_examen
			);
		}else{
			$arr = array(
				'id_usuarios' => $id_usr,
				'id_evaluacion' => $_POST['id_ee'],
				'observaciones' => trim( mb_strtoupper($_POST['obs'], 'UTF-8')),
				'resultado' => $resultado,
				'recomienda' => ( !empty($_POST['recomienda']))?$_POST['recomienda']:'NULL',
				'valor_examen' => (!empty($_POST['valor_examen']))?$_POST['valor_examen']:'0',
				'indice_ganancia' => (!empty($_POST['indice_ganancia']))?$_POST['indice_ganancia']:'0',
				'ccosto' => (!empty($_POST['ccosto']))?$_POST['ccosto']:'NULL',
				'fecha_e' => $fecha_e,
				'fecha_v' => $fecha_v,
				'pago' => $_POST['pago'],
				'examen_referido' =>  (!empty($_POST['referido']))?$_POST['referido']:'0',
				'asistencia_examen' =>  $asiste_examen
			);
		}

		if($id_evalua){
			$id_eval = $id_evalua;
			$this->Evaluaciones_model->editar($id_evalua,$arr);
		}else{
			$get_ultimo_id = array('id' => $ultimo_id);
			$get_arr = array_merge($arr, $get_ultimo_id);
			$this->Evaluaciones_model->ingresar($get_arr);
			$id_eval = $ultimo_id;
		}

		if($_FILES['docu']['error'] == 0){
			$salida = subir($_FILES,"docu","extras/evaluaciones/");
			if($salida == 1)
				redirect('carrera/trabajadores/detalle/'.$id_usr.'#datos-examenes', 'refresh');
				//redirect('/est/trabajadores/buscar_js', 'refresh');
			elseif($salida==2)
				redirect('carrera/trabajadores/detalle/'.$id_usr.'#datos-examenes', 'refresh');
				//redirect('est/trabajadores/buscar_js', 'refresh');
			else{
				$data = array(
					'id_evaluacion' => $id_eval,
					'url' => $salida
				);
				$this->Evaluacionesarchivo_model->ingresar($data);
			}
		}

		if($_POST['id_ee'] == 3){
			if( $id_evalua )
				$this->Evaluacionesbaterias_model->eliminar_eval($id_evalua);

			$baterias = (isset($_POST['baterias'])?"1":"0");

			if($baterias == 1){
				foreach ($_POST['baterias'] as $b) {
					$dat = array(
						'evaluaciones_id' => $id_eval,
						'nombre' => $b
					);
					$this->Evaluacionesbaterias_model->ingresar($dat);
				}
			}

			if( $id_evalua )
				$this->Evaluacionescargos_model->eliminar_eval($id_evalua);

			$cargos_aptos = (isset($_POST['cargos_aptos'])?"1":"0");

			if($cargos_aptos == 1){
				foreach ($_POST['cargos_aptos'] as $cg){
					$cargos = array(
						'id_evaluacion' => $id_eval,
						'id_r_cargo' => $cg
					);

					$this->Evaluacionescargos_model->ingresar($cargos);
				}
			}
		}

		$get_cantidad = $this->Usuarios_model->contar_evaluaciones_user($id_usr, $_POST['id_ee']);
		$total_examenes = isset($get_cantidad->total)?$get_cantidad->total:0;
		if($total_examenes >= 1){
			$get_ultimo = $this->Usuarios_model->id_maximo_examenes_user($id_usr, $_POST['id_ee']);
			$this->Usuarios_model->actualizar_desactivo_estado_preo($id_usr, $_POST['id_ee']);
			$this->Usuarios_model->actualizar_activo_estado_preo($get_ultimo->ultimo);
		}
		redirect('carrera/trabajadores/detalle/'.$id_usr.'#datos-examenes', 'refresh');
	}

	function listado_solicitudes_revision_examenes(){
		$this->load->model('carrera/Requerimiento_asc_trabajadores_model');
		$this->load->model('carrera/Solicitud_revision_examenes_model');
		$this->load->model('carrera/Solicitud_revision_examenes_previos_model');
		$this->load->model('carrera/Usuarios_model');
		$this->load->model('carrera/ciudades_model');
		$this->load->model('carrera/Cargos_model');
		$this->load->model('carrera/Empresa_planta_model');
		$this->load->model('carrera/Requerimientos_model');
		$this->load->model('carrera/Evaluaciones_model');
		$this->load->model('carrera/Sre_evaluacion_req_model');
		$this->load->model('carrera/Sre_evaluacion_req_agenda_model');

		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Solicitudes revision de examenes pendientes",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/trabajadores/buscar_js','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Listado Trabajadores Revision Examenes Pendientes' ) ),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$usuarios = $this->Solicitud_revision_examenes_model->get_result_en_proceso();
		$lista = array();
		foreach ($usuarios as $l){
			$aux = new stdClass();

			$proceso_completo = 0;

			$get_usu = $this->Usuarios_model->get($l->usuario_id);
			$ciudad = $this->ciudades_model->get($get_usu->id_ciudad);
			$get_ultimo_req = $this->Requerimiento_asc_trabajadores_model->get_area_cargo_req_row($l->id_asc_trabajador);

			$nombre = isset($get_usu->nombres)?$get_usu->nombres:"";
			$paterno = isset($get_usu->paterno)?$get_usu->paterno:"";
			$materno = isset($get_usu->materno)?$get_usu->materno:"";
			$aux->id_solicitud = $l->id;
			$aux->usuario_id = $l->usuario_id;
			$aux->rut = isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"";
			$aux->nombres = $nombre." ".$paterno." ".$materno;
			$aux->fono = isset($get_usu->fono)?$get_usu->fono:"";
			$aux->fecha_nac = isset($get_usu->fecha_nac)?$get_usu->fecha_nac:"";
			$aux->desc_ciudades = isset($ciudad->desc_ciudades)?ucwords(mb_strtolower($ciudad->desc_ciudades,'UTF-8')):"";
			$aux->id_asc_trab = isset($l->id_asc_trabajador)?$l->id_asc_trabajador:"";
			$aux->referido = isset($get_ultimo_req->referido)?$get_ultimo_req->referido:NULL;
			$aux->nombre_cargo = isset($get_ultimo_req->nombre_cargo)?$get_ultimo_req->nombre_cargo:"";
			$aux->nombre_area = isset($get_ultimo_req->nombre_area)?$get_ultimo_req->nombre_area:"";
			$aux->id_req = isset($get_ultimo_req->id_req)?$get_ultimo_req->id_req:"";
			$aux->nombre_req = isset($get_ultimo_req->nombre_req)?$get_ultimo_req->nombre_req:"";
			$aux->empresa_planta = isset($get_ultimo_req->empresa_planta)?$get_ultimo_req->empresa_planta:"";
			$aux->fecha_solicitud = isset($l->fecha_solicitud)?$l->fecha_solicitud:"";
			$aux->fecha_esperada_ingreso = isset($l->fecha_esperada_ingreso)?$l->fecha_esperada_ingreso:"";
			$aux->observaciones = isset($l->observaciones)?$l->observaciones:"";
			$aux->examen_preo = isset($l->exam_preo)?$l->exam_preo:0;
			$aux->examen_masso = isset($l->exam_masso)?$l->exam_masso:0;
			$aux->examen_psicologico = isset($l->exam_psicologico)?$l->exam_psicologico:0;

			$examen_masso = isset($l->exam_masso)?$l->exam_masso:0;
			$examen_preo = isset($l->exam_preo)?$l->exam_preo:0;
			$examen_psicologico = isset($l->exam_psicologico)?$l->exam_psicologico:0;

			//Inicio validacion examen masso
			if($examen_masso != 0){
				$masso = $this->Evaluaciones_model->get_una_masso($l->usuario_id);
				$aux->masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
				$masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
				$estado_masso = isset($masso->estado_masso)?$masso->estado_masso:NULL;

				if($masso_id != ""){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $masso_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $masso_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 1,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $masso_id);
					$aux->sre_eval_req_id_masso = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado == 0){
						$aux->color_estado_eval_sre_masso = "#D7DF01";
						$aux->letra_estado_eval_sre_masso = "EP";
						$proceso_completo += 1;
					}elseif($sre_eval_req_estado == 1){
						$aux->color_estado_eval_sre_masso = "green";
						$aux->letra_estado_eval_sre_masso = "A";
					}elseif($sre_eval_req_estado == 2){
						$aux->color_estado_eval_sre_masso = "red";
						$aux->letra_estado_eval_sre_masso = "R";
					}elseif($sre_eval_req_estado == 3){
						$aux->color_estado_eval_sre_masso = "#886A08";
						$aux->letra_estado_eval_sre_masso = "NA";
					}else{
						$aux->color_estado_eval_sre_masso = "";
						$aux->letra_estado_eval_sre_masso = "";
						$proceso_completo += 1;
					}
				}else{
					$get_agenda_masso = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 1);
					$aux->id_sre_agenda_masso = isset($get_agenda_masso->id)?$get_agenda_masso->id:NULL;
					$proceso_completo += 1;
				}

				if($estado_masso == NULL){
					$aux->masso = "N/D";
					$aux->color_masso = "";
					$aux->estado_masso = "N/D";
				}else{
					if($estado_masso >= 0 && $estado_masso <= 30){
						$color_masso = "#FF8000";
					}elseif($estado_masso < 0){
						$color_masso = "red";
					}elseif($estado_masso > 30){
						$color_masso = "green";
					}
					$aux->masso = isset($masso->fecha_v)?$masso->fecha_v:"N/D";
					$aux->color_masso = $color_masso;
					$aux->estado_masso = $estado_masso;
				}
			}else{
				$aux->sre_eval_req_id_masso = NULL;
				$aux->masso = "";
				$aux->color_masso = "";
				$aux->color_estado_eval_sre_masso = "";
				$aux->letra_estado_eval_sre_masso = "";
			}
			//Fin validacion examen masso
			//Inicio validacion examen preocupacional
			if($examen_preo != 0){
				$examen_pre = $this->Evaluaciones_model->get_una_preocupacional($l->usuario_id);
				$estado_preo = isset($examen_pre->estado_preo)?$examen_pre->estado_preo:NULL;
				$aux->preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;
				$preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;

				if($preo_id != NULL){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $preo_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $preo_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 2,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $preo_id);
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$aux->sre_eval_req_id_preo = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado == 0){
						$aux->color_estado_eval_sre_preo = "#D7DF01";
						$aux->letra_estado_eval_sre_preo = "EP";
						$proceso_completo += 1;
					}elseif($sre_eval_req_estado == 1){
						$aux->color_estado_eval_sre_preo = "green";
						$aux->letra_estado_eval_sre_preo = "A";
					}elseif($sre_eval_req_estado == 2){
						$aux->color_estado_eval_sre_preo = "red";
						$aux->letra_estado_eval_sre_preo = "R";
					}elseif($sre_eval_req_estado == 3){
						$aux->color_estado_eval_sre_preo = "#886A08";
						$aux->letra_estado_eval_sre_preo = "NA";
					}else{
						$aux->color_estado_eval_sre_preo = "";
						$aux->letra_estado_eval_sre_preo = "";
						$proceso_completo += 1;
					}
				}else{
					$get_agenda_preo = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 2);
					$aux->id_sre_agenda_preo = isset($get_agenda_preo->id)?$get_agenda_preo->id:NULL;
					$proceso_completo += 1;
				}

				if($estado_preo == NULL){
					$aux->examen_pre = "N/D";
					$aux->color_preo = "";
					$aux->estado_preo = "N/D";
				}else{
					if($estado_preo >= 0 && $estado_preo <= 30){
						$color_preo = "#FF8000";
					}elseif($estado_preo < 0){
						$color_preo = "red";
					}elseif($estado_preo > 30){
						$color_preo = "green";
					}
					$aux->examen_pre = isset($examen_pre->fecha_v)?$examen_pre->fecha_v:"N/D";
					$aux->color_preo = $color_preo;
					$aux->estado_preo = $estado_preo;
				}
			}else{
				$aux->sre_eval_req_id_preo = "";
				$aux->examen_pre = "";
				$aux->color_preo = "";
				$aux->color_estado_eval_sre_preo = "";
				$aux->letra_estado_eval_sre_preo = "";
			}
			//Fin validacion examen preocupacional
			//Inicio validacion examen psicologico
			if($examen_psicologico != 0){
				$examen_psic = $this->Examenes_psicologicos_model->get_ultimo_examen($l->usuario_id);
				$estado_psic = isset($examen_psic->estado_psic)?$examen_psic->estado_psic:NULL;
				$aux->eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;
				$eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;

				if($eval_psic_id != NULL){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $eval_psic_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $eval_psic_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 3,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $eval_psic_id);
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$aux->sre_eval_req_id_psic = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado_psic = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado_psic == 0){
						$aux->color_estado_eval_sre_psic = "#D7DF01";
						$aux->letra_estado_eval_sre_psic = "EP";
						$proceso_completo += 1;
					}elseif($sre_eval_req_estado_psic == 1){
						$aux->color_estado_eval_sre_psic = "green";
						$aux->letra_estado_eval_sre_psic = "A";
					}elseif($sre_eval_req_estado_psic == 2){
						$aux->color_estado_eval_sre_psic = "red";
						$aux->letra_estado_eval_sre_psic = "R";
					}elseif($sre_eval_req_estado_psic == 3){
						$aux->color_estado_eval_sre_psic = "#886A08";
						$aux->letra_estado_eval_sre_psic = "NA";
					}else{
						$aux->color_estado_eval_sre_psic = "";
						$aux->letra_estado_eval_sre_psic = "";
						$proceso_completo += 1;
					}
				}else{
					$get_agenda_psic = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 3);
					$aux->id_sre_agenda_psic = isset($get_agenda_psic->id)?$get_agenda_psic->id:NULL;
					$proceso_completo += 1;
				}

				if($estado_psic == NULL){
					$aux->examen_psic = "N/D";
					$aux->color_psic = "";
					$aux->estado_psic = "N/D";
				}else{
					if($estado_psic >= 0 && $estado_psic <= 30){
						$color_psic = "#FF8000";
					}elseif($estado_psic < 0){
						$color_psic = "red";
					}elseif($estado_psic > 30){
						$color_psic = "green";
					}
					$aux->examen_psic = isset($examen_psic->fecha_vigencia)?$examen_psic->fecha_vigencia:"N/D";
					$aux->color_psic = $color_psic;
					$aux->estado_psic = $estado_psic;
				}
			}else{
				$aux->sre_eval_req_id_psic = "";
				$aux->examen_psic = "";
				$aux->color_psic = "";
				$aux->color_estado_eval_sre_psic = "";
				$aux->letra_estado_eval_sre_psic = "";
			}
			//Fin validacion examen psicologico

			

			$aux->proceso_completo = $proceso_completo;
			array_push($lista,$aux);
			unset($aux);
		}

		if($this->session->userdata('tipo_usuario') == 5)
			$pagina['tipo_usuario'] = "psicologo";
		elseif($this->session->userdata('tipo_usuario') == 8 or $this->session->userdata('tipo_usuario') == 2 or $this->session->userdata('id') == 10)
			$pagina['tipo_usuario'] = "analista";
		else
			$pagina['tipo_usuario'] = "error";

		$pagina['listado'] = $lista;
		$pagina['usuario_analista'] = "SI";
		$pagina['empresas_plantas'] = $this->Empresa_planta_model->listar();
		$pagina['lista_requerimientos'] = $this->Requerimientos_model->r_listar_activos();
		$pagina['r_cargos'] = $this->Cargos_model->r_listar();
		$base['cuerpo'] = $this->load->view('carrera/trabajadores/listado_solicitudes_revision_examen',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}


	function solicitudes_revision_examenes(){
		$this->load->model('carrera/Requerimiento_asc_trabajadores_model');
		$this->load->model('carrera/Solicitud_revision_examenes_previos_model');
		$this->load->model('carrera/Solicitud_revision_examenes_model');
		$this->load->model('carrera/Usuarios_model');
		$this->load->model('carrera/ciudades_model');
		$this->load->model('carrera/Cargos_model');
		$this->load->model('carrera/Empresa_planta_model');
		$this->load->model('carrera/Requerimientos_model');

		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Trabajadores a enviar revision de examenes",
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/trabajadores/buscar_js','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Listado Trabajadores Revision Examenes' ) ),
			'menu' => $this->menu,
			'js' => array('js/si_datepicker_solicitudes_revision_examenes2.js','js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);
		//var_dump($_POST['seleccionar_todos']);
		//return false;

		if($this->session->flashdata('usuario_req')){
			foreach($this->session->flashdata('usuario_req') as $r){
				$existe = $this->Solicitud_revision_examenes_previos_model->consultar_si_existe($r);
				$datos = array(
					'id_usuario' => $r,
					'id_solicitante' => $this->session->userdata('id'),
					'estado' => 1,
				);
				if($existe == "NA"){
					$this->Solicitud_revision_examenes_previos_model->guardar($datos);
				}else{
					$this->Solicitud_revision_examenes_previos_model->actualizar($existe->id, $datos);
				}
			}
		}

		if(!empty($_POST['seleccionar_todos'])){
			foreach($_POST['seleccionar_todos'] as $c=>$valores){
				$existe = $this->Solicitud_revision_examenes_previos_model->consultar_si_existe($valores);
				$datos = array(
					'id_usuario' => $valores,
					'id_solicitante' => $this->session->userdata('id'),
					'estado' => 1,
				);
				if($existe == "NA"){
					$this->Solicitud_revision_examenes_previos_model->guardar($datos);
				}else{
					$this->Solicitud_revision_examenes_previos_model->actualizar($existe->id, $datos);
				}
			}
		}

		$usuarios = $this->Solicitud_revision_examenes_previos_model->get_result($this->session->userdata('id'));
		$lista = array();
		foreach ($usuarios as $l){
			$aux = new stdClass();
			$get_usu = $this->Usuarios_model->get($l->id_usuario);
			$ciudad = $this->ciudades_model->get($get_usu->id_ciudad);
			$get_req_activos = $this->Requerimiento_asc_trabajadores_model->get_usuarios_area_cargo_req_activos_result($l->id_usuario);

			$nombre = isset($get_usu->nombres)?$get_usu->nombres:"";
			$paterno = isset($get_usu->paterno)?$get_usu->paterno:"";
			$materno = isset($get_usu->materno)?$get_usu->materno:"";
			$aux->id_solicitud_previa = $l->id;
			$aux->usuario_id = $l->id_usuario;
			$aux->rut = isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"";
			$aux->nombres = $nombre." ".$paterno." ".$materno;
			$aux->fono = isset($get_usu->fono)?$get_usu->fono:"";
			$aux->fecha_nac = isset($get_usu->fecha_nac)?$get_usu->fecha_nac:"";
			$aux->desc_ciudades = isset($ciudad->desc_ciudades)?ucwords(mb_strtolower($ciudad->desc_ciudades,'UTF-8')):"";

			$req_activos = 0;
			$aux->requerimientos_activos = array();
			if (!empty($get_req_activos)){
				foreach ($get_req_activos as $req){
					$archivo = new StdClass();
					$req_activos += 1;

					if($req->referido == 0)
						$referido = "No";
					elseif($req->referido == 1)
						$referido = "Si";
					else
						$referido = "";

					$archivo->id_req = $req->id_req;
					$archivo->empresa_planta = $req->empresa_planta;
					$archivo->nombre_req = $req->nombre_req;
					$archivo->nombre_area = $req->nombre_area;
					$archivo->nombre_cargo = $req->nombre_cargo;
					$archivo->referido = $referido;
					array_push($aux->requerimientos_activos, $archivo);
					unset($archivo);
				}
			}
			$aux->req_activos = $req_activos;
			//$id_asc_trab = isset($get_ultimo_req->id_asc_trab)?$get_ultimo_req->id_asc_trab:"";
			//$id_req = isset($get_ultimo_req->id_req)?$get_ultimo_req->id_req:"";
			//$get_solicitud = $this->Solicitud_revision_examenes_model->get_usu_req($l->id_usuario, $id_req, $id_asc_trab);

			//$aux->envio_masso = isset($get_solicitud->exam_masso)?$get_solicitud->exam_masso:NULL;
			$aux->envio_masso = NULL;
			//$aux->envio_preo = isset($get_solicitud->exam_preo)?$get_solicitud->exam_preo:NULL;
			$aux->envio_preo = NULL;
			//$aux->envio_psic = isset($get_solicitud->exam_psicologico)?$get_solicitud->exam_psicologico:NULL;
			$aux->envio_psic = NULL;
			//$aux->id_asc_trab = isset($get_ultimo_req->id_asc_trab)?$get_ultimo_req->id_asc_trab:"";
			//$aux->referido = isset($get_ultimo_req->referido)?$get_ultimo_req->referido:0;
			//$aux->id_cargo = isset($get_ultimo_req->id_cargo)?$get_ultimo_req->id_cargo:"";
			//$aux->nombre_cargo = isset($get_ultimo_req->nombre_cargo)?$get_ultimo_req->nombre_cargo:"";
			//$aux->nombre_area = isset($get_ultimo_req->nombre_area)?$get_ultimo_req->nombre_area:"";
			//$aux->id_req = isset($get_ultimo_req->id_req)?$get_ultimo_req->id_req:"";
			//$aux->nombre_req = isset($get_ultimo_req->nombre_req)?$get_ultimo_req->nombre_req:"";
			//$aux->planta_id = isset($get_ultimo_req->planta_id)?$get_ultimo_req->planta_id:"";
			//$aux->empresa_planta = isset($get_ultimo_req->empresa_planta)?$get_ultimo_req->empresa_planta:"";
			//$aux->fecha_nac = isset($get_ultimo_req->fecha_nac)?$get_ultimo_req->fecha_nac:"";

			if ($get_usu->id_especialidad_trabajador){
				$e1 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador);
				$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
			}else
				$aux->especialidad1 = false;

			if ($get_usu->id_especialidad_trabajador_2){
				$e2 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador_2);
				$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
			}else
				$aux->especialidad2 = false;

			array_push($lista,$aux);
			unset($aux);
		}

		if($this->session->userdata('tipo_usuario') == 5)
			$pagina['tipo_usuario'] = "psicologo";
		elseif($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2)
			$pagina['tipo_usuario'] = "analista";
		else
			$pagina['tipo_usuario'] = "error";

		$pagina['listado'] = $lista;
		$pagina['usuario_analista'] = "NO";
		$pagina['empresas_plantas'] = $this->Empresa_planta_model->listar();
		$pagina['lista_requerimientos'] = $this->Requerimientos_model->r_listar_activos();
		$pagina['r_cargos'] = $this->Cargos_model->r_listar();
		$base['cuerpo'] = $this->load->view('carrera/trabajadores/listado_envio_solicitud_revision_examen',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function enviar_solicitud_revision_examenes(){
		$this->load->model("carrera/Solicitud_revision_examenes_model");
		$this->load->model("carrera/Solicitud_revision_examenes_previos_model");
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->model("carrera/Requerimiento_asc_trabajadores_model");
		
		if(!empty($_POST['check_estado'])?$_POST['check_estado']:false){
			foreach($_POST['check_estado'] as $c=>$valores){
				$examen_preo = ((!empty($_POST['examen_preo'][$c]))?1:0);
				$id_requerimiento = (!empty($_POST['requerimiento_asociado'][$c]))?$_POST['requerimiento_asociado'][$c]:false;
				$get_req_asc_usu = $this->Requerimiento_asc_trabajadores_model->get_usuarios_area_cargo_asc_req_usu_row($valores, $id_requerimiento);
				$id_asc_trabajador = isset($get_req_asc_usu->id_asc_trab)?$get_req_asc_usu->id_asc_trab:null;

				$preo = array(
					'exam_preo' => $examen_preo,
				);
				$data = array(
					"usuario_id" => $valores,
					"solicitante_id" => $this->session->userdata('id'),
					"id_requerimiento" => $id_requerimiento,
					"id_asc_trabajador" => $id_asc_trabajador,
					"fecha_solicitud" => date('Y-m-d'),
					"fecha_esperada_ingreso" => (!empty($_POST['fecha_ingreso_esperado'][$c]))?$_POST['fecha_ingreso_esperado'][$c]:false,
					"observaciones" => (!empty($_POST['observaciones'][$c]))?$_POST['observaciones'][$c]:false,
					"estado" => '0',
				);

				$todos_los_datos = array_merge($data, $preo);

				$get_solicitudes = $this->Solicitud_revision_examenes_model->get_usu_req($valores, $id_requerimiento, $id_asc_trabajador);
				$id_solicitud_anterior = isset($get_solicitudes->id)?$get_solicitudes->id:NULL;

				if($id_solicitud_anterior == NULL){
					$this->Solicitud_revision_examenes_model->guardar($todos_los_datos);
					$id_solicitud = $this->db->insert_id();
				}else{
					$this->Solicitud_revision_examenes_model->actualizar($id_solicitud_anterior, $todos_los_datos);
					$id_solicitud = $id_solicitud_anterior;
				}

				
				$this->Solicitud_revision_examenes_previos_model->eliminar($valores);
			}
		}

		//avisar via email cuando se crea la solicitud
		$get_solicitud = $this->Solicitud_revision_examenes_model->get_row($id_solicitud);
		$id_solicitante = isset($get_solicitud->solicitante_id)?$get_solicitud->solicitante_id:'';
		$id_trabajador = isset($get_solicitud->usuario_id)?$get_solicitud->usuario_id:'';

		$get_usuario = $this->Usuarios_model->get($id_trabajador);
		$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
		$nombres_trabajador = isset($get_usuario->nombres)?$get_usuario->nombres:'';
		$ap_paterno_trabajador = isset($get_usuario->paterno)?$get_usuario->paterno:'';
		$ap_materno_trabajador = isset($get_usuario->materno)?$get_usuario->materno:'';
		$rut_trabajador = isset($get_usuario->rut_usuario)?$get_usuario->rut_usuario:'';
		$nombre_completo_trabajador = $nombres_trabajador.' '.$ap_paterno_trabajador.' '.$ap_materno_trabajador;

		$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
		$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
		$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
		$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
		$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';

		//$destinatarios_uno = array('acarter@empresasintegra.cl','psicologos@empresasintegra.cl','jcruces@empresasintegra.cl','vmatamala@empresasintegra.cl');

		$destinatarios_uno = array('jcruces@empresasintegra.cl');

		$this->load->library('email');
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);
	    $this->email->from('informaciones@empresasintegra.cl', 'Informacion Evaluaciones Integra');
	    $this->email->to($destinatarios_uno);
	    //$this->email->cco('soporte@empresasintegra.cl');
	    $this->email->subject("SE-SGO");
	    $this->email->message('Estimados el administrador(a) '.$nombre_completo_solicitante.' ha realizado una solicitud de revision de examenes del trabajdor: '.$nombre_completo_trabajador.' con el siguiente Rut: '.$rut_trabajador.'.<br>Saludos');
	    $this->email->send();
	    $this->session->set_userdata('exito',2);
		//echo "<script>alert('Solicitud/es de Revision Enviada/s Exitosamente')</script>";
		redirect('usuarios/home', 'refresh');
	}

	function trabajador_carrera($id, $id_evaluacion = FALSE){
		//$this->load->model("carrera/Tipoarchivos_model");
		$this->load->model("carrera/Archivos_trab_model");
		$this->load->model("carrera/estado_civil_model");
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("carrera/regiones_model");
		//$this->load->model("carrera/Provincia_model");
		$this->load->model("carrera/ciudades_model");
		//$this->load->model("carrera/Bancos_model");
		$this->load->model("carrera/Afp_model");
		$this->load->model("carrera/Salud_model");
		//$this->load->model("carrera/Nivelestudios_model");
		$this->load->model("carrera/Usu_parentesco_model");
		$this->load->model("carrera/Profesiones_model");
		//$this->load->model("carrera/Especialidadtrabajador_model");
		//$this->load->model("carrera/Experiencia_model");
		$this->load->model("carrera/Evaluaciones_model");
		//Masso
		//$this->load->model('carrera/Evaluacionestipo_model');
		//$this->load->model('carrera/Evaluacionesbaterias_model');
		$this->load->model('carrera/Evaluacionesevaluacion_model');

		$base = array(
			'head_titulo' => "Sistema EST - Datos Trabajador",
			'titulo' => "Empresa: carrera S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/trabajadores/buscar_js','txt'=>'Trabajadores EST' ), array('url'=>'','txt'=>'Datos Trabajadores' )),
			'js' => array('js/jquery.Rut.min.js','js/usuarios.js', 'js/confirm.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css'),
			'menu' => $this->menu
		);

		$pagina['datos_usuario'] = $this->Usuarios_model->get($id);
		//$pagina['lista_archivos'] = $this->Tipoarchivos_model->listar();
		$pagina['lista_archivos_subidos'] = $this->Archivos_trab_model->get_usuario($id);
		$pagina['lista_civil'] = $this->estado_civil_model->listar();
		$pagina['lista_region'] = $this->regiones_model->listar();
		//$pagina['lista_provincia'] = $this->Provincia_model->listar_region($pagina['datos_usuario']->id_regiones);
		$pagina['lista_ciudad'] = $this->ciudades_model->listar_region($pagina['datos_usuario']->id_regiones);
		//$pagina['lista_bancos'] = $this->Bancos_model->listar();
		$pagina['lista_afp'] = $this->Afp_model->listar();
		$pagina['lista_salud'] = $this->Salud_model->listar();
		//$pagina['lista_estudios'] = $this->Nivelestudios_model->listar();
		$pagina['lista_parentesco'] = $this->Usu_parentesco_model->listar();
		$pagina['lista_profesiones'] = $this->Profesiones_model->listar();
		//$pagina['lista_especialidades'] = $this->Especialidadtrabajador_model->listar();
		//$pagina['lista_experiencia'] = $this->Experiencia_model->get_usuario($id);
		$pagina['id_usuario'] = $id;
		$pagina['id'] = $id;
		$usr = $this->Usuarios_model->get($id);
		$eval = $this->Evaluaciones_model->get_all($id);
		$pagina['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$pagina['listado'] = $eval;
		$pagina['exam_conocimientos'] = $this->Evaluaciones_model->get_all_tipo(3);
		$pagina['exam_desempeno'] = $this->Evaluaciones_model->get_all_tipo(1);
		$base['cuerpo'] = $this->load->view('trabajadores/trabajador_carrera',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_editar_sre_eval_req($id_registro, $estado = FALSE, $idExamen = false){
		$this->load->model("carrera/Sre_evaluacion_req_model");
		$this->load->model("carrera/Evaluaciones_model");
		$this->load->model("carrera/Evaluacionescargos_model");
		$this->load->model("carrera/Cargos_model");
		$this->load->model("carrera/Solicitud_revision_examenes_model");
		$this->load->model("carrera/Examenes_psicologicos_model");

		if($estado == 1)
			$pagina['estado_bloqueo'] = "SI";
		else
			$pagina['estado_bloqueo'] = "NO";

		$get_registro = $this->Sre_evaluacion_req_model->get_registro($id_registro);
		$id_eval = isset($get_registro->id_evaluacion)?$get_registro->id_evaluacion:"";
		$id_tipo_eval = isset($get_registro->tipo_examen)?$get_registro->tipo_examen:"";
		$get_eval = $this->Evaluaciones_model->get($id_eval);
		$get_cargos_aptos_eval = $this->Evaluacionescargos_model->get_eval($id_eval);
		if($id_tipo_eval == 2){
			$cargos_aptos = array();
			if (!empty($get_cargos_aptos_eval)){
				foreach ($get_cargos_aptos_eval as $cg) {
					$get_cargo = $this->Cargos_model->r_get($cg->id_r_cargo);
					$archivo = new StdClass();
					$archivo->nombre_cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
					array_push($cargos_aptos, $archivo);
				}
				unset($archivo);
			}
		}else{
			$cargos_aptos = array();
		}
		if ($idExamen) {// #08-01-2018 si vengo desde el perfil psicologo consultar sobre las fecha de vigencia del examen
			$this->load->model('carrera/Usuarios_model');
			$this->load->model('carrera/Examenes_psicologicos_model');
			$this->load->model('carrera/Examenes_psicologicos_archivos_model');
			$this->load->model('carrera/usuarios/Usuarios_general_model');
			$this->load->model('carrera/Empresa_planta_model');
			$this->load->model('carrera/Cargos_model');
			$this->load->model('carrera/Especialidadtrabajador_model');
			$get_id_examen = $this->Examenes_psicologicos_model->get_result($idExamen);
			$listado = array();
			foreach ($get_id_examen as $l){
				$aux = new stdClass();
				$get_usuario = $this->Usuarios_model->get($l->usuario_id);
				$get_cargo_postulacion = $this->Cargos_model->r_get($l->cargo_postulacion_id);
				$get_lugar_trabajo = $this->Empresa_planta_model->get($l->lugar_trabajo_id);
				$get_solicitante = $this->Usuarios_general_model->get($l->solicitante_id);
				$get_psicologo_evaluador = $this->Usuarios_model->get_datos_psicologo_row($l->psicologo_evaluador);

				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:"";
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:"";
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:"";

				$nombre_usu = isset($get_usuario->nombres)?$get_usuario->nombres:"";
				$paterno_usu = isset($get_usuario->paterno)?$get_usuario->paterno:"";
				$materno_usu = isset($get_usuario->materno)?$get_usuario->materno:"";

				$nombre_psicologo = isset($get_psicologo_evaluador->nombres)?$get_psicologo_evaluador->nombres:"";
				$ap_psicologo = isset($get_psicologo_evaluador->paterno)?$get_psicologo_evaluador->paterno:"";
				$am_psicologo = isset($get_psicologo_evaluador->materno)?$get_psicologo_evaluador->materno:"";
				$aux->usuario_id = $l->usuario_id;
				$aux->nombres_usuario = $nombre_usu." ".$paterno_usu." ".$materno_usu;
				$aux->lugar_trabajo = isset($get_lugar_trabajo->nombre)?$get_lugar_trabajo->nombre:"";
				$aux->solicitante = $nombre_solicitante." ".$paterno_solicitante." ".$materno_solicitante;
				$aux->especialidad_post = isset($get_cargo_postulacion->nombre)?$get_cargo_postulacion->nombre:"";

				if($l->tecnico_supervisor == 1){
					$aux->tecnico_supervisor = "Tecnico";
				}elseif($l->tecnico_supervisor == 2){
					$aux->tecnico_supervisor = "Supervisor";
				}else{
					$aux->tecnico_supervisor = "";
				}

				$aux->sueldo_definido = isset($l->sueldo_definido)?$l->sueldo_definido:"0";
				$aux->fecha_solicitud = isset($l->fecha_solicitud)?$l->fecha_solicitud:"";
				$aux->fecha_evaluacion = isset($l->fecha_evaluacion)?$l->fecha_evaluacion:"";
				$aux->fecha_vigencia = isset($l->fecha_vigencia)?$l->fecha_vigencia:"0000-00-00";
				$aux->resultado = isset($l->resultado)?$l->resultado:"";
				$aux->referido = isset($l->referido)?$l->referido:"";
				$aux->observaciones = isset($l->observaciones)?$l->observaciones:"";

				$get_archivo_informe = $this->Examenes_psicologicos_archivos_model->get_archivo_informe($idExamen);
				$aux->url_informe = isset($get_archivo_informe->id)?$get_archivo_informe->url:"NE";
				$aux->id_archivo_examen = isset($get_archivo_informe->id)?$get_archivo_informe->id:"0";

				$id_espec = isset($get_usuario->id_especialidad_trabajador)?$get_usuario->id_especialidad_trabajador:NULL;
				if($id_espec != NULL){
					$e1 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador);
					$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
				}else
					$aux->especialidad1 = false;

				$id_espec2 = isset($get_usuario->id_especialidad_trabajador_2)?$get_usuario->id_especialidad_trabajador_2:NULL;
				if($id_espec2 != NULL){
					$e2 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador_2);
					$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
				}else
					$aux->especialidad2 = false;

				$id_espec3 = isset($get_usuario->id_especialidad_trabajador_3)?$get_usuario->id_especialidad_trabajador_3:NULL;
				if($id_espec3 != NULL){
					$e3 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador_3);
					$aux->especialidad3 = (!empty($e3->desc_especialidad))?$e3->desc_especialidad:FALSE;
				}else
					$aux->especialidad3 = false;

				array_push($listado,$aux);
				unset($aux);
			}
			$pagina['datos_examen'] = $listado;
			$pagina['idExamen'] = $idExamen;
			
		}
		//var_dump($id_tipo_eval);
		//$pagina['id_tipo_eval'] = $id_tipo_eval;
		$pagina['cargos_aptos'] = $cargos_aptos;
		$pagina['id_tipo_eval'] = $id_tipo_eval;
		$pagina['lista_aux'] = $this->Sre_evaluacion_req_model->get_result($id_registro);
		$this->load->view('carrera/trabajadores/modal_editar_sre_evaluacion_req', $pagina);
	}

	function actualizar_sre_eval_req(){
		$this->load->model("carrera/Sre_evaluacion_req_model");
		$this->load->model("carrera/Solicitud_revision_examenes_model");
		$this->load->model("carrera/Evaluaciones_model");
		$this->load->model("carrera/Examenes_psicologicos_model");
		$this->load->model("carrera/Usuarios_model");
		$this->load->model("usuarios/Usuarios_general_model");

		$id_registro = $_POST['id_registro'];
		$datos = array(
			'fecha_gestion' => date('Y-m-d'),
			'estado' => $_POST['estado'],
			'observaciones' => $_POST['observaciones'],
		);
		$this->Sre_evaluacion_req_model->actualizar($id_registro, $datos);
		/*$arrayAuditoria= array(
			'estado'=>$_POST['estado'],
			'id_personal' => $this->session->userdata('id'),
			);
		$this->Sre_evaluacion_req_model->auditoriaSave($arrayAuditoria);*/
		$get_registro = $this->Sre_evaluacion_req_model->get_registro($id_registro);
		$id_solicitud_revision = isset($get_registro->id_solicitud_revision)?$get_registro->id_solicitud_revision:"";
		$get_solicitud = $this->Solicitud_revision_examenes_model->get_row($id_solicitud_revision);

		$proceso_completo = 0;
		$examen_masso = isset($get_solicitud->exam_masso)?$get_solicitud->exam_masso:0;
		$examen_preo = isset($get_solicitud->exam_preo)?$get_solicitud->exam_preo:0;
		$examen_psicologico = isset($get_solicitud->exam_psicologico)?$get_solicitud->exam_psicologico:0;
		$usuario_id = isset($get_solicitud->usuario_id)?$get_solicitud->usuario_id:0;

		//Inicio validacion examen masso
		if($examen_masso != 0){
			$masso = $this->Evaluaciones_model->get_una_masso($usuario_id);
			$masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
			$estado_masso = isset($masso->estado_masso)?$masso->estado_masso:NULL;

			if($masso_id != ""){
				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $masso_id);
				$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;
				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $masso_id);
				$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
				$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

				if($sre_eval_req_estado == 0){
					$proceso_completo += 1;
				}elseif($sre_eval_req_estado == 1){
				}elseif($sre_eval_req_estado == 2){
				}elseif($sre_eval_req_estado == 3){
				}else{
					$proceso_completo += 1;
				}
			}else{
				$proceso_completo += 1;
			}
		}
		//Fin validacion examen masso
		//Inicio validacion examen preocupacional
		if($examen_preo != 0){
			$examen_pre = $this->Evaluaciones_model->get_una_preocupacional($usuario_id);
			$estado_preo = isset($examen_pre->estado_preo)?$examen_pre->estado_preo:NULL;
			$preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;

			if($preo_id != NULL){
				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $preo_id);
				$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;
				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $preo_id);
				$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
				$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

				if($sre_eval_req_estado == 0){
					$proceso_completo += 1;
				}elseif($sre_eval_req_estado == 1){
				}elseif($sre_eval_req_estado == 2){
				}elseif($sre_eval_req_estado == 3){
				}else{
					$proceso_completo += 1;
				}
			}else{
				$proceso_completo += 1;
			}
		}
		//Fin validacion examen preocupacional
		//Inicio validacion examen psicologico
		if($examen_psicologico != 0){
			$examen_psic = $this->Examenes_psicologicos_model->get_ultimo_examen($usuario_id);
			$estado_psic = isset($examen_psic->estado_psic)?$examen_psic->estado_psic:NULL;
			$eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;

			if($eval_psic_id != NULL){
				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $eval_psic_id);
				$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $eval_psic_id);
				$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
				$sre_eval_req_estado_psic = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

				if($sre_eval_req_estado_psic == 0){
					$proceso_completo += 1;
				}elseif($sre_eval_req_estado_psic == 1){
				}elseif($sre_eval_req_estado_psic == 2){
				}elseif($sre_eval_req_estado_psic == 3){
				}else{
					$proceso_completo += 1;
				}
			}else{
				$proceso_completo += 1;
			}
			#07-01-2019
			if (isset($_POST['idExamen'])) {
				$this->load->model('Examenes_psicologicos_model');
				$this->load->model('Examenes_psicologicos_archivos_model');
				$id_examen = $_POST['idExamen'];
				//$usuario_id = $_POST['usuario_id'];

				if(isset($_POST['ano_v']) && isset($_POST['mes_v']) && isset($_POST['dia_v'])){
					$fecha_v = $_POST['ano_v'].'-'.$_POST['mes_v'].'-'.$_POST['dia_v'];
				}else{
					$fecha_v = '0000-00-00';
				}

				if(isset($_POST['ano_e']) && isset($_POST['mes_e']) && isset($_POST['dia_e'])){
					$fecha_e = $_POST['ano_e'].'-'.$_POST['mes_e'].'-'.$_POST['dia_e'];
				}else{
					$fecha_e = '0000-00-00';
				}

				$datos_examen = array(
					'psicologo_evaluador' => $_POST['psicologo'],
					'fecha_evaluacion' => $fecha_e,
					'fecha_vigencia' => $fecha_v,
					'resultado' => $_POST['resultado'],
					'observaciones' => $_POST['observaciones'],
				/*	'estado' => 1,*/
					'estado_ultimo_examen' => 0
				);

				$estado_cero = array('estado_ultimo_examen' => '0');
			//	$this->Examenes_psicologicos_model->actualizar_estado_ultimo_examen($usuario_id, $estado_cero);
				$this->Examenes_psicologicos_model->actualizar($id_examen, $datos_examen);
			}
		}
		//Fin validacion examen psicologico

		if($proceso_completo == 0){
			$proceso_completo_array = array(
				'estado' => 1,
			);
			$this->Solicitud_revision_examenes_model->actualizar($id_solicitud_revision, $proceso_completo_array);
			
			//avisar via email cuando se completa la revision de la solicitud
			$id_solicitante = isset($get_solicitud->solicitante_id)?$get_solicitud->solicitante_id:'';
			$id_trabajador = isset($get_solicitud->usuario_id)?$get_solicitud->usuario_id:'';

			$get_usuario = $this->Usuarios_model->get($id_trabajador);
			$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
			$nombres_trabajador = isset($get_usuario->nombres)?$get_usuario->nombres:'';
			$ap_paterno_trabajador = isset($get_usuario->paterno)?$get_usuario->paterno:'';
			$ap_materno_trabajador = isset($get_usuario->materno)?$get_usuario->materno:'';
			$rut_trabajador = isset($get_usuario->rut_usuario)?$get_usuario->rut_usuario:'';
			$nombre_completo_trabajador = $nombres_trabajador.' '.$ap_paterno_trabajador.' '.$ap_materno_trabajador;

			$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
			$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
			$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
			$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
			$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';

			/*$this->load->library('email');
			$config['smtp_host'] = 'mail.empresasintegra.cl';
			$config['smtp_user'] = 'informaciones@empresasintegra.cl';
			$config['smtp_pass'] = '%SYkNLH1';
			$config['mailtype'] = 'html';
			$config['smtp_port']    = '2552';
			$this->email->initialize($config);
		    $this->email->from('informaciones@empresasintegra.cl', 'Informacion Evaluaciones Integra');
		    $this->email->to($email_solicitante);
		    $this->email->cc('jcruces@empresasintegra.cl','vmatamala@empresasintegra.cl');
	    	//$this->email->cco('soporte@empresasintegra.cl');
		    $this->email->subject("RE-SGO");
		    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' su solicitud de revision de examenes del trabajador '.$nombre_completo_trabajador.' con el siguiente Rut: '.$rut_trabajador.' ha sido finalizado con exito.<br>Saludos');
		    $this->email->send();*/
		}
		//echo "<script>alert('Solicitud/es de Revision Enviada/s Exitosamente')</script>";
		//redirect('est/trabajadores/listado_solicitudes_revision_examenes', 'refresh');
		echo json_encode(1);
	}
	function pruebaqla(){
		echo json_encode(1);
	}

	function modal_agendar_examen($id_solicitud, $tipo_examen, $estado = FALSE){
		$this->load->model('Sre_evaluacion_req_agenda_model');
		if($tipo_examen == 1)
			$examen = "Masso";
		elseif ($tipo_examen == 2)
			$examen = "Preocupacional";
		elseif($tipo_examen == 3)
			$examen = "Psicologico";

		if($estado == 1)
			$pagina['estado_bloqueo'] = "SI";
		else
			$pagina['estado_bloqueo'] = "NO";

		$pagina['id_solicitud'] = $id_solicitud;
		$pagina['tipo_examen'] = $examen;
		$pagina['id_tipo_examen'] = $tipo_examen;
		$pagina['agendado'] = $this->Sre_evaluacion_req_agenda_model->get_tipo($id_solicitud, $tipo_examen);
		$this->load->view('carrera/trabajadores/modal_agendar_solicitud_examen',$pagina);
	}

	function ingresar_agenda_de_examen(){
		$this->load->model('carrera/Sre_evaluacion_req_agenda_model');

		$id_agendado = $_POST['id_agendado'];
		$id_solicitud_sre = $_POST['id_solicitud'];
		$id_tipo_examen = $_POST['id_tipo_examen'];
		$lugar = $_POST['lugar'];
		$hora = $_POST['hora'];
		$observaciones = $_POST['observaciones'];

		if(isset($_POST['ano_fn']) && isset($_POST['mes_fc']) && isset($_POST['dia_fc'])){
			$fecha_citacion = $_POST['ano_fn'].'-'.$_POST['mes_fc'].'-'.$_POST['dia_fc'];
		}else {
			$fecha_citacion = '0000-00-00';
		}

		$datos = array(
			'id_sre' => $id_solicitud_sre,
			'id_tipo_examen' => $id_tipo_examen,
			'fecha_citacion' => $fecha_citacion,
			'lugar' => $lugar,
			'hora' => $hora,
			'observaciones' => $observaciones,
		);

		if($id_agendado == NULL)
			$this->Sre_evaluacion_req_agenda_model->guardar($datos);
		else
			$this->Sre_evaluacion_req_agenda_model->actualizar($id_agendado, $datos);

		//faltar enviar a administrador de contrato datos de la agenda

		echo "<script>alert('Agenda ingresada exitosamente')</script>";
		redirect('carrera/trabajadores/listado_solicitudes_revision_examenes', 'refresh');
	}


	function solicitudes_revision_examenes_completas(){
		$this->load->model('carrera/Requerimiento_asc_trabajadores_model');
		$this->load->model('carrera/Solicitud_revision_examenes_model');
		$this->load->model('carrera/Solicitud_revision_examenes_previos_model');
		$this->load->model('carrera/Usuarios_model');
		$this->load->model('carrera/ciudades_model');
		$this->load->model('carrera/Cargos_model');
		//$this->load->model('carrera/Especialidadtrabajador_model');
		$this->load->model('carrera/Empresa_planta_model');
		$this->load->model('carrera/Requerimientos_model');
		$this->load->model('carrera/Evaluaciones_model');
		$this->load->model('carrera/Sre_evaluacion_req_model');
		$this->load->model('carrera/Sre_evaluacion_req_agenda_model');
		$this->load->model('carrera/Examenes_psicologicos_model');

		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Solicitudes revision de examenes completas",
			'subtitulo' => 'Unidad de Negocio: carrera',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'carrera/trabajadores/buscar_js','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Listado Trabajadores Revision Examenes Completas' ) ),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$usuarios = $this->Solicitud_revision_examenes_model->get_result_completas();
		$lista = array();
		foreach ($usuarios as $l){
			$aux = new stdClass();
			$get_usu = $this->Usuarios_model->get($l->usuario_id);
			$idCiudad = isset($get_usu->id_ciudades)?$get_usu->id_ciudades:false;
			$ciudad = $this->ciudades_model->get($idCiudad);
			$get_ultimo_req = $this->Requerimiento_asc_trabajadores_model->get_area_cargo_req_row($l->id_asc_trabajador);

			$nombre = isset($get_usu->nombres)?$get_usu->nombres:"";
			$paterno = isset($get_usu->paterno)?$get_usu->paterno:"";
			$materno = isset($get_usu->materno)?$get_usu->materno:"";
			$aux->id_solicitud = $l->id;
			$aux->usuario_id = $l->usuario_id;
			$aux->rut = isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"";
			$aux->nombres = $nombre." ".$paterno." ".$materno;
			$aux->fono = isset($get_usu->fono)?$get_usu->fono:"";
			$aux->fecha_nac = isset($get_usu->fecha_nac)?$get_usu->fecha_nac:"";
			$aux->desc_ciudades = isset($ciudad->desc_ciudades)?ucwords(mb_strtolower($ciudad->desc_ciudades,'UTF-8')):"";

			$aux->id_asc_trab = isset($l->id_asc_trabajador)?$l->id_asc_trabajador:"";
			$aux->referido = isset($get_ultimo_req->referido)?$get_ultimo_req->referido:NULL;
			$aux->nombre_cargo = isset($get_ultimo_req->nombre_cargo)?$get_ultimo_req->nombre_cargo:"";
			$aux->nombre_area = isset($get_ultimo_req->nombre_area)?$get_ultimo_req->nombre_area:"";
			$aux->id_req = isset($get_ultimo_req->id_req)?$get_ultimo_req->id_req:"";
			$aux->nombre_req = isset($get_ultimo_req->nombre_req)?$get_ultimo_req->nombre_req:"";
			$aux->empresa_planta = isset($get_ultimo_req->empresa_planta)?$get_ultimo_req->empresa_planta:"";
			$aux->fecha_solicitud = isset($l->fecha_solicitud)?$l->fecha_solicitud:"";
			$aux->fecha_esperada_ingreso = isset($l->fecha_esperada_ingreso)?$l->fecha_esperada_ingreso:"";
			$aux->observaciones = isset($l->observaciones)?$l->observaciones:"";
			$aux->examen_preo = isset($l->exam_preo)?$l->exam_preo:0;
			$aux->examen_masso = isset($l->exam_masso)?$l->exam_masso:0;
			$aux->examen_psicologico = isset($l->exam_psicologico)?$l->exam_psicologico:0;

			$examen_masso = isset($l->exam_masso)?$l->exam_masso:0;
			$examen_preo = isset($l->exam_preo)?$l->exam_preo:0;
			$examen_psicologico = isset($l->exam_psicologico)?$l->exam_psicologico:0;

			$proceso_completo = 0;
			//Inicio validacion examen masso
			if($examen_masso != 0){
				$masso = $this->Evaluaciones_model->get_una_masso($l->usuario_id);
				$aux->masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
				$masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
				$estado_masso = isset($masso->estado_masso)?$masso->estado_masso:"";

				if($masso_id != ""){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $masso_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $masso_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 1,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $masso_id);
					$aux->sre_eval_req_id_masso = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado == 0){
						$aux->color_estado_eval_sre_masso = "#D7DF01";
						$aux->letra_estado_eval_sre_masso = "EP";
					}elseif($sre_eval_req_estado == 1){
						$aux->color_estado_eval_sre_masso = "green";
						$aux->letra_estado_eval_sre_masso = "A";
					}elseif($sre_eval_req_estado == 2){
						$aux->color_estado_eval_sre_masso = "red";
						$aux->letra_estado_eval_sre_masso = "R";
					}elseif($sre_eval_req_estado == 3){
						$aux->color_estado_eval_sre_masso = "#886A08";
						$aux->letra_estado_eval_sre_masso = "NA";
					}else{
						$aux->color_estado_eval_sre_masso = "";
						$aux->letra_estado_eval_sre_masso = "";
					}
				}else{
					$get_agenda_masso = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 1);
					$aux->id_sre_agenda_masso = isset($get_agenda_masso->id)?$get_agenda_masso->id:NULL;
				}

				if(!$estado_masso){
					$aux->masso = "N/D";
					$aux->color_masso = "";
				}else{
					if($estado_masso >= 0 && $estado_masso <= 30){
						$color_masso = "#FF8000";
					}elseif($estado_masso < 0){
						$color_masso = "red";
					}elseif($estado_masso > 30){
						$color_masso = "green";
					}
					$aux->masso = isset($masso->fecha_v)?$masso->fecha_v:"";
					$aux->color_masso = $color_masso;
				}
			}else{
				$aux->sre_eval_req_id_masso = NULL;
				$aux->masso = "N/D";
				$aux->color_masso = "";
				$aux->color_estado_eval_sre_masso = "";
				$aux->letra_estado_eval_sre_masso = "";
			}
			//Fin validacion examen masso
			//Inicio validacion examen preocupacional
			if($examen_preo != 0){
				$examen_pre = $this->Evaluaciones_model->get_una_preocupacional($l->usuario_id);
				$estado_preo = isset($examen_pre->estado_preo)?$examen_pre->estado_preo:"";
				$aux->preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;
				$preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;

				if($preo_id != NULL){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $preo_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $preo_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 2,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $preo_id);
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$aux->sre_eval_req_id_preo = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado == 0){
						$aux->color_estado_eval_sre_preo = "#D7DF01";
						$aux->letra_estado_eval_sre_preo = "EP";
					}elseif($sre_eval_req_estado == 1){
						$aux->color_estado_eval_sre_preo = "green";
						$aux->letra_estado_eval_sre_preo = "A";
					}elseif($sre_eval_req_estado == 2){
						$aux->color_estado_eval_sre_preo = "red";
						$aux->letra_estado_eval_sre_preo = "R";
					}elseif($sre_eval_req_estado == 3){
						$aux->color_estado_eval_sre_preo = "#886A08";
						$aux->letra_estado_eval_sre_preo = "NA";
					}else{
						$aux->color_estado_eval_sre_preo = "";
						$aux->letra_estado_eval_sre_preo = "";
					}
				}else{
					$get_agenda_preo = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 2);
					$aux->id_sre_agenda_preo = isset($get_agenda_preo->id)?$get_agenda_preo->id:NULL;
				}

				if(!$estado_preo){
					$aux->examen_pre = "N/D";
					$aux->color_preo = "";
				}else{
					if($estado_preo >= 0 && $estado_preo <= 30){
						$color_preo = "#FF8000";
					}elseif($estado_preo < 0){
						$color_preo = "red";
					}elseif($estado_preo > 30){
						$color_preo = "green";
					}
					$aux->examen_pre = isset($examen_pre->fecha_v)?$examen_pre->fecha_v:"";
					$aux->color_preo = $color_preo;
				}
			}else{
				$aux->sre_eval_req_id_preo = "";
				$aux->examen_pre = "N/D";
				$aux->color_preo = "";
				$aux->color_estado_eval_sre_preo = "";
				$aux->letra_estado_eval_sre_preo = "";
			}
			//Fin validacion examen preocupacional
			//Inicio validacion examen psicologico
			if($examen_psicologico != 0){
				$examen_psic = $this->Examenes_psicologicos_model->get_ultimo_examen($l->usuario_id);
				$estado_psic = isset($examen_psic->estado_psic)?$examen_psic->estado_psic:NULL;
				$aux->eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;
				$eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;

				if($eval_psic_id != NULL){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $eval_psic_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $eval_psic_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 3,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $eval_psic_id);
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$aux->sre_eval_req_id_psic = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado_psic = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado_psic == 0){
						$aux->color_estado_eval_sre_psic = "#D7DF01";
						$aux->letra_estado_eval_sre_psic = "EP";
						$proceso_completo += 1;
					}elseif($sre_eval_req_estado_psic == 1){
						$aux->color_estado_eval_sre_psic = "green";
						$aux->letra_estado_eval_sre_psic = "A";
					}elseif($sre_eval_req_estado_psic == 2){
						$aux->color_estado_eval_sre_psic = "red";
						$aux->letra_estado_eval_sre_psic = "R";
					}elseif($sre_eval_req_estado_psic == 3){
						$aux->color_estado_eval_sre_psic = "#886A08";
						$aux->letra_estado_eval_sre_psic = "NA";
					}else{
						$aux->color_estado_eval_sre_psic = "";
						$aux->letra_estado_eval_sre_psic = "";
						$proceso_completo += 1;
					}
				}else{
					$get_agenda_psic = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 3);
					$aux->id_sre_agenda_psic = isset($get_agenda_psic->id)?$get_agenda_psic->id:NULL;
					$proceso_completo += 1;
				}

				if($estado_psic == NULL){
					$aux->examen_psic = "N/D";
					$aux->color_psic = "";
					$aux->estado_preo = "N/D";
				}else{
					if($estado_psic >= 0 && $estado_psic <= 30){
						$color_psic = "#FF8000";
					}elseif($estado_psic < 0){
						$color_psic = "red";
					}elseif($estado_psic > 30){
						$color_psic = "green";
					}
					$aux->examen_psic = isset($examen_psic->fecha_vigencia)?$examen_psic->fecha_vigencia:"N/D";
					$aux->color_psic = $color_psic;
					$aux->estado_psic = $estado_psic;
				}
			}else{
				$aux->sre_eval_req_id_psic = "";
				$aux->examen_psic = "";
				$aux->color_psic = "";
				$aux->color_estado_eval_sre_psic = "";
				$aux->letra_estado_eval_sre_psic = "";
			}
			//Fin validacion examen psicologico

			$id_espec = isset($get_usu->id_especialidad_trabajador)?$get_usu->id_especialidad_trabajador:NULL;
			if($id_espec != NULL){
				$e1 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador);
				$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
			}else
				$aux->especialidad1 = false;

			$id_espec2 = isset($get_usu->id_especialidad_trabajador_2)?$get_usu->id_especialidad_trabajador_2:NULL;
			if($id_espec2 != NULL){
				$e2 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador_2);
				$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
			}else
				$aux->especialidad2 = false;
		
			array_push($lista,$aux);
			unset($aux);
		}

		if($this->session->userdata('tipo_usuario') == 5)
			$pagina['tipo_usuario'] = "psicologo";
		elseif($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2)
			$pagina['tipo_usuario'] = "analista";
		else
			$pagina['tipo_usuario'] = "error";

		$pagina['listado'] = $lista;
		$pagina['usuario_analista'] = "SI";
		$pagina['empresas_plantas'] = $this->Empresa_planta_model->listar();
		$pagina['lista_requerimientos'] = $this->Requerimientos_model->r_listar_activos();
		$pagina['r_cargos'] = $this->Cargos_model->r_listar();
		$base['cuerpo'] = $this->load->view('carrera/trabajadores/listado_solicitudes_revision_examen_visualizacion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
	
	function ajax_provincias($id_region){
		$this->load->model("carrera/Provincia_model");
		echo json_encode($this->Provincia_model->listar_region($id_region));
	}
	function ajax_ciudades($id_region){
		$this->load->model("carrera/ciudades_model");
		echo json_encode($this->Ciudades_model->listar_region($id_region));
	}
	function eliminar_examen($id_usr, $id_evalua=FALSE){
		$this->load->model('carrera/Evaluaciones_model');
		$this->Evaluaciones_model->eliminar($id_evalua);
		redirect('carrera/trabajadores/detalle/'.$id_usr.'#datos-personales', 'refresh');	
	}
	function guardar_archivo($id){
		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$this->load->helper("acento");
			$this->load->model("carrera/Tipoarchivos_model");
			$this->load->model("carrera/Archivos_trab_model");
			$this->load->model("carrera/Usuarios_model");

			if($_POST['select_archivo'] == 13){
				$la = $this->Archivos_trab_model->get_usuario($id);
				foreach ($la as $l) {
				 	if( $l->id_tipoarchivo == 13)
				 		redirect('carrera/trabajadores/detalle/'.$id.'/archivo_repetido#datos-extras', 'refresh');
				}
			}
			
			$tipo = $this->Tipoarchivos_model->get($_POST['select_archivo'])->desc_tipoarchivo;
			$tipo = str_replace(" ", "_", $tipo);
			$usuario = $this->Usuarios_model->get($id);
			$aux = str_replace(" ", "_", $usuario->nombres);
			$ape = normaliza($aux)."_".normaliza($usuario->paterno).'_'.normaliza($usuario->materno);
			$nb_archivo = strtolower($id."_".trim($ape));
			$nb_archivo = urlencode($nb_archivo);
			$salida = subir($_FILES,"documento","extras/docs/",$nb_archivo);
			
			if($salida == 1)
				redirect('carrera/trabajadores/detalle/'.$id.'/archivo_error0#datos-extras', 'refresh');
			elseif($salida==2)
				redirect('carrera/trabajadores/detalle/'.$id.'/archivo_error1#datos-extras', 'refresh');
			else{
				$data = array(
					'id_usuarios' => $id,
					'nombre' => $nb_archivo,
					'id_tipoarchivo' => $_POST['select_archivo'],
					'url' => $salida
 				);
				$this->Archivos_trab_model->ingresar($data);
				redirect('carrera/trabajadores/detalle/'.$id.'/archivo_exito#datos-extras', 'refresh');
			}
		}
		else redirect('carrera/trabajadores/detalle/'.$id.'/archivo_vacio#datos-extras', 'refresh');
	}
	function rut_existe(){
		$this->load->model("carrera/Usuarios_model");
		if ( $_POST['rut'] ){
			if($this->Usuarios_model->get_rut2($_POST['rut'])){
				$salida = "si";
			}
			else $salida = "no";
		}
		else $salida = "vacio";

		echo $salida;
	}

}
?>
